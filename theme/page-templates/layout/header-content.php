<?php

$logo = ds_get_image_data_from_option_field('navigation_logo');
$links = get_field('navigation_links', 'options');

$home_link = [
    'url' => get_home_url(),
    'target' => '_self',
    'title' => 'Zur Startseite',
];
?>

<div x-data="dsNavigation()" x-effect="document.body.style.overflow = isSubmenuOpen ? 'hidden' : 'auto'" class="hidden">
    <header class="fixed top-0 w-full transition-all duration-300 z-[1000]"
        :class="!isScrolled && hasHeader ? 'bg-transparent' : 'bg-ds-white'">
        <div
            class="ds-section bg-transparent ds-section flex flex-row gap-[50px] justify-between h-full pt-[14px] lg:pt-[34px] pb-[9px] items-center lg:items-start">
            <?php echo ds_open_link($home_link, 'h-fit'); ?>
            <?php ds_render_component('image', [
                'image' => $logo,
                'css_class' => 'h-[62px] lg:h-[72px] w-auto',
            ]); ?>
            <?php echo ds_close_link(); ?>

            <?php if(is_array($links) && count($links) > 0): ?>
            <div class="hidden lg:flex flex-row lg:gap-[50px] xl:gap-[74px] pt-[8px]">
                <?php foreach($links as $link): ?>
                <div x-data="{ linkHref: '<?php echo esc_url($link['link']['url']); ?>' }"
                    :class="isActive(linkHref) && !hasHeader ? 'text-ds-red-dark' : (!isScrolled && hasHeader ? 'text-ds-white' : 'text-ds-black')">
                    <?php ds_render_component('link', [
                        'link' => $link['link'],
                        'css_class' => 'leading-[50px] text-ds-18 font-amarante uppercase transition-colors duration-300',
                    ]); ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <button class="lg:hidden ds-button px-[20px] h-fit"
                :class="!isScrolled && hasHeader ? 'text-ds-white' : 'text-ds-black'" aria-label="Menü öffnen"
                @click="isSubmenuOpen = true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Submenu -->
    <div class=" ds-header--submenu w-full h-[100dvh] left-0 z-[1050] fixed bg-ds-beige" x-show="isSubmenuOpen"
        x-transition.opacity x-cloak>
        <div class="ds-section py-[14px] flex flex-col justify-between min-h-full">
            <!-- Top Row -->
            <div class="bg-transparent flex flex-row justify-between items-center h-full">
                <?php echo ds_open_link($home_link, 'h-fit'); ?>
                <?php ds_render_component('image', [
                    'image' => $logo,
                    'css_class' => ' h-[62px] w-auto',
                ]); ?>
                <?php echo ds_close_link(); ?>

                <button class="lg:hidden px-[20px] ds-button h-fit" aria-label="Menü schließen"
                    @click="isSubmenuOpen = false">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Links -->
            <div class="flex flex-col gap-[20px] justify-center py-[28px] overflow-y-auto h-[calc(100dvh-76px)]">

                <div class="flex flex-col gap-[35px] text-ds-black overflow-y-auto max-h-full ds-no-scrollbar">
                    <?php if(is_array($links) && count($links) > 0): ?>
                    <?php foreach($links as $link): ?>
                    <div x-data="{ linkHref: '<?php echo esc_url($link['link']['url']); ?>' }"
                        :class="isActive(linkHref) ? 'text-ds-red-dark' : ''">
                        <?php ds_render_component('link', [
                            'link' => $link['link'],
                            'css_class' => 'text-ds-30',
                        ]); ?>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>