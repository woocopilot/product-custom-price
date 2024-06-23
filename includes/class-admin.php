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
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $current_user = wp_get_current_user();

            // Check and sanitize each input field
            if (isset($_POST['input_value'])) {
                update_user_meta($current_user->ID, 'input_value', sanitize_text_field($_POST['input_value']));
            }

            if (isset($_POST['check']) && $_POST['check'] === 'check') {
                if (isset($_POST['max_value'])) {
                    update_user_meta($current_user->ID, 'max_value', sanitize_text_field($_POST['max_value']));
                }
                if (isset($_POST['min_value'])) {
                    update_user_meta($current_user->ID, 'min_value', sanitize_text_field($_POST['min_value']));
                }
                if (isset($_POST['step_value'])) {
                    update_user_meta($current_user->ID, 'step_value', sanitize_text_field($_POST['step_value']));
                }
            } else {
                // Remove values from the database if the checkbox is not checked
                delete_user_meta($current_user->ID, 'max_value');
                delete_user_meta($current_user->ID, 'min_value');
                delete_user_meta($current_user->ID, 'step_value');
            }
        }

        // Get current values to display in the form
        $current_user = wp_get_current_user();
        $input_value = get_user_meta($current_user->ID, 'input_value', true);
        $max_value = get_user_meta($current_user->ID, 'max_value', true);
        $min_value = get_user_meta($current_user->ID, 'min_value', true);
        $step_value = get_user_meta($current_user->ID, 'step_value', true);

        ?>
        <script type="text/javascript">
            function validateForm() {
                var checkBox = document.getElementById('check');
                if (!checkBox.checked) {
                    alert('You must agree to the settings.');
                    return false;
                }
                return true;
            }


        </script>

        <h1>Something I want to add</h1>
        <form method="post" onsubmit="return validateForm()">
            <input class="border-block-support-panel" name="input_value" value="<?php echo esc_attr($input_value); ?>"/>
            <button type="submit" class="btn btn-primary">Save</button>

            <div class="card" id="additionalFields" >
                <h1>Input max value</h1>
                <input class="border-block-support-panel" name="max_value" value="<?php echo esc_attr($max_value); ?>"/>
                <h1>Input min value</h1>
                <input class="border-block-support-panel" name="min_value" value="<?php echo esc_attr($min_value); ?>"/>
                <h1>Input step value</h1>
                <input class="border-block-support-panel" name="step_value" value="<?php echo esc_attr($step_value); ?>"/>
<!--                <br>-->
<!--                <br>-->
<!--                <button type="submit" class="btn btn-primary">Save</button>-->
            </div>

            <br>
            <input type="checkbox" id="check" name="check" value="check" onclick="toggleFormFields()">
            <label for="check"> I agree in this settings</label><br>
            <br>
            <input type="submit" value="Submit">
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