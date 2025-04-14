<?php
    $sub_heading = get_sub_field('sub_heading');
    $sub_heading_tag = get_sub_field('sub_heading_tag');
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $text = get_sub_field('text');
    $image = ds_get_image_data_from_sub_field('image');
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section-header flex flex-col-reverse lg:flex-row gap-[50px]">
        <div class="flex flex-col justify-between text-brand-dark gap-[30px] lg:gap-[50px] lg:w-1/2">
            <div class="flex flex-col gap-[30px] lg:gap-[20px]">
                <?php 
                    ds_render_component( 'heading', [
                        'heading' => $sub_heading,
                        'heading_tag' => $sub_heading_tag,
                        'css_class' => 'ds-subheading',
                    ]);
                    
                    ds_render_component( 'heading', [
                        'heading' => $heading,
                        'heading_tag' => $heading_tag,
                        'css_class' => 'ds-heading mt-[10px]',
                    ]);
                ?>
            </div>
            <div class="flex flex-col gap-[38px] max-w-[50%]">
            <?php 
                    ds_render_component( 'text', [
                        'text' => $text,
                        'css_class' => 'ds-wysiwyg text-sm ',
                    ]);
                ?>
            </div>
        </div>
        <?php if($image): ?>
            <div class="aspect-[595/650] lg:w-1/2">
                <?php 
                    ds_render_component( 'image', [
                        'image' => $image,
                        'css_class' => 'w-full h-auto object-cover',
                    ]);
                ?>
            </div>
        <?php endif; ?>
    </div>
<?php echo ds_close_section() ?>    
