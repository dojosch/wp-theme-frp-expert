<?php

$popups = get_posts(
	[
		'post_type'      => 'ds_popups',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_key'       => 'active',
		'meta_value'     => '1',
	]
);

if ( empty( $popups ) ) {
	return;
}

$queried_id = get_queried_object_id();
?>

<?php foreach ( $popups as $popup ) : ?>
<?php
	$popup_id = $popup->ID;

	if ( ! get_field( 'active', $popup_id ) ) {
		continue;
	}

	// Display option check.
	$display_option = get_field( 'display_option', $popup_id ) ?: 'all';

	if ( 'pages' === $display_option ) {
		$page_ids = array_map(
			function( $p ) {
				return is_object( $p ) ? (int) $p->ID : (int) $p;
			},
			(array) get_field( 'pages', $popup_id )
		);
		$page_ids = array_filter( $page_ids );

		if ( ! in_array( (int) $queried_id, $page_ids, true ) ) {
			continue;
		}
	} elseif ( 'categories' === $display_option ) {
		$cat_ids = array_map(
			function( $cat ) {
				return is_object( $cat ) ? (int) $cat->term_id : (int) $cat;
			},
			(array) get_field( 'categories', $popup_id )
		);
		$cat_ids = array_filter( $cat_ids );

		$current_cat_ids = [];
		if ( is_category() || is_tax() ) {
			$current_cat_ids[] = (int) $queried_id;
		} elseif ( is_singular() ) {
			$current_cat_ids = array_map( 'intval', wp_get_post_categories( get_the_ID() ) );
		}

		if ( empty( array_intersect( $current_cat_ids, $cat_ids ) ) ) {
			continue;
		}
	}

	$heading         = get_field( 'heading', $popup_id );
	$text            = get_field( 'text', $popup_id );
	$button1         = get_field( 'button_1', $popup_id );
	$button2         = get_field( 'button_2', $popup_id );
	$popup_settings  = get_field( 'popup_settings', $popup_id ) ?: [];
	$cookie_duration = isset( $popup_settings['cookie_duration'] ) ? (int) $popup_settings['cookie_duration'] : 7;
	$popup_delay     = isset( $popup_settings['delay'] ) ? (int) $popup_settings['delay'] : 3;
	?>
<dialog id="popup-<?php echo esc_attr( $popup_id ); ?>"
    class="popup-dialog fixed inset-0 m-auto w-[calc(100%-32px)] max-w-[560px] rounded-[24px] lg:rounded-[36px] bg-ds-beige-dark p-[28px] lg:p-[44px] text-ds-brown shadow-2xl border border-ds-brown/15 backdrop:bg-ds-brown/60 backdrop:backdrop-blur-sm z-[9999]"
    data-cookie-duration="<?php echo esc_attr( $cookie_duration ); ?>"
    data-popup-delay="<?php echo esc_attr( $popup_delay ); ?>">
    <div class="relative flex flex-col gap-[20px] lg:gap-[24px]">
        <button type="button"
            class="popup-close absolute -top-[12px] -right-[12px] lg:-top-[18px] lg:-right-[18px] size-[36px] rounded-full border border-ds-brown/20 bg-ds-beige text-ds-brown hover:bg-ds-rost hover:text-ds-white hover:border-ds-rost flex items-center justify-center transition-colors duration-200 cursor-pointer shadow-sm"
            aria-label="<?php esc_attr_e( 'Schließen', 'ds-starter' ); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"
                class="stroke-current" stroke-width="1.8" stroke-linecap="round">
                <line x1="3" y1="3" x2="13" y2="13" />
                <line x1="13" y1="3" x2="3" y2="13" />
            </svg>
        </button>

        <?php ds_render_component('heading', [
            'heading'   => $heading,
            'css_class' => 'font-light text-[26px] leading-[34px] lg:text-[36px] lg:leading-[44px] text-ds-brown',
        ]); ?>

        <?php ds_render_component('text', [
            'text'      => $text,
            'css_class' => 'ds-wysiwyg text-ds-16 lg:text-ds-18 leading-[24px] lg:leading-[26px] text-ds-brown/85',
        ]); ?>

        <?php if ( $button1 || $button2 ) : ?>

        <!-- ds-lint-ignore -->
        <div class="flex flex-col sm:flex-row gap-[12px] mt-[8px]">
            <?php ds_render_component('link-button', [
                'link'      => $button1,
                'css_class' => 'ds-button--rost popup-btn',
            ]); ?>

            <?php ds_render_component('link-button', [
                'link'      => $button2,
                'css_class' => 'ds-button--black-outline popup-btn',
            ]); ?>
        </div>
        <?php endif; ?>
    </div>
</dialog>
<?php endforeach; ?>