<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class Admin.
 *
 * @since 1.0.0
 */
class Admin {

    public string $test;

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_menu', array( $this, 'sub_menu_under_woocommerce' ) );
        add_action( 'admin_notices', array( $this, 'dependencies_notices' ) );
    }

    public function admin_menu() {
        add_menu_page(
            'Woo Custom Price',
            'Woo Custom Price',
            'manage_options',
            'woo-custom-price',
            array( $this, 'admin_page' ),
            'dashicons-cart',
            '56',
        );
    }

    public function admin_page() {
        echo '<div class="wrap">';
        echo '<h2>Woo Custom Price</h2>';
        echo '</div>';
    }

    public function sub_menu_under_woocommerce() {
        add_submenu_page(
            'woocommerce',
            'Woo Custom Price',
            'Woo Custom Price',
            'manage_options',
            'woo-custom-price',
            array( $this, 'under_woocommerce_page' )
        );
    }
    public function under_woocommerce_page() {
//        session_start(); // Start session
//
//        if(isset($_POST['input_value'])) {
//            $_SESSION['input_value'] = $_POST['input_value']; // Save input value in session
//        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['input_value'])) {
            $current_user = wp_get_current_user();
            update_user_meta($current_user->ID, 'input_value', sanitize_text_field($_POST['input_value']));
        }

        ?>
        <h1>Something I want to add</h1>
        <form method="post">
            <input class="border-block-support-panel" name="input_value"/>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <?php
    }

    public function dependencies_notices() {
        $current_user = wp_get_current_user();
        $input = get_user_meta($current_user->ID, 'input_value', true);

        if (!$input) {
            $input = 'No input saved';
        }

        if (class_exists('WooCommerce')) {
            printf('<div id="message" class="notice is-dismissible notice-success"><p>%s</p></div>', $input);
        }
    }

}