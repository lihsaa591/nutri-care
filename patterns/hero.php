<?php
/**
 * Title: Hero: balanced plate
 * Slug: nutri-care/hero
 * Categories: nutri-care
 * Description: Headline, buttons and a round plate photo inside a three-segment ring.
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"soft","className":"nc-hero","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained","wideSize":"1120px"}} -->
<div class="wp-block-group alignfull has-soft-background-color has-background nc-hero" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:columns {"align":"wide","verticalAlignment":"center"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"width":"52%"} -->
<div class="wp-block-column" style="flex-basis:52%"><!-- wp:paragraph {"className":"nc-eyebrow"} -->
<p class="nc-eyebrow"><?php esc_html_e( 'Registered Dietitian · Clinical Nutrition', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"nc-display"} -->
<h1 class="wp-block-heading nc-display"><?php esc_html_e( 'Evidence-based care, explained clearly.', 'nutri-care' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"nc-lead"} -->
<p class="nc-lead"><?php esc_html_e( 'Practical support for diabetes, gut health and weight management, one balanced plate at a time.', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#contact"><?php esc_html_e( 'Request appointment', 'nutri-care' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"nc-btn-outline"} -->
<div class="wp-block-button nc-btn-outline"><a class="wp-block-button__link wp-element-button" href="#services"><?php esc_html_e( 'View services', 'nutri-care' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"className":"nc-credentials"} -->
<p class="nc-credentials"><?php esc_html_e( 'RD, MSc · Diabetes educator · 10+ years', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"48%"} -->
<div class="wp-block-column" style="flex-basis:48%"><!-- wp:group {"className":"nc-plate","layout":{"type":"default"}} -->
<div class="wp-block-group nc-plate"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"nc-plate__photo"} -->
<figure class="wp-block-image size-large nc-plate__photo"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/plate-bowl.webp" alt="<?php esc_attr_e( 'A bowl of oats, banana and berries', 'nutri-care' ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"nc-plate__label nc-plate__label--grains"} -->
<p class="nc-plate__label nc-plate__label--grains"><strong>25%</strong> <?php esc_html_e( 'Whole grains', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"nc-plate__label nc-plate__label--veg"} -->
<p class="nc-plate__label nc-plate__label--veg"><strong>50%</strong> <?php esc_html_e( 'Vegetables & fruit', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"nc-plate__label nc-plate__label--protein"} -->
<p class="nc-plate__label nc-plate__label--protein"><strong>25%</strong> <?php esc_html_e( 'Lean protein', 'nutri-care' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"nc-plate__caption"} -->
<p class="nc-plate__caption"><?php esc_html_e( 'A balanced plate, simplified', 'nutri-care' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
