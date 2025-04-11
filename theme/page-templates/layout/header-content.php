<?php
$buttons = get_field('navigation_buttons', 'options');
$links = get_field('navigation_links', 'options');
$link = get_field('navigation_link', 'options');
$home_link = [
    'url' => get_home_url(),
    'target' => '_self',
    'title' => 'Zur Startseite',
];
?>

<div
    x-data="{
        submenuOpen: false,
        activeTab: null,
        toggleTab(index) {
            if (this.activeTab === index) {
                this.activeTab = null;
            } else {
                this.activeTab = index;
            }
        }
    }"
    x-effect="document.body.style.overflow = submenuOpen ? 'hidden' : 'auto'"
>
    <header class="bg-background w-full fixed top0 z-[1000]">
        <div class="ds-section !py-[24px] flex flex-row justify-between items-center">
            <?php echo ds_open_link($home_link, "block w-[130px] lg:w-[145px] max-h-[80px] h-auto"); ?>
                <img
                    src="<?php echo ds_get_theme_logo_url('/logo-navigation.svg'); ?>"
                    alt="Logo"
                    class="block w-full h-auto object-contain"
                >
                <span class="sr-only"><?php echo $home_link['title']?></span>
            <?php echo ds_close_link(); ?>

            <div class="flex flex-row gap-[55px] items-center">
                <?php if ($buttons): ?>
                    <div class="lg:flex flex-row gap-[9px] hidden">
                        <?php foreach ($buttons as $button): ?>
                            <?php 
                                ds_render_component('link-button', [
                                    'link' => $button['link'],
                                    'css_class' => 'ds-button',
                                ]);
                            ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Burger -->
                <div 
                    class="size-[23.5px] cursor-pointer"
                    @click="submenuOpen = true"
                >
                    <img 
                        src="<?php echo ds_get_theme_icon_url('/menu-burger-grau.svg'); ?>" 
                        alt="Menü öffnen"
                        class="w-full h-full object-contain"
                    >
                </div>
            </div>
        </div>
    </header>

    <!-- Submenu -->
    <div
        class="ds-header--submenu w-[100vw] h-[100dvh] left-0 z-[1050] fixed bg-background"
        x-show="submenuOpen"
        x-transition.opacity
        x-cloak
    >
        <div class="ds-section !py-0 flex flex-col justify-between min-h-full">

            <!-- Top Row -->
            <div class="!py-[30px] flex flex-row justify-between items-center">
                <?php echo ds_open_link($home_link, "block w-[130px] lg:w-[145px] max-h-[80px] h-auto"); ?>
                    <img
                        src="<?php echo ds_get_theme_logo_url('/logo-navigation.svg'); ?>"
                        alt="Logo"
                        class="block w-full h-auto object-contain"
                    >
                    <span class="sr-only"><?php echo $home_link['title']?></span>
                <?php echo ds_close_link(); ?>

                <div class="flex flex-row gap-[55px] items-center">
                    <!-- Close -->
                    <div class="size-[19px] cursor-pointer" @click="submenuOpen = false; activeTab = null">
                        <img 
                            src="<?php echo ds_get_theme_icon_url('/menu-X-grau.svg'); ?>" 
                            alt="Menü schließen"
                            class="w-full h-full object-contain"
                        >
                    </div>
                </div>
            </div>

            <!-- Main Links -->
            <?php if ($links && count($links) > 0): ?>
            <div class="flex-1 flex flex-row items-center">
                <div class="flex flex-row gap-[50px] justify-between w-full">

                    <!-- Left Column -->
                    <div class="flex flex-col h-fit gap-[20px] lg:gap-0 overflow-y-auto max-h-[calc(100svh-204px)] lg:max-h-[calc(100svh-253px)] ds-no-scrollbar">

                        <?php foreach ($links as $index => $item): ?>
                            <?php $hasSub = $item['sub_links'] && count($item['sub_links']) > 0; ?>

                            <?php if ($item['link'] && $hasSub): ?>
                                <!-- Desktop tab -->
                                <div
                                    class="lg:flex flex-row items-center gap-[22px] cursor-pointer hidden"
                                    @mouseover="activeTab = '<?php echo $index; ?>'"
                                    :class="{ 'ds-header--tab-trigger-active': activeTab === '<?php echo $index; ?>' }"
                                >
                                    <div class="text-5xl hyphens-auto font-serif lg:font-extralight text-brand-light font-light leading-[90px]">
                                        <?php echo $item['link']['title']; ?>
                                    </div>
                                    <div class="size-[19px]">
                                        <img 
                                            src="<?php echo ds_get_theme_icon_url('/menu-plus-grau.svg'); ?>" 
                                            alt="Plus"
                                            class="w-full h-full object-contain transition-transform duration-200"
                                            :class="{ 'rotate-45': activeTab === '<?php echo $index; ?>' }">
                                    </div>
                                </div>

                                <!-- Mobile accordion -->
                                <div
                                    class="flex lg:hidden flex-row items-center gap-[22px] cursor-pointer"
                                    @click="toggleTab('<?php echo $index; ?>')"
                                >
                                    <div class="flex-1">
                                        <?php echo ds_get_link($item['link'], 'cursor-pointer hyphens-auto text-[42px] font-serif text-brand-light font-light leading-[normal]'); ?>
                                    </div>
                                    <div class="size-[19px] shrink-0">
                                        <img 
                                            src="<?php echo ds_get_theme_icon_url('/menu-plus-grau.svg'); ?>" 
                                            alt="Plus"
                                            class="w-full h-full object-contain transition-transform duration-200"
                                            :class="{ 'rotate-45': activeTab === '<?php echo $index; ?>' }"
                                        >
                                    </div>
                                </div>

                            <?php elseif ($item['link']): ?>
                                <!-- Regular link -->
                                <?php echo ds_get_link($item['link'], 'ds-header-link cursor-pointer hyphens-auto text-[42px] lg:text-5xl font-serif text-brand-light font-light leading-[normal] lg:leading-[90px]'); ?>
                            <?php endif; ?>

                            <!-- Mobile accordion content -->
                            <?php if ($hasSub): ?>
                            <div
                                class="flex-col gap-[5px] lg:hidden pl-4"
                                x-show="activeTab === '<?php echo $index; ?>'"
                                x-transition
                                x-cloak
                            >
                                <?php foreach ($item['sub_links'] as $sub_item): ?>
                                    <?php if ($sub_item['link']): ?>
                                        <?php echo ds_get_link($sub_item['link'], 'text-base leading-[26px] text-brand-light hover:text-brand-yellow'); ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Right Column (Desktop only) -->
                    <div class="w-[25.8%] text-brand-light text-base leading-[26px] mt-[102px] hidden lg:block">
                        <?php foreach ($links as $index => $item): ?>
                            <?php if ($item['sub_links'] && count($item['sub_links']) > 0): ?>
                            <div
                                class="flex-col gap-[5px]"
                                x-show="activeTab === '<?php echo $index; ?>'"
                                x-transition
                                x-cloak
                            >
                                <?php foreach ($item['sub_links'] as $sub_item): ?>
                                    <?php if ($sub_item['link']): ?>
                                        <?php echo ds_get_link($sub_item['link'], 'text-base leading-[26px] hover:text-brand-yellow'); ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Bottom -->
            <div class="py-[37px] lg:pb-48px lg:pt-[1px] flex flex-row justify-end lg:justify-between items-end">
                <?php if ($link): ?>
                    <?php echo ds_get_link($link, 'ds-button--yellow ds-button--hover-light'); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
