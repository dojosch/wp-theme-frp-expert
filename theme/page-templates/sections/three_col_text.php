<?php
    $columns = get_sub_field('columns');
    $background_color = get_sub_field('background_color');
?>

<section class="w-full">
    <div class="ds-section grid grid-cols-1 lg:grid-cols-3 gap-[50px]">
        <?php foreach($columns as $column): ?>
            <div class="flex flex-col">
                <?php 
                    ds_render_component( 'heading', [
                        'heading' => $column['sub_heading'],
                        'heading_tag' => $column['sub_heading_tag'],
                        'css_class' => 'ds-subheading',
                    ]);

                    ds_render_component( 'heading', [
                        'heading' => $column['heading'],
                        'heading_tag' => $column['heading_tag'],
                        'css_class' => 'heading text-2xl font-serif mt-3',
                    ]);

                    ds_render_component( 'text', [
                        'text' => $column['text'],
                        'css_class' => 'mt-3 mr-2 text-sm',
                    ]);
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>