<?php
/**
 * Post card component
 *
 * Renders a blog post as a linked card from its "Blog Card" fields: card image
 * (falls back to the featured image), sub heading, title and teaser text
 * (falls back to the excerpt), followed by an arrow button.
 *
 * @var int    $post_id   Required. ID of the post to render.
 * @var string $css_class Optional. Classes appended to the card link.
 */

if( empty($post_id) || 'publish' !== get_post_status($post_id) ) return;

$css_class = $css_class ?? '';
?>

<a href="<?php echo esc_url(get_permalink($post_id)); ?>"
    class="group flex flex-col h-full overflow-hidden rounded-[5px] bg-ds-white text-ds-main <?php echo esc_attr($css_class); ?>">
    <?php
    ds_render_component('image', [
        'image'     => ds_get_image_data_from_id(get_field('card_image', $post_id) ?: get_post_thumbnail_id($post_id), 'full'),
        'css_class' => 'w-full h-[200px] object-cover',
    ]);
    ?>
    <div class="flex flex-1 flex-col justify-between items-start gap-[20px] p-[25px] lg:p-[30px] lg:pr-[60px]">
        <div class="flex flex-col gap-[15px]">
            <div class="flex flex-col gap-[10px] font-medium">
                <?php
                ds_render_component('heading', [
                    'heading'   => ['heading' => get_field('sub_heading', $post_id), 'heading_tag' => 'div'],
                    'css_class' => 'text-ds-10 leading-[14px] tracking-[2px] uppercase text-ds-accent',
                ]);
                ds_render_component('heading', [
                    'heading'   => ['heading' => get_the_title($post_id), 'heading_tag' => get_field('title_tag', $post_id) ?: 'h3'],
                    'css_class' => 'text-[21px] leading-[28px] lg:max-w-[291px] transition-colors group-hover:text-ds-accent',
                ]);
                ?>
            </div>
            <?php
            ds_render_component('text', [
                'text'      => get_field('text', $post_id) ?: get_the_excerpt($post_id),
                'css_class' => 'text-ds-13 leading-[18px]',
            ]);
            ?>
        </div>
        <span class="ds-button ds-button-arrow__icon lg:size-[41px] group-hover:bg-ds-white group-hover:text-ds-accent"
            aria-hidden="true"></span>
    </div>
</a>
