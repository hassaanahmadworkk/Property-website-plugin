<?php
// Hook to add the options page
add_action('admin_menu', 'tf_register_option_page');

function tf_register_option_page() {
    add_menu_page(
        'My Options', // Page title
        'My Options', // Menu title
        'manage_options', // Capability (fixed capitalization)
        'my_options', // Menu slug
        'my_options_page_html', // Callback function
        'dashicons-admin-generic', // Icon (optional)
        20 // Position (optional)
    );
}

function my_options_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Check if the settings are updated
    if (isset($_GET['settings_updated'])) {
        add_settings_error(
            'my_options_messages',
            'my_options_message',
            esc_html__('Settings Saved', 'text_domain'),
            'updated'
        );
    }

    // Show settings errors or updates
    settings_errors('my_options_messages');

    ?>

    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('my_options_group'); // Security field (fixed typo from settings_field to settings_fields)
            do_settings_sections('my_options'); // Settings sections
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

// Hook to register settings
add_action('admin_init', 'my_plugin_register_settings');

function my_plugin_register_settings() {
    register_setting('my_options_group', 'my_plugin_options');

    add_settings_section(
        'my_plugin_section', // Section ID
        esc_html__('My Plugin Settings', 'text_domain'), // Title
        'my_plugin_section_callback', // Callback function
        'my_options' // Page
    );

    add_settings_field(
        'my_plugin_field', // Field ID
        esc_html__('Enable Modules', 'text_domain'), // Title
        'my_plugin_field_callback', // Callback function
        'my_options', // Page
        'my_plugin_section' // Section
    );
}

function my_plugin_section_callback() {
    echo esc_html__('Check the modules you want to enable.', 'text_domain');
}

function my_plugin_field_callback() {
    $options = get_option('my_plugin_options');
    $modules = isset($options['modules']) ? $options['modules'] : array();
    $available_modules = array(
        'module1' => esc_html__('Module 1', 'text_domain'),
        'module2' => esc_html__('Module 2', 'text_domain'),
        'module3' => esc_html__('Module 3', 'text_domain'),
    );

    foreach ($available_modules as $key => $label) {
        $checked = in_array($key, $modules) ? 'checked' : '';
        echo '<label><input type="checkbox" name="my_plugin_options[modules][]" value="' . esc_attr($key) . '" ' . $checked . '> ' . esc_html($label) . '</label><br>';
    }
}
?>
