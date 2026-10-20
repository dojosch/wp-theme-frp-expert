<?php
$post_ids = 'selected' === get_sub_field('source')
    ? array_filter(get_sub_field('posts') ?: [], fn($post_id) => 'publish' === get_post_status($post_id))
    : get_posts([
        'post_type'   => 'post',
        'numberposts' => -1,
        'fields'      => 'ids',
    ]);
$post_ids = array_values(array_diff($post_ids, is_singular('post') ? [get_queried_object_id()] : []));
$link = get_sub_field('link');

if( empty($post_ids) ) return;
?>

<?php echo ds_open_section('text-ds-main'); ?>
<div class="ds-section flex flex-col gap-[20px] lg:gap-[40px]" x-data="dsBlogSlider">
    <div class="flex flex-row items-end justify-between gap-[30px]">
        <div class="flex flex-col gap-[10px] lg:gap-[20px]">
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
        ds_render_component('link-button-arrow', [
            'link'      => $link,
            'css_class' => 'hidden lg:flex shrink-0',
        ]);
        ?>
    </div>

    <div class="swiper w-full" x-ref="swiper">
        <div class="swiper-wrapper">
            <?php foreach( $post_ids as $post_id ): ?>
            <div class="swiper-slide !h-auto">
                <?php ds_render_component('post-card', [
                    'post_id' => $post_id,
                ]); ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="lg:hidden flex flex-row flex-wrap items-center justify-between gap-[20px]">
        <?php ds_render_component('link-button-arrow', [
            'link' => $link,
        ]); ?>

        <?php if( count($post_ids) > 1 ): ?>
        <div class="flex flex-row gap-[20px] ml-auto">
            <button type="button" class="shrink-0 rotate-180 transition-opacity hover:opacity-80 disabled:opacity-40"
                aria-label="<?php esc_attr_e('Vorheriger Beitrag', 'ds-starter'); ?>" :disabled="isBeginning" @click="prev">
                <img src="<?php echo esc_url(ds_get_theme_icon_url('slider-arrow-right.svg')); ?>" alt="" class="size-[38px]">
            </button>
            <button type="button" class="shrink-0 transition-opacity hover:opacity-80 disabled:opacity-40"
                aria-label="<?php esc_attr_e('Nächster Beitrag', 'ds-starter'); ?>" :disabled="isEnd" @click="next">
                <img src="<?php echo esc_url(ds_get_theme_icon_url('slider-arrow-right.svg')); ?>" alt="" class="size-[38px]">
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php echo ds_close_section(); ?>
