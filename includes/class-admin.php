<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class Admin.
 *
 * @since 1.0.0
 */
class Admin {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 59 );
        add_action( 'admin_post_woocp_update_settings', array( $this, 'update_settings' ) );
    }

    /**
     * Add sub menu.
     *
     * @since 1.0.0
     */
    public function admin_menu() {
        add_submenu_page(
            'woocommerce',
            __( 'Woo Custom Prices', 'woo-custom-price' ),
            __( 'Woo Custom Prices', 'woo-custom-price' ),
            'manage_woocommerce',
            'woo-custom-price',
            array( $this, 'render_settings_page' ),
        );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Woo Custom Price', 'woo-custom-price' ); ?></h1>
            <p><?php esc_html_e( 'Bellow are the plugin options that will determine how the plugin will work.', 'woo-custom-price' ); ?></p>

            <form method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                <label for="price_label"><?php esc_html_e( 'Enter price label:', 'woo-custom-price' ); ?></label>
                <input type="text" name="price_label" id="price_label" placeholder="Enter the price label text" value="<?php echo esc_attr( get_option( 'woocp_price_label' ) ); ?>" />

                <?php wp_nonce_field( 'woocp_update_settings' ); ?>
                <input type="hidden" name="action" value="woocp_update_settings">
                <?php submit_button( __( 'Save Settings', 'woo-custom-price' ) ); ?>
            </form>
        </div>
        <?php
    }

    public function update_settings() {
        check_admin_referer( 'woocp_update_settings' );
        $referrer = wp_get_referer();

        $price_label = isset( $_POST['price_label'] ) ? sanitize_text_field( wp_unslash( $_POST['price_label'] ) ) : '';

        // Update settings.
        update_option( 'woocp_price_label', $price_label );

        wp_safe_redirect( $referrer );
    }
}