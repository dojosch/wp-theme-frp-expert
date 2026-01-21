<?php
    $sub_heading = get_sub_field('sub_heading');
    $sub_heading_tag = get_sub_field('sub_heading_tag');
    $type = get_sub_field('type');

    if ($type == "pick") {
        $testimonials = get_sub_field('testimonials');
    } else if ($type == "latest") {
        $testimonials = get_posts(array(
            'post_type' => 'testimonial',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'fields' => 'ids'
        ));
    } else {
        $testimonials = get_posts(array(
            'post_type' => 'testimonial',
            'posts_per_page' => 3,
            'orderby' => 'rand',
            'fields' => 'ids'
        ));
    }
?>

<?php echo ds_open_section() ?>    
    <div class="ds-section-narrow flex flex-col items-center">
        <?php 
            ds_render_component( 'heading', [
                'heading' => $sub_heading,
                'heading_tag' => $sub_heading_tag,
                'css_class' => 'ds-subheading',
            ]);
        ?>
        <?php if($testimonials && count($testimonials) > 0): ?>
        <div class="relative mt-[50px] glide ds-testimonials--glider pb-[50px]">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    <?php foreach($testimonials as $testimonial): ?>
                    <?php 
                        $text = get_field('text', $testimonial);
                        $author = get_field('author', $testimonial);
                    ?>
                    <li class="glide__slide text-black text-center">
                        <?php if($text): ?>
                        <div class="text-2xl  font-serif">
                            <?php echo $text; ?>
                        </div>
                        <?php endif; ?>
                        <div class="mt-[30px] text-sm flex flex-row w-full justify-center gap-[3px]">
                            <?php if($author): ?>
                            <div>
                                <?php echo $author; ?>
                            </div>
                            <?php endif; ?>                           
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="glide__bullets absolute !bottom-0 flex flex-row gap-[12px]" data-glide-el="controls[nav]">
                <?php foreach($testimonials as $key => $testimonial): ?>
                    <button class="glide__bullet" data-glide-dir="=<?php echo $key; ?>"></button>
                <?php endforeach;?>
            </div>
        </div>
        <?php endif; ?>
    </div>
<?php echo ds_close_section() ?>    
