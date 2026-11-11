/* global tinymce */

// "Lead" toolbar button: toggles the intro paragraph style (.ds-lead) on the current block.
// TinyMCE 4 instantiates plugins with `new`, so this must be a regular function.
tinymce.PluginManager.add('ds_lead', function (editor) {
	editor.on('init', () => {
		editor.formatter.register('ds_lead', {
			block: 'p',
			classes: 'ds-lead',
		});
	});

	editor.addButton('ds_lead', {
		text: 'Lead',
		tooltip: 'Einleitungstext',
		onclick: () => editor.formatter.toggle('ds_lead'),
		onPostRender() {
			editor.on('NodeChange', () =>
				this.active(editor.formatter.match('ds_lead'))
			);
		},
	});
});
