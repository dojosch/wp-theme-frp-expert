<?php 

function ds_scripts() {
	wp_enqueue_style( 'ds-starter-style', get_template_directory_uri() . '/dist/style.css', array(), 1 );
	wp_enqueue_style( 'ds-starter-style', get_template_directory_uri() . '/dist/style-editor.css', array(), 1 );
	wp_enqueue_script( 'ds-starter-script', get_template_directory_uri() . '/dist/script.min.js', array(), 1, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ds_scripts' );