<?php
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $link = get_sub_field('link');
    $image = ds_get_image_data_from_sub_field('image');
    $icon = ds_get_image_data_from_sub_field('icon');
?>

<section class="w-full">
    <div class="ds-section-medium flex flex-col lg:flex-row items-center gap-[30px] lg:gap-[40px]">
        <div class="lg:w-1/2 w-full relative">
            <?php 
                ds_render_component( 'image', [
                    'image' => $image,
                    'css_class'  => 'w-full h-auto object-cover',
                ] );
           
        
                ds_render_component( 'image', [
                    'image' => $icon,
                    'css_class' => 'absolute -top-[84px] -right-[19px] lg:-top-[45px] lg:-right-[88px] lg:size-[146px] size-[120px]',
                ]);
            ?>
        </div>
        <div class="lg:w-1/2 w-full flex flex-col items-center lg:items-start relative lg:-mt-[8px]">
            <?php 
                ds_render_component( 'heading', [
                    'heading' => $heading,
                    'heading_tag' => $heading_tag,
                    'css_class' => 'ds-heading text-center lg:text-left hyphens-auto',
                ]);
           
                ds_render_component( 'link-button', [
                    'link' => $link,
                    'css_class' => 'mt-[32px]',
                ]);
            ?>
        </div>
    </div>
</section>