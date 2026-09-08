<?php
    $heading = get_sub_field('heading');
    $slides = get_sub_field('slides');
?>

<?php echo ds_open_section(); ?>

<div class="ds-section flex flex-col gap-[30px]">
    <?php
        ds_render_component('heading', [
            'heading'   => $heading,
            'css_class' => 'ds-heading',
        ]);
    ?>

    <?php if(!empty($slides)): ?>
    <div class="flex flex-col gap-[20px]" x-data="dsSlider()">
        <div class="swiper w-full" x-ref="slider">
            <div class="swiper-wrapper">
                <?php foreach($slides as $slide): ?>
                <?php $image = ds_get_image_data_from_id($slide['image']); ?>
                <?php if(!$image): ?>
                <?php continue; ?>
                <?php endif; ?>

                <div class="swiper-slide aspect-[3/2]">
                    <?php ds_render_component('image', [
                        'image'     => $image,
                        'css_class' => 'h-full w-full object-cover',
                    ]); ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex items-center gap-[10px]">
            <button type="button" class="ds-slider-nav rotate-180" x-ref="prev"
                aria-label="<?php esc_attr_e('Vorheriges Bild', 'ds-starter'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14" fill="none"
                    aria-hidden="true">
                    <path d="M12.5 1L19 7L12.5 13M19 7H1" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <button type="button" class="ds-slider-nav" x-ref="next"
                aria-label="<?php esc_attr_e('Nächstes Bild', 'ds-starter'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14" fill="none"
                    aria-hidden="true">
                    <path d="M12.5 1L19 7L12.5 13M19 7H1" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php echo ds_close_section(); ?>
