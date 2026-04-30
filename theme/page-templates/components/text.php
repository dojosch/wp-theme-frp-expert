<?php 

if(!isset($text)) return; 

?>

<?php if($text): ?>
<div class="<?php echo esc_attr($css_class ?: ''); ?>">
    <?php echo $text; ?>
</div>
<?php endif; ?>