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
}