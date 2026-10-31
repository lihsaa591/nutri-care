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
