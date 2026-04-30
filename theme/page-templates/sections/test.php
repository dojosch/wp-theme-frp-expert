<?php 

$heading = get_sub_field('heading');
$heading_2 = get_sub_field('heading_2');
$heading_3 = get_sub_field('heading_3');
$link_1 = get_sub_field('link_1');
$media = get_sub_field('media');
$image = ds_get_image_data_from_sub_field('image');
$cropped_image = ds_get_image_data_from_sub_field('cropped_image');
$cropped_media = get_sub_field('cropped_media');
$video = get_sub_field('video');
$text = get_sub_field('text');
$textarea = get_sub_field('textarea');
$wysiwyg = get_sub_field('wysiwyg');
?>

<?php echo ds_open_section('ds-section flex flex-col gap-[10px]'); ?>
<?php 
    ds_render_component('image', array(
        'image' => $image,
        'css_class' => 'my-4',
    ));
    ds_render_component('image', array(
        'image' => $cropped_image,
        'css_class' => '!w-[200px] !h-[200px]',
    ));
    ds_render_component('heading', array(
        'heading' => $heading,
        'css_class' => 'text-center',
    )); 
    ds_render_component('heading', array(
        'heading' => $heading_2,
        'css_class' => 'text-center',
    ));
    ds_render_component('heading', array(
        'heading' => $heading_3,
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
    ds_render_component('text', array(
        'text' => $text,
        'css_class' => 'my-4',
    ));
    ds_render_component('text', array(
        'text' => $textarea,
        'css_class' => 'my-4',
    ));
    ds_render_component('text', array(
        'text' => $wysiwyg,
        'css_class' => 'my-4 ds-wysiwyg',
    ));
?>
<?php echo ds_close_section(); ?>