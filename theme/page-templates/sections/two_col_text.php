<?php
    $sub_heading = get_sub_field('sub_heading');
    $sub_heading_tag = get_sub_field('sub_heading_tag');
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $column_1 = get_sub_field('column_1');
    $column_2 = get_sub_field('column_2');
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section-narrow">
        <div>
            <?php 
                ds_render_component( 'heading', [
                    'heading' => $sub_heading,
                    'heading_tag' => $sub_heading_tag,
                    'css_class' => 'ds-subheading',
                ]);
                
                ds_render_component( 'heading', [
                    'heading' => $heading,
                    'heading_tag' => $heading_tag,
                    'css_class' => 'ds-heading mt-3',
                ]);
            ?>
        </div>
        <div class="flex flex-col lg:flex-row gap-[40px] text-sm mt-4">
            <?php if($column_1): ?>
                <div class="lg:w-1/2">
                    <?php echo $column_1; ?>
                </div>
            <?php endif;?>
            <?php if($column_2): ?>
                <div class="lg:w-1/2">
                    <?php echo $column_2; ?>
                </div>
            <?php endif;?>
        </div>
    </div>
<?php echo ds_close_section() ?>    
