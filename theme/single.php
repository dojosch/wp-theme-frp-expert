<?php
/**
 * Single blog post (standard posts). Renders the post's flexible content like the main template.
 *
 * @package wp-starter-tw
 */

get_header();
?>

<main class="min-h-dvh">
    <?php
    while( have_rows('elements') ) {
        the_row();
        $file = get_stylesheet_directory() . '/page-templates/sections/' . get_row_layout() . '.php';

        if( file_exists($file) ) {
            include $file;
        } else {
            ds_missing_layout_notice(get_row_layout());
        }
    }
    ?>
</main>

<?php get_footer(); ?>
