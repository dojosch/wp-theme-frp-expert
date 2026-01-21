<?php
if ( ! isset( $video ) || ! is_array( $video ) ) {
    return;
}

$video_url = $video['url'] ?? '';
$mime_type = $video['mime_type'] ?? 'video/mp4';

if ( empty( $video_url ) || ! filter_var( $video_url, FILTER_VALIDATE_URL ) ) {
    return;
}
?>
<video controls class="<?php echo esc_attr( $css_class ); ?>">
    <source src="<?php echo esc_url( $video_url ); ?>" type="<?php echo esc_attr( $mime_type ); ?>">
    Your browser does not support the video tag.
</video>