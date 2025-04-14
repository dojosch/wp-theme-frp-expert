<?php
    $shortcode = get_sub_field('shortcode');
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section">
        <?php 
            ds_render_component( 'shortcode', [
                'shortcode' => $shortcode,
                'css_class'  => 'ds-cf',
            ] );
        ?>
    </div>
<?php echo ds_close_section() ?>    
