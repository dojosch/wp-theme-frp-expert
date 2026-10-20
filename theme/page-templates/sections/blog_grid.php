<?php
$post_ids = 'selected' === get_sub_field('source') ? (get_sub_field('posts') ?: []) : get_posts([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
]);
?>

<?php echo ds_open_section('text-ds-main first:pt-[90px] lg:first:pt-[89px]'); ?>
<div class="ds-section flex flex-col gap-[30px] lg:gap-[50px]">
    <div class="flex flex-col gap-[10px] lg:gap-[18px]">
        <?php
        ds_render_component('heading', [
            'heading'   => get_sub_field('sub_heading'),
            'css_class' => 'ds-subheading gap-[5px] lg:gap-[10px]',
        ]);
        ds_render_component('heading', [
            'heading'   => get_sub_field('heading'),
            'css_class' => 'ds-heading lg:leading-[40px]',
        ]);
        ?>
    </div>

    <?php if( !empty($post_ids) ): ?>
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-[10px] gap-y-[30px] lg:gap-y-[60px]">
        <?php foreach( $post_ids as $post_id ): ?>
        <li>
            <?php
            ds_render_component('post-card', [
                'post_id' => $post_id,
            ]);
            ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>
<?php echo ds_close_section(); ?>
