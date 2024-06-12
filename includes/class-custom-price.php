<?php

// Define the class
class MyCustomWooCommerceSubmenu {
    public function __construct() {
        // Hook into the 'admin_menu' action to add the submenu
        add_action('admin_menu', array($this, 'add_submenu'));

        // Hook into 'admin_init' action to register settings
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_submenu() {
        // Add submenu page under WooCommerce menu
        add_submenu_page(
            'woocommerce',                 // Parent slug
            'My Custom Submenu',           // Page title
            'My Custom Submenu',           // Menu title
            'manage_woocommerce',          // Capability
            'my-custom-submenu-slug',      // Menu slug
            array($this, 'submenu_page')   // Callback function
        );
    }

    public function submenu_page() {
        ?>
        <div class="wrap">
            <h1>My Custom Submenu Page</h1>
            <form method="post" action="options.php">
                <?php
                // Output security fields for the registered setting
                settings_fields('my_custom_submenu_options_group');

                // Output setting sections and their fields
                do_settings_sections('my-custom-submenu-slug');

                // Output save settings button
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        // Register a new setting for "my_custom_submenu_options_group" page
        register_setting('my_custom_submenu_options_group', 'my_custom_submenu_option_name');

        // Add a new section in the "my_custom_submenu_options_group" page
        add_settings_section(
            'my_custom_submenu_section_id',     // ID
            'My Custom Submenu Section',        // Title
            array($this, 'submenu_section_cb'), // Callback
            'my-custom-submenu-slug'            // Page
        );

        // Add a new field to the "my_custom_submenu_section_id" section, inside the "my-custom-submenu-slug" page
        add_settings_field(
            'my_custom_submenu_field_id',       // ID
            'My Custom Field',                  // Title
            array($this, 'submenu_field_cb'),   // Callback
            'my-custom-submenu-slug',           // Page
            'my_custom_submenu_section_id'      // Section
        );
    }

    public function submenu_section_cb() {
        echo 'This is a description of the section.';
    }

    public function submenu_field_cb() {

        $setting = get_option('my_custom_submenu_option_name');
        ?>
        <input type="text" name="my_custom_submenu_option_name" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
        <?php
    }
}

// Instantiate the class if in the admin area
//if (is_admin()) {
//    $my_custom_woocommerce_submenu = new MyCustomWooCommerceSubmenu();
//}
