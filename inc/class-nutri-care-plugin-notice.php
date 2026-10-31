<?php
/**
 * Optional, dismissible suggestion to install the MeroDiet plugin.
 *
 * Shown on the Themes screen only, to users who can install plugins. The
 * plugin is installed only when the user clicks the button.
 *
 * @package Nutri_Care
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin notice that suggests the MeroDiet plugin.
 */
class Nutri_Care_Plugin_Notice {

	const PLUGIN_SLUG = 'merodiet';
	const PLUGIN_FILE = 'merodiet/merodiet.php';
	const META_KEY    = 'nutri_care_merodiet_notice_dismissed';
	const ACTION      = 'nutri_care_dismiss_notice';
	const LEARN_MORE  = 'https://wordpress.org/plugins/merodiet/';

	/**
	 * Whether the notice should be shown.
	 *
	 * @param bool $can_install Whether the user can install plugins.
	 * @param bool $is_active   Whether MeroDiet is already active.
	 * @param bool $dismissed   Whether this user dismissed the notice.
	 * @return bool
	 */
	public static function should_display( $can_install, $is_active, $dismissed ) {
		return $can_install && ! $is_active && ! $dismissed;
	}

	/**
	 * Hook the notice and the dismiss handler.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'admin_notices', array( $this, 'render' ) );
		add_action( 'admin_post_' . self::ACTION, array( $this, 'handle_dismiss' ) );
	}

	/**
	 * Output the notice on the Themes screen.
	 *
	 * @return void
	 */
	public function render() {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || 'themes' !== $screen->id ) {
			return;
		}

		$installed = array_key_exists( self::PLUGIN_FILE, get_plugins() );
		$active    = $installed && is_plugin_active( self::PLUGIN_FILE );
		$dismissed = (bool) get_user_meta( get_current_user_id(), self::META_KEY, true );

		if ( ! self::should_display( current_user_can( 'install_plugins' ), $active, $dismissed ) ) {
			return;
		}

		wp_enqueue_script( 'updates' );
		wp_enqueue_script( 'nutri-care-notice', get_theme_file_uri( 'assets/js/notice.js' ), array( 'updates' ), '1.0.0', true );

		$activate_url = wp_nonce_url(
			admin_url( 'plugins.php?action=activate&plugin=' . self::PLUGIN_FILE ),
			'activate-plugin_' . self::PLUGIN_FILE
		);
		$dismiss_url  = wp_nonce_url( admin_url( 'admin-post.php?action=' . self::ACTION ), self::ACTION );
		?>
		<div class="notice notice-info is-dismissible nutri-care-notice" data-dismiss-url="<?php echo esc_url( $dismiss_url ); ?>">
			<p><strong><?php esc_html_e( 'Nutri Care pairs well with MeroDiet', 'nutri-care' ); ?></strong></p>
			<p><?php esc_html_e( 'Optional: manage clients, meal plans and appointments from your WordPress dashboard.', 'nutri-care' ); ?></p>
			<p>
				<?php if ( $installed ) : ?>
					<a class="button button-primary" href="<?php echo esc_url( $activate_url ); ?>"><?php esc_html_e( 'Activate MeroDiet', 'nutri-care' ); ?></a>
				<?php else : ?>
					<button type="button" class="button button-primary" data-slug="<?php echo esc_attr( self::PLUGIN_SLUG ); ?>" data-activate-url="<?php echo esc_url( $activate_url ); ?>" data-label="<?php esc_attr_e( 'Install MeroDiet', 'nutri-care' ); ?>" data-working="<?php esc_attr_e( 'Installing…', 'nutri-care' ); ?>"><?php esc_html_e( 'Install MeroDiet', 'nutri-care' ); ?></button>
				<?php endif; ?>
				<a href="<?php echo esc_url( self::LEARN_MORE ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Learn more', 'nutri-care' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Remember, per user, that the notice was dismissed.
	 *
	 * @param bool $redirect Whether to redirect and exit afterwards.
	 * @return void
	 */
	public function handle_dismiss( $redirect = true ) {
		$nonce = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, self::ACTION ) ) {
			wp_die( esc_html__( 'The link you followed has expired.', 'nutri-care' ) );
		}

		update_user_meta( get_current_user_id(), self::META_KEY, 1 );

		if ( $redirect ) {
			wp_safe_redirect( admin_url( 'themes.php' ) );
			exit;
		}
	}
}
