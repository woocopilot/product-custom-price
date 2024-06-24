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
            'woo price',       // Menu title
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
        register_setting('my_custom_submenu_options_group', 'my_custom_price', 'my_plugin_sanitize');

        // Add a new section in the "my_custom_submenu_options_group" page
        add_settings_section(
            'my_custom_submenu_section_id',      // ID
            'My Custom Submenu Section',         // Title
            array($this, 'my_custom_submenu_section_cb'),      // Callback
            'my-custom-price-slug'             // Page
        );

        // Add a new field to the "my_custom_submenu_section_id" section, inside the "my-custom-submenu-slug" page
        add_settings_field(
            'max_price_id',        // ID
            'Max Price',                   // Title
            array($this, 'my_custom_max_price'),        // Callback
            'my-custom-price-slug',            // Page
            'my_custom_submenu_section_id'       // Section
        );

        add_settings_field(
            'min_price_id',        // ID
            'Min Price',                   // Title
            array($this, 'my_custom_min_price'),        // Callback
            'my-custom-price-slug',            // Page
            'my_custom_submenu_section_id'       // Section
        );
        add_settings_field(
            'step_price_id',        // ID
            'Step Price',                   // Title
            array($this, 'my_custom_step_price'),        // Callback
            'my-custom-price-slug',            // Page
            'my_custom_submenu_section_id'       // Section
        );
        add_settings_field(
            'my_plugin_checkbox',
            'Enable Feature',
            array($this, 'my_plugin_checkbox_callback'),

            'my-custom-price-slug',
            'my_custom_submenu_section_id'
        );
    }

    public function my_custom_submenu_section_cb() {
        echo 'This is a description of the section.';
    }

    public function my_custom_max_price() {
        $setting = get_option('my_custom_price');
        ?>
        <input type="number" name="my_custom_price[max_price]" value="<?php echo isset($setting['max_price']) ? esc_attr($setting['max_price']) : ''; ?>">
        <?php
    }

    public function my_custom_min_price() {
        $setting = get_option('my_custom_price');
        ?>
        <input type="number" name="my_custom_price[min_price]" value="<?php echo isset($setting['min_price']) ? esc_attr($setting['min_price']) : ''; ?>">
        <?php
    }
    public function my_custom_step_price() {
        $setting = get_option('my_custom_price');
        ?>
        <input type="number" name="my_custom_price[step_price]" value="<?php echo isset($setting['step_price']) ? esc_attr($setting['step_price']) : ''; ?>">
        <?php
    }

    function my_plugin_checkbox_callback() {
        $setting = get_option('my_custom_price');
        $checked = isset($setting['my_plugin_checkbox']) ? checked($setting['my_plugin_checkbox'], 1, false) : '';
        ?>
        <input type="checkbox" name="my_custom_price[my_plugin_checkbox]" value="1" <?php echo $checked; ?>>
        <?php
    }

    function my_plugin_sanitize($input) {
        $new_input = array();
        if (isset($input['my_plugin_checkbox'])) {
            $new_input['my_plugin_checkbox'] = absint($input['my_plugin_checkbox']);
        } else {
            $new_input['my_plugin_checkbox'] = 0;
        }

        return $new_input;
    }
}

// Instantiate the class
//if (is_admin()) {
//    $my_custom_settings = new MyCustomSettings();
//}
