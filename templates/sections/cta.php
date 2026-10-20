<?php
    $heading = get_sub_field('heading');
    $sub_heading = get_sub_field('sub_heading');
    $link = get_sub_field('link');
    $image = ds_get_image_data_from_sub_field('image');
    $is_left = get_sub_field('image_position') === 'left';
?>

<?php echo ds_open_section(); ?>

<div class="ds-section py-0 lg:py-[80px]">
    <div class="-mx-[30px] flex flex-col items-center gap-[52px] px-[30px] py-[80px] text-center text-ds-beige lg:mx-0 lg:grid lg:items-center lg:gap-x-[60px] lg:gap-y-[60px] lg:p-[76px] lg:text-left <?php
            echo $is_left
                ? "lg:grid-cols-[414px_1fr] lg:[grid-template-areas:'image_heading'_'image_footer']"
                : "lg:grid-cols-[1fr_414px] lg:[grid-template-areas:'heading_image'_'footer_image']";
        ?>">
        <?php
            ds_render_component('heading', [
                'heading' => $heading,
                'css_class' => 'font-light text-[35px] leading-[40px] lg:text-[55px] lg:leading-[60px] lg:[grid-area:heading]',
            ]);
        ?>

        <?php
            ds_render_component('image', [
                'image' => $image,
                'css_class' => 'aspect-[414/343] w-full object-cover lg:h-auto lg:w-[414px] lg:shrink-0  lg:[grid-area:image]',
            ]);
        ?>

        <div
            class="flex flex-col items-center gap-[38px] text-center lg:items-start lg:text-left lg:[grid-area:footer]">
            <?php
                ds_render_component('heading', [
                    'heading' => $sub_heading,
                    'css_class' => '-rotate-[5deg] text-[23px] leading-[28px] lg:text-[30px] lg:leading-[35px]',
                ]);
            ?>

            <?php if($link): ?>
            <div class="flex flex-wrap items-center justify-center gap-[12px] lg:justify-start">
                <?php
                    ds_render_component('link-button', [
                        'link' => $link,
                        'css_class' => '',
                    ]);
                ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo ds_close_section(); ?>