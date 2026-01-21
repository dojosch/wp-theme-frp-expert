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

$debugging = false;
?>

<main class="min-h-dvh <?php echo $debugging ? 'ds-debug' : ''; ?>">
    <?php if ( have_rows( 'elements' ) ) : ?>
    <?php
		while ( have_rows( 'elements' ) ) :
			the_row();
			?>
    <?php
			$layout       = get_row_layout();
			$section_path = 'sections/' . $layout . '.php';
			$file         = get_stylesheet_directory() . '/page-templates/' . $section_path;

			if($debugging) {
				?>
    <div class="rounded-md bg-blue-50 p-4 max-w-3xl mx-auto my-4">
        <div class="flex">
            <div class="shrink-0">
                <svg class="size-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                    data-slot="icon">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-sm text-blue-700">Section: <?php echo $layout ?></p>
                <p class="mt-3 text-sm md:mt-0 md:ml-6">

                </p>
            </div>
        </div>
    </div>
    <?php
			}

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