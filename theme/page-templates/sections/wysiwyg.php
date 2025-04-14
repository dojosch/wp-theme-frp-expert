<?php 
    $text = get_sub_field('text');
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section-medium">
        <?php 
            ds_render_component( 'text', [
                'text' => $text,
                'css_class' => 'ds-wysiwyg',
            ]);
        ?>
    </div>
<?php echo ds_close_section() ?>    
