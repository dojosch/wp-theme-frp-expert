<?php $tags = get_sub_field('tags'); ?>

<?php echo ds_open_section('text-ds-main'); ?>
<div class="ds-section pt-[48.5px] lg:pt-[101px] flex flex-col items-center gap-[20px] lg:gap-[28px] text-center">
    <div class="flex flex-col items-center gap-[8px] lg:gap-[18px]">
        <?php
        ds_render_component('heading', [
            'heading'   => get_sub_field('sub_heading'),
            'css_class' => 'ds-subheading justify-center',
        ]);
        ds_render_component('text', [
            'text'      => get_sub_field('text'),
            'css_class' => 'max-w-[801px] font-medium text-ds-28 leading-[34px] lg:text-[38px] lg:leading-[44px]',
        ]);
        ?>
    </div>

    <?php if( !empty($tags) ): ?>
    <ul class="flex flex-row flex-wrap justify-center gap-[10px]">
        <?php foreach( $tags as $tag ): ?>
        <li class="px-[10px] py-[3px] lg:px-[15px] lg:py-[5px] rounded-[5px] border border-ds-light-accent-2 bg-ds-light-accent text-ds-10 leading-[14px] lg:text-[11px] lg:leading-[16px]">
            <strong class="font-bold"><?php echo esc_html($tag['label']); ?></strong>
            <?php echo esc_html($tag['text']); ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>
<?php echo ds_close_section(); ?>
