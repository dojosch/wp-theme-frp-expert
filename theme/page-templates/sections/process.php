<?php $steps = get_sub_field('steps'); ?>

<?php echo ds_open_section('text-ds-main pb-[25px] lg:pb-[50px]'); ?>
<div class="bg-ds-main text-ds-white">
    <div class="max-w-[1500px] mx-auto flex flex-col-reverse lg:flex-row">
        <div class="ds-section mx-0 py-[85px] lg:pt-[73px] lg:pb-[73px] lg:w-2/3 flex flex-col gap-[10px] lg:gap-[20px]">
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
                'css_class' => 'max-w-[494px]',
            ]);
            ?>
        </div>

        <?php
        ds_render_component('image', [
            'image'     => ds_get_image_data_from_sub_field('image', 'full'),
            'css_class' => 'w-full aspect-[390/411] object-cover object-bottom lg:w-1/3 lg:aspect-auto lg:min-h-[527px]',
        ]);
        ?>
    </div>
</div>

<?php if( !empty($steps) ): ?>
<ol class="max-w-[1500px] mx-auto flex flex-col lg:flex-row border-b border-ds-accent lg:border-t min-[1501px]:border-x divide-y lg:divide-y-0 lg:divide-x divide-ds-accent">
    <?php foreach( $steps as $index => $step ): ?>
    <li class="flex-1 min-h-[340px] lg:min-h-[436px] p-[50px] flex flex-col justify-between gap-[50px]">
        <div class="uppercase font-medium text-[8px] leading-[14px] tracking-[1.6px] lg:text-ds-10 lg:tracking-[2px]">
            <?php echo esc_html(sprintf('%02d – %s', $index + 1, $step['label'])); ?>
        </div>

        <div class="flex flex-col gap-[15px] lg:gap-[25px]">
            <?php
            ds_render_component('image', [
                'image'     => ds_get_image_data_from_id($step['icon']),
                'css_class' => 'size-[52px] lg:size-[72px]',
            ]);
            ?>
            <div class="flex flex-col gap-[15px]">
                <?php
                ds_render_component('heading', [
                    'heading'   => ['heading' => $step['heading'], 'heading_tag' => 'h3'],
                    'css_class' => 'max-w-[291px] font-medium text-[18px] leading-[24px] lg:text-[21px] lg:leading-[28px]',
                ]);
                ds_render_component('text', [
                    'text'      => $step['text'],
                    'css_class' => 'max-w-[382px] text-[13px] leading-[18px]',
                ]);
                ?>
            </div>
        </div>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>
<?php echo ds_close_section(); ?>
