<?php
$modes = get_sub_field('modes') ?: [];
$config = [
    'modes' => array_map(fn($mode) => [
        'sliders' => array_map(fn($slider) => [
            'key'   => $slider['key'],
            'unit'  => $slider['unit'],
            'min'   => (float) $slider['min'],
            'max'   => (float) $slider['max'],
            'value' => (float) $slider['value'],
        ], $mode['sliders'] ?: []),
    ], $modes),
];
?>

<?php echo ds_open_section('text-ds-main'); ?>
<div class="ds-section grid grid-cols-1 gap-[30px] lg:grid-cols-[minmax(0,540px)_minmax(0,784px)] lg:justify-between"
    x-data="dsCalculator(<?php echo esc_attr(wp_json_encode($config)); ?>)">
    <div class="flex flex-col gap-[20px] lg:gap-[36px]">
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
                'css_class' => 'text-ds-14 leading-[1.5] lg:text-ds-16 lg:leading-[24px] [&_br]:hidden lg:[&_br]:inline',
            ]);
            ?>
        </div>

        <?php if( count($modes) > 1 ): ?>
        <div class="flex flex-row gap-[10px]" role="tablist">
            <?php foreach( $modes as $index => $mode ): ?>
            <button type="button" role="tab"
                class="flex-1 lg:flex-none lg:w-[188px] h-[40px] lg:h-[50px] flex flex-row items-center gap-[10px] text-left text-[11px] leading-[14px] lg:text-ds-13 lg:leading-[18px] cursor-pointer"
                :class="active === <?php echo (int) $index; ?> ? 'font-semibold border-b-2 border-ds-accent' : 'border-b border-[#d9d9d9]'"
                :aria-selected="active === <?php echo (int) $index; ?>" @click="active = <?php echo (int) $index; ?>">
                <img src="<?php echo esc_url(ds_get_theme_icon_url('arrow-right-16.svg')); ?>" alt="" class="shrink-0">
                <?php echo esc_html($mode['label']); ?>
            </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <?php foreach( $modes as $index => $mode ): ?>
    <div class="flex flex-col gap-[10px] lg:gap-[24px] p-[24px] rounded-[5px] border border-[rgba(0,23,98,0.12)] bg-ds-light-accent"
        x-show="active === <?php echo (int) $index; ?>" <?php echo 0 === $index ? '' : 'x-cloak'; ?>>
        <?php
        ds_render_component('heading', [
            'heading'   => ['heading' => $mode['heading'], 'heading_tag' => 'h3'],
            'css_class' => 'font-medium text-[18px] tracking-[-0.18px] leading-[1.2] lg:text-ds-24 lg:tracking-[-0.24px]',
        ]);
        ?>

        <div class="flex flex-col gap-[5px] lg:gap-[10px]">
            <?php foreach( $mode['sliders'] ?: [] as $slider_index => $slider ): ?>
            <?php
            $model = sprintf('modes[%d].sliders[%d]', $index, $slider_index);
            $slider_id = sprintf('ds-calculator-%d-%d-%d', get_row_index(), $index, $slider_index);
            ?>
            <div class="flex flex-col gap-[20px] px-[16px] pt-[16px] pb-[20px] rounded-[5px] bg-ds-white">
                <div class="flex flex-row items-center justify-between gap-[10px] text-ds-accent text-[11px] tracking-[-0.11px] leading-[1.2] lg:text-ds-14 lg:tracking-[-0.14px]">
                    <label for="<?php echo esc_attr($slider_id); ?>">
                        <?php echo esc_html($slider['label']); ?>
                    </label>
                    <span class="shrink-0 whitespace-nowrap font-medium"
                        x-text="`${<?php echo esc_attr($model); ?>.value} ${<?php echo esc_attr($model); ?>.unit}`.trim()"></span>
                </div>

                <div class="relative h-[6px] lg:h-[12px] rounded-[24px] bg-ds-light-accent [--thumb:16px] lg:[--thumb:24px]"
                    :style="{ '--progress': progress(<?php echo esc_attr($model); ?>) }">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-[8px] lg:h-[12px] rounded-[100px] bg-ds-accent w-[calc((100%-var(--thumb))*var(--progress,0)+var(--thumb)/2)]"></div>
                    <div class="absolute top-1/2 -translate-y-1/2 left-[calc((100%-var(--thumb))*var(--progress,0))] pointer-events-none">
                        <img src="<?php echo esc_url(ds_get_theme_icon_url('slider-thumb-16.svg')); ?>" alt="" class="lg:hidden">
                        <img src="<?php echo esc_url(ds_get_theme_icon_url('slider-thumb-24.svg')); ?>" alt="" class="hidden lg:block">
                    </div>
                    <input type="range" class="absolute inset-x-0 top-1/2 -translate-y-1/2 w-full h-[24px] m-0 opacity-0 cursor-pointer"
                        id="<?php echo esc_attr($slider_id); ?>"
                        min="<?php echo esc_attr($slider['min']); ?>" max="<?php echo esc_attr($slider['max']); ?>"
                        step="<?php echo esc_attr($slider['step'] ?: 1); ?>"
                        x-model.number="<?php echo esc_attr($model); ?>.value">
                </div>
            </div>
            <?php endforeach; ?>

            <div class="grid grid-cols-2 gap-[5px] lg:gap-[10px]">
                <?php foreach( ['cost_label' => 'cost', 'comparison_label' => 'comparison'] as $label_field => $result ): ?>
                <div class="min-h-[100px] lg:min-h-0 flex flex-col justify-between gap-[12px] p-[20px] rounded-[5px] border border-ds-light-accent bg-ds-white leading-[1.2]">
                    <div class="text-ds-accent text-[11px] tracking-[-0.11px] lg:text-ds-14 lg:tracking-[-0.14px]">
                        <?php echo esc_html($mode[$label_field]); ?>
                    </div>
                    <div class="font-medium text-[18px] tracking-[-0.36px] lg:text-ds-24 lg:tracking-[-0.48px]"
                        x-text="formatCurrency(results.<?php echo esc_attr($result); ?>)"></div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="flex flex-col items-center gap-[5px] lg:gap-[12px] px-[32px] py-[20px] lg:py-[32px] rounded-[5px] bg-ds-accent text-ds-white text-center leading-[1.2]">
                <div class="text-[11px] tracking-[-0.11px] lg:text-ds-14 lg:tracking-[-0.14px]">
                    <?php echo esc_html($mode['savings_label']); ?>
                </div>
                <div class="font-medium text-ds-28 tracking-[-0.56px] lg:text-[32px] lg:tracking-[-0.64px]"
                    x-text="formatCurrency(results.savings)"></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php echo ds_close_section(); ?>
