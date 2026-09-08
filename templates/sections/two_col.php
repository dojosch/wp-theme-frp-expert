<?php
    $image = ds_get_image_data_from_sub_field('image');
    $image_position = get_sub_field('image_position');
    $heading = get_sub_field('heading');
    $text = get_sub_field('text');
    $link = get_sub_field('link');
?>

<?php echo ds_open_section(); ?>
<div class="ds-section flex flex-col gap-[53px] lg:grid lg:grid-cols-2 lg:items-end lg:gap-x-[60px]">
    <?php
        ds_render_component('image', [
            'image' => $image,
            'css_class' => 'aspect-[354/250] w-full object-cover lg:row-start-1 lg:aspect-[630/391] '
                . (($image_position ?? 'left') === 'right' ? 'lg:col-start-2' : 'lg:col-start-1'),
        ]);
    ?>

    <div
        class="flex flex-col gap-[32px] lg:row-start-1 lg:gap-[38px] <?php echo ($image_position ?? 'left') === 'right' ? 'lg:col-start-1' : 'lg:col-start-2'; ?>">
        <div class="flex flex-col gap-[15px] lg:gap-[29px]">
            <?php
                ds_render_component('heading', [
                    'heading' => $heading,
                    'css_class' => 'font-light text-[25px] leading-[35px] lg:text-[35px] lg:leading-[50px]',
                ]);

                ds_render_component('text', [
                    'text' => $text,
                ]);
            ?>
        </div>

        <?php
            ds_render_component('link-button', [
                'link' => $link,
            ]);
        ?>
    </div>
</div>
<?php echo ds_close_section(); ?>