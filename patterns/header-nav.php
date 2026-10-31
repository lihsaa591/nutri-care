<?php
/**
 * Title: Header navigation
 * Slug: nutri-care/header-nav
 * Inserter: no
 * Description: Menu links and the Book a call button.
 */
?>
<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:navigation {"overlayMenu":"mobile","overlayBackgroundColor":"base","overlayTextColor":"contrast","layout":{"type":"flex","justifyContent":"left"}} -->
<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Services', 'nutri-care' ); ?>","type":"custom","url":"/#services","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'About', 'nutri-care' ); ?>","type":"custom","url":"/#about","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Plans', 'nutri-care' ); ?>","type":"custom","url":"/#pricing","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Journal', 'nutri-care' ); ?>","type":"custom","url":"/#journal","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Contact', 'nutri-care' ); ?>","type":"custom","url":"/#contact","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/#contact"><?php esc_html_e( 'Book a call', 'nutri-care' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
