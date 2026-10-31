<?php
/**
 * Title: Footer columns
 * Slug: nutri-care/footer-columns
 * Inserter: no
 * Description: Brand, pages, contact and hours columns with the education disclaimer.
 */
?>
<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"34%"} -->
<div class="wp-block-column" style="flex-basis:34%"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:site-logo {"width":36,"shouldSyncIcon":false} /-->

<!-- wp:site-title {"level":0,"isLink":false} /--></div>
<!-- /wp:group -->

<!-- wp:site-tagline {"fontSize":"small"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"fontSize":"small","className":"nc-footer-heading"} -->
<p class="has-small-font-size nc-footer-heading"><?php esc_html_e( 'Pages', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"}} -->
<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Services', 'nutri-care' ); ?>","type":"custom","url":"/#services","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'About', 'nutri-care' ); ?>","type":"custom","url":"/#about","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Plans', 'nutri-care' ); ?>","type":"custom","url":"/#pricing","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Journal', 'nutri-care' ); ?>","type":"custom","url":"/#journal","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"fontSize":"small","className":"nc-footer-heading"} -->
<p class="has-small-font-size nc-footer-heading"><?php esc_html_e( 'Contact', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php esc_html_e( 'hello@example.com', 'nutri-care' ); ?><br><?php esc_html_e( 'Clinic address line, City', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"fontSize":"small","className":"nc-footer-heading"} -->
<p class="has-small-font-size nc-footer-heading"><?php esc_html_e( 'Hours', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php esc_html_e( 'Mon to Fri, 9am to 5pm', 'nutri-care' ); ?><br><?php esc_html_e( 'Online and in clinic', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:separator {"align":"wide","className":"is-style-wide"} -->
<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php esc_html_e( 'Nutrition information on this site is for education and is not medical advice.', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->
