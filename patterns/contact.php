<?php
/**
 * Title: Contact details
 * Slug: nutri-care/contact
 * Categories: nutri-care
 * Description: Contact details and an email button. Replace with your own form.
 */
?>
<!-- wp:group {"anchor":"contact","align":"full","backgroundColor":"soft","className":"nc-contact","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained","wideSize":"1120px"}} -->
<div id="contact" class="wp-block-group alignfull has-soft-background-color has-background nc-contact" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"nc-eyebrow"} -->
<p class="nc-eyebrow"><?php esc_html_e( '08 — Contact', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Let’s talk', 'nutri-care' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'hello@example.com', 'nutri-care' ); ?><br><?php esc_html_e( 'Mon to Fri, 9am to 5pm', 'nutri-care' ); ?><br><?php esc_html_e( 'Clinic address line, City', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p><?php esc_html_e( 'Add your preferred contact form here, or use the button below to send an email.', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="mailto:hello@example.com"><?php esc_html_e( 'Send an email', 'nutri-care' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
