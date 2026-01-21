<?php
    $sub_heading = get_sub_field('sub_heading');
    $sub_heading_tag = get_sub_field('sub_heading_tag');
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $text = get_sub_field('text');
    $faq = get_sub_field('faqs');
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section justify-between">
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
        <?php if($faq && count($faq) > 0): ?>
            <div class="flex flex-col gap-[20px] flex-1 w-full mt-12">
                <?php foreach($faq as $index => $element): ?>
                    <?php 
                        $title = get_the_title($element);
                        $text = get_field('text', $element);

                        ds_render_component('collapsible', [
                            'heading' => $title,
                            'heading_tag' => "div",
                            'text' => $text,
                            'css_class' => '',
                            'index' => $index,
                        ]);
                    ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php echo ds_close_section() ?>    
