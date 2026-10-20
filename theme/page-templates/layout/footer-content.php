<?php

$footer = get_field('footer', 'options');
$meta_links = get_field('navigation', 'options')['meta_links'] ?? [];
?>

<footer class="relative isolate overflow-hidden text-ds-white bg-ds-main bg-[conic-gradient(from_270deg_at_calc(100%-26px)_calc(100%-58px),#0b1223_0%,#0f1933_32.212%,#18234d_35.877%,#202d66_39.543%,#304299_46.875%,#4056cc_54.207%,#506bff_61.538%,#6c83fe_71.154%,#899afc_80.769%,#c1c9fa_100%)] lg:bg-[conic-gradient(from_270deg_at_calc(100%-61px)_calc(100%-60px),#0b1223_0%,#0f1933_32.212%,#18234d_35.877%,#202d66_39.543%,#304299_46.875%,#4056cc_54.207%,#506bff_61.538%,#6c83fe_71.154%,#899afc_80.769%,#c1c9fa_100%)]">
    <div class="absolute inset-0 -z-10 bg-[rgba(126,126,126,0.87)] opacity-60 mix-blend-overlay" aria-hidden="true"></div>

    <div class="ds-section pt-[60px] pb-[21px] lg:pt-[100px] lg:pb-[21px] flex flex-col gap-[57px] lg:gap-[64px]">
        <div class="flex flex-col gap-[20px] lg:grid lg:grid-cols-2 lg:grid-rows-[auto_1fr] lg:gap-x-[20px] lg:gap-y-[51px] lg:px-[83px]">
            <div class="flex flex-col gap-[20px] lg:gap-[26px]">
                <?php
                ds_render_component('image', [
                    'image'     => ds_get_image_data_from_option_field('defaults_logo', 'full'),
                    'css_class' => 'block h-[30px] w-fit',
                ]);
                ds_render_component('text', [
                    'text'      => $footer['text'] ?? null,
                    'css_class' => 'flex flex-col gap-[21px] lg:gap-[24px] lg:max-w-[460px] text-[#fafafa]',
                ]);
                ?>
            </div>

            <?php
            ds_render_component('shortcode', [
                'shortcode' => $footer['form'] ?? null,
                'css_class' => 'ds-cf lg:col-start-2 lg:row-span-2',
            ]);
            ?>

            <div class="grid grid-cols-[196px_1fr] gap-x-[20px] pt-[15px] text-ds-13 leading-[1.5] lg:flex lg:flex-col lg:gap-[21px] lg:pt-0 lg:text-ds-14 lg:leading-[21px]">
                <?php
                ds_render_component('text', [
                    'text' => $footer['address'] ?? null,
                ]);
                ds_render_component('text', [
                    'text' => $footer['contact'] ?? null,
                ]);
                ?>
            </div>
        </div>

        <?php
        ds_render_component('image', [
            'image'     => ds_get_image_data_from_id($footer['watermark'] ?? null, 'full'),
            'css_class' => 'hidden lg:block w-full h-auto',
        ]);
        ?>

        <?php if( !empty($meta_links) ): ?>
        <nav class="flex flex-row items-center justify-center gap-[20px] h-[16px] lg:h-[18px]" aria-label="Rechtliches">
            <?php foreach( $meta_links as $index => $item ): ?>
            <?php if( $index > 0 ): ?>
            <span class="h-[16px] lg:h-[18px] border-l border-ds-accent" aria-hidden="true"></span>
            <?php endif; ?>
            <?php
            ds_render_component('link', [
                'link'      => $item['link'],
                'css_class' => 'text-[8px] leading-[10px] tracking-[1.6px] lg:text-[11px] lg:leading-[11px] lg:tracking-[2.2px] uppercase text-ds-main transition-colors hover:text-ds-accent',
            ]);
            ?>
            <?php endforeach; ?>
        </nav>
        <?php endif; ?>
    </div>
</footer>
