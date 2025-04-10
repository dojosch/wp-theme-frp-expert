<?php
    $shortcode = get_sub_field('shortcode');
?>

<section class="w-full">
    <div class="ds-section">
        <?php 
            ds_render_component( 'shortcode', [
                'shortcode' => $shortcode,
                'css_class'  => 'ds-cf',
            ] );
        ?>
    </div>
</section>