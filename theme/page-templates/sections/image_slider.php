<?php 
$images = get_sub_field('images');
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section-full">
        <?php if ($images && count($images) > 0): ?>
            <div class="ds-image-slider relative" role="region" aria-label="Image gallery slider">
                <!-- Custom cursor (only for desktop) -->
                <div class="ds-image-slider--cursor absolute items-center justify-center w-[64px] h-[48px] bg-primary rounded-[23px] pointer-events-none hidden z-10">
                    <div class="w-[35px] h-auto">
                        <img class="object-contain w-full h-full"
                            src="<?php echo ds_get_theme_icon_url('drag-white.svg'); ?>"
                            alt="Drag Hinweis">
                    </div>
                </div>

                <ul role="list"
                    class="max-h-[405px] ds-image-slider--slider flex overflow-hidden whitespace-nowrap cursor-none gap-[32px] select-none px-[8px]">
                    <?php foreach ($images as $elements): ?>
                        <?php 
                        $image = ds_get_image_data_from_id($elements['image']);
                        ?>
                        <?php if ($image): ?>
                            <li role="listitem"
                                class="shrink-0 basis-[90%] sm:basis-[50%] lg:basis-[20%] xl:basis-[14%]">
                                <figure>
                                    <img src="<?php echo $image['src']; ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>"
                                        class="w-full h-[293px] object-cover" draggable="false">
                                </figure>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
<?php echo ds_close_section() ?>    
