<?php
/**
 * Default logo mark shown when no site logo is set.
 *
 * The header and footer use the core Site Logo block, so users can upload their
 * own logo. Until they do, this palette-aware ring-and-leaf mark is shown.
 *
 * @package Nutri_Care
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The bare, decorative logo mark as an SVG string.
 *
 * @return string
 */
function nutri_care_mark_svg() {
	return '<svg class="nc-mark" width="36" height="36" viewBox="0 0 48 48" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">'
		. '<g fill="none" stroke-width="5" transform="rotate(-90 24 24)">'
		. '<circle class="nc-mark__a" cx="24" cy="24" r="19" stroke-dasharray="56.7 62.7"/>'
		. '<circle class="nc-mark__c" cx="24" cy="24" r="19" stroke-dasharray="26.85 92.55" stroke-dashoffset="-59.7"/>'
		. '<circle class="nc-mark__t" cx="24" cy="24" r="19" stroke-dasharray="26.85 92.55" stroke-dashoffset="-89.55"/>'
		. '</g>'
		. '<path class="nc-mark__leaf" d="M24 11C34 16 37 26 24 37C11 26 14 16 24 11Z"/>'
		. '<path class="nc-mark__vein" d="M24 15L24 35"/>'
		. '</svg>';
}

/**
 * Markup for the default logo mark, wrapped like a Site Logo block.
 *
 * @return string
 */
function nutri_care_default_logo_markup() {
	return '<div class="wp-block-site-logo nc-default-logo">' . nutri_care_mark_svg() . '</div>';
}

/**
 * Show the default mark when the Site Logo block has nothing to render.
 *
 * @param string $block_content Rendered block content.
 * @return string
 */
function nutri_care_site_logo_fallback( $block_content ) {
	if ( '' !== trim( (string) $block_content ) ) {
		return $block_content;
	}

	return nutri_care_default_logo_markup();
}
