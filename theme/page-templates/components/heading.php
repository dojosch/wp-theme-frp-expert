<?php 
$heading = $heading['heading'] ?? null;
$heading_tag = $heading['heading_tag'] ?? null;
$css_class = $css_class ?? '';

if($heading): ?>
<?php echo ds_get_heading($heading, $heading_tag, esc_attr($css_class)); ?>
<?php endif; ?>