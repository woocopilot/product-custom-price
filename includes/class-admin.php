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
        add_action( 'admin_menu', array( $this, 'admin_submenu_under_setting' ) );
        add_action( 'admin_menu', array( $this, 'admin_submenu_under_woocommerce' ) );
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
        ?>
        <div class="wrap">
            <h2>Woo Custom Price</h2>


            <form>
                
            </form>
        </div>
        <?php
    }
    /**
     * Add submenu under setting.
     *
     * @since 1.0.0
     * @return void
     */
public function admin_submenu_under_setting(){
add_options_page(
    "Woo Custom Price1",
    "Woo Custom Price1",
    'manage_options',
    'woo-custom-price1',
    array( $this, 'admin_page_under_setting' ),
    'dashicons-admin-settings',
);
}

/**
 * submenu page.
 *
 * @since 1.0.0
 * @return void
 */
public function admin_page_under_setting(){
    echo '<div class="wrap">';
    echo '<h2>Woo Custom Price1</h2>';
    echo '</div>';
}

    /**
     * Add submenu under woocommerce .
     *
     * @since 1.0.0
     * @return void
     */
public function admin_submenu_under_woocommerce(){
    add_submenu_page(
       'woocommerce',
       'Woo Custom Price2',
       'Woo Custom Price2',
       'manage_options',
       'woo-custom-price2',
       array( $this, 'admin_page_under_woocommerce' ),
   ) ;
}
public function admin_page_under_woocommerce(){
    echo '<div class="wrap">';
    echo '<h2>Woo Custom Price</h2>';
    echo '<p>Welcome to the Woo Custom Price plugin settings page.</p>';
    echo '</div>';
}


}