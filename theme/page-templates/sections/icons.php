<?php
	$icons = get_sub_field( 'icons' );
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-[60px]">
            <?php foreach ( $icons as $icon ) : ?>
                <?php $image_data = ds_get_image_data_from_id( $icon['image'] ); ?>
                <div class="flex flex-row gap-[30px] items-center">
                    <?php
                        ds_render_component( 'image', [
                            'image'     => $image_data,
                            'css_class' => 'size-[50px] md:size-[35px] shrink-0',
                        ] );
                    
                        ds_render_component( 'text', [
                            'text'       => $icon['text'],
                            'css_class'  => 'text-sm hyphens-auto',
                        ] );
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php echo ds_close_section() ?>    
