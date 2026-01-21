<?php
    $column1 = get_sub_field('column_1');
    $column2 = get_sub_field('column_2');
?>

<?php echo ds_open_section("ds-section !px-0 !max-full !min-w-full flex flex-col ds-section--marquee text-brand-dark font-serif text-4xl lg:text-5xl font-light leading-[60px] lg:leading-[100px]") ?>
    <?php if($column1 && count($column1) > 0): ?>
    <div class="overflow-hidden flex whitespace-nowrap ds-marquee gap-[10px] lg:gap-[20px]" data-direction="right">
        <div>
            <?php foreach($column1 as $column): ?>
                <?php echo $column['text']; ?>
            <?php endforeach; ?>
            <?php foreach($column1 as $column): ?>
                <?php echo $column['text']; ?>
            <?php endforeach; ?>
            <?php foreach($column1 as $column): ?>
                <?php echo $column['text']; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if($column2 && count($column2) > 0): ?>
    <div class="overflow-hidden flex whitespace-nowrap ds-marquee gap-[10px] lg:gap-[20px]" data-direction="left">
        <div>
            <?php foreach($column2 as $column): ?>
                <?php echo $column['text']; ?>
            <?php endforeach; ?>
            <?php foreach($column2 as $column): ?>
                <?php echo $column['text']; ?>
            <?php endforeach; ?>
            <?php foreach($column2 as $column): ?>
                <?php echo $column['text']; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
<?php echo ds_close_section() ?>    
