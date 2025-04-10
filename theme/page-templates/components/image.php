 <?php if($image): ?>
    <img 
        src="<?php echo $image['src']; ?>" 
        alt="<?php echo $image['alt']; ?>"
        class="<?php echo esc_attr($css_class); ?>"
    >
<?php endif; ?>