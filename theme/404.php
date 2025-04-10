<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package devsolution_Starter
 */

get_header();

$text = get_field('text_404', 'option');
?>

<section class="ds-section">
	<div class="container mx-auto px-[25px] min-h-[25vh] mt-[120px]">
		<div class="ds-wysiwyg">
			<?php echo $text; ?>
		</div>
	</div>
</section>

<?php
get_footer();
