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
<div class="wp-block-column" style="flex-basis:48%"><!-- wp:html -->
<div class="nc-plate" role="img" aria-label="<?php esc_attr_e( 'A balanced plate: half vegetables and fruit, a quarter lean protein, a quarter whole grains', 'nutri-care' ); ?>">
<svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
<defs><clipPath id="nc-plate-clip"><circle cx="250" cy="250" r="168"/></clipPath></defs>
<circle cx="250" cy="250" r="235" fill="#fff" opacity=".7"/>
<image href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/plate-bowl.webp" x="70" y="-5" width="360" height="480" preserveAspectRatio="none" clip-path="url(#nc-plate-clip)"/>
<circle cx="250" cy="250" r="168" fill="none" stroke="#fff" stroke-width="6"/>
<g fill="none" stroke-width="16" transform="rotate(-90 250 250)">
<circle cx="250" cy="250" r="196" stroke="#1F7A8C" stroke-dasharray="602 1232" stroke-dashoffset="0"/>
<circle cx="250" cy="250" r="196" stroke="#0F3A46" stroke-dasharray="301 1232" stroke-dashoffset="-616"/>
<circle cx="250" cy="250" r="196" stroke="#8cc7d2" stroke-dasharray="301 1232" stroke-dashoffset="-931"/>
</g>
</svg>
<p class="nc-plate__label nc-plate__label--grains"><strong>25%</strong> <?php esc_html_e( 'Whole grains', 'nutri-care' ); ?></p>
<p class="nc-plate__label nc-plate__label--veg"><strong>50%</strong> <?php esc_html_e( 'Vegetables &amp; fruit', 'nutri-care' ); ?></p>
<p class="nc-plate__label nc-plate__label--protein"><strong>25%</strong> <?php esc_html_e( 'Lean protein', 'nutri-care' ); ?></p>
<p class="nc-plate__caption"><?php esc_html_e( 'A balanced plate, simplified', 'nutri-care' ); ?></p>
</div>
<!-- /wp:html --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
