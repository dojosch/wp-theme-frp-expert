<?php 

$heading = get_sub_field('heading');
$heading_2 = get_sub_field('heading_2');
$link_1 = get_sub_field('link_1');
$media = get_sub_field('media');
$cropped_media = get_sub_field('cropped_media');
$video = get_sub_field('video');
?>

<?php echo ds_open_section(); ?>
<?php ds_render_component('heading', array(
        'heading' => $heading,
        'css_class' => 'text-center',
    )); 
    ds_render_component('heading', array(
        'heading' => $heading_2,
        'css_class' => 'text-center',
    ));
    ds_render_component('link', array(
        'link' => $link_1,
        'css_class' => 'd-block text-center',
    ));
    ds_render_component('media', array(
        'media' => $media,
        'css_class' => 'my-4',
    ));
    ds_render_component('media', array(
        'media' => $cropped_media,
        'css_class' => '!w-[200px] !h-[200px]',
    ));
    ds_render_component('video', array(
        'video' => $video,
        'css_class' => 'my-4',
    ));
?>
<?php echo ds_close_section(); ?>