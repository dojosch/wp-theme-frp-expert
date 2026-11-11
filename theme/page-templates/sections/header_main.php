<?php echo ds_open_section('relative overflow-x-clip text-ds-white'); ?>
<div class="ds-background absolute inset-x-0 top-0 bottom-[142.5px] lg:bottom-[47px]" aria-hidden="true"></div>

<div class="ds-section relative pt-[234px] pb-[12.5px] lg:pt-[309px] lg:pb-[109px] flex flex-col gap-[30px]">
    <div class="flex flex-col gap-[20px] lg:gap-[24px]">
        <?php
        ds_render_component('heading', [
            'heading'   => get_sub_field('heading'),
            'css_class' => 'font-semibold text-[45px] leading-[45px] tracking-[-0.9px] lg:text-ds-80 lg:leading-[80px] lg:tracking-[-1.6px]',
        ]);
        ?>
        <div class="flex flex-col gap-[20px]">
            <?php
            ds_render_component('text', [
                'text'      => get_sub_field('text'),
                'css_class' => 'text-ds-14 leading-[21px] lg:text-[17px] lg:leading-[27px] lg:max-w-[491px]',
            ]);
            ds_render_component('link-button-arrow', [
                'link' => get_sub_field('link'),
            ]);
            ?>
        </div>
    </div>

    <?php
    ds_render_component('image', [
        'image'     => ds_get_image_data_from_sub_field('image', 'full'),
        'css_class' => 'self-center w-full max-w-[350px] aspect-[809/604] object-cover lg:absolute lg:top-[190px] lg:left-[calc(50%+243px)] lg:w-[809px] lg:max-w-none',
    ]);
    ?>
</div>
<?php echo ds_close_section(); ?>
