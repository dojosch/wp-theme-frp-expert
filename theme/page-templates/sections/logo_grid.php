<?php
    $sub_heading = get_sub_field('sub_heading');
    $sub_heading_tag = get_sub_field('sub_heading_tag');
    $heading = get_sub_field('heading');
    $heading_tag = get_sub_field('heading_tag');
    $logos = get_sub_field('logos');
?>

<section class="overflow-x-hidden">
    <div class="ds-section flex flex-col">
        <div class="relative flex flex-col lg:items-center">
            <?php 
                ds_render_component('heading', [
                    'heading' => $sub_heading,
                    'heading_tag' => $sub_heading_tag,
                    'css_class' => 'ds-subheading mb-2',
                ]);

                ds_render_component('heading', [
                    'heading' => $heading,
                    'heading_tag' => $heading_tag,
                    'css_class' => 'ds-heading',
                ]);
            ?>

            <?php if($logos && count($logos) > 0): ?>
                <div
                    class="hidden lg:grid grid-cols-3 xl:grid-cols-4 gap-x-[50px] gap-y-[70px] justify-between mt-[70px] justify-items-center">
                    <?php foreach($logos as $logo): ?>
                        <?php $image_data = ds_get_image_data_from_id($logo['image']); ?>
                        <?php if($image_data): ?>
                            <div class="w-[100px] lg:w-[200px] ds-section-logo-grid__logo">
                                <?php 
                                    ds_render_component('image', [
                                        'image' => $image_data,
                                        'css_class' => 'w-full h-full object-contain',
                                    ]); 
                                ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="ds-logo-grid--glider glide lg:hidden mt-[40px]">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            <?php foreach($logos as $logo): ?>
                                <?php $image_data = ds_get_image_data_from_id($logo['image']); ?>
                                <?php if($image_data): ?>
                                    <li class="glide__slide flex flex-col items-center">
                                        <div class="h-auto max-w-[277px] w-[277px]">
                                            <?php 
                                                ds_render_component('image', [
                                                    'image' => $image_data,
                                                    'css_class' => 'w-full h-full object-contain',
                                                ]); 
                                            ?>
                                        </div>
                                    </li>
                                <?php endif;?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>