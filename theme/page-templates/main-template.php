<?php
/*
 * Template Name: Main Template
 * Template Post Type: page
 */

get_header();
?>

<main class="min-h-dvh">
    <?php if ( have_rows('elements') ) : ?>
        <?php while ( have_rows('elements') ) : the_row(); ?>
            <?php
            $layout     = get_row_layout();
            $path       = 'sections/' . $layout . '.php';
            $file       = get_stylesheet_directory() . '/page-templates/' . $path;

            if ( file_exists( $file ) ) {
                include $path;
            } else {
                ds_missing_layout_notice( $layout );
            }
            ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
