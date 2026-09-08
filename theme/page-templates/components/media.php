<?php
/**
 * Media component.
 *
 * Renders either an image or a video with a play/pause button.
 *
 * @var array  $media     ACF media group: type, image, video, video_thumbnail.
 * @var string $css_class Optional. Classes applied to the media wrapper.
 */

if( empty($media) || !is_array($media) ) return;

$css_class = $css_class ?? '';

if( 'video' !== ($media['type'] ?? 'image') ) {
    $image_id = is_numeric($media['image'] ?? null) ? $media['image'] : ($media['image']['id'] ?? null);
    ds_render_component('image', [
        'image'     => ds_get_image_data_from_id($image_id),
        'css_class' => $css_class,
    ]);
    return;
} else {
    ds_render_component('video', [
        'video'     => $media['video'] ?? null,
        'poster'    => $media['video_thumbnail'] ?? null,
        'css_class' => $css_class,
    ]);
}