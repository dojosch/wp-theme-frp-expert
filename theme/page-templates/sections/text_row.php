<?php
    $rows = get_sub_field('rows');
?>

<section>
    <div class="ds-section flex flex-col"> 
        <?php if($rows && count($rows) > 0): ?>
            <?php foreach($rows as $row): ?>
                <div class="flex flex-col lg:flex-row gap-[30px] lg:gap-[50px] justify-between py-[30px] lg:py-[56px] first:border-t-[1px] border-black border-b-[1px]">
                <?php 
                        ds_render_component('heading', [
                            'heading' => $row['heading'],
                            'heading_tag' => $row['heading_tag'],
                            'css_class' => 'ds-heading',
                        ]);

                        ds_render_component('text', [
                            'text' => $row['text'],
                            'css_class' => 'ds-wysiwyg max-w-[50%]',
                        ]);
                    ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>