<?php

$navigation = get_field('navigation', 'options');
$links = $navigation['links'] ?? [];
$button = $navigation['button'] ?? null;
$light = ds_has_light_header();
?>

<div x-data="dsNavigation()" x-effect="document.body.style.overflow = isSubmenuOpen ? 'hidden' : ''"
    @keydown.escape.window="isSubmenuOpen = false" @resize.window="if( window.innerWidth >= 1024 ) isSubmenuOpen = false">
    <header class="group/header fixed top-0 inset-x-0 z-[1000] transition-colors duration-300 <?php echo $light ? 'is-light' : ''; ?>"
        :class="{
            'bg-ds-main': isScrolled && !isSubmenuOpen,
            'bg-transparent': !isScrolled || isSubmenuOpen,
            'is-light': <?php echo $light ? 'true' : 'false'; ?> && !isScrolled && !isSubmenuOpen,
        }">
        <div class="ds-section py-0 lg:py-0 h-[90px] lg:h-[99px] flex flex-row items-center justify-between gap-[50px]">
            <?php echo ds_open_link(['url' => home_url('/'), 'title' => 'Zur Startseite'], 'shrink-0'); ?>
            <?php ds_render_component('image', [
                'image'     => ds_get_image_data_from_option_field('defaults_logo', 'full'),
                'css_class' => 'block h-[30px] w-auto group-[.is-light]/header:hidden',
            ]); ?>
            <?php ds_render_component('image', [
                'image'     => ds_get_image_data_from_id($navigation['logo_dark'] ?? null, 'full'),
                'css_class' => 'hidden h-[30px] w-auto group-[.is-light]/header:block',
            ]); ?>
            <?php echo ds_close_link(); ?>

            <?php if( !empty($links) ): ?>
            <nav class="hidden lg:flex flex-row gap-[15px] text-ds-13 leading-[24px]" aria-label="Hauptnavigation">
                <?php foreach( $links as $item ): ?>
                <?php ds_render_component('link', [
                    'link'      => $item['link'],
                    'css_class' => 'font-medium text-ds-white whitespace-nowrap transition-colors hover:text-ds-light-accent-3 group-[.is-light]/header:text-ds-main group-[.is-light]/header:hover:text-ds-accent',
                ]); ?>
                <?php endforeach; ?>
            </nav>
            <?php endif; ?>

            <?php ds_render_component('link-button-arrow', [
                'link'      => $button,
                'css_class' => 'hidden lg:flex',
            ]); ?>

            <button type="button" class="lg:hidden flex items-center justify-center size-[32px] shrink-0"
                aria-controls="ds-mobile-menu" :aria-expanded="isSubmenuOpen"
                :aria-label="isSubmenuOpen ? 'Menü schließen' : 'Menü öffnen'" @click="isSubmenuOpen = !isSubmenuOpen">
                <img src="<?php echo esc_url(ds_get_theme_icon_url('menu-burger-white.svg')); ?>" alt=""
                    class="group-[.is-light]/header:hidden" x-show="!isSubmenuOpen">
                <img src="<?php echo esc_url(ds_get_theme_icon_url('menu-burger-dark.svg')); ?>" alt=""
                    class="hidden group-[.is-light]/header:block" x-show="!isSubmenuOpen">
                <img src="<?php echo esc_url(ds_get_theme_icon_url('menu-x-white.svg')); ?>" alt="" x-show="isSubmenuOpen"
                    x-cloak>
            </button>
        </div>
    </header>

    <div id="ds-mobile-menu" class="lg:hidden fixed inset-0 z-[999] bg-ds-main overflow-y-auto" x-show="isSubmenuOpen"
        x-transition.opacity x-cloak>
        <div class="min-h-full grid grid-rows-[90px_1fr_90px] px-[22px]">
            <div class="row-start-2 flex flex-col items-center justify-center gap-[20px] py-[20px]">
                <?php if( !empty($links) ): ?>
                <nav class="flex flex-col w-full max-w-[348px]" aria-label="Mobile Navigation"
                    @click="isSubmenuOpen = false">
                    <?php foreach( $links as $item ): ?>
                    <?php ds_render_component('link', [
                        'link'      => $item['link'],
                        'css_class' => 'py-[10px] border-b border-ds-accent last:border-b-0 text-center text-[18px] leading-[24px] font-medium text-ds-white transition-colors hover:text-ds-light-accent-3',
                    ]); ?>
                    <?php endforeach; ?>
                </nav>
                <?php endif; ?>

                <div @click="isSubmenuOpen = false">
                    <?php ds_render_component('link-button-arrow', [
                        'link' => $button,
                    ]); ?>
                </div>
            </div>

            <?php if( !empty($navigation['meta_links']) ): ?>
            <div class="row-start-3 flex flex-row items-end justify-center pb-[30px]">
                <div class="flex flex-row items-center gap-[20px]">
                    <?php foreach( $navigation['meta_links'] as $i => $item ): ?>
                    <?php if( $i > 0 ): ?>
                    <span class="w-px h-[16px] bg-ds-accent" aria-hidden="true"></span>
                    <?php endif; ?>
                    <?php ds_render_component('link', [
                        'link'      => $item['link'],
                        'css_class' => 'text-[8px] leading-[10px] tracking-[1.6px] uppercase text-ds-white transition-colors hover:text-ds-light-accent-3',
                    ]); ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
