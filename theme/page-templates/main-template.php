<?php
/**
 * Main Template for WordPress Theme
 *
 * This file defines a custom page template for the WordPress theme.
 *
 * Template Name: Main Template
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage wp-starter-tw
 * @since 1.0.0
 */

get_header();
?>

<main class="min-h-dvh">
	<?php if ( have_rows( 'elements' ) ) : ?>
		<?php
		while ( have_rows( 'elements' ) ) :
			the_row();
			?>
			<?php
			$layout       = get_row_layout();
			$section_path = 'sections/' . $layout . '.php';
			$file         = get_stylesheet_directory() . '/page-templates/' . $section_path;

			if ( file_exists( $file ) ) {
				include $section_path;
			} else {
				ds_missing_layout_notice( $layout );
			}
			?>
		<?php endwhile; ?>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
