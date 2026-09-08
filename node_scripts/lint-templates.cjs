#!/usr/bin/env node

/*
 * Template linter.
 *
 * Checks PHP templates against the mechanically verifiable rules documented in
 * CLAUDE.md ("Template Rules"). Rules that need human judgement (class reuse,
 * inline utilities vs. named classes) are not checked here.
 *
 * Usage:
 *   node node_scripts/lint-templates.cjs [path ...]
 *
 * Suppress a single finding by putting `ds-lint-ignore` in a comment on the
 * offending line or the line above it. Narrow it to one rule with
 * `ds-lint-ignore:no-margin-spacing`.
 */

const fs = require('fs');
const path = require('path');

const ROOTS = ['theme/page-templates'];

const RULES = [
	{
		name: 'no-rem-arbitrary',
		severity: 'error',
		test: /\[[^\]\s]*?\d(?:\.\d+)?rem[^\]\s]*?\]/,
		message: 'Arbitrary value in rem — use px (Figma is specced in px).',
	},
	{
		name: 'no-margin-spacing',
		severity: 'warning',
		test: /(?:^|["'\s:])(?:[a-z0-9]+:)*mt-(?:\[[^\]]+\]|[\d.]+)/,
		message:
			'Spacing with mt-* — space stacked elements with a parent `flex flex-col gap-*` instead. If this is an absolute offset, add ds-lint-ignore.',
	},
	{
		name: 'no-p-wrapper',
		severity: 'warning',
		test: /<p(?:\s[^>]*)?>/,
		message: '<p> used as markup — reserve <p> for prose, use <div> for wrappers.',
	},
	{
		name: 'no-raw-text-echo',
		severity: 'warning',
		// The text component is the one place that may echo $text.
		exclude: /components[\\/]text\.php$/,
		test: /echo\s+\$[\w]*text\b/i,
		message:
			"Raw text echo — render ACF text/WYSIWYG with ds_render_component('text', [...]).",
	},
	{
		name: 'no-redundant-text-guard',
		severity: 'warning',
		test: /(?:!\s*empty|empty)\s*\(\s*\$[\w]*text\s*\)/i,
		message:
			'Redundant empty() guard — the text component already bails on empty/unset $text.',
	},
];

/** Rule that inspects the whole file rather than one line. */
const FILE_RULES = [
	{
		name: 'no-file-docblock',
		severity: 'warning',
		// Components document their $args contract; page templates need the
		// WordPress "Template Name" header. Neither is a narrative explainer.
		exclude: /components[\\/]/,
		message:
			'Top-of-file docblock on a template — put narrative explanation in the commit message.',
		test: (lines) => {
			for (let i = 0; i < lines.length; i++) {
				const line = lines[i].trim();

				if (line === '' || line === '<?php') continue;

				if (!line.startsWith('/**')) return 0;

				return lines.slice(i, i + 12).some((l) => l.includes('Template Name:')) ? 0 : i + 1;
			}

			return 0;
		},
	},
];

/**
 * Collects every .php file below the given directory.
 *
 * @param {string} dir Directory to walk.
 * @return {string[]} Absolute file paths.
 */
function collectFiles(dir) {
	if (!fs.existsSync(dir)) return [];

	if (fs.statSync(dir).isFile()) return dir.endsWith('.php') ? [dir] : [];

	return fs.readdirSync(dir).flatMap((entry) => collectFiles(path.join(dir, entry)));
}

/**
 * Checks whether a finding is suppressed by a ds-lint-ignore comment.
 *
 * @param {string[]} lines Every line of the file.
 * @param {number}   index Zero-based line the finding sits on.
 * @param {string}   rule  Rule name.
 * @return {boolean} True when suppressed.
 */
function isIgnored(lines, index, rule) {
	const candidates = [lines[index], lines[index - 1] ?? ''];

	return candidates.some((line) => {
		const match = line.match(/ds-lint-ignore(?::([\w-]+))?/);

		return Boolean(match) && (!match[1] || match[1] === rule);
	});
}

const targets = process.argv.slice(2);
const roots = targets.length ? targets : ROOTS;
const findings = [];

roots.flatMap((root) => collectFiles(root)).forEach((file) => {
	const lines = fs.readFileSync(file, 'utf8').split('\n');

	lines.forEach((line, index) => {
		RULES.forEach((rule) => {
			if (rule.exclude && rule.exclude.test(file)) return;

			if (rule.test.test(line) && !isIgnored(lines, index, rule.name)) {
				findings.push({ file, line: index + 1, ...rule });
			}
		});
	});

	FILE_RULES.forEach((rule) => {
		if (rule.exclude && rule.exclude.test(file)) return;

		const line = rule.test(lines);

		if (line && !isIgnored(lines, line - 1, rule.name)) {
			findings.push({ file, line, ...rule });
		}
	});
});

if (!findings.length) {
	console.log('✔ templates: no findings');
	process.exit(0);
}

const errors = findings.filter((finding) => finding.severity === 'error');

findings
	.sort((a, b) => a.file.localeCompare(b.file) || a.line - b.line)
	.forEach((finding) => {
		const label = finding.severity === 'error' ? 'error  ' : 'warning';
		console.log(`${label} ${finding.file}:${finding.line}  [${finding.name}] ${finding.message}`);
	});

console.log(
	`\n${findings.length} finding(s): ${errors.length} error(s), ${findings.length - errors.length} warning(s)`
);

process.exit(errors.length ? 1 : 0);
