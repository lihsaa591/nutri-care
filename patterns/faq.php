<?php
/**
 * Title: FAQ with details blocks
 * Slug: nutri-care/faq
 * Categories: nutri-care
 * Description: Questions that expand and collapse, no JavaScript.
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"soft","className":"nc-faq","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained","wideSize":"1120px"}} -->
<div class="wp-block-group alignfull has-soft-background-color has-background nc-faq" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"34%"} -->
<div class="wp-block-column" style="flex-basis:34%"><!-- wp:paragraph {"className":"nc-eyebrow"} -->
<p class="nc-eyebrow"><?php esc_html_e( '06 — FAQ', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Common questions', 'nutri-care' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"66%"} -->
<div class="wp-block-column" style="flex-basis:66%"><!-- wp:details -->
<details class="wp-block-details"><summary><?php esc_html_e( 'Do I need a referral?', 'nutri-care' ); ?></summary><!-- wp:paragraph {"placeholder":""} -->
<p><?php esc_html_e( 'Not usually. Check with your insurer if you plan to claim.', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary><?php esc_html_e( 'Are sessions online or in person?', 'nutri-care' ); ?></summary><!-- wp:paragraph {"placeholder":""} -->
<p><?php esc_html_e( 'Both. Choose what suits you when you book.', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary><?php esc_html_e( 'How long until I see progress?', 'nutri-care' ); ?></summary><!-- wp:paragraph {"placeholder":""} -->
<p><?php esc_html_e( 'It varies from person to person. We review together at each follow-up.', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary><?php esc_html_e( 'Do you work with families?', 'nutri-care' ); ?></summary><!-- wp:paragraph {"placeholder":""} -->
<p><?php esc_html_e( 'Yes, including children and teens with a parent present.', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
