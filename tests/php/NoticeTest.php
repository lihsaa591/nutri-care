<?php
use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;

class NoticeTest extends TestCase {

	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
		Functions\stubTranslationFunctions();
		Functions\stubEscapeFunctions();
		Functions\when( 'admin_url' )->alias( fn( $p = '' ) => 'https://example.test/wp-admin/' . $p );
		Functions\when( 'wp_nonce_url' )->alias( fn( $u, $a ) => $u . '&_wpnonce=nonce-' . $a );
		Functions\when( 'get_current_user_id' )->justReturn( 7 );
		Functions\when( 'get_theme_file_uri' )->alias( fn( $p ) => 'https://example.test/' . $p );
		Functions\when( 'get_theme_file_path' )->alias( fn( $p ) => dirname( __DIR__, 2 ) . '/' . $p );
	}

	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

	private function show_context( array $plugins, bool $can_install = true, $dismissed = '' ): void {
		Functions\when( 'current_user_can' )->justReturn( $can_install );
		Functions\when( 'get_plugins' )->justReturn( $plugins );
		Functions\when( 'is_plugin_active' )->alias( fn( $f ) => isset( $plugins[ $f ] ) && ! empty( $plugins[ $f ]['active'] ) );
		Functions\when( 'get_user_meta' )->justReturn( $dismissed );
		Functions\when( 'get_current_screen' )->justReturn( (object) array( 'id' => 'themes' ) );
	}

	public function test_should_display_false_when_user_cannot_install(): void {
		$this->assertFalse( Nutri_Care_Plugin_Notice::should_display( false, false, false ) );
	}

	public function test_should_display_false_when_plugin_active(): void {
		$this->assertFalse( Nutri_Care_Plugin_Notice::should_display( true, true, false ) );
	}

	public function test_should_display_false_when_dismissed(): void {
		$this->assertFalse( Nutri_Care_Plugin_Notice::should_display( true, false, true ) );
	}

	public function test_should_display_true_otherwise(): void {
		$this->assertTrue( Nutri_Care_Plugin_Notice::should_display( true, false, false ) );
	}

	public function test_render_outputs_nothing_when_should_not_display(): void {
		$this->show_context( array(), false );
		ob_start();
		( new Nutri_Care_Plugin_Notice() )->render();
		$this->assertSame( '', ob_get_clean() );
	}

	public function test_render_outputs_nothing_off_the_themes_screen(): void {
		$this->show_context( array() );
		Functions\when( 'get_current_screen' )->justReturn( (object) array( 'id' => 'dashboard' ) );
		ob_start();
		( new Nutri_Care_Plugin_Notice() )->render();
		$this->assertSame( '', ob_get_clean() );
	}

	public function test_render_offers_install_when_plugin_missing(): void {
		$this->show_context( array() );
		ob_start();
		( new Nutri_Care_Plugin_Notice() )->render();
		$out = ob_get_clean();
		$this->assertStringContainsString( 'notice notice-info is-dismissible', $out );
		$this->assertStringContainsString( 'data-slug="merodiet"', $out );
		$this->assertStringContainsString( 'Install MeroDiet', $out );
	}

	public function test_render_offers_activate_when_installed_but_inactive(): void {
		$this->show_context( array( 'merodiet/merodiet.php' => array( 'active' => false ) ) );
		ob_start();
		( new Nutri_Care_Plugin_Notice() )->render();
		$out = ob_get_clean();
		$this->assertStringContainsString( 'Activate MeroDiet', $out );
		$this->assertStringNotContainsString( 'data-slug="merodiet"', $out );
		$this->assertStringContainsString( 'plugin=merodiet/merodiet.php', $out );
	}

	public function test_render_outputs_nothing_when_user_cannot_activate_plugins(): void {
		$this->show_context( array() );
		Functions\when( 'current_user_can' )->alias( fn( $cap ) => 'install_plugins' === $cap );
		ob_start();
		( new Nutri_Care_Plugin_Notice() )->render();
		$this->assertSame( '', ob_get_clean() );
	}

	public function test_notice_lists_real_meroditet_features_and_never_claims_appointments(): void {
		$this->show_context( array() );
		ob_start();
		( new Nutri_Care_Plugin_Notice() )->render();
		$out = ob_get_clean();
		$this->assertStringContainsString( 'Meal plans', $out );
		$this->assertStringContainsString( 'Client portal', $out );
		$this->assertStringContainsString( 'Progress dashboard', $out );
		$this->assertStringNotContainsStringIgnoringCase( 'appointment', $out );
		$this->assertStringContainsString( 'nutri-care-notice__icon', $out );
		$this->assertStringContainsString( 'class="nc-mark"', $out );
		$this->assertStringNotContainsString( 'dashicons-carrot', $out );
	}

	public function test_assets_are_enqueued_only_when_the_notice_will_show(): void {
		$this->show_context( array() );
		Functions\when( 'wp_enqueue_style' )->justReturn( true );
		Functions\expect( 'wp_enqueue_script' )->atLeast()->once();
		( new Nutri_Care_Plugin_Notice() )->enqueue_assets();
		$this->assertTrue( true );
	}

	public function test_asset_versions_follow_the_file_modification_time_so_updates_bust_the_cache(): void {
		$this->show_context( array() );
		$root = dirname( __DIR__, 2 );
		Functions\when( 'get_theme_file_path' )->alias( fn( $p ) => $root . '/' . $p );
		$css_version = (string) filemtime( $root . '/assets/css/notice.css' );
		$js_version  = (string) filemtime( $root . '/assets/js/notice.js' );
		Functions\expect( 'wp_enqueue_style' )->once()->with( 'nutri-care-notice', \Mockery::any(), array(), $css_version );
		Functions\expect( 'wp_enqueue_script' )->with( 'nutri-care-notice', \Mockery::any(), array( 'updates' ), $js_version, true )->once();
		Functions\expect( 'wp_enqueue_script' )->with( 'updates' )->zeroOrMoreTimes();
		( new Nutri_Care_Plugin_Notice() )->enqueue_assets();
		$this->assertTrue( true );
	}

	public function test_assets_are_not_enqueued_for_users_who_cannot_install(): void {
		$this->show_context( array(), false );
		Functions\expect( 'wp_enqueue_style' )->never();
		Functions\expect( 'wp_enqueue_script' )->never();
		( new Nutri_Care_Plugin_Notice() )->enqueue_assets();
		$this->assertTrue( true );
	}

	public function test_handle_dismiss_rejects_bad_nonce(): void {
		$_GET['_wpnonce'] = 'bad';
		Functions\when( 'sanitize_text_field' )->returnArg();
		Functions\when( 'wp_unslash' )->returnArg();
		Functions\when( 'wp_verify_nonce' )->justReturn( false );
		Functions\expect( 'wp_die' )->once()->andThrow( new RuntimeException( 'die' ) );
		Functions\expect( 'update_user_meta' )->never();
		$this->expectException( RuntimeException::class );
		( new Nutri_Care_Plugin_Notice() )->handle_dismiss();
	}

	public function test_handle_dismiss_stores_user_meta_on_valid_nonce(): void {
		$_GET['_wpnonce'] = 'good';
		Functions\when( 'sanitize_text_field' )->returnArg();
		Functions\when( 'wp_unslash' )->returnArg();
		Functions\when( 'wp_verify_nonce' )->justReturn( 1 );
		Functions\when( 'current_user_can' )->justReturn( true );
		Functions\expect( 'update_user_meta' )->once()->with( 7, 'nutri_care_merodiet_notice_dismissed', 1 );
		Functions\when( 'wp_safe_redirect' )->justReturn( true );
		( new Nutri_Care_Plugin_Notice() )->handle_dismiss( false );
		$this->assertTrue( true );
	}

	public function test_register_hooks_admin_notices_and_dismiss_action(): void {
		Functions\expect( 'add_action' )->with( 'admin_notices', \Mockery::type( 'array' ) )->once();
		Functions\expect( 'add_action' )->with( 'admin_post_nutri_care_dismiss_notice', \Mockery::type( 'array' ) )->once();
		Functions\expect( 'add_action' )->with( 'admin_enqueue_scripts', \Mockery::type( 'array' ) )->zeroOrMoreTimes();
		( new Nutri_Care_Plugin_Notice() )->register();
		$this->assertTrue( true );
	}
}
