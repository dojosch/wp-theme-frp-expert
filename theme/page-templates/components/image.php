<?php 
    if( !isset($image) || !is_array($image) || !isset($image['src']) ) return;

    $css_class = $css_class ?? '';
?>

<img src="<?php echo $image['src']; ?>" alt="<?php echo $image['alt']; ?>" class="<?php echo esc_attr($css_class); ?>">