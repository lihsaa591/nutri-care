<?php
/**
 * Title: About with stats
 * Slug: nutri-care/about
 * Categories: nutri-care
 * Description: Photo beside a short bio and three key numbers.
 */
?>
<!-- wp:group {"anchor":"about","align":"full","backgroundColor":"soft","className":"nc-about","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained","wideSize":"1120px"}} -->
<div id="about" class="wp-block-group alignfull has-soft-background-color has-background nc-about" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:columns {"align":"wide","verticalAlignment":"center"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/salad-greens.webp" alt="<?php esc_attr_e( 'Fresh salad greens and vegetables', 'nutri-care' ); ?>"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"nc-eyebrow"} -->
<p class="nc-eyebrow"><?php esc_html_e( '02 — About', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Hi, I’m Dr. Name.', 'nutri-care' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Ten years helping people eat well without extreme rules. A short, honest bio goes here: training, approach, and who you work best with.', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide","className":"nc-stats"} -->
<div class="wp-block-columns alignwide nc-stats"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"nc-stat"} -->
<p class="nc-stat"><strong>1,200+</strong><br><?php esc_html_e( 'clients', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"nc-stat"} -->
<p class="nc-stat"><strong>10</strong><br><?php esc_html_e( 'years', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"nc-stat"} -->
<p class="nc-stat"><strong>4.9</strong><br><?php esc_html_e( 'rating', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Read my story', 'nutri-care' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
