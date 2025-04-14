<div 
    class="ds-collapsible bg-background rounded flex flex-col p-4 gap-[30px]"
    data-collapsible="<?php echo $index; ?>"
    x-data="{ open: false }"
>
    <button 
        class="ds-collapsible--trigger flex flex-row justify-between gap-[20px] items-center cursor-pointer w-full text-left"
        @click="open = !open"
        :aria-expanded="open.toString()"
    >
        <?php 
            ds_render_component('heading', [
                'heading' => $heading,
                'heading_tag' => $heading_tag,
                'css_class' => 'text-base hyphens-auto leading-[24px]',
            ]); 
        ?>
        <div 
            class="size-[24px] shrink-0 transform transition-transform duration-300"
            :class="{ 'rotate-90': open }"
        >
            <img 
                src="<?php echo ds_get_theme_icon_url('/pfeil-rechts-grau.svg'); ?>"
                class="w-full h-full object-contain" 
                alt="Pfeil Rechts Grau"
            >
        </div>
    </button>

    <div 
        class="ds-collapsible--content flex-col gap-[20px] pb-[20px] text-sm overflow-hidden"
        x-show="open"
        x-transition:enter="transition-all ease-out duration-300"
        x-transition:enter-start="opacity-0 max-h-0"
        x-transition:enter-end="opacity-100 max-h-[999px]"
        x-transition:leave="transition-all ease-in duration-200"
        x-transition:leave-start="opacity-100 max-h-[999px]"
        x-transition:leave-end="opacity-0 max-h-0"
        x-cloak
    >
        <?php 
            ds_render_component('text', [
                'text' => $text ?? "",
                'css_class' => 'ds-wysiwyg',
            ]); 

            ds_render_component('link-button', [
                'link' => $link ?? null,
                'css_class' => 'mt-6 block w-fit',
            ]);
        ?>
    </div>
</div>