<?php 
$heading = get_sub_field('heading');
$link = get_sub_field('link');
?>

<?php echo ds_open_section('ds-section flex flex-col gap-[10px]'); ?>
<?php 
    ds_render_component('heading', [
        'heading'   => $heading,
        'css_class' => 'ds-subheading',
    ]); 
    ds_render_component('heading', [
        'heading'   => $heading,
        'css_class' => 'ds-heading',
    ]); 
    
    ds_render_component('link', [
        'link'      => $link,
        'css_class' => 'ds-button',
    ]);
?>
<?php echo ds_close_section(); ?>