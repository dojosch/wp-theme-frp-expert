<?php echo ds_open_section('text-ds-white'); ?>
<div class="ds-section px-0 lg:px-[60px]">
    <div class="ds-background flex flex-col items-center gap-[20px] px-[35px] py-[60px] lg:rounded-[5px] lg:py-[55px] text-center [--ds-background-gradient:linear-gradient(120.5deg,var(--color-ds-main)_0.324%,rgb(46_73_153/0)_67.576%)] [--ds-background-image-size:378%_100%] [--ds-background-image-position:63%_0] lg:[--ds-background-gradient:linear-gradient(154.97deg,var(--color-ds-main)_0.324%,rgb(46_73_153/0)_67.576%)] lg:[--ds-background-image-size:cover] lg:[--ds-background-image-position:center]">
        <div class="flex flex-col items-center gap-[10px] lg:gap-[20px]">
            <?php
            ds_render_component('heading', [
                'heading'   => get_sub_field('heading'),
                'css_class' => 'ds-heading leading-[110%] hyphens-manual max-w-[300px] lg:max-w-[760px]',
            ]);
            ds_render_component('text', [
                'text'      => get_sub_field('text'),
                'css_class' => 'leading-[24px] lg:max-w-[633px]',
            ]);
            ?>
        </div>
        <?php
        ds_render_component('link-button-arrow', [
            'link'      => get_sub_field('link'),
            'css_class' => 'ds-button-arrow--white',
        ]);
        ?>
    </div>
</div>
<?php echo ds_close_section(); ?>
