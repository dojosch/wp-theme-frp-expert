<?php
    $image = ds_get_image_data_from_sub_field('image');
    $icon = ds_get_image_data_from_sub_field('icon');
    $sub_heading = get_sub_field('sub_heading');
    $sub_heading_tag = get_sub_field('sub_heading_tag');
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $text = get_sub_field('text');
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section flex flex-col lg:flex-row gap-[25px] lg:gap-[15%] lg:items-center">   
        <div class="lg:w-1/2 w-full aspect-[595/650] relative">
            <?php 
                ds_render_component('image', [
                    'image' => $image,
                    'css_class' => 'object-cover w-full h-full',
                ]);

                ds_render_component('image', [
                    'image' => $icon,
                    'css_class' => 'absolute top-[62px] hidden lg:block right-0 transform translate-x-1/2 aspect-[176/177] w-[34.2%] max-w-[176px]',
                ]);
            ?>
        </div>
        <div class="lg:w-[37.5%] w-full flex flex-col gap-[30px] lg:gap-[24px] text-brand-dark">
            <?php 
                ds_render_component('heading', [
                    'heading' => $sub_heading,
                    'heading_tag' => $sub_heading_tag,
                    'css_class' => 'ds-subheading',
                ]);

                ds_render_component('heading', [
                    'heading' => $heading,
                    'heading_tag' => $heading_tag,
                    'css_class' => 'ds-heading',
                ]);

                ds_render_component('text', [
                    'text' => $text,
                    'css_class' => 'ds-wsyiwyg',
                ]);   
            ?>
        </div>
    </div>
<?php echo ds_close_section() ?>    
