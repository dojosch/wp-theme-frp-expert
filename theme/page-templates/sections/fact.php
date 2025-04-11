<?php 
    $sub_heading = get_sub_field('sub_heading');
    $sub_heading_tag = get_sub_field('sub_heading_tag');
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $text = get_sub_field('text');
?>

<section class="w-full">
    <div class="ds-section-medium">
        <div class="flex flex-col lg:flex-row gap-[30px] lg:gap-[75px] p-[50px] lg:p-[80px] bg-background rounded-[20px]">
            <div class="flex flex-col lg:w-[50%] shrink-0">
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
            <?php 
                ds_render_component( 'text', [
                    'text' => $text,
                    'css_class' => 'ds-wysiwyg text-sm',
                ]);
            ?>
        </div>
    </div>
</section>