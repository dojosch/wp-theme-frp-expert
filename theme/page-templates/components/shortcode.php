<?php if($shortcode): ?>
    <div class="<?php echo esc_attr($css_class); ?>">
        <?php echo do_shortcode($shortcode); ?>
    </div>
<?php endif; ?>