<?php
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $collapsible = get_sub_field('collapsible');
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section flex flex-col lg:flex-row gap-[100px] justify-between">
        <?php 
            ds_render_component('heading', [
                'heading' => get_sub_field('heading'),
                'heading_tag' => get_sub_field('heading_tag'),
                'css_class' => 'ds-heading',
            ]);
        ?>
        <?php if($collapsible && count($collapsible) > 0): ?>
            <div class="flex flex-col gap-[20px] flex-1 w-full">
                <?php foreach($collapsible as $index => $element): ?>
                    <?php 
                        ds_render_component('collapsible', [
                            'heading' => $element['heading'],
                            'heading_tag' => $element['heading_tag'],
                            'text' => $element['text'],
                            'link' => $element['link'],
                            'css_class' => '',
                            'index' => $index,
                        ]);
                    ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php echo ds_close_section() ?>    
