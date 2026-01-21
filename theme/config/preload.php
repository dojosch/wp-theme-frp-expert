<?php
/**
 * Preload fonts to improve performance.
 *
 * @package wp-starter-tw
 */
function ds_preload_fonts() {
    $font_dir = get_template_directory() . '/assets/fonts/';
    $font_url = get_template_directory_uri() . '/assets/fonts/';

    if ( is_dir( $font_dir ) ) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $font_dir, RecursiveDirectoryIterator::SKIP_DOTS )
        );

        foreach ( $iterator as $file ) {
            if ( $file->isFile() && in_array( $file->getExtension(), array( 'woff', 'woff2', 'ttf', 'otf' ) ) ) {
                $relative_path = substr( $file->getPathname(), strlen( $font_dir ) );
                $font_path = $font_url . $relative_path;
                $font_type = $file->getExtension();

                if($font_type !== 'woff2') continue;

                echo '<link rel="preload" href="' . esc_url( $font_path ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
            }
        }
    }
}
add_action( 'wp_head', 'ds_preload_fonts' );

/**
 * Preload header images from the first section's ACF fields.
 *
 * This function retrieves the 'elements' ACF field, checks the first section
 * for any image-type fields, and preloads those images in the document head.
 *
 * @return void
 */
function ds_preload_header_images() {
    $elements = get_field('elements');
    $first_section = $elements[0] ?? null;

    if( !$first_section) return;
    
    foreach( $first_section as $key => $value ) {
        if( is_array($value) && isset($value['type']) && $value['type'] === 'image' && isset($value['url']) ) {
            $image_url = $value['url'];
            echo '<link rel="preload" href="' . esc_url( $image_url ) . '" as="image" fetchpriority="high">' . "\n";
        }
    }

}
add_action( 'wp_head', 'ds_preload_header_images');