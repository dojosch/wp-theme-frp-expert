<?php 

$heading = get_sub_field('heading');
?>

<?php echo ds_open_section(); ?>
<?php ds_render_component('heading', array(
        'heading' => $heading,
        'css_class' => 'text-center',
    )); ?>
<?php echo ds_close_section(); ?>