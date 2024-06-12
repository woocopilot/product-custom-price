<?php

class MyCustomSettings {
    public function __construct() {
        // Hook into the 'admin_menu' action
        add_action('admin_menu', array($this, 'add_my_custom_price'));

        // Hook into the 'admin_init' action
        add_action('admin_init', array($this, 'register_my_custom_settings'));
    }

    public function add_my_custom_price() {
        // Add submenu page under Settings menu
        add_options_page(
            'My Woo Custom Price', // Page title
            'My Woo Custom Price',       // Menu title
            'manage_options',          // Capability
            'my-custom-price-slug',  // Menu slug
            array($this, 'my_custom_price')   // Callback function
        );
    }

    public function my_custom_price() {
        ?>
        <div class="wrap">
            <h1>My Custom Price</h1>
            <form method="post" action="options.php">
                <?php
                // Output security fields for the registered setting
                settings_fields('my_custom_submenu_options_group');

                // Output setting sections and their fields
                do_settings_sections('my-custom-price-slug');

                // Output save settings button
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_my_custom_settings() {
        // Register a new setting for "my_custom_submenu_options_group" page
        register_setting('my_custom_submenu_options_group', 'my_custom_submenu_option_name');

        // Add a new section in the "my_custom_submenu_options_group" page
        add_settings_section(
            'my_custom_submenu_section_id',      // ID
            'My Custom Submenu Section',         // Title
            array($this, 'my_custom_submenu_section_cb'),      // Callback
            'my-custom-price-slug'             // Page
        );

        // Add a new field to the "my_custom_submenu_section_id" section, inside the "my-custom-submenu-slug" page
        add_settings_field(
            'my_custom_submenu_field_id',        // ID
            'My Custom Field',                   // Title
            array($this, 'my_custom_submenu_field_cb'),        // Callback
            'my-custom-price-slug',            // Page
            'my_custom_submenu_section_id'       // Section
        );
    }

    public function my_custom_submenu_section_cb() {
        echo 'This is a description of the section.';
    }

    public function my_custom_submenu_field_cb() {
        $setting = get_option('my_custom_submenu_option_name');
        ?>
        <input type="text" name="my_custom_submenu_option_name" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
        <?php
    }
}

// Instantiate the class
//if (is_admin()) {
//    $my_custom_settings = new MyCustomSettings();
//}
