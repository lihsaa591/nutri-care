<?php
use Brain\Monkey;
use PHPUnit\Framework\TestCase;

class LogoTest extends TestCase {

	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
	}

	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

	public function test_fallback_shows_the_default_mark_when_no_logo_is_set(): void {
		$out = nutri_care_site_logo_fallback( '' );
		$this->assertStringContainsString( 'class="nc-mark"', $out );
		$this->assertStringContainsString( 'aria-hidden="true"', $out );
		$this->assertStringContainsString( 'wp-block-site-logo', $out );
	}

	public function test_mark_svg_is_the_bare_decorative_svg_without_the_block_wrapper(): void {
		$svg = nutri_care_mark_svg();
		$this->assertStringStartsWith( '<svg class="nc-mark"', $svg );
		$this->assertStringContainsString( 'aria-hidden="true"', $svg );
		$this->assertStringNotContainsString( 'wp-block-site-logo', $svg );
	}

	public function test_fallback_treats_whitespace_as_empty(): void {
		$this->assertStringContainsString( 'nc-mark', nutri_care_site_logo_fallback( " \n\t " ) );
	}

	public function test_fallback_leaves_a_real_logo_untouched(): void {
		$logo = '<div class="wp-block-site-logo"><a href="/"><img src="logo.png" alt="Clinic"></a></div>';
		$this->assertSame( $logo, nutri_care_site_logo_fallback( $logo ) );
	}
}
