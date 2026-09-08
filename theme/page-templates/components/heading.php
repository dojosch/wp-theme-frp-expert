<?php 

if( !isset($heading) || !is_array($heading) ) return;

$title = $heading['heading'] ?? null;
$heading_tag = $heading['heading_tag'] ?? null;
$css_class = $css_class ?? '';

if( $title ): ?>
<?php echo ds_get_heading($title, $heading_tag, esc_attr($css_class)); ?>
<?php endif; ?>