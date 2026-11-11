<?php echo ds_open_section('text-ds-white'); ?>
<div class="ds-section px-0 lg:px-[60px]">
    <div class="relative flex flex-col lg:pb-[95px]">
        <?php
        ds_render_component('image', [
            'image'     => ds_get_image_data_from_sub_field('image', 'full'),
            'css_class' => 'w-full aspect-[390/375] object-cover object-[25%_67%] lg:aspect-auto lg:h-[755px] lg:rounded-[5px] lg:object-[68%_60%]',
        ]);
        ?>
        <div class="flex flex-col gap-[10px] lg:gap-[20px] p-[50px] bg-ds-main lg:absolute lg:bottom-0 lg:right-[47.5px] lg:w-[736px] lg:p-[75px] lg:rounded-[5px]">
            <div class="flex flex-col gap-[10px] lg:gap-[15px]">
                <?php
                ds_render_component('heading', [
                    'heading'   => get_sub_field('sub_heading'),
                    'css_class' => 'ds-subheading gap-[5px] lg:gap-[10px]',
                ]);
                ds_render_component('heading', [
                    'heading'   => get_sub_field('heading'),
                    'css_class' => 'ds-heading font-medium leading-[110%] hyphens-manual tracking-[-0.34px] lg:font-semibold lg:leading-[50px] lg:tracking-normal',
                ]);
                ?>
            </div>
            <?php
            ds_render_component('text', [
                'text' => get_sub_field('text'),
            ]);
            ?>
        </div>
    </div>
</div>
<?php echo ds_close_section(); ?>
