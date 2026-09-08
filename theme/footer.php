<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the `#content` element and all content thereafter.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package devsolution_Starter
 */

?>

</div><!-- #content -->

<?php get_template_part( 'page-templates/layout/footer', 'content' ); ?>
<?php get_template_part( 'page-templates/popup', 'template' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>