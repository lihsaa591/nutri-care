<?php
/**
 * Title: Booking band
 * Slug: nutri-care/booking-cta
 * Categories: nutri-care
 * Description: Dark call-to-action band with booking and client login buttons.
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"contrast","textColor":"base","className":"nc-band","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained","wideSize":"1120px"}} -->
<div class="wp-block-group alignfull has-base-color has-contrast-background-color has-text-color has-background nc-band" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Ready to feel better about food?', 'nutri-care' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Book a first consultation, or log in to your client area.', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"nc-btn-light"} -->
<div class="wp-block-button nc-btn-light"><a class="wp-block-button__link wp-element-button" href="#contact"><?php esc_html_e( 'Book a consultation', 'nutri-care' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"nc-btn-ghost"} -->
<div class="wp-block-button nc-btn-ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Client login', 'nutri-care' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
