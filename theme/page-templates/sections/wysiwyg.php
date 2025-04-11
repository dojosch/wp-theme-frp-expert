<?php 
    $text = get_sub_field('text');
?>

<section class="w-full">
    <div class="ds-section-medium">
        <?php 
            ds_render_component( 'text', [
                'text' => $text,
                'css_class' => 'ds-wysiwyg',
            ]);
        ?>
    </div>
</section>