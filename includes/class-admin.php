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
        $woocp_price_setting = get_option('woocp_price');
        ?>
        <style>
            .wooco-wrap {
                max-width: 960px;
                width: 100%;
                margin: 10px auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 8px;
                background-color: #fff;
                box-sizing: border-box;
            }
            .form-card {
                display: grid;
                grid-template-columns: 1fr 2fr;
                gap: 20px;
            }
            .form-heading {
                grid-column: span 2;
                margin-bottom: 20px;
            }
            .form-group {
                display: contents;
            }
            .form-group label {
                padding-top: 10px;
            }
            .form-group .form-input, .form-group select {
                width: 50%;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            .form-group p {
                margin-top: 5px;
                font-size: 0.9em;
                color: #666;
            }
        </style>
        <div class="wooco-wrap">
            <h1><?php esc_html_e( 'Woo Custom Price', 'woo-custom-price' ); ?></h1>
            <p><?php esc_html_e( 'Below are the plugin options that will determine how the plugin will work.', 'woo-custom-price' ); ?></p>

            <form class="form-card" method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <div class="form-heading">
                    <h2><?php esc_html_e( 'General Options', 'woo-custom-price' ); ?></h2>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <div>
                        <input type="radio" id="status" name="status" value="enable" <?php checked('enable', $woocp_price_setting['status']); ?>>
                        <label for="enable">Enable</label>

                        <input type="radio" id="status" name="status" value="disable" <?php checked('disable', $woocp_price_setting['status']); ?>>
                        <label for="disable">Disable</label>
                        <p><?php esc_html_e( 'You still can enable/disable it on a product basis.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="price_label"><?php esc_html_e( 'Suggested price', 'woo-custom-price' ); ?></label>
                    <div>
                        <input class="form-input" type="text" name="suggested_price" id="suggested_price" placeholder="Suggested Price: %s" value="<?php echo esc_attr( $woocp_price_setting['suggested_price'] ); ?>" />
                        <p><?php esc_html_e( 'Use General tabs price as suggested price, leave blank to hide. Use "%s" for price.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="add_to_cart_button">Add to cart button</label>
                    <div>
                        <input type="radio" id="add_to_cart_button" name="add_to_cart_button" value="show" <?php checked('show', $woocp_price_setting['add_to_cart_button']); ?>>
                        <label for="enable">Show</label>

                        <input type="radio" id="add_to_cart_button" name="add_to_cart_button" value="hide" <?php checked('hide', $woocp_price_setting['add_to_cart_button']); ?>>
                        <label for="disable">Hide</label>
                        <p><?php esc_html_e( 'Show/hide add to cart button on the shop/archive page.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="rounding_values">Rounding values</label>
                    <div>
                        <input type="radio" id="rounding_values" name="rounding_values" value="down" <?php checked('down', $woocp_price_setting['rounding_values']); ?>>
                        <label for="enable">Down</label>

                        <input type="radio" id="rounding_values" name="rounding_values" value="up" <?php checked('up', $woocp_price_setting['rounding_values']); ?>>
                        <label for="disable">Up</label>
                        <p><?php esc_html_e( 'Round the amount to the nearest bigger (up) or smaller (down) value when an invalid number is inputted.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-heading">
                    <h2><?php esc_html_e( 'Custom Price input', 'woo-custom-price' ); ?></h2>
                </div>

                <div class="form-group">
                    <label for="price_label"><?php esc_html_e( 'Label', 'woo-custom-price' ); ?></label>
                    <div>
                        <input class="form-input" type="text" name="price_label" id="price_label" placeholder="Name Your Price (%s)" value="<?php echo esc_attr( $woocp_price_setting['price_label'] ); ?>" />
                        <p><?php esc_html_e( 'Use "%s" for currency.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="default_value">Default value</label>
                    <div>
                        <select name="default_value" id="default_value" class="form-input">
                            <option value="product_price" <?php selected('product_price', $woocp_price_setting['default_value']); ?>>Product Price</option>
                            <option value="min_value" <?php selected('min_value', $woocp_price_setting['default_value']); ?>>Min Value</option>
                            <option value="max_value" <?php selected('max_value', $woocp_price_setting['default_value']); ?>>Max Value</option>
                            <option value="step_value" <?php selected('step_value', $woocp_price_setting['default_value']); ?>>Step Value</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="minimum"><?php esc_html_e( 'Minimum', 'woo-custom-price' ); ?></label>
                    <div>
                        <input class="form-input" type="text" name="minimum" id="minimum" value="<?php echo esc_attr( $woocp_price_setting['minimum'] ); ?>" />
                        <p><?php esc_html_e( 'Leave blank or zero to disable.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="step"><?php esc_html_e( 'Step', 'woo-custom-price' ); ?></label>
                    <div>
                        <input class="form-input" type="text" name="step" id="step" value="<?php echo esc_attr( $woocp_price_setting['step'] ); ?>" />
                        <p><?php esc_html_e( 'Leave blank or zero to disable.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="maximum"><?php esc_html_e( 'Maximum', 'woo-custom-price' ); ?></label>
                    <div>
                        <input class="form-input" type="text" name="maximum" id="maximum" value="<?php echo esc_attr( $woocp_price_setting['maximum'] ); ?>" />
                        <p><?php esc_html_e( 'Leave blank or zero to disable.', 'woo-custom-price' ); ?></p>
                    </div>
                </div>

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

        $woocp_price['status'] = isset( $_POST['status'] ) ? sanitize_text_field( wp_unslash( $_POST['status'] ) ) : '';
        $woocp_price['suggested_price'] = isset( $_POST['suggested_price'] ) ? sanitize_text_field( wp_unslash( $_POST['suggested_price'] ) ) : '';
        $woocp_price['add_to_cart_button'] = isset( $_POST['add_to_cart_button'] ) ? sanitize_text_field( wp_unslash( $_POST['add_to_cart_button'] ) ) : '';
        $woocp_price['rounding_values'] = isset( $_POST['rounding_values'] ) ? sanitize_text_field( wp_unslash( $_POST['rounding_values'] ) ) : '';

        $woocp_price['price_label'] = isset( $_POST['price_label'] ) ? sanitize_text_field( wp_unslash( $_POST['price_label'] ) ) : '';
        $woocp_price['default_value'] = isset( $_POST['default_value'] ) ? sanitize_text_field( wp_unslash( $_POST['default_value'] ) ) : '';
        $woocp_price['minimum'] = isset( $_POST['minimum'] ) ? sanitize_text_field( wp_unslash( $_POST['minimum'] ) ) : '';
        $woocp_price['step'] = isset( $_POST['step'] ) ? sanitize_text_field( wp_unslash( $_POST['step'] ) ) : '';
        $woocp_price['maximum'] = isset( $_POST['minimum'] ) ? sanitize_text_field( wp_unslash( $_POST['maximum'] ) ) : '';

        // Update settings.
        update_option( 'woocp_price', $woocp_price );

        wp_safe_redirect( $referrer );
    }
}