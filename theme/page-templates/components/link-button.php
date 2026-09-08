<?php
    if( !isset($link) || !is_array($link) ) return;

    $css_class = $css_class ?? '';
    echo ds_get_link($link, 'ds-button ' . esc_attr($css_class));
?>