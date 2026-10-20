<?php $items = get_sub_field('items'); ?>

<?php echo ds_open_section('text-ds-main'); ?>
<div class="ds-section lg:py-[100px]">
    <div class="relative flex flex-col gap-[20px] lg:grid lg:grid-cols-[495px_1fr] lg:gap-0 lg:rounded-[5px] lg:bg-ds-white"
        x-data="{ active: 0 }">
        <div class="flex flex-col gap-[20px] lg:px-[41px] lg:pt-[40px] lg:pb-[58px]">
            <div class="flex flex-col gap-[10px] lg:gap-[18px]">
                <?php
                ds_render_component('heading', [
                    'heading'   => get_sub_field('sub_heading'),
                    'css_class' => 'ds-subheading gap-[5px] lg:gap-[10px]',
                ]);
                ds_render_component('heading', [
                    'heading'   => get_sub_field('heading'),
                    'css_class' => 'ds-heading lg:max-w-[300px] lg:leading-[50px]',
                ]);
                ?>
            </div>

            <?php if( !empty($items) ): ?>
            <ul class="flex flex-col lg:max-w-[287px]">
                <?php foreach( $items as $index => $item ): ?>
                <li>
                    <button type="button"
                        class="w-full flex flex-row items-center gap-[10px] py-[15px] text-left text-[11px] leading-[14px] lg:text-ds-13 lg:leading-[18px] cursor-pointer"
                        :class="active === <?php echo (int) $index; ?> ? 'font-semibold border-b-2 border-ds-accent' : 'border-b border-[#d9d9d9]'"
                        :aria-expanded="active === <?php echo (int) $index; ?>" @click="active = <?php echo (int) $index; ?>">
                        <img src="<?php echo esc_url(ds_get_theme_icon_url('arrow-right-16.svg')); ?>" alt="" class="shrink-0">
                        <?php echo esc_html($item['label']); ?>
                    </button>

                    <div class="py-[20px] lg:p-0 lg:absolute lg:inset-y-0 lg:right-0 lg:left-[495px]"
                        x-show="active === <?php echo (int) $index; ?>" <?php echo 0 === $index ? '' : 'x-cloak'; ?>>
                        <?php if( 'video' === ($item['media']['type'] ?? 'image') && !empty($item['media']['video']['url']) ): ?>
                        <div class="relative aspect-video lg:aspect-auto lg:h-full overflow-hidden rounded-r-[5px] bg-ds-main"
                            x-data="{ playing: false }"
                            x-effect="if( active !== <?php echo (int) $index; ?> ) $refs.video.pause()">
                            <video class="size-full object-cover" x-ref="video" playsinline preload="metadata"
                                poster="<?php echo esc_url(ds_get_image_data_from_id($item['media']['video_thumbnail'] ?? null, 'full')['src'] ?? ''); ?>" @play="playing = true"
                                @pause="playing = false" @click="$refs.video.pause()">
                                <source src="<?php echo esc_url($item['media']['video']['url']); ?>"
                                    type="<?php echo esc_attr($item['media']['video']['mime_type'] ?? 'video/mp4'); ?>">
                            </video>

                            <button type="button"
                                class="absolute inset-0 flex items-center justify-center bg-black/15 backdrop-blur-[33px] cursor-pointer"
                                x-show="!playing" x-transition.opacity aria-label="Video abspielen"
                                @click="$refs.video.play()">
                                <img src="<?php echo esc_url(ds_get_theme_icon_url('play-circle-32.svg')); ?>" alt=""
                                    class="lg:hidden">
                                <img src="<?php echo esc_url(ds_get_theme_icon_url('play-circle-80.svg')); ?>" alt=""
                                    class="hidden lg:block">
                            </button>
                        </div>
                        <?php else: ?>
                        <?php
                        ds_render_component('image', [
                            'image'     => ds_get_image_data_from_id($item['media']['image'] ?? null, 'full'),
                            'css_class' => 'w-full aspect-video object-cover rounded-r-[5px] lg:aspect-auto lg:h-full',
                        ]);
                        ?>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <div class="hidden lg:block aspect-[884/497]" aria-hidden="true"></div>
    </div>
</div>
<?php echo ds_close_section(); ?>
