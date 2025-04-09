<?php
/**
 * Display a warning box if a layout file is missing
 */
function ds_missing_layout_notice( $layout ) {
    ?>
    <div class="bg-gray-50 py-20">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="rounded-md bg-red-50 p-4 m-8 border border-red-300">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Row Layout "<?php echo esc_html( $layout ); ?>" not found
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function ds_missing_component_notice($view) {
    ?>
        <div class="bg-gray-50 py-10">
            <div class="mx-auto max-w-4xl px-4">
                <div class="rounded-md bg-red-50 p-4 border border-red-300">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Component "<?php echo esc_html( $view ); ?>" not found.
                            </h3>
                            <div class="mt-1 text-sm text-red-700">
                                <p>Expected path: <code>/page-templates/components/<?php echo esc_html( $view ); ?>.php</code></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php
}

function ds_render_component( $view, $args = [] ) {
	$component_path = get_template_directory() . "/page-templates/components/{$view}.php";

	if ( file_exists( $component_path ) ) {
		extract( $args );
		include $component_path;
	} else {
        ds_missing_component_notice( $view );
    }
}