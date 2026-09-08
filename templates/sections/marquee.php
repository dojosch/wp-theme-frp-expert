<?php
    $logos = get_sub_field('logos');
?>

<?php echo ds_open_section(); ?>

<div class="ds-section max-w-full px-0">
    <div class="flex flex-col gap-[40px] overflow-hidden" x-data="dsMarquee()">
        <?php if(!empty($logos)): ?>
        <div class="flex w-full cursor-grab flex-row items-center gap-[50px] overflow-x-auto overscroll-x-contain [scrollbar-width:none] lg:gap-[80px] [&::-webkit-scrollbar]:hidden"
            x-ref="track">
            <?php foreach($logos as $logo): ?>
            <?php $image = ds_get_image_data_from_id($logo['image'], 'medium'); ?>
            <?php if(!$image): ?>
            <?php continue; ?>
            <?php endif; ?>

            <?php if(ds_is_valid_link($logo['link'])): ?>
            <?php echo ds_open_link($logo['link'], 'block shrink-0'); ?>
            <?php ds_render_component('image', [
                'image'     => $image,
                'css_class' => 'max-h-[100px] w-auto object-contain lg:max-h-[150px]',
            ]); ?>
            <?php echo ds_close_link(); ?>
            <?php else: ?>
            <div class="shrink-0">
                <?php ds_render_component('image', [
                    'image'     => $image,
                    'css_class' => 'max-h-[100px] w-auto object-contain lg:max-h-[150px]',
                ]); ?>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php echo ds_close_section(); ?>