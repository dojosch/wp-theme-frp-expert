<?php 

$heading = get_sub_field('heading');
$image = ds_get_image_data_from_sub_field('image');
$cropped_image = ds_get_image_data_from_sub_field('cropped_image');
?>

<?php echo ds_open_section(); ?>
<?php ds_render_component('heading', array(
        'heading' => $heading,
        'css_class' => 'text-center',
    )); 
    ds_render_component('image', array(
        'image' => $image,
        'css_class' => 'mx-auto',
    )); 
    ds_render_component('image', array(
        'image' => $cropped_image,
        'css_class' => 'mx-auto',
    ));    
?>
<?php echo ds_close_section(); ?>