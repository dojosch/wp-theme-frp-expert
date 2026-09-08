<?php
    $text = get_sub_field('text');
?>

<?php echo ds_open_section(); ?>
<?php ds_render_component('text', [
    'text' => $text,
    'css_class' => 'ds-wysiwyg',
]); ?>
<?php echo ds_close_section(); ?>