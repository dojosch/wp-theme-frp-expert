<?php
$slides = get_sub_field('slides');
$facts = get_sub_field('facts');
?>

<?php echo ds_open_section('py-[25px] lg:py-[50px]'); ?>
<div class="relative overflow-hidden bg-ds-main text-ds-white">
<div class="ds-background absolute inset-x-0 bottom-0 h-[777px] lg:[--ds-background-gradient:linear-gradient(to_bottom,var(--color-ds-main)_3.089%,rgb(46_73_153/0)_111%)] lg:[--ds-background-image-position:50%_100%]" aria-hidden="true"></div>

<div class="relative max-w-[1500px] mx-auto flex flex-col">
    <?php if( !empty($slides) ): ?>
    <div class="px-[20px] pt-[20px] lg:px-[40px] lg:pt-[71px]">
        <div class="grid lg:grid-cols-[701fr_719fr] lg:min-h-[725px] rounded-[3px] lg:rounded-[5px] overflow-hidden text-ds-main" x-data="dsContentSlider">
            <div class="swiper min-w-0 w-full h-[363px] lg:h-auto" x-ref="swiper">
                <div class="swiper-wrapper">
                    <?php foreach( $slides as $slide ): ?>
                    <div class="swiper-slide">
                        <?php
                        ds_render_component('image', [
                            'image'     => ds_get_image_data_from_id($slide['image'], 'large'),
                            'css_class' => 'size-full object-cover',
                        ]);
                        ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-[#f4f4f4] px-[30px] pt-[34px] pb-[40px] lg:px-[122px] lg:pt-[71px] lg:pb-[79px] flex flex-col justify-between gap-[39px]">
                <div class="flex flex-col gap-[8px] lg:gap-[38px]">
                    <div class="flex flex-col gap-[10px] lg:gap-[13px]">
                        <?php
                        ds_render_component('heading', [
                            'heading'   => get_sub_field('slider_sub_heading'),
                            'css_class' => 'ds-subheading gap-[5px] lg:gap-[10px]',
                        ]);
                        ds_render_component('heading', [
                            'heading'   => get_sub_field('slider_heading'),
                            'css_class' => 'font-medium text-ds-34 leading-[1.1] tracking-[-0.34px] lg:text-ds-50 lg:tracking-[-0.5px]',
                        ]);
                        ?>
                    </div>

                    <?php if( count($slides) > 1 ): ?>
                    <div class="flex flex-row items-center">
                        <button type="button" class="shrink-0 rotate-180 transition-opacity hover:opacity-80" aria-label="<?php esc_attr_e('Vorheriger Slide', 'ds-starter'); ?>" @click="prev">
                            <img src="<?php echo esc_url(ds_get_theme_icon_url('slider-arrow-right.svg')); ?>" alt="" class="size-[38px] lg:size-[41px]">
                        </button>
                        <div class="w-[48px] lg:w-[81px] text-center whitespace-pre font-medium text-ds-10 leading-[10px] tracking-[0.1px] lg:text-[12px] lg:leading-[18px] lg:tracking-[0.12px]" aria-live="polite" x-text="`${active + 1}  / <?php echo count($slides); ?>`">1  / <?php echo count($slides); ?></div>
                        <button type="button" class="shrink-0 transition-opacity hover:opacity-80" aria-label="<?php esc_attr_e('Nächster Slide', 'ds-starter'); ?>" @click="next">
                            <img src="<?php echo esc_url(ds_get_theme_icon_url('slider-arrow-right.svg')); ?>" alt="" class="size-[38px] lg:size-[41px]">
                        </button>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="grid">
                    <?php foreach( $slides as $index => $slide ): ?>
                    <div class="[grid-area:1/1] flex flex-col gap-[10px] transition-opacity duration-500 <?php echo $index > 0 ? 'opacity-0 invisible' : ''; ?>" :class="{ 'opacity-0 invisible': active !== <?php echo (int) $index; ?> }">
                        <?php
                        ds_render_component('heading', [
                            'heading'   => ['heading' => $slide['title'], 'heading_tag' => 'h3'],
                            'css_class' => 'font-medium text-[18px] leading-[21px] lg:text-ds-24 lg:leading-[36px] text-ds-accent',
                        ]);
                        ds_render_component('text', [
                            'text'      => $slide['text'],
                            'css_class' => 'max-w-[472px] tracking-[0.14px] lg:tracking-[0.16px]',
                        ]);
                        ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="ds-section w-full pt-[50px] pb-[49px] lg:pt-[75px] lg:pb-[78px] flex flex-col gap-[10px] lg:gap-[20px]">
        <?php
        ds_render_component('heading', [
            'heading'   => get_sub_field('sub_heading'),
            'css_class' => 'ds-subheading gap-[5px] lg:gap-[10px]',
        ]);
        ds_render_component('heading', [
            'heading'   => get_sub_field('heading'),
            'css_class' => 'ds-heading',
        ]);
        ds_render_component('text', [
            'text'      => get_sub_field('text'),
            'css_class' => 'max-w-[583px]',
        ]);
        ?>
    </div>

    <?php if( !empty($facts) ): ?>
    <ul class="grid grid-cols-2 lg:grid-cols-4 border-ds-accent min-[1501px]:border-x">
        <?php foreach( $facts as $fact ): ?>
        <li class="min-h-[195px] lg:min-h-[317px] px-[20px] py-[30px] lg:px-[60px] lg:py-[50px] flex flex-col justify-between gap-[30px] border-t border-ds-accent even:border-l lg:not-first:border-l">
            <div class="text-[45px] leading-[45px] lg:text-[60px] lg:leading-[60px] text-ds-accent">
                <?php echo esc_html($fact['value']); ?>
            </div>
            <div class="flex flex-col gap-[5px] lg:gap-[10px] lg:max-w-[228px]">
                <?php
                ds_render_component('heading', [
                    'heading'   => ['heading' => $fact['title'], 'heading_tag' => 'h3'],
                    'css_class' => 'font-semibold text-[13px] leading-[16px] lg:text-ds-15 lg:leading-[18px]',
                ]);
                ds_render_component('text', [
                    'text'      => esc_html($fact['text']),
                    'css_class' => 'text-[11px] leading-[14px] lg:text-[13px] lg:leading-[17px]',
                ]);
                ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>
</div>
<?php echo ds_close_section(); ?>
