<?php
    $quote = get_sub_field('quote');
    $author = get_sub_field('author');
?>

<section class="w-full">
    <div class="ds-section-narrow">
        <?php if($quote): ?>
            <div class="text-primary text-2xl font-serif ds-wysiwyg">
                <?php echo $quote; ?>
            </div>
        <?php endif; ?>
        <?php if($author): ?>
            <div class="text-md text-black leading-[17px] mt-[30px] uppercase">
                <?php echo $author; ?>
            </div>
        <?php endif; ?>
    </div>
</section>