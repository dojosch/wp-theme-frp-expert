<?php
/**
 * Video component.
 *
 * Renders a video with a play/pause button.
 *
 * @var array  $video     ACF file array: url, mime_type.
 * @var int    $poster    Optional. Attachment ID shown while the video has not started.
 * @var string $css_class Optional. Classes applied to the video wrapper.
 */

if( !isset($video) || !is_array($video) ) return;

$css_class = $css_class ?? '';
$video_url = $video['url'] ?? '';
$mime_type = $video['mime_type'] ?? 'video/mp4';

if( empty($video_url) || !filter_var($video_url, FILTER_VALIDATE_URL) ) return;

$poster_image = ds_get_image_data_from_id($poster ?? null, 'full');
?>
<div class="relative <?php echo esc_attr($css_class); ?>" x-data="{ playing: false }">
    <video class="w-full h-full object-cover" x-ref="video" playsinline preload="metadata"
        poster="<?php echo esc_url($poster_image['src'] ?? ''); ?>" @play="playing = true" @pause="playing = false">
        <source src="<?php echo esc_url($video_url); ?>" type="<?php echo esc_attr($mime_type); ?>">
    </video>

    <button type="button"
        class="absolute inset-0 flex items-center justify-center cursor-pointer transition-opacity duration-300"
        :class="{ 'opacity-0 hover:opacity-100': playing }" aria-label="Toggle video playback"
        @click="playing ? $refs.video.pause() : $refs.video.play()">
        <span class="relative flex size-[96px]">
            <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 96 96" fill="none"
                class="opacity-[0.32]">
                <circle cx="48" cy="48" r="48" fill="#D9D9D9"
                    :class="{'drop-shadow-[0_4px_24px_rgba(0,0,0,0.24)]': !playing }" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="41" viewBox="0 0 35 41" fill="none"
                class="absolute top-1/2 -translate-y-1/2 left-[36px] opacity-[0.8]" :class="{ 'hidden': playing }">
                <path
                    d="M0 2.00312V38.8709C0 40.4328 1.71019 41.3919 3.0429 40.5775L33.2074 22.1436C34.4836 21.3637 34.4836 19.5103 33.2074 18.7304L3.0429 0.296562C1.71019 -0.51787 0 0.441265 0 2.00312Z"
                    fill="#FFF" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none"
                :class="{ 'hidden': !playing }" class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2">
                <path
                    d="M14 35C14 35.5523 13.5523 36 13 36H1C0.447716 36 0 35.5523 0 35V1C0 0.447716 0.447715 0 1 0H13C13.5523 0 14 0.447715 14 1V35ZM36 35C36 35.5523 35.5523 36 35 36H23C22.4477 36 22 35.5523 22 35V1C22 0.447716 22.4477 0 23 0H35C35.5523 0 36 0.447715 36 1V35Z"
                    fill="#D9D9D9" />
            </svg>
        </span>
    </button>
</div>