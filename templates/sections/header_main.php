<?php
    $media = get_sub_field('media');
    $heading = get_sub_field('heading');
    $sub_heading = get_sub_field('sub_heading');
    $is_video = 'video' === ( $media['type'] ?? 'image' );
    $defaults   = get_field( 'defaults', 'option' );
    $play_text  = $defaults['video_play_text'] ?? 'Video abspielen';
    $pause_text = $defaults['video_pause_text'] ?? 'Video pausieren';
?>

<?php echo ds_open_section('relative min-h-screen overflow-hidden text-ds-white'); ?>

<div<?php echo $is_video ? ' x-data="{ playing: true }"' : ''; ?>>

    <?php ds_render_component('media', array(
        'media'       => $media,
        'css_class'   => 'absolute inset-0 size-full object-cover',
        'autoplay'    => true,
        'show_button' => false,
    )); ?>

    <div class="pointer-events-none absolute inset-0 bg-black/50"></div>

    <div
        class="relative flex min-h-screen flex-col items-center justify-center px-[30px] pb-[140px] pt-[160px] lg:px-[60px]">
        <?php
        ds_render_component('heading', array(
            'heading'   => $heading,
            'css_class' => 'text-center text-ds-30 font-light leading-[35px] lg:text-ds-55 lg:leading-[60px]',
        ));
        ?>
    </div>

    <?php if (!empty($sub_heading['heading']) || $is_video) : ?>
    <div
        class="absolute inset-x-0 bottom-[40px] flex flex-col items-center gap-[24px] px-[30px] text-center lg:bottom-[56px] lg:px-[60px]">
        <?php if (!empty($sub_heading['heading'])) : ?>
        <?php ds_render_component('heading', array(
                'heading'   => $sub_heading,
                'css_class' => 'text-ds-14 font-light leading-[20px] lg:text-ds-16',
            )); ?>
        <?php endif; ?>

        <?php if ($is_video) : ?>
        <button type="button" class="flex cursor-pointer appearance-none items-center border-0 bg-transparent p-0"
            :aria-label="playing ? '<?php echo esc_js($pause_text); ?>' : '<?php echo esc_js($play_text); ?>'"
            @click="playing ? $refs.video.pause() : $refs.video.play()">
            <?php ds_render_component('video-toggle-label', array(
                    'play_text'  => $play_text,
                    'pause_text' => $pause_text,
                )); ?>
        </button>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    </div>

    <?php echo ds_close_section(); ?>