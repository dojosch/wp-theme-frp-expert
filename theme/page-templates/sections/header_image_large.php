<?php 
    $sub_heading = get_sub_field('sub_heading');
    $sub_heading_tag = get_sub_field('sub_heading_tag');
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $text = get_sub_field('text');
    $image = ds_get_image_data_from_sub_field('image');
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section-header flex flex-col gap-[40px] lg:gap-[110px]">
        <div class="flex flex-col gap-[20px]">
            <?php 
                ds_render_component( 'heading', [
                    'heading' => $sub_heading,
                    'heading_tag' => $sub_heading_tag,
                    'css_class' => 'ds-subheading',
                ]);
            ?>
            <div class="flex flex-col lg:flex-row gap-[27px] lg:gap-[50px] justify-between lg:items-end">
                <?php 
                    ds_render_component( 'heading', [
                        'heading' => $heading,
                        'heading_tag' => $heading_tag,
                        'css_class' => 'ds-heading shrink-0 min-w-1/3',
                    ]);
                
                    ds_render_component( 'text', [
                        'text' => $text,
                        'css_class' => 'text-sm lg:pl-[10%]',
                    ]);
            ?>    
            </div>
        </div>
        <?php if($image): ?>
            <div class="flex relative w-full max-h-[650px] aspect-[1024/650]">
                <?php 
                    ds_render_component( 'image', [
                        'image' => $image,
                        'css_class'  => 'w-full h-auto object-cover',
                    ] );
                ?>
            </div>
        <?php endif; ?>
    </div>
<?php echo ds_close_section() ?>    
