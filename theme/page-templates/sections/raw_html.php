<?php echo ds_open_section(); ?>
<div class="ds-section">
    <?php
    ds_render_component('text', [
        'text' => get_sub_field('html'),
    ]);
    ?>
</div>
<?php echo ds_close_section(); ?>
