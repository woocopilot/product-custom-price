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
        add_action( 'admin_post_pcprice_update_settings', array( $this, 'update_settings' ) );

        // Product metaboxes.
        add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_data_tab' ) );
        add_action('woocommerce_product_data_panels', array( $this, 'add_data_panel' ) );
        add_action('woocommerce_process_product_meta', array( $this, 'save_product_meta' ) );

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
            __( 'Product Custom Price', 'product-custom-price' ),
            __( 'Product Custom Price', 'product-custom-price' ),
            'manage_woocommerce',
            'product-custom-price',
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
        <div class="wrap pcprice-wrap">
            <h1><?php esc_html_e( 'Product Custom Price', 'product-custom-price' ); ?></h1>
            <p><?php esc_html_e( 'Below are the plugin options that will determine how the plugin will work.', 'product-custom-price' ); ?></p>

            <form class="pcprice-settings-form" method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                <div class="form-heading">
                    <h2><?php esc_html_e( 'General Options', 'product-custom-price' ); ?></h2>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="pcprice_status_enabled"><?php esc_html_e( 'Status', 'product-custom-price' );?></label>
                    </div>
                    <div class="form-field">
                        <label for="pcprice_status_enabled"><input type="radio" id="pcprice_status_enabled" name="pcprice_status" value="enable" <?php checked('enable', get_option( 'pcprice_status' ) ); ?>><?php esc_html_e( 'Enable', 'product-custom-price' ); ?></label>
                        <label for="pcprice_status_disabled"><input type="radio" id="pcprice_status_disabled" name="pcprice_status" value="disable" <?php checked('disable', get_option( 'pcprice_status' ) ); ?>><?php esc_html_e( 'Disable', 'product-custom-price' ); ?></label>
                        <p><?php esc_html_e( 'Enable this to apply the plugin features.', 'product-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="pcprice_loop_add_to_cart_btn_show"><?php esc_html_e( 'Add to cart button', 'product-custom-price' );?></label>
                    </div>
                    <div class="form-field">
                        <label for="pcprice_loop_add_to_cart_btn_show"><input type="radio" id="pcprice_loop_add_to_cart_btn_show" name="pcprice_loop_add_to_cart_btn" value="enable" <?php checked('enable', get_option( 'pcprice_loop_add_to_cart_btn' )); ?>><?php esc_html_e( 'Show', 'product-custom-price' ); ?></label>
                        <label for="pcprice_loop_add_to_cart_btn_hide"><input type="radio" id="pcprice_loop_add_to_cart_btn_hide" name="pcprice_loop_add_to_cart_btn" value="disable" <?php checked('disable', get_option( 'pcprice_loop_add_to_cart_btn' )); ?>><?php esc_html_e( 'Hide', 'product-custom-price' ); ?></label>
                        <p><?php esc_html_e( 'Show/hide add to cart button on the shop/archive page.', 'product-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-heading">
                    <h2><?php esc_html_e( 'Options for Custom Price Input', 'product-custom-price' ); ?></h2>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="pcprice_input_label_text"><?php esc_html_e( 'Label', 'product-custom-price' ); ?></label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="pcprice_input_label_text" id="pcprice_input_label_text" placeholder="Name Your Price" value="<?php echo esc_attr( get_option('pcprice_input_label_text', 'Enter Your Price' ) ); ?>" />
                        <p><?php esc_html_e( 'Enter the custom price field label.', 'product-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="pcprice_minimum_price"><?php esc_html_e( 'Minimum', 'product-custom-price' ); ?></label>
                    </div>
                    <div class="form-field">
                        <input type="number" id="pcprice_minimum_price" name="pcprice_minimum_price" step="any" placeholder="Enter the minimum value" value="<?php echo esc_attr( get_option( 'pcprice_minimum_price', floatval( '1' ) ) ); ?>" />
                        <p><?php esc_html_e( 'Enter the minimum value. You can still override it on a per-product basis.', 'product-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="pcprice_maximum_price"><?php esc_html_e( 'Maximum', 'product-custom-price' ); ?></label>
                    </div>
                    <div class="form-field">
                        <input type="number" id="pcprice_maximum_price" step="any" name="pcprice_maximum_price" placeholder="Enter the maximum value" value="<?php echo esc_attr( get_option( 'pcprice_maximum_price', floatval( '1000' ) ) ); ?>" />
                        <p><?php esc_html_e( 'Enter the maximum value. You can still override it on a per-product basis.', 'product-custom-price' ); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="pcprice_step"><?php esc_html_e( 'Step', 'product-custom-price' ); ?></label>
                    </div>
                    <div class="form-field">
                        <input type="number" id="pcprice_step" name="pcprice_step" step="any" value="<?php echo esc_attr( get_option( 'pcprice_step', floatval( '0.01' ) ) ); ?>" />
                        <p><?php esc_html_e( 'Enter the step value. You can still override it on a per-product basis.', 'product-custom-price' ); ?></p>
                    </div>
                </div>

                <?php wp_nonce_field( 'pcprice_update_settings' ); ?>
                <input type="hidden" name="action" value="pcprice_update_settings">
                <?php submit_button( __( 'Save Settings', 'product-custom-price' ) ); ?>
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
        check_admin_referer( 'pcprice_update_settings' );
        $referrer = wp_get_referer();

        $status = isset( $_POST['pcprice_status'] ) ? sanitize_key( $_POST['pcprice_status'] ) : '';
        $loop_add_to_cart_btn = isset( $_POST['pcprice_loop_add_to_cart_btn'] ) ? sanitize_key( wp_unslash( $_POST['pcprice_loop_add_to_cart_btn'] ) ) : '';
        $input_label = isset( $_POST['pcprice_input_label_text'] ) ? sanitize_text_field( $_POST['pcprice_input_label_text'] ) : '';
        $minimum_price = isset( $_POST['pcprice_minimum_price'] ) ? floatval( $_POST['pcprice_minimum_price'] ) : '';
        $maximum_price = isset( $_POST['pcprice_maximum_price'] ) ? floatval( $_POST['pcprice_maximum_price'] ) : '';
        $step = isset( $_POST['pcprice_step'] ) ? floatval( $_POST['pcprice_step'] ) : '';

        // Update settings.
        update_option( 'pcprice_status', $status );
        update_option( 'pcprice_loop_add_to_cart_btn', $loop_add_to_cart_btn );
        update_option( 'pcprice_input_label_text', $input_label );
        update_option( 'pcprice_minimum_price', $minimum_price );
        update_option( 'pcprice_maximum_price', $maximum_price );
        update_option( 'pcprice_step', $step );

        wp_safe_redirect( $referrer );
    }

    /**
     * Add product data tab.
     *
     * @since 1.0.0
     * @retun array
     */
    public function add_data_tab($tabs) {
        $tabs['pcprice_custom_price'] = array(
            'label'    => __('Product Custom Price', 'product-custom-price'),
            'target'   => 'pcprice_product_data',
            'class'    => array('show_if_simple', 'show_if_variable'),
            'priority' => 21,
        );

        return $tabs;
    }

    /**
     * Add product data panel.
     *
     * @since 1.0.0
     * @retun void
     */
    public function add_data_panel() {
        global $woocommerce, $post;
        ?>
        <div id='pcprice_product_data' class='panel woocommerce_options_panel'>
            <div class='options_group'>
                <?php
                woocommerce_wp_checkbox(array(
                    'id'    => '_pcprice_is_enabled',
                    'label'  => __('Enable Custom Price', 'product-custom-price'),
                    'options' => array(
                            'yes' => __('Yes', 'product-custom-price'),
                        'no'  => __('No', 'product-custom-price'),
                    ),
                    'default' => 'yes',
                    'description' => __('Enable Product Custom Price for this product', 'product-custom-price'),
                    'desc_tip'    => 'true',
                ));

                woocommerce_wp_text_input(array(
                    'id'          => '_pcprice_input_label_text',
                    'label'       => __('Price Label', 'product-custom-price'),
                    'placeholder' => 'Enter Your Price',
                    'description' => __('Enter the custom price field label.', 'product-custom-price'),
                    'desc_tip'    => 'true',
                    'type'        => 'text',
                ));

                woocommerce_wp_text_input(array(
                    'id'          => '_pcprice_minimum_price',
                    'label'       => __('Minimum', 'product-custom-price'),
                    'placeholder' => 'Enter the minimum value',
                    'description' => __('Enter the minimum value (ex: 1). Keep this empty or enter 0 for global settings.', 'product-custom-price'),
                    'desc_tip'    => 'true',
                    'type'        => 'number',
                    'custom_attributes' => array(
                        'step' => 'any',
                        'min'  => 0,
                    ),
                ));

                woocommerce_wp_text_input(array(
                    'id'          => '_pcprice_maximum_price',
                    'label'       => __('Maximum', 'product-custom-price'),
                    'placeholder' => 'Enter the maximum value',
                    'description' => __('Enter the maximum value (ex: 1000). Keep this empty or enter 0 for global settings.', 'product-custom-price'),
                    'desc_tip'    => 'true',
                    'type'        => 'number',
                    'custom_attributes' => array(
                        'step' => 'any',
                        'min'  => 0,
                    ),

                ));

                woocommerce_wp_text_input(array(
                    'id'          => '_pcprice_step',
                    'label'       => __('Step', 'product-custom-price'),
                    'placeholder' => 'Enter the step value',
                    'description' => 'Enter the step value. Keep this empty or enter 0 for global settings.',
                    'desc_tip'    => 'true',
                    'type'        => 'number',
                    'custom_attributes' => array(
                        'step' => 'any',
                        'min'  => 0.01,
                    ),
                    'data_type' => 'price'
                ));
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Save product meta.
     *
     * @since 1.0.0
     * @retun void
     */
    public function save_product_meta($post_id) {
        $pcprice_is_enable = isset($_POST['_pcprice_is_enabled']) ? sanitize_text_field($_POST['_pcprice_is_enabled']) : '';
        $price_label = isset($_POST['_pcprice_input_label_text']) ? sanitize_text_field($_POST['_pcprice_input_label_text']) : '';
        $min = isset($_POST['_pcprice_minimum_price']) ? floatval($_POST['_pcprice_minimum_price']) : '';
        $max = isset($_POST['_pcprice_maximum_price']) ? floatval($_POST['_pcprice_maximum_price']) : '';
        $step = isset($_POST['_pcprice_step']) ? floatval($_POST['_pcprice_step']) : '';

        update_post_meta($post_id, '_pcprice_is_enabled', $pcprice_is_enable);
        update_post_meta($post_id, '_pcprice_input_label_text', $price_label);
        update_post_meta($post_id, '_pcprice_minimum_price', $min);
        update_post_meta($post_id, '_pcprice_maximum_price', $max);
        update_post_meta($post_id, '_pcprice_step', $step);
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
        if ( 'woocommerce_page_product-custom-price' === $hook ) {
            wp_enqueue_style( 'pcprice_admin_style', PCPRICE_PLUGIN_URL . 'assets/css/admin.css', array(), PCPRICE_VERSION );
        }
    }
}
