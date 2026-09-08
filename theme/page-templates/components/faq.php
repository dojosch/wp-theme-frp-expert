<?php
/**
 * FAQ component
 *
 * Renders a single collapsible FAQ item. The content panel animates via
 * grid-template-rows (0fr → 1fr), so it works with content of any height and
 * needs no max-height guess.
 *
 * Every class is overridable so the component can be styled per project:
 *
 * @var string|array $heading         Required. Title text, or a heading array with 'heading' + 'heading_tag'.
 * @var string       $heading_tag     Optional. Tag for a string heading. Default 'span'.
 * @var string       $text            Optional. Answer markup (WYSIWYG).
 * @var int|string   $index           Optional. Item number; rendered when set.
 * @var string       $icon            Optional. Inline SVG markup for the toggle indicator.
 * @var bool         $open            Optional. Whether the item starts open. Default false.
 * @var string       $css_class       Optional. Classes for the item wrapper.
 * @var string       $button_class    Optional. Classes for the toggle button.
 * @var string       $number_class    Optional. Classes for the index.
 * @var string       $heading_class   Optional. Classes for the heading.
 * @var string       $icon_class      Optional. Classes always applied to the icon wrapper.
 * @var string       $icon_open_class Optional. Icon classes while open. Default 'rotate-90'.
 * @var string       $icon_idle_class Optional. Icon classes while closed.
 * @var string       $content_class   Optional. Classes for the inner content padding.
 * @var string       $text_class      Optional. Classes for the answer text.
 *
 * $icon is echoed unescaped — pass developer-authored markup, never user input.
 *
 * Example:
 *
 *     foreach ( $faq_ids as $i => $faq_id ) {
 *         ds_render_component(
 *             'faq',
 *             array(
 *                 'heading'         => get_the_title( $faq_id ),
 *                 'text'            => get_field( 'text', $faq_id ),
 *                 'index'           => $i + 1,
 *                 'icon'            => '<svg xmlns="http://www.w3.org/2000/svg" width="34" height="23" viewBox="0 0 34 23" fill="none"><path d="M22.885 22L33 11.5L22.885 1M33 11.5L1 11.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
 *                 'css_class'       => 'rounded-[30px] border-2 border-transparent bg-ds-ultrawhite transition-colors duration-300 lg:hover:border-ds-berry-barrierefrei',
 *                 'button_class'    => 'flex flex-col gap-[20px] p-[30px] lg:flex-row lg:items-center lg:gap-0 lg:px-[39px] lg:py-[34px]',
 *                 'number_class'    => 'text-ds-20 font-semibold text-ds-berry-barrierefrei lg:order-1 lg:w-[70px]',
 *                 'heading_class'   => 'hyphens-auto lg:order-2',
 *                 'icon_class'      => 'ml-auto text-ds-berry-barrierefrei lg:order-3',
 *                 'icon_open_class' => '-rotate-90',
 *                 'icon_idle_class' => 'lg:group-hover/faq:-rotate-45',
 *                 'content_class'   => 'px-[30px] pb-[30px] lg:pr-[151px] lg:pb-[34px] lg:pl-[109px]',
 *             )
 *         );
 *     }
 */

if ( empty( $heading ) ) {
	return;
}

if ( is_array( $heading ) ) {
	$title       = $heading['heading'] ?? '';
	$heading_tag = $heading['heading_tag'] ?? 'span';
} else {
	$title       = $heading;
	$heading_tag = $heading_tag ?? 'span';
}

if ( empty( $title ) ) {
	return;
}

$index           = $index ?? null;
$text            = $text ?? '';
$icon            = $icon ?? '';
$open            = ! empty( $open );
$css_class       = $css_class ?? '';
$button_class    = $button_class ?? '';
$number_class    = $number_class ?? '';
$heading_class   = $heading_class ?? '';
$icon_class      = $icon_class ?? '';
$icon_open_class = $icon_open_class ?? 'rotate-90';
$icon_idle_class = $icon_idle_class ?? '';
$content_class   = $content_class ?? '';
$text_class      = $text_class ?? 'ds-wysiwyg';

// Unique ids so multiple FAQ lists can share a page.
$GLOBALS['ds_faq_uid'] = ( $GLOBALS['ds_faq_uid'] ?? 0 ) + 1;
$uid                   = $GLOBALS['ds_faq_uid'];
?>

<div class="group/faq <?php echo esc_attr( $css_class ); ?>" x-data="{ open: <?php echo $open ? 'true' : 'false'; ?> }"
    <?php if ( null !== $index ) : ?>data-faq="<?php echo esc_attr( $index ); ?>" <?php endif; ?>>
    <button type="button" id="faq-trigger-<?php echo esc_attr( $uid ); ?>"
        class="w-full cursor-pointer text-left <?php echo esc_attr( $button_class ); ?>" @click="open = !open"
        :aria-expanded="open" aria-controls="faq-panel-<?php echo esc_attr( $uid ); ?>">
        <?php if ( null !== $index ) : ?>
        <span class="shrink-0 <?php echo esc_attr( $number_class ); ?>">
            <?php echo esc_html( $index ); ?>
        </span>
        <?php endif; ?>

        <?php echo ds_get_heading( $title, $heading_tag, $heading_class ); ?>

        <?php if ( $icon ) : ?>
        <span class="shrink-0 transition-transform duration-300 <?php echo esc_attr( $icon_class ); ?>"
            :class="open ? '<?php echo esc_attr( $icon_open_class ); ?>' : '<?php echo esc_attr( $icon_idle_class ); ?>'"
            aria-hidden="true">
            <?php echo $icon; ?>
        </span>
        <?php endif; ?>
    </button>

    <div id="faq-panel-<?php echo esc_attr( $uid ); ?>" role="region"
        aria-labelledby="faq-trigger-<?php echo esc_attr( $uid ); ?>"
        class="grid transition-all duration-300 <?php echo $open ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'; ?>"
        :class="{ 'grid-rows-[1fr]': open, 'grid-rows-[0fr]': !open }">
        <div class="overflow-hidden">
            <div class="<?php echo esc_attr( $content_class ); ?>">
                <?php
					ds_render_component('text', [
                        'text'      => $text,
                        'css_class' => $text_class,
                    ]); ?>
            </div>
        </div>
    </div>
</div>