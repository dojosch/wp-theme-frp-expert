<?php
    $logo = ds_get_image_data_from_option_field('footer_logo');
    $address = get_field('footer_address', 'option');
    $phone = get_field('footer_telephone_number', 'option');
    $email = get_field('footer_email', 'option');
    $highlights_heading = get_field('footer_highlights_heading', 'option');
    $highlights_heading_tag = get_field('footer_highlights_heading_tag', 'option');
    $highlights = get_field('footer_highlights', 'option');
    $service_heading = get_field('footer_service_heading', 'option');
    $service_heading_tag = get_field('footer_service_heading_tag', 'option');
    $service = get_field('footer_service', 'option');
    $newsletter_text = get_field('footer_newsletter_text', 'option');
    $newsletter_link = get_field('footer_newsletter_link', 'option');
    $icon = ds_get_image_data_from_option_field('footer_icon');
    $copyright = get_field('footer_copyright', 'option');
    $socials = get_field('footer_socials', 'option');
    $legals = get_field('footer_legals', 'option');
    $background = get_field('footer_background');
?>

<footer class="bg-background">
    <div class="ds-section flex flex-col">
        <div class="flex flex-col gap-[50px] lg:gap-[160px] lg:flex-row justify-between">
            <div class="flex flex-col items-center lg:items-start gap-[40px]">
                <?php 
                    ds_render_component('image', [
                        'image' => $logo,
                        'css_class' => 'w-auto h-[50px] object-contain',
                    ]);
                ?>
                <div class="flex flex-col gap-[10px] items-center lg:items-start lg:gap-[20px]">
                    <?php if($address): ?>
                        <div class="flex flex-row gap-[12px] lg:gap-[18px] items-center">
                            <img 
                                src="<?php echo ds_get_theme_icon_url('adress-footer.svg'); ?>" 
                                alt="Adress Icon"
                                class="size-[25px] object-contain"
                            >
                            <?php echo $address; ?>
                        </div>
                    <?php endif; ?>
                    <?php if($phone): ?>
                        <a 
                            href="<?php echo ds_parse_phone_into_tel($phone)?>"
                            class="flex flex-row gap-[12px] lg:gap-[18px] items-center hover:underline"
                        >
                            <img 
                                src="<?php echo ds_get_theme_icon_url('phone-footer.svg'); ?>" 
                                alt="Telefon Icon"
                                class="size-[25px] object-contain"
                            >
                            <?php echo $phone; ?>
                        </a>
                    <?php endif; ?>
                    <?php if($email): ?>
                        <a 
                            href="<?php echo ds_parse_mail_into_mailto($email); ?>"
                            class="flex flex-row gap-[12px] lg:gap-[18px] items-center hover:underline"
                        >
                            <img 
                                src="<?php echo ds_get_theme_icon_url('mail-footer.svg'); ?>" 
                                alt="E-Mail Icon"
                                class="size-[25px] object-contain"
                            >
                            <?php echo $email; ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php if($service && count($service) > 0): ?>
                    <div class="flex flex-col items-center gap-[20px] lg:hidden">
                        <?php foreach($service as $service_item): ?>
                            <?php if($service_item['link']): ?>
                                <?php echo ds_get_link($service_item['link']); ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if($legals && count($legals) > 0): ?>
                    <div class="flex flex-col items-center gap-[20px] lg:hidden">
                        <?php foreach($legals as $legal): ?>
                            <?php if($legal['link']): ?>
                                <?php echo ds_get_link($legal['link']); ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="lg:flex flex-row hidden gap-[20px] lg:gap-[100px] lg:mt-[20px] shrink-1">
                <div class="flex flex-col">
                    <?php 
                        ds_render_component('heading', [
                            'heading' => $highlights_heading,
                            'heading_tag' => $highlights_heading_tag,
                            'css_class' => 'font-bold',
                        ])
                    ?>
                    <?php if($highlights && count($highlights) > 0): ?>
                        <div class="flex mt-[30px] flex-col gap-[10px]">
                            <?php foreach($highlights as $highlight): ?>
                                <?php if($highlight['link']): ?>
                                    <?php echo ds_get_link($highlight['link'], "lg:hover:underline"); ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col">
                    <?php 
                        ds_render_component('heading', [
                            'heading' => $service_heading,
                            'heading_tag' => $service_heading_tag,
                            'css_class' => 'font-bold',
                        ])
                    ?>
                    <?php if($service && count($service) > 0): ?>
                        <div class="flex mt-[30px] flex-col gap-[10px]">
                            <?php foreach($service as $service_item): ?>
                                <?php if($service_item['link']): ?>
                                    <?php echo ds_get_link($service_item['link'], "lg:hover:underline"); ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mt-[47px] lg:mt-[18px] flex flex-col lg:items-start items-center">
                <?php 
                    ds_render_component('text', [
                        'text' => $newsletter_text,
                        'css_class' => 'text-xl leading-[normal] font-serif text-center lg:text-start',
                    ])
                ?>
                <?php if($newsletter_link): ?>
                    <?php echo ds_get_link($newsletter_link, 'ds-button mt-[20px]'); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-[40px] lg:mt-[140px] w-full gap-[40px] flex flex-col lg:flex-row-reverse items-center lg:justify-between">
            <?php if($socials && count($socials) > 0): ?>
                <div class="flex flex-row gap-[20px] items-center lg:items-end">
                    <?php foreach($socials as $social): ?>
                        <?php $image_data = ds_get_image_data_from_id($social['image']); ?>
                        <?php if($social['link']): ?>
                            <?php echo ds_open_link($social['link']); ?>
                                <?php 
                                    ds_render_component('image', [
                                        'image' => $image_data,
                                        'css_class' => 'size-[40px] object-contain',
                                    ]);
                                ?>
                            <?php echo ds_close_link(); ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php 
                ds_render_component('image', [
                    'image' => $icon,
                    'css_class' => 'size-[40px] object-contain',
                ]);
            ?>
        </div>
        <div class="mt-[40px] lg:mt-[35px] flex flex-row justify-center lg:justify-between text-md">
            <?php 
                ds_render_component('text', [
                    'text' => $copyright,
                    'css_class' => '',
                ])
            ?>
            <?php if($legals && count($legals) > 0): ?>
                <div class="hidden lg:flex flex-row gap-[30px]">
                    <?php foreach($legals as $legal): ?>
                        <?php if($legal['link']): ?>
                            <?php echo ds_get_link($legal['link']); ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</footer>