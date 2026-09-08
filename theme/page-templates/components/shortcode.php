<?php
    if( !isset($shortcode) || !is_string($shortcode) ) return;

    $css_class = $css_class ?? '';
?>
<div class="<?php echo esc_attr($css_class); ?>">
    <?php echo do_shortcode($shortcode); ?>
</div>