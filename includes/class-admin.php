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

        // Product metaboxes.
        add_action( 'woocommecre_product_panel_hook_name_should_appear_here', array( $this, 'your_method_name' ) );

        // Enqueue admin scripts.
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    /**
     * Add sub menu.
     *
     * @since 1.0.0
     * @return void
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

    /**
     * Settings.
     *
     * @since 1.0.0
     * @return void
     */
    public function render_settings_page() {
        ?>
        <div class="wrap wooco-wrap">
            <h1><?php esc_html_e( 'Woo Custom Price', 'woo-custom-price' ); ?></h1>
            <p><?php esc_html_e( 'Below are the plugin options that will determine how the plugin will work.', 'woo-custom-price' ); ?></p>

            <form class="woocp-settings-form" method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                <div class="form-heading">
                    <h2><?php esc_html_e( 'General Options', 'woo-custom-price' ); ?></h2>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="woocp_status_enabled"><?php esc_html_e( 'Status', 'woo-custom-price' );?></label>
                    </div>
                    <div class="form-field">
                        <label for="woocp_status_enabled"><input type="radio" id="woocp_status_enabled" name="woocp_status" value="enable" <?php checked('enable', get_option( 'woocp_status' ) ); ?>><?php esc_html_e( 'Enable', 'woo-custom-price' ); ?></label>
                        <label for="woocp_status_disabled"><input type="radio" id="woocp_status_disabled" name="woocp_status" value="disable" <?php checked('disable', get_option( 'woocp_status' ) ); ?>><?php esc_html_e( 'Disable', 'woo-custom-price' ); ?></label>
                        <p><?php esc_html_e( 'Enable this to apply the plugin features.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="woocp_loop_add_to_cart_btn_show"><?php esc_html_e( 'Add to cart button', 'woo-custom-price' );?></label>
                    </div>
                    <div class="form-field">
                        <label for="woocp_loop_add_to_cart_btn_show"><input type="radio" id="woocp_loop_add_to_cart_btn_show" name="woocp_loop_add_to_cart_btn" value="enable" <?php checked('enable', get_option( 'woocp_loop_add_to_cart_btn' )); ?>><?php esc_html_e( 'Show', 'woo-custom-price' ); ?></label>
                        <label for="woocp_loop_add_to_cart_btn_hide"><input type="radio" id="woocp_loop_add_to_cart_btn_hide" name="woocp_loop_add_to_cart_btn" value="disable" <?php checked('disable', get_option( 'woocp_loop_add_to_cart_btn' )); ?>><?php esc_html_e( 'Hide', 'woo-custom-price' ); ?></label>
                        <p><?php esc_html_e( 'Show/hide add to cart button on the shop/archive page.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-heading">
                    <h2><?php esc_html_e( 'Options for Custom Price Input', 'woo-custom-price' ); ?></h2>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="woocp_input_label_text"><?php esc_html_e( 'Label', 'woo-custom-price' ); ?></label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="woocp_input_label_text" id="woocp_input_label_text" placeholder="Name Your Price" value="<?php echo esc_attr( get_option('woocp_input_label_text', 'Enter Your Price' ) ); ?>" />
                        <p><?php esc_html_e( 'Enter the custom label.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="woocp_minimum_price"><?php esc_html_e( 'Minimum', 'woo-custom-price' ); ?></label>
                    </div>
                    <div class="form-field">
                        <input type="number" id="woocp_minimum_price" name="woocp_minimum_price" min="0" placeholder="Enter the minimum value" value="<?php echo esc_attr( get_option( 'woocp_minimum_price') ); ?>" />
                        <p><?php esc_html_e( 'Enter the minimum value. You can still override it on a per-product basis.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="woocp_maximum_price"><?php esc_html_e( 'Maximum', 'woo-custom-price' ); ?></label>
                    </div>
                    <div class="form-field">
                        <input type="number" id="woocp_maximum_price" name="woocp_maximum_price" min="0" placeholder="Enter the maximum value" value="<?php echo esc_attr( get_option( 'woocp_maximum_price' ) ); ?>" />
                        <p><?php esc_html_e( 'Enter the maximum value. You can still override it on a per-product basis.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="woocp_step"><?php esc_html_e( 'Step', 'woo-custom-price' ); ?></label>
                    </div>
                    <div class="form-field">
                        <input type="number" id="woocp_step" name="woocp_step" step="0.01" value="<?php echo esc_attr( get_option( 'woocp_step') ); ?>" />
                        <p><?php esc_html_e( 'Enter the step value. You can still override it on a per-product basis.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <?php wp_nonce_field( 'woocp_update_settings' ); ?>
                <input type="hidden" name="action" value="woocp_update_settings">
                <?php submit_button( __( 'Save Settings', 'woo-custom-price' ) ); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Update settings.
     *
     * @since 1.0.0
     * @return void
     */
    public function update_settings() {
        check_admin_referer( 'woocp_update_settings' );
        $referrer = wp_get_referer();

        $status = isset( $_POST['woocp_status'] ) ? sanitize_key( $_POST['woocp_status'] ) : '';
        $loop_add_to_cart_btn = isset( $_POST['woocp_loop_add_to_cart_btn'] ) ? sanitize_key( $_POST['woocp_loop_add_to_cart_btn'] ) : '';
        $input_label = isset( $_POST['woocp_input_label_text'] ) ? sanitize_text_field( $_POST['woocp_input_label_text'] ) : '';
        $minimum_price = isset( $_POST['woocp_minimum_price'] ) ? intval( $_POST['woocp_minimum_price'] ) : '';
        $maximum_price = isset( $_POST['woocp_maximum_price'] ) ? intval( $_POST['woocp_maximum_price'] ) : '';
        $step = isset( $_POST['woocp_step'] ) ? floatval( $_POST['woocp_step'] ) : '';

        // Update settings.
        update_option( 'woocp_status', $status );
        update_option( 'woocp_loop_add_to_cart_btn', $loop_add_to_cart_btn );
        update_option( 'woocp_input_label_text', $input_label );
        update_option( 'woocp_minimum_price', $minimum_price );
        update_option( 'woocp_maximum_price', $maximum_price );
        update_option( 'woocp_step', $step );

        wp_safe_redirect( $referrer );
    }

    /**
     * Your method description.
     *
     * @since 1.0.0
     * @retun void
     */
    public function your_method_name() {
        // Your code should appear here...

        // Possible chat GPT commands.
        // How to add woocommerce product panel tab and data.
        // How to add custom panel and data inside the woocommerce product metabox panel.

        // for saving metabpox data.
        $step = isset( $_POST['woocp_step'] ) ? floatval( $_POST['woocp_step'] ) : '';

        update_post_meta( get_the_ID(), 'woocp_your_id_name', 'yes' );
    }

    /**
     * Admin scripts.
     *
     * @param string $hook Page hook.
     *
     * @since 1.0.0
     * @retun void
     */
    public function enqueue_scripts( $hook ) {
        if ( 'woocommerce_page_woo-custom-price' === $hook ) {
            wp_enqueue_style( 'woocp_admin_style', WOOCP_PLUGIN_URL . 'assets/css/admin-style.css', array(), WOOCP_VERSION );
        }
    }
}