<?php
if( !is_singular('post') ) return;

$back_link = get_sub_field('back_link') ?: [
    'url'    => home_url('/'),
    'title'  => 'Zurück',
    'target' => '',
];
?>

<?php echo ds_open_section('text-ds-main'); ?>
<div class="ds-section max-w-[1102px] pt-[90px] pb-[5px] lg:pt-[110px] lg:pb-[21px] flex flex-col gap-[30px] lg:gap-[40px]">
    <?php echo ds_open_link($back_link, 'flex flex-row items-center gap-[10px] h-[40px] lg:h-[50px] border-b border-[#d9d9d9] text-[11px] leading-[14px] lg:text-ds-13 lg:leading-[18px] transition-colors hover:text-ds-accent'); ?>
    <img src="<?php echo esc_url(ds_get_theme_icon_url('arrow-right-16.svg')); ?>" alt="" class="shrink-0 rotate-180">
    <?php echo esc_html($back_link['title']); ?>
    <?php echo ds_close_link(); ?>

    <div class="flex flex-col gap-[10px] lg:gap-[20px]">
        <?php
        ds_render_component('heading', [
            'heading'   => ['heading' => get_field('sub_heading'), 'heading_tag' => 'div'],
            'css_class' => 'ds-subheading gap-[5px] lg:gap-[10px]',
        ]);
        ds_render_component('heading', [
            'heading'   => ['heading' => get_the_title(), 'heading_tag' => 'h1'],
            'css_class' => 'ds-heading',
        ]);
        ?>
    </div>

    <?php
    ds_render_component('image', [
        'image'     => ds_get_image_data_from_sub_field('image', 'full'),
        'css_class' => '-mx-[20px] w-[calc(100%+40px)] max-w-none aspect-[390/254] object-cover lg:mx-0 lg:w-full lg:aspect-[982/539] lg:rounded-[5px]',
    ]);
    ?>
</div>
<?php echo ds_close_section(); ?>
