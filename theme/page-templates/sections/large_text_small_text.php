<?php
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $wysiwyg = get_sub_field('wysiwyg');
    $text = get_sub_field('text');
?>

<section class="w-full">
    <div class="ds-section grid grid-cols-3 lg:grid-cols-8 gap-[30px] lg:gap-[50px] items-end">
        <div class="flex flex-col col-span-3 lg:col-span-5 gap-[30px] lg:gap-[25px]">
            <?php 
                ds_render_component('heading', [
                    'heading' => $heading,
                    'heading_tag' => $heading_tag,
                    'css_class' => 'ds-heading',
                ]);

                ds_render_component('text', [
                    'text' => $wysiwyg,
                    'css_class' => 'ds-wysiwyg',
                ]);
            ?>
        </div>
        <?php  
            ds_render_component('text', [
                'text' => $text,
                'css_class' => 'ds-wysiwyg col-span-3 lg:pl-[calc((100%-100px)/3)]',
            ]);
        ?>
    </div>
</section>