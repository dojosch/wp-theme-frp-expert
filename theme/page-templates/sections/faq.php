<?php
$faq_ids = 'selected' === get_sub_field('source')
    ? array_filter(get_sub_field('faqs') ?: [], fn($faq_id) => 'publish' === get_post_status($faq_id))
    : get_posts([
        'post_type'   => 'faq',
        'numberposts' => -1,
        'fields'      => 'ids',
        'orderby'     => ['menu_order' => 'ASC', 'date' => 'ASC'],
    ]);

$icon = sprintf(
    '<span x-show="!open"><img src="%1$s" alt="" class="lg:hidden"><img src="%2$s" alt="" class="hidden lg:block"></span><span x-show="open"><img src="%3$s" alt="" class="lg:hidden"><img src="%4$s" alt="" class="hidden lg:block"></span>',
    esc_url(ds_get_theme_icon_url('faq-plus-21.svg')),
    esc_url(ds_get_theme_icon_url('faq-plus-24.svg')),
    esc_url(ds_get_theme_icon_url('faq-minus-21.svg')),
    esc_url(ds_get_theme_icon_url('faq-minus-24.svg'))
);
?>

<?php echo ds_open_section('text-ds-main border-y border-ds-accent'); ?>
<div class="ds-section pb-0 lg:py-0 grid grid-cols-1 gap-[50px] lg:grid-cols-[minmax(0,540px)_minmax(0,784px)] lg:justify-between lg:gap-[30px]">
    <div class="flex flex-col items-start gap-[20px] lg:gap-[30px] lg:pt-[96px] lg:pb-[50px]">
        <div class="flex flex-col gap-[10px] lg:gap-[20px]">
            <div class="flex flex-col gap-[10px]">
                <?php
                ds_render_component('heading', [
                    'heading'   => get_sub_field('sub_heading'),
                    'css_class' => 'ds-subheading gap-[5px] lg:gap-[10px]',
                ]);
                ds_render_component('heading', [
                    'heading'   => get_sub_field('heading'),
                    'css_class' => 'ds-heading',
                ]);
                ?>
            </div>
            <?php
            ds_render_component('text', [
                'text'      => get_sub_field('text'),
                'css_class' => 'text-ds-14 leading-[1.5] lg:text-ds-16 lg:leading-[24px]',
            ]);
            ?>
        </div>

        <?php
        ds_render_component('link-button', [
            'link'      => get_sub_field('link'),
            'css_class' => 'min-w-[150px] whitespace-nowrap',
        ]);
        ?>
    </div>

    <?php if( !empty($faq_ids) ): ?>
    <div class="-mx-[20px] lg:mx-0 lg:border-x lg:border-ds-accent">
        <?php
        foreach( array_values($faq_ids) as $index => $faq_id ) {
            ds_render_component('faq', [
                'heading'         => ['heading' => get_the_title($faq_id), 'heading_tag' => 'h3'],
                'text'            => get_field('text', $faq_id),
                'icon'            => $icon,
                'open'            => 0 === $index,
                'css_class'       => 'border-t border-ds-accent first:border-t-0 px-[30px] py-[30px] lg:py-[35px] transition-colors lg:hover:bg-ds-light-accent',
                'button_class'    => 'flex flex-row items-center gap-[10px]',
                'heading_class'   => 'font-medium text-ds-16 leading-[18px] lg:text-[18px] lg:leading-[21px]',
                'icon_class'      => 'order-first',
                'icon_open_class' => '',
                'content_class'   => 'pt-[10px]',
                'text_class'      => 'flex flex-col gap-[10px] text-ds-13 leading-[18px]',
            ]);
        }
        ?>
    </div>
    <?php endif; ?>
</div>
<?php echo ds_close_section(); ?>
