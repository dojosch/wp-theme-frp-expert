<?php
/**
 * Link button with arrow component
 *
 * Renders an ACF link as a split button: a `ds-button` label followed by a
 * square `ds-button` holding the arrow icon. Both halves switch to the hover
 * state together.
 *
 * @var array  $link      Required. ACF link array.
 * @var string $css_class Optional. Classes appended to the `ds-button-arrow` wrapper.
 */

if( !ds_is_valid_link($link ?? null) ) return;

$css_class = $css_class ?? '';
?>

<?php echo ds_open_link($link, 'ds-button-arrow ' . $css_class); ?>
<span class="ds-button w-[150px]"><?php echo esc_html($link['title']); ?></span>
<span class="ds-button ds-button-arrow__icon" aria-hidden="true"></span>
<?php echo ds_close_link(); ?>
