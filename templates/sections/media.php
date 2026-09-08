<?php
    $media = get_sub_field('media');
?>

<?php echo ds_open_section(); ?>

<div class="ds-section">
    <?php ds_render_component('media', array(
        'media'     => $media,
        'css_class' => 'aspect-[16/9] w-full object-cover',
    )); ?>
</div>

<?php echo ds_close_section(); ?>