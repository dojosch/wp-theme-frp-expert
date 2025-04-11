<?php
    $sub_heading = get_sub_field('sub_heading');
    $sub_heading_tag = get_sub_field('sub_heading_tag');
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $timeline = get_sub_field('timeline');
?>

<section class="">
    <div class="ds-section gap-[50px] flex flex-col lg:flex-row justify-between relative">
        <div class="lg:w-[35%] h-fit flex flex-col gap-[24px] lg:sticky lg:top-[100px]">
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
        <?php if($timeline && count($timeline) > 0): ?>
            <div class="lg:w-1/2 flex flex-col gap-[20px] lg:gap-[30px] relative">
                <?php foreach($timeline as $item): ?>
                <div class="bg-background py-[75px] lg:py-[85px] px-[50px] lg:px-[85px] flex flex-col gap-[20px] rounded-[30px]">
                    <?php 
                        ds_render_component('heading', [
                            'heading' => $item['heading'],
                            'heading_tag' => $item['heading_tag'],
                            'css_class' => 'ds-heading',
                        ]);

                        ds_render_component('text', [
                            'text' => $item['text'],
                            'css_class' => 'ds-wysiwyg text-sm',
                        ]);
                    ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>