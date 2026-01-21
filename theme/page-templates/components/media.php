<?php
/**
 * Media Component
 * 
 * Displays media based on type (image or video)
 * 
 * @param array $media {
 *     @type string $type The media type ('image' or 'video')
 *     @type int|string $image The image ID (optional)
 *     @type array $video The video array with 'url' and 'mime_type' (optional)
 *     @type string $css_class Additional CSS classes (optional)
 * }
 */
?>

<?php
if ( ! isset( $media['type'] ) ) {
    return;
}

$css_class = $css_class ?? '';
?>

<?php if ( $media['type'] === 'image' && isset( $media['image'] ) ) : ?>
<?php
    $image_data = ds_get_image_data_from_id( $media['image'] );
    ds_console_log($image_data);
    if ( $image_data && isset( $image_data['src'] ) ) :
    ?>
<img src="<?php echo esc_url( $image_data['src'] ); ?>" alt="<?php echo $image_data['alt']; ?>"
    class="<?php echo esc_attr( $css_class ); ?>">
<?php endif; ?>
<?php elseif ( $media['type'] === 'video' && isset( $media['video'] ) && is_array( $media['video'] ) ) : ?>
<?php
    $video_url = $media['video']['url'] ?? '';
    if ( ! empty( $video_url ) && filter_var( $video_url, FILTER_VALIDATE_URL ) ) :
        $mime_type = $media['video']['mime_type'] ?? 'video/mp4';
    ?>
<video controls class="<?php echo esc_attr( $css_class ); ?>">
    <source src="<?php echo esc_url( $video_url ); ?>" type="<?php echo esc_attr( $mime_type ); ?>">
    Your browser does not support the video tag.
</video>
<?php endif; ?>
<?php endif; ?>