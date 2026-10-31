<?php
/**
 * Nutri Care theme functions.
 *
 * @package Nutri_Care
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the pattern category used by the theme's patterns.
 *
 * @return void
 */
function nutri_care_register_pattern_category() {
	register_block_pattern_category(
		'nutri-care',
		array( 'label' => __( 'Nutri Care', 'nutri-care' ) )
	);
}
add_action( 'init', 'nutri_care_register_pattern_category' );

/**
 * Load the theme stylesheet on the front end.
 *
 * Block themes do not load style.css automatically.
 *
 * @return void
 */
function nutri_care_enqueue_styles() {
	wp_enqueue_style( 'nutri-care-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'nutri_care_enqueue_styles' );

/**
 * Load the same stylesheet in the block editor.
 *
 * @return void
 */
function nutri_care_editor_styles() {
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'nutri_care_editor_styles' );

if ( is_admin() ) {
	require_once get_template_directory() . '/inc/class-nutri-care-plugin-notice.php';
	( new Nutri_Care_Plugin_Notice() )->register();
}
