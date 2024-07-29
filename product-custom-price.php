<?php
/*
 * Plugin Name:       Product Custom Price
 * Plugin URI:        https://woocopilot.com/plugins/product-custom-price/
 * Description:       Product Custom Price is a powerful WordPress plugin designed to give your customers the flexibility to set their own price when purchasing products on your WooCommerce store. With this plugin, you can empower your customers to input a custom-chosen price for any product, allowing for greater engagement and flexibility in your pricing strategy.
 * Version:           1.0.0
 * Requires at least: 6.5
 * Requires PHP:      7.2
 * Author:            WooCopilot
 * Author URI:        https://woocopilot.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       product-custom-price
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
 */

/*
Product Custom Price is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Product Custom Price is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Product Custom Price. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

defined( 'ABSPATH' ) || exit; // Exist if accessed directly.

// Including classes.
require_once __DIR__ . '/includes/class-product-custom-price.php';
require_once __DIR__ . '/includes/class-admin.php';

/**
 * Initializing plugin.
 *
 * @since 1.0.0
 * @return Object Plugin object.
 */
function product_custom_price() {
    return new Product_Custom_Price( __FILE__, '1.0.0' );
}

product_custom_price();
