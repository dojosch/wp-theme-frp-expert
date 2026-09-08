#!/usr/bin/env node

/*
 * PHP formatter.
 *
 * Enforces the house style documented in CLAUDE.md ("Template Rules"):
 *
 *   1. No alignment padding on assignments — `$a = 1;`, never `$a   = 1;`.
 *   2. Control-structure conditions pad inside the parens but not before them —
 *      `if( $x )`, not `if ($x)` or `if($x)`. Everything else stays tight:
 *      `get_field('heading', $id)`, `!empty($x)`, `['page']`.
 *   3. Single `return` / `continue` / `break` bodies collapse onto the
 *      condition line without braces — `if( $x ) return;`.
 *   4. ds_render_component() calls use short array syntax with `=>` aligned.
 *
 * Usage:
 *   node node_scripts/format-php.cjs [--check] [path ...]
 *
 * --check reports what would change and exits 1 instead of writing.
 *
 * Transformations only run inside PHP regions, and inside those regions only
 * on code — never on string or comment contents. Files using heredoc/nowdoc
 * syntax are skipped, since the scanner does not track it.
 */

const fs = require('fs');
const path = require('path');

const CONTROL_KEYWORDS = ['if', 'elseif', 'while', 'for', 'foreach', 'switch', 'catch'];
const COLLAPSIBLE = /^(?:return\b[^;]*|continue|break);$/;

/**
 * Marks every offset that is real code: inside a PHP region, and not inside a
 * string or a comment. Markup outside `<?php ... ?>` is never touched.
 *
 * @param {string}  text     PHP source.
 * @param {boolean} fragment True when the text is already inside a PHP region
 *                           (an argument list, an array body) rather than a
 *                           whole file that opens with `<?php`.
 * @return {boolean[]} Mask parallel to the input.
 */
function buildMask(text, fragment = false) {
	const mask = new Array(text.length).fill(true);
	let i = 0;
	let inPhp = fragment;

	while (i < text.length) {
		const char = text[i];

		if (!inPhp) {
			const open = text.startsWith('<?php', i) ? 5 : text.startsWith('<?=', i) ? 3 : 0;

			if (open) {
				for (let j = i; j < i + open; j++) mask[j] = false;
				i += open;
				inPhp = true;
				continue;
			}

			mask[i] = false;
			i++;
			continue;
		}

		if (char === '?' && text[i + 1] === '>') {
			mask[i] = false;
			mask[i + 1] = false;
			i += 2;
			inPhp = false;
			continue;
		}

		if (char === "'" || char === '"') {
			mask[i] = false;
			i++;

			while (i < text.length) {
				if (text[i] === '\\') {
					mask[i] = false;
					mask[i + 1] = false;
					i += 2;
					continue;
				}

				mask[i] = false;

				if (text[i] === char) {
					i++;
					break;
				}

				i++;
			}

			continue;
		}

		if ((char === '/' && text[i + 1] === '/') || char === '#') {
			while (i < text.length && text[i] !== '\n') {
				mask[i] = false;
				i++;
			}

			continue;
		}

		if (char === '/' && text[i + 1] === '*') {
			while (i < text.length && !(text[i] === '*' && text[i + 1] === '/')) {
				mask[i] = false;
				i++;
			}

			mask[i] = false;
			mask[i + 1] = false;
			i += 2;
			continue;
		}

		i++;
	}

	return mask;
}

/**
 * Finds the offset closing the bracket opened at openIdx.
 *
 * @param {string}    text    PHP source.
 * @param {number}    openIdx Offset of the opening bracket.
 * @param {boolean[]} mask    Code mask.
 * @return {number} Offset of the matching bracket, or -1.
 */
function findMatching(text, openIdx, mask) {
	const open = text[openIdx];
	const close = { '(': ')', '[': ']', '{': '}' }[open];
	let depth = 0;

	for (let i = openIdx; i < text.length; i++) {
		if (!mask[i]) continue;

		if (text[i] === open) depth++;
		else if (text[i] === close && --depth === 0) return i;
	}

	return -1;
}

/**
 * Splits a bracketed body on its top-level commas.
 *
 * @param {string}    text   Body text.
 * @param {boolean[]} mask   Code mask for the body.
 * @return {string[]} The parts, commas removed.
 */
function splitTopLevel(text, mask) {
	const parts = [];
	let depth = 0;
	let start = 0;

	for (let i = 0; i < text.length; i++) {
		if (!mask[i]) continue;

		if ('([{'.includes(text[i])) depth++;
		else if (')]}'.includes(text[i])) depth--;
		else if (text[i] === ',' && depth === 0) {
			parts.push(text.slice(start, i));
			start = i + 1;
		}
	}

	parts.push(text.slice(start));

	return parts;
}

/**
 * Rule 2 (part one) — strip padding just inside every bracket and after `!`.
 * Control structures get their own padding back in fixControlStructures().
 *
 * @param {string} source PHP source.
 * @return {string} Rewritten source.
 */
function fixParenSpacing(source) {
	const mask = buildMask(source);
	const isBlank = (char) => ' ' === char || '\t' === char;
	let out = '';
	let atLineStart = true;

	for (let i = 0; i < source.length; i++) {
		const char = source[i];

		if (mask[i] && ('(' === char || '[' === char || ('!' === char && '=' !== source[i + 1]))) {
			out += char;
			atLineStart = false;

			let j = i + 1;
			while (j < source.length && mask[j] && isBlank(source[j])) j++;

			i = j - 1;
			continue;
		}

		// Padding before a closing bracket goes, but never a line's indentation.
		if (mask[i] && isBlank(char) && !atLineStart) {
			let j = i;
			while (j < source.length && mask[j] && isBlank(source[j])) j++;

			if ((')' === source[j] || ']' === source[j]) && mask[j]) {
				i = j - 1;
				continue;
			}
		}

		out += char;

		if ('\n' === char) atLineStart = true;
		else if (!isBlank(char)) atLineStart = false;
	}

	return out;
}

/** Rule 1 — collapse alignment padding before an assignment operator. */
function fixAssignmentAlignment(text) {
	const pattern =
		/^([ \t]*)(\$[A-Za-z_]\w*(?:(?:->|::)\w+|\[[^\]\n]*\])*)([ \t]{2,})((?:\.|\+|-|\*|\/|%|\?\?|\|\||&&|>>|<<)?=)(?![=>])/gm;

	return text.replace(pattern, (match, indent, target, _pad, operator, offset, whole) => {
		const mask = buildMask(whole);
		const opIndex = offset + indent.length + target.length + _pad.length;

		return mask[opIndex] ? `${indent}${target} ${operator}` : match;
	});
}

/**
 * Rules 2 and 3 — tighten control-structure parens, then collapse a lone
 * return/continue/break body onto the condition line.
 */
function fixControlStructures(text) {
	let result = text;
	let changed = true;

	while (changed) {
		changed = false;

		const mask = buildMask(result);
		const pattern = new RegExp(`\\b(${CONTROL_KEYWORDS.join('|')})\\s*\\(`, 'g');
		let match;

		while ((match = pattern.exec(result)) !== null) {
			const keyword = match[1];
			const start = match.index;
			const openIdx = match.index + match[0].length - 1;

			if (!mask[start] || !mask[openIdx]) continue;

			const closeIdx = findMatching(result, openIdx, mask);

			if (closeIdx === -1) continue;

			const condition = result.slice(openIdx + 1, closeIdx).trim();

			// Multi-line conditions keep their own layout.
			if (condition.includes('\n')) continue;

			let replacement = `${keyword}( ${condition} )`;
			let end = closeIdx + 1;

			if ('if' === keyword || 'elseif' === keyword) {
				const rest = result.slice(closeIdx + 1);
				const braceOffset = rest.search(/\S/);

				if (braceOffset !== -1 && rest[braceOffset] === '{') {
					const braceIdx = closeIdx + 1 + braceOffset;
					const bodyEnd = findMatching(result, braceIdx, mask);
					const body = bodyEnd === -1 ? '' : result.slice(braceIdx + 1, bodyEnd).trim();

					// Only a single, unconditional jump collapses; anything
					// with a trailing else keeps its braces.
					if (COLLAPSIBLE.test(body) && !/^\s*(else|elseif)\b/.test(result.slice(bodyEnd + 1))) {
						replacement = `${keyword}( ${condition} ) ${body}`;
						end = bodyEnd + 1;
					}
				}
			}

			if (replacement !== result.slice(start, end)) {
				result = result.slice(0, start) + replacement + result.slice(end);
				changed = true;
				break;
			}
		}
	}

	return result;
}

/** Rule 4 — rewrite ds_render_component() calls in the canonical shape. */
function fixComponentCalls(text) {
	let result = text;
	let cursor = 0;

	for (;;) {
		const mask = buildMask(result);
		const start = result.indexOf('ds_render_component', cursor);

		if (start === -1) break;

		cursor = start + 1;

		if (!mask[start]) continue;

		const openIdx = result.indexOf('(', start);

		if (openIdx === -1 || !mask[openIdx]) continue;

		const closeIdx = findMatching(result, openIdx, mask);

		if (closeIdx === -1) continue;

		const body = result.slice(openIdx + 1, closeIdx);
		const args = splitTopLevel(body, buildMask(body, true));

		if (args.length !== 2) continue;

		const name = args[0].trim();
		let literal = args[1].trim();

		// array( ... ) → [ ... ]
		if (literal.startsWith('array')) {
			const inner = literal.slice(literal.indexOf('('));
			literal = `[${inner.slice(1, -1)}]`;
		}

		if (!literal.startsWith('[') || !literal.endsWith(']')) continue;

		const inner = literal.slice(1, -1);
		const entries = splitTopLevel(inner, buildMask(inner, true))
			.map((entry) => entry.trim())
			.filter(Boolean);

		if (!entries.length) continue;

		const parsed = entries.map((entry) => {
			const separator = entry.indexOf('=>');

			return separator === -1
				? null
				: { key: entry.slice(0, separator).trim(), value: entry.slice(separator + 2).trim() };
		});

		// Bail on anything this formatter cannot lay out safely.
		if (parsed.some((entry) => !entry || entry.value.includes('\n'))) continue;

		const lineStart = result.lastIndexOf('\n', start) + 1;
		const indent = (result.slice(lineStart, start).match(/^[ \t]*/) || [''])[0];
		const unit = indent.includes('\t') ? '\t' : '    ';
		const width = Math.max(...parsed.map((entry) => entry.key.length));

		const rendered = [
			`ds_render_component(${name}, [`,
			...parsed.map(
				(entry) => `${indent}${unit}${entry.key.padEnd(width)} => ${entry.value},`
			),
			`${indent}])`,
		].join('\n');

		if (rendered !== result.slice(start, closeIdx + 1)) {
			result = result.slice(0, start) + rendered + result.slice(closeIdx + 1);
		}
	}

	return result;
}

/**
 * Formats one file's contents.
 *
 * @param {string} source File contents.
 * @return {string} Formatted contents.
 */
function format(source) {
	// The scanner does not model heredoc/nowdoc; leave those files alone.
	if (/<<<['"]?\w/.test(source)) return source;

	return fixComponentCalls(
		fixControlStructures(fixParenSpacing(fixAssignmentAlignment(source)))
	);
}

/**
 * Collects every .php file below the given path.
 *
 * @param {string} target File or directory.
 * @return {string[]} File paths.
 */
function collectFiles(target) {
	if (!fs.existsSync(target)) return [];

	if (fs.statSync(target).isFile()) return target.endsWith('.php') ? [target] : [];

	return fs.readdirSync(target).flatMap((entry) => collectFiles(path.join(target, entry)));
}

const args = process.argv.slice(2);
const check = args.includes('--check');
const targets = args.filter((arg) => !arg.startsWith('--'));
const changed = [];

// This tool rewrites files in place, so it never guesses a target.
if (!targets.length) {
	console.error('usage: node node_scripts/format-php.cjs [--check] <path> [path ...]');
	process.exit(2);
}

targets.flatMap((root) => collectFiles(root)).forEach((file) => {
	const source = fs.readFileSync(file, 'utf8');
	const formatted = format(source);

	if (formatted === source) return;

	changed.push(file);

	if (!check) fs.writeFileSync(file, formatted);
});

if (!changed.length) {
	console.log('✔ php: already formatted');
	process.exit(0);
}

changed.forEach((file) => console.log(`${check ? 'needs formatting' : 'formatted'}  ${file}`));
console.log(`\n${changed.length} file(s)`);

process.exit(check ? 1 : 0);
