<?php

$popups = get_posts([
		'post_type'      => 'ds_popups',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_key'       => 'active',
		'meta_value'     => '1',
	]);

if( empty($popups) ) return;

$queried_id = get_queried_object_id();
?>

<?php foreach( $popups as $popup ) : ?>
<?php
	$popup_id = $popup->ID;

	if( !get_field('active', $popup_id) ) continue;

	// Display option check.
	$display_option = get_field('display_option', $popup_id) ?: 'all';

	if( 'pages' === $display_option ) {
		$page_ids = array_map(
			function($p) {
				return is_object($p) ? (int) $p->ID : (int) $p;
			},
			(array) get_field('pages', $popup_id)
		);
		$page_ids = array_filter($page_ids);

		if( !in_array((int) $queried_id, $page_ids, true) ) continue;
	} elseif( 'categories' === $display_option ) {
		$cat_ids = array_map(
			function($cat) {
				return is_object($cat) ? (int) $cat->term_id : (int) $cat;
			},
			(array) get_field('categories', $popup_id)
		);
		$cat_ids = array_filter($cat_ids);

		$current_cat_ids = [];
		if( is_category() || is_tax() ) {
			$current_cat_ids[] = (int) $queried_id;
		} elseif( is_singular() ) {
			$current_cat_ids = array_map('intval', wp_get_post_categories(get_the_ID()));
		}

		if( empty(array_intersect($current_cat_ids, $cat_ids)) ) continue;
	}

	$heading = get_field('heading', $popup_id);
	$text = get_field('text', $popup_id);
	$button1 = get_field('button_1', $popup_id);
	$button2 = get_field('button_2', $popup_id);
	$popup_settings = get_field('popup_settings', $popup_id) ?: [];
	$cookie_duration = isset($popup_settings['cookie_duration']) ? (int) $popup_settings['cookie_duration'] : 7;
	$popup_delay = isset($popup_settings['delay']) ? (int) $popup_settings['delay'] : 3;
	?>
<dialog id="popup-<?php echo esc_attr($popup_id); ?>"
    class="popup-dialog fixed inset-0 m-auto w-[calc(100%-40px)] max-w-[600px] rounded-[5px] border border-ds-light-accent-2 bg-ds-white p-[30px] lg:p-[50px] text-ds-main backdrop:bg-ds-main/60 backdrop:backdrop-blur-sm z-[9999]"
    data-cookie-duration="<?php echo esc_attr($cookie_duration); ?>"
    data-popup-delay="<?php echo esc_attr($popup_delay); ?>">
    <button type="button"
        class="popup-close absolute top-[15px] right-[15px] lg:top-[20px] lg:right-[20px] size-[38px] lg:size-[41px] flex items-center justify-center rounded-[3px] bg-ds-light-accent text-ds-main transition-colors hover:bg-ds-accent hover:text-ds-white cursor-pointer outline-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ds-accent"
        aria-label="<?php esc_attr_e('Schließen', 'ds-starter'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"
            class="stroke-current" stroke-width="1.8" stroke-linecap="round">
            <line x1="3" y1="3" x2="13" y2="13" />
            <line x1="13" y1="3" x2="3" y2="13" />
        </svg>
    </button>

    <div class="flex flex-col gap-[25px] lg:gap-[30px]">
        <div class="flex flex-col gap-[15px] lg:gap-[20px] pr-[40px]">
            <?php ds_render_component('heading', [
                'heading'   => $heading,
                'css_class' => 'font-semibold text-ds-28 leading-[1.1] lg:text-ds-35',
            ]); ?>

            <?php ds_render_component('text', [
                'text'      => $text,
                'css_class' => 'ds-wysiwyg lg:gap-[20px]',
            ]); ?>
        </div>

        <?php if( $button1 || $button2 ) : ?>
        <div class="flex flex-col sm:flex-row gap-[10px]">
            <?php ds_render_component('link-button', [
                'link'      => $button1,
                'css_class' => 'popup-btn',
            ]); ?>

            <?php ds_render_component('link-button', [
                'link'      => $button2,
                'css_class' => 'popup-btn bg-transparent text-ds-accent hover:bg-ds-accent hover:text-ds-white',
            ]); ?>
        </div>
        <?php endif; ?>
    </div>
</dialog>
<?php endforeach; ?>