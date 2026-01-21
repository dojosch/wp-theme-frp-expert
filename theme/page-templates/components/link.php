<?php if($link): ?>
<?php 
$css_class = $css_class ?? '';
?>
<?php echo ds_get_link($link, esc_attr($css_class)); ?>
<?php endif; ?>