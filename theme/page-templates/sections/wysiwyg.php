<?php echo ds_open_section('text-ds-main'); ?>
<div class="ds-section">
    <?php
    ds_render_component('text', [
        'text'      => get_sub_field('text'),
        'css_class' => 'ds-wysiwyg max-w-[784px] mx-auto',
    ]);
    ?>
</div>
<?php echo ds_close_section(); ?>
