<?php
    $heading      = get_sub_field( 'heading' );
    $heading_tag  = get_sub_field( 'heading_tag' );
    $list         = get_sub_field( 'list' );
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section">
        <?php
            ds_render_component( 'heading', [
                'heading'     => $heading,
                'heading_tag' => $heading_tag,
                'css_class'   => 'ds-heading text-center lg:text-left mx-auto lg:mx-0 lg:w-[55%]',
            ] );
        ?>
        <?php if ( $list && count( $list ) > 0 ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-[60px] gap-x-[110px] mt-[40px] lg:mt-[40px]">
                <?php foreach ( $list as $item ) : ?>
                    <?php $image_data = ds_get_image_data_from_id( $item['image'] ); ?>
                    <div class="flex flex-row items-center gap-[36px]">
                        <?php
                            ds_render_component( 'image', [
                                'image'     => $image_data,
                                'css_class' => 'size-[50px] md:size-[35px] shrink-0',
                            ] );
                       
                            ds_render_component( 'text', [
                                'text' => $item['text'],
                                'css_class' => 'ds-wysiwyg text-sm',
                            ]);
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php echo ds_close_section() ?>    
