<?php $rows = get_sub_field('rows'); ?>

<?php echo ds_open_section('text-ds-main'); ?>
<div class="ds-section flex flex-col gap-[30px] lg:gap-[50px]">
    <div class="flex flex-col gap-[10px] lg:gap-[20px]">
        <?php
        ds_render_component('heading', [
            'heading'   => get_sub_field('sub_heading'),
            'css_class' => 'ds-subheading gap-[5px] lg:gap-[10px]',
        ]);
        ds_render_component('heading', [
            'heading'   => get_sub_field('heading'),
            'css_class' => 'ds-heading',
        ]);
        ds_render_component('text', [
            'text'      => get_sub_field('text'),
            'css_class' => 'text-ds-14 leading-[21px] lg:text-ds-16 lg:leading-[24px]',
        ]);
        ?>
    </div>

    <?php if( !empty($rows) ): ?>
    <div class="flex flex-col gap-[50px]">
        <?php foreach( $rows as $row ): ?>
        <div class="grid grid-cols-1 gap-[30px] lg:grid-cols-2 lg:gap-0 lg:border lg:border-ds-accent">
            <div class="flex items-center justify-center px-[20px] py-[35px] rounded-[3px] bg-ds-main lg:p-[50px] lg:rounded-none <?php echo 'right' === $row['image_position'] ? 'lg:order-2' : ''; ?>">
                <?php
                ds_render_component('image', [
                    'image'     => ds_get_image_data_from_id($row['image'], 'full'),
                    'css_class' => 'w-full aspect-[764/430] object-cover rounded-[5px] border border-ds-light-accent-2',
                ]);
                ?>
            </div>

            <div class="flex flex-col justify-center gap-[25px] lg:px-[99px] lg:py-[50px]">
                <div class="flex flex-col gap-[10px] lg:gap-[15px]">
                    <?php
                    ds_render_component('heading', [
                        'heading'   => ['heading' => $row['heading'], 'heading_tag' => 'h3'],
                        'css_class' => 'font-medium text-[18px] leading-[21px] lg:text-[21px] lg:leading-[28px]',
                    ]);
                    ds_render_component('text', [
                        'text'      => $row['text'],
                        'css_class' => 'text-ds-13 leading-[18px] lg:text-ds-15 lg:leading-[21px]',
                    ]);
                    ?>
                </div>

                <?php if( !empty($row['list']) ): ?>
                <ul class="flex flex-col border-t border-[#cdc8bc]">
                    <?php foreach( $row['list'] as $item ): ?>
                    <li class="flex flex-row items-start gap-[10px] py-[10px] border-b border-[#cdc8bc] text-ds-13 leading-[18px] lg:text-ds-15 lg:leading-[21px]">
                        <img src="<?php echo esc_url(ds_get_theme_icon_url('check-20.svg')); ?>" alt="" class="shrink-0 lg:hidden">
                        <img src="<?php echo esc_url(ds_get_theme_icon_url('check-24.svg')); ?>" alt="" class="shrink-0 hidden lg:block">
                        <span><?php echo esc_html($item['item']); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<?php echo ds_close_section(); ?>
