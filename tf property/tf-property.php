<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://grow9x.com/
 * @since             1.0.0
 * @package           Tf_Property
 *
 * @wordpress-plugin
 * Plugin Name:       TF-Property
 * Plugin URI:        https://https://grow9x.com/
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            grow9x
 * Author URI:        https://https://grow9x.com//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tf-property
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TF_PROPERTY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tf-property-activator.php
 */
function activate_tf_property() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tf-property-activator.php';
	Tf_Property_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tf-property-deactivator.php
 */
function deactivate_tf_property() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tf-property-deactivator.php';
	Tf_Property_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tf_property' );
register_deactivation_hook( __FILE__, 'deactivate_tf_property' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tf-property.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tf_property() {

	$plugin = new Tf_Property();
	$plugin->run();

}
run_tf_property();

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/cmb2/init.php';
}


if (!function_exists('child_theme_configurator_css')):
    function child_theme_configurator_css()
    {
        wp_enqueue_style('chld_thm_cfg_child', trailingslashit(get_stylesheet_directory_uri()) . 'style.css', array('hello-elementor', 'hello-elementor', 'hello-elementor-theme-style', 'hello-elementor-header-footer'));
        // Enqueue custom JavaScript
        wp_enqueue_script('custom-script', trailingslashit(get_stylesheet_directory_uri()) . 'js/custom-script.js', array('jquery'), null, true);
    }
endif;



add_action('wp_enqueue_scripts', 'child_theme_configurator_css', 99);





// Enqueue Slick Slider library
function enqueue_slick_slider()
{
    wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);
}
add_action('wp_enqueue_scripts', 'enqueue_slick_slider');




// Register Property Post Type
function custom_register_property_post_type()
{
    $labels = array(
        'name' => _x('Properties', 'post type general name'),
        'singular_name' => _x('Property', 'post type singular name'),
        'menu_name' => _x('Properties', 'admin menu'),
        'name_admin_bar' => _x('Property', 'add new on admin bar'),
        'add_new' => _x('Add New', 'property'),
        'add_new_item' => __('Add New Property'),
        'new_item' => __('New Property'),
        'edit_item' => __('Edit Property'),
        'view_item' => __('View Property'),
        'all_items' => __('All Properties'),
        'search_items' => __('Search Properties'),
        'parent_item_colon' => __('Parent Properties:'),
        'not_found' => __('No properties found.'),
        'not_found_in_trash' => __('No properties found in Trash.')
    );

    $args = array(
        'labels' => $labels,
        'description' => __('Description.'),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'property'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail'), // Removed 'excerpt', 'custom-fields'
    );

    register_post_type('property', $args);
}
add_action('init', 'custom_register_property_post_type');



function myplugin_load_custom_property_template($single_template) {
    global $post;

    if ($post->post_type == 'property') {
        $template_path = plugin_dir_path(__FILE__) . 'templates/single-property.php';
        error_log('Custom template path: ' . $template_path); // Debugging line
        if (file_exists($template_path)) {
            error_log('Custom template found.'); // Debugging line
            return $template_path;
        } else {
            error_log('Custom template not found.'); // Debugging line
        }
    }

    return $single_template;
}
add_filter('single_template', 'myplugin_load_custom_property_template');

// Add custom fields using CMB2
function custom_register_property_fields()
{
    $cmb = new_cmb2_box(
        array(
            'id' => 'property_metabox',
            'title' => __('Property Details', 'cmb2'),
            'object_types' => array('property'), // Post type to attach to
            'context' => 'normal',
            'priority' => 'high',
        )
    );

    // Add your custom fields here
    $cmb->add_field(
        array(
            'name' => __('Property Address', 'cmb2'),
            'id' => '_property_address',
            'type' => 'text',
        )
    );


    $cmb->add_field(
        array(
            'name' => 'Gallery Images',
            'desc' => '',
            'id' => 'property_gallery',
            'type' => 'file_list',
            // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
            // 'query_args' => array( 'type' => 'image' ), // Only images attachment
            // Optional, override default text strings
            'text' => array(
                'add_upload_files_text' => 'Add or Upload Files', // default: "Add or Upload Files"
                'remove_image_text' => 'Remove Image', // default: "Remove Image"
                'file_text' => 'File:', // default: "File:"
                'file_download_text' => 'Download', // default: "Download"
                'remove_text' => 'Remove', // default: "Remove"
            ),
        )
    );
    $cmb->add_field(
        array(
            'name' => __('Video File', 'cmb2'),
            'desc' => __('Upload or add a link to the video file.', 'cmb2'),
            'id' => 'video_file',
            'type' => 'file_list',
            // Additional parameters as needed
        )
    );

    // Add common note field
    $cmb->add_field(
        array(
            'name' => __('Common Note', 'cmb2'),
            'desc' => __('Add a common note for all properties.', 'cmb2'),
            'id' => 'tf_property_note',
            'type' => 'textarea',
            'default' => __('This is a sample note to share some basic information on all properties. This note can be enabled or disabled from Real Homes settings and its text plus label are fully customizable.', 'cmb2'),
            // Additional parameters as needed
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Property Price', 'cmb2'),
            'id' => '_property_price',
            'type' => 'text_money',
        )
    );

    $cmb->add_field(
        array(
            'name' => 'Description',
            'desc' => 'field description (optional)',
            'default' => 'standard value (optional)',
            'id' => 'property_description',
            'type' => 'textarea'
        )
    );

    $cmb->add_field(
        array(
            'name' => 'Bedrooms',
            'desc' => 'Select an option',
            'id' => 'property_bedroom',
            'type' => 'select',
            'show_option_none' => true,
            'default' => 'bedroom1',
            'options' => array(
                '1' => __('1', 'cmb2'),
                '2' => __('2', 'cmb2'),
                '3' => __('3', 'cmb2'),
                '4' => __('4', 'cmb2'),
                '5' => __('5', 'cmb2'),
                '6' => __('6', 'cmb2'),
            ),
        )
    );


    $cmb->add_field(
        array(
            'name' => 'Bathroom',
            'desc' => 'Select an option',
            'id' => 'property_bathroom',
            'type' => 'select',
            'show_option_none' => true,
            'default' => 'bathroom1',
            'options' => array(
                '1' => __('1', 'cmb2'),
                '2' => __('2', 'cmb2'),
                '3' => __('3', 'cmb2'),
                '4' => __('4', 'cmb2'),
                '5' => __('5', 'cmb2'),
                '6' => __('6', 'cmb2'),
            ),
        )
    );
    $cmb->add_field(
        array(
            'name' => 'Garage',
            'desc' => 'Select an option',
            'id' => 'property_garage',
            'type' => 'select',
            'show_option_none' => true,
            'default' => 'garage1',
            'options' => array(
                'garage1' => __('1', 'cmb2'),
                'garage2' => __('2', 'cmb2'),
                'garage3' => __('3', 'cmb2'),

            ),
        )
    );


    //floorplan start


    $group_field_id = $cmb->add_field(
        array(
            'id' => 'property_floor_plans',
            'type' => 'group',
            'description' => __('Generates reusable form entries', 'cmb2'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options' => array(
                'group_title' => __('Entry {#}', 'cmb2'), // since version 1.1.4, {#} gets replaced by row number
                'add_button' => __('Add Another Entry', 'cmb2'),
                'remove_button' => __('Remove Entry', 'cmb2'),
                'sortable' => true,
                // 'closed'         => true, // true to have the groups closed by default
                // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
            ),
        )
    );

    // Id's for group's fields only need to be unique for the group. Prefix is not needed.
    $cmb->add_group_field(
        $group_field_id,
        array(
            'name' => 'Entry Title',
            'id' => 'title',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        )
    );

    $cmb->add_group_field(
        $group_field_id,
        array(
            'name' => 'Description',
            'description' => 'Write a short description for this entry',
            'id' => 'description',
            'type' => 'textarea_small',
        )
    );

    $cmb->add_group_field(
        $group_field_id,
        array(
            'name' => 'Entry Image',
            'id' => 'image',
            'type' => 'file',
        )
    );





    // floor plan end





    $current_year = date('Y');
    $years_range = range($current_year, $current_year - 100); // Change 100 to adjust the range of years if needed

    $year_options = array();
    foreach ($years_range as $year) {
        $year_options[$year] = $year;
    }

    $cmb->add_field(
        array(
            'name' => 'Year Built',
            'id' => 'property_year_built',
            'type' => 'select',
            'options' => $year_options,
        )
    );



    $cmb->add_field(
        array(
            'name' => __('Area', 'cmb2'),
            'id' => '_area_size',
            'type' => 'text',
        )
    );
    $cmb->add_field(
        array(
            'name' => __('Lot Size', 'cmb2'),
            'id' => '_lot_size',
            'type' => 'text',
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Latitude', 'cmb2'),
            'id' => '_property_latitude',
            'type' => 'text',
            'description' => __('Enter latitude value', 'cmb2'),
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Longitude', 'cmb2'),
            'id' => '_property_longitude',
            'type' => 'text',
            'description' => __('Enter longitude value', 'cmb2'),
        )
    );

    $cmb->add_field(
        array(
            'name' => 'Location',
            'desc' => 'Drag the marker to set the exact location',
            'id' => 'location',
            'type' => 'pw_map',
            // 'split_values' => true, // Save latitude and longitude as two separate fields
        )
    );
}
add_action('cmb2_init', 'custom_register_property_fields');


add_action('cmb2_admin_init', 'cmb2_additional_details_metabox');

function cmb2_additional_details_metabox()
{
    $prefix_additional = 'additional_details_';

    $cmb = new_cmb2_box(
        array(
            'id' => $prefix_additional . 'metabox',
            'title' => __('Additional Details', 'cmb2'),
            'object_types' => array('property'),
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Bedroom Features', 'cmb2'),
            'id' => $prefix_additional . 'bedroom_features',
            'type' => 'text',
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Dining Area', 'cmb2'),
            'id' => $prefix_additional . 'dining_area',
            'type' => 'text',
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Doors & Windows', 'cmb2'),
            'id' => $prefix_additional . 'doors_windows',
            'type' => 'text',
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Entry Location', 'cmb2'),
            'id' => $prefix_additional . 'entry_location',
            'type' => 'text',
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Exterior Construction', 'cmb2'),
            'id' => $prefix_additional . 'exterior_construction',
            'type' => 'text',
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Fireplace Fuel', 'cmb2'),
            'id' => $prefix_additional . 'fireplace_fuel',
            'type' => 'text',
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Fireplace Location', 'cmb2'),
            'id' => $prefix_additional . 'fireplace_location',
            'type' => 'text',
        )
    );

    $cmb->add_field(
        array(
            'name' => __('Floors', 'cmb2'),
            'id' => $prefix_additional . 'floors',
            'type' => 'text',
        )
    );
}








// Register Property Features Taxonomy
function custom_register_property_features_taxonomy()
{
    $labels = array(
        'name' => _x('Property Features', 'taxonomy general name'),
        'singular_name' => _x('Property Feature', 'taxonomy singular name'),
        'search_items' => __('Search Property Features'),
        'all_items' => __('All Property Features'),
        'parent_item' => __('Parent Property Feature'),
        'parent_item_colon' => __('Parent Property Feature:'),
        'edit_item' => __('Edit Property Feature'),
        'update_item' => __('Update Property Feature'),
        'add_new_item' => __('Add New Property Feature'),
        'new_item_name' => __('New Property Feature Name'),
        'menu_name' => __('Property Features'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'property-feature'),
    );

    register_taxonomy('property_feature', array('property'), $args);
}
add_action('init', 'custom_register_property_features_taxonomy');

// Register Property Types Taxonomy
function custom_register_property_types_taxonomy()
{
    $labels = array(
        'name' => _x('Property Types', 'taxonomy general name'),
        'singular_name' => _x('Property Type', 'taxonomy singular name'),
        'search_items' => __('Search Property Types'),
        'all_items' => __('All Property Types'),
        'parent_item' => __('Parent Property Type'),
        'parent_item_colon' => __('Parent Property Type:'),
        'edit_item' => __('Edit Property Type'),
        'update_item' => __('Update Property Type'),
        'add_new_item' => __('Add New Property Type'),
        'new_item_name' => __('New Property Type Name'),
        'menu_name' => __('Property Types'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'property-type'),
    );

    register_taxonomy('property_type', array('property'), $args);
}
add_action('init', 'custom_register_property_types_taxonomy');



// Register Property City Taxonomy
function custom_register_property_city_taxonomy()
{
    $labels = array(
        'name' => _x('Property City', 'taxonomy general name'),
        'singular_name' => _x('Property City', 'taxonomy singular name'),
        'search_items' => __('Search Property City'),
        'all_items' => __('All Property Locations'),
        'parent_item' => __('Parent Property City'),
        'parent_item_colon' => __('Parent Property City:'),
        'edit_item' => __('Edit Property City'),
        'update_item' => __('Update Property City'),
        'add_new_item' => __('Add New Property City'),
        'new_item_name' => __('New Property City Name'),
        'menu_name' => __('Property City'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'property-city'),
    );

    register_taxonomy('property_city', array('property'), $args);
}
add_action('init', 'custom_register_property_city_taxonomy');



// Register Property Types Taxonomy
function custom_register_property_status_taxonomy()
{
    $labels = array(
        'name' => _x('Property Status', 'taxonomy general name'),
        'singular_name' => _x('Property Status', 'taxonomy singular name'),
        'search_items' => __('Search Property Status'),
        'all_items' => __('All Property Status'),
        'parent_item' => __('Parent Property Staus'),
        'parent_item_colon' => __('Parent Property Status:'),
        'edit_item' => __('Edit Property Status'),
        'update_item' => __('Update Property Status'),
        'add_new_item' => __('Add New Property Status'),
        'new_item_name' => __('New Property Status Name'),
        'menu_name' => __('Property Status'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'property-status'),
    );

    register_taxonomy('property_status', array('property'), $args);
}
add_action('init', 'custom_register_property_status_taxonomy');



// Register Agents Taxonomy
function custom_register_agents_taxonomy()
{
    $labels = array(
        'name' => _x('Agents', 'taxonomy general name'),
        'singular_name' => _x('Agent', 'taxonomy singular name'),
        'search_items' => __('Search Agents'),
        'all_items' => __('All Agents'),
        'parent_item' => __('Parent Agent'),
        'parent_item_colon' => __('Parent Agent:'),
        'edit_item' => __('Edit Agent'),
        'update_item' => __('Update Agent'),
        'add_new_item' => __('Add New Agent'),
        'new_item_name' => __('New Agent Name'),
        'menu_name' => __('Agents'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'agent'),
    );

    register_taxonomy('agent', array('property'), $args);
}
add_action('init', 'custom_register_agents_taxonomy');

function myplugin_load_custom_taxonomy_template($taxonomy_template) {
    if (is_tax('agent')) {
        $template_path = plugin_dir_path(__FILE__) . 'templates/taxonomy-agent.php';
        error_log('Custom taxonomy template path: ' . $template_path); // Debugging line
        if (file_exists($template_path)) {
            error_log('Custom taxonomy template found.'); // Debugging line
            return $template_path;
        } else {
            error_log('Custom taxonomy template not found.'); // Debugging line
        }
    }

    return $taxonomy_template;
}
add_filter('taxonomy_template', 'myplugin_load_custom_taxonomy_template');

function custom_register_agent_fields() {
    // Create a new CMB2 box for the 'agent' taxonomy
    $cmb = new_cmb2_box( array(
        'id'           => 'agent_details',
        'title'        => __( 'Agent Details', 'cmb2' ),
        'object_types' => array( 'term' ), // This is a term metabox
        'taxonomies'   => array( 'agent' ), // Your taxonomy ID
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ) );

    // Add fields to the metabox

    $cmb->add_field( array(
        'name' => __( 'Profile Picture', 'cmb2' ),
        'desc' => __( 'Upload a profile picture for the agent', 'cmb2' ),
        'id'   => 'agent_profile_picture',
        'type' => 'file',
    ) );

    $cmb->add_field( array(
        'name' => __( 'Office', 'cmb2' ),
        'desc' => __( 'Enter the agent\'s phone number', 'cmb2' ),
        'id'   => 'agent_office_number',
        'type' => 'text',
    ) );

    $cmb->add_field( array(
        'name' => __( 'Mobile', 'cmb2' ),
        'desc' => __( 'Enter the agent\'s phone number', 'cmb2' ),
        'id'   => 'agent_mobile_number',
        'type' => 'text',
    ) );

    $cmb->add_field( array(
        'name' => __( 'Fax', 'cmb2' ),
        'desc' => __( 'Enter the agent\'s phone number', 'cmb2' ),
        'id'   => 'agent_fax_number',
        'type' => 'text',
    ) );

    $cmb->add_field( array(
        'name' => __( 'Whatsaap', 'cmb2' ),
        'desc' => __( 'Enter the agent\'s phone number', 'cmb2' ),
        'id'   => 'agent_whatsaap_number',
        'type' => 'text',
    ) );

    $cmb->add_field( array(
        'name' => __( 'Email Address', 'cmb2' ),
        'desc' => __( 'Enter the agent\'s email address', 'cmb2' ),
        'id'   => 'agent_email_address',
        'type' => 'text_email',
    ) );

   
}

add_action( 'cmb2_admin_init', 'custom_register_agent_fields' );




// Register the custom template
function myplugin_add_custom_template($templates) {
    $templates['includes/search-result.php'] = 'Property Search Template';
    return $templates;
}
add_filter('theme_page_templates', 'myplugin_add_custom_template');

// Load the custom template
function myplugin_load_custom_template($template) {
    if (get_page_template_slug() === 'includes/search-result.php') {
        $template = plugin_dir_path(__FILE__) . 'includes/search-result.php';
    }
    return $template;
}
add_filter('template_include', 'myplugin_load_custom_template');

//Search Filters
function property_search_shortcode()
{
    // Initialize variables to hold selected values
    $city_selected = isset($_GET['property-city']) ? $_GET['property-city'] : '';
    $status_selected = isset($_GET['property-status']) ? $_GET['property-status'] : '';
    $type_selected = isset($_GET['property-type']) ? $_GET['property-type'] : '';

    // Start output buffering to capture the form and results
    ob_start();

    // Display the search form
    ?>
    <!-- HTML Form -->
    <form class="tf-search-form tf-search-product" method="get"
        action="https://pedisarealtyhunters.grow9x.com/index.php/search-result/">
        <div class="form-group">
            <label for="property-city">Location</label>

            <div class="select-box">

                <select name="property-city" id="property-city" class="minimal">
                    <option value="">Any</option>
                    <!-- Populate options dynamically from taxonomy terms -->
                    <?php
                    $terms = get_terms('property_city');
                    foreach ($terms as $term) {
                        $selected = ($term->slug == $city_selected) ? 'selected' : '';
                        echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="form-group">
            <label for="property-status">Property Status</label>
            <select name="property-status" id="property-status" class="minimal">
                <option value="">Any</option>
                <!-- Populate options dynamically from taxonomy terms -->
                <?php
                $terms = get_terms('property_status');
                foreach ($terms as $term) {
                    $selected = ($term->slug == $status_selected) ? 'selected' : '';
                    echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                }

                ?>

            </select>
        </div>
        <div class="form-group">
            <label for="property-type">Property Type</label>
            <select name="property-type" id="property-type" class="minimal">
                <option value="">Any</option>
                <!-- Populate options dynamically from property type terms including child terms -->
                <?php
                $terms = get_terms(
                    array(
                        'taxonomy' => 'property_type',
                        'hide_empty' => false,
                        'parent' => 0, // Only fetch parent terms
                    )
                );
                foreach ($terms as $term) {
                    $selected = ($term->slug == $type_selected) ? 'selected' : '';
                    echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                    // Fetch and display child terms recursively
                    $child_terms = get_terms(
                        array(
                            'taxonomy' => 'property_type',
                            'hide_empty' => false,
                            'parent' => $term->term_id, // Fetch child terms of current parent
                        )
                    );
                    foreach ($child_terms as $child) {
                        $selected = ($child->slug == $type_selected) ? 'selected' : '';
                        echo '<option value="' . esc_attr($child->slug) . '" ' . $selected . '> - ' . esc_html($child->name) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <input type="submit" value="Search">
    </form>
    <?php

    // Process the search form submission
    if (!empty($city_selected) || !empty($status_selected) || !empty($type_selected)) {
        // Build the query to fetch properties based on selected filters
        $tax_query = array('relation' => 'AND');

        if (!empty($city_selected)) {
            $tax_query[] = array(
                'taxonomy' => 'property_city',
                'field' => 'slug',
                'terms' => $city_selected,
            );
        }

        if (!empty($status_selected)) {
            $tax_query[] = array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => $status_selected,
            );
        }

        if (!empty($type_selected)) {
            $tax_query[] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $type_selected,
            );
        }

        $sort_order = isset($_GET['property-sort']) ? $_GET['property-sort'] : 'date-desc';

        // Set default orderby and order
        $orderby = 'date';
        $order = 'DESC';

        switch ($sort_order) {
            case 'date-asc':
                $orderby = 'date';
                $order = 'ASC';
                break;
            case 'price-desc':
                $orderby = 'meta_value_num';
                $meta_key = '_property_price';
                $order = 'DESC';
                break;
            case 'price-asc':
                $orderby = 'meta_value_num';
                $meta_key = '_property_price';
                $order = 'ASC';
                break;
            case 'name-asc':
                $orderby = 'title';
                $order = 'ASC';
                break;
            case 'name-desc':
                $orderby = 'title';
                $order = 'DESC';
                break;
            default:
                $orderby = 'date';
                $order = 'DESC';
                break;
        }


        $args = array(
            'post_type' => 'property',
            'tax_query' => $tax_query,
            'orderby' => $orderby,
            'order' => $order,
        );

        $query = new WP_Query($args);

        // Get the current user's favorite properties
        $user_favorites = is_user_logged_in() ? get_user_meta(get_current_user_id(), 'user_favourites', true) : array();
        if (!$user_favorites) {
            $user_favorites = array();
        }
        // Display search results
        // echo '<h2>Search Results</h2>';

        ?>
        <div class="sort-options">
            <form class="tf-search-form tf-sort-form" method="get" action="">

                <label for="property-sort">Sort By:</label>
                <select name="property-sort" id="property-sort">
                    <?php
                    $sort_selected = isset($_GET['property-sort']) ? $_GET['property-sort'] : 'date-desc';
                    $selected_date_desc = ($sort_selected == 'date-desc') ? 'selected' : '';
                    $selected_date_asc = ($sort_selected == 'date-asc') ? 'selected' : '';
                    $selected_price_desc = ($sort_selected == 'price-desc') ? 'selected' : '';
                    $selected_price_asc = ($sort_selected == 'price-asc') ? 'selected' : '';
                    $selected_name_asc = ($sort_selected == 'name-asc') ? 'selected' : '';
                    $selected_name_desc = ($sort_selected == 'name-desc') ? 'selected' : '';

                    echo '<option value="date-desc" ' . $selected_date_desc . '>Date - Newest First</option>';
                    echo '<option value="date-asc" ' . $selected_date_asc . '>Date - Oldest First</option>';
                    echo '<option value="price-asc" ' . $selected_price_desc . '>Price - High to Low</option>';
                    echo '<option value="price-desc" ' . $selected_price_asc . '>Price - Low to High</option>';
                    echo '<option value="name-asc" ' . $selected_name_asc . '>Name - A to Z</option>';
                    echo '<option value="name-desc" ' . $selected_name_desc . '>Name - Z to A</option>';
                    ?>
                </select>

                <input type="hidden" name="property-city" value="<?php echo esc_attr($city_selected); ?>">
                <input type="hidden" name="property-status" value="<?php echo esc_attr($status_selected); ?>">
                <input type="hidden" name="property-type" value="<?php echo esc_attr($type_selected); ?>">

            </form>

        </div>
        <?php
        echo '<div class="slides-container">'; // Add container div for slides

        // Sorting options HTML
        ?>




        <?php


        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $property_address = get_post_meta($post_id, '_property_address', true);
                $property_price = get_post_meta($post_id, '_property_price', true);
                $property_bathroom = get_post_meta($post_id, 'property_bedroom', true);
                $property_bedrooms = get_post_meta($post_id, 'property_bathroom', true);
                $property_year_built = get_post_meta($post_id, 'property_year_built', true);
                $property_area_size = get_post_meta($post_id, '_area_size', true);
                $is_favorite = in_array($post_id, $user_favorites);
                ?>
                <div class="slide">
                    <div class="tf-card-slider">
                        <div class="tf-card-image">
                            <a href="<?php the_permalink(); ?>" class="tf-card-link">
                                <div class="featured-image"><?php the_post_thumbnail('large'); ?></div>
                            </a>
                        </div>
                        <div class="tf-card-content">

                            <h6> <a href="<?php the_permalink(); ?>" class="tf-card-link"><?php the_title(); ?> </a></h6>

                            <a href="<?php the_permalink(); ?>" class="tf-card-link">
                                <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="14px" viewBox="0 0 395.71 395.71"
                                    xml:space="preserve">
                                    <g>
                                        <path d="M197.849,0C122.131,0,60.531,61.609,60.531,137.329c0,72.887,124.591,243.177,129.896,250.388l4.951,6.738
        c0.579,0.792,1.501,1.255,2.471,1.255c0.985,0,1.901-0.463,2.486-1.255l4.948-6.738c5.308-7.211,129.896-177.501,129.896-250.388
        C335.179,61.609,273.569,0,197.849,0z M197.849,88.138c27.13,0,49.191,22.062,49.191,49.191c0,27.115-22.062,49.191-49.191,49.191
        c-27.114,0-49.191-22.076-49.191-49.191C148.658,110.2,170.734,88.138,197.849,88.138z" />
                                    </g>
                                </svg><?php echo esc_html($property_address); ?>
                            </a>
                            <p class="tf-publish-date"><strong> Added on:</strong><?php echo get_the_date(); ?></p>
                            <div class="tf-card-content-quantity" style="display: flex;gap: 10px;">
                                <div>
                                    <p><strong>Bedrooms</strong></p>
                                    <p><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/bedroom.svg" alt="">
                                        <?php echo wp_kses_post($property_bedrooms); ?></p>
                                </div>
                                <div>
                                    <p><strong>Bathrooms</strong></p>
                                    <p><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/bathroom.svg" alt="">
                                        <?php echo wp_kses_post($property_bathroom); ?></p>
                                </div>
                                <div>
                                    <p><strong>Area</strong></p>
                                    <p><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/area.svg" alt="">
                                        <?php echo wp_kses_post($property_area_size); ?> Sq Ft</p>
                                </div>
                            </div>
                            <div class="tf_price_fav_box">
                                <p class="tf-price"><strong>$</strong><?php echo esc_html($property_price); ?></p>
                                <button class="add-to-favourites" data-post-id="<?php echo esc_attr($post_id); ?>">
                                    <?php if ($is_favorite): ?>
                                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                                fill="#FF0000" />
                                        </svg>
                                    <?php else: ?>
                                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                                fill="#000000" />
                                        </svg>
                                    <?php endif; ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
        } else {
            // Display message for no properties found
            echo '<p>No properties found for the selected criteria.</p>';
        }
        echo '</div>'; // Close container div for slides
    }

    // Return the buffered content
    return ob_get_clean();
}
add_shortcode('property_search', 'property_search_shortcode');





// Add shortcode to display carousel slider
function custom_slider_shortcode($atts)
{
    // Shortcode attributes
    $atts = shortcode_atts(
        array(
            'post_type' => 'property', // Default custom post type
            'posts_per_page' => -1, // Default to retrieve all posts
            'property_status' => '' // Default to show all properties if no status is provided
        ),
        $atts
    );

    // Retrieve custom post type data
    $args = array(
        'post_type' => $atts['post_type'],
        'posts_per_page' => $atts['posts_per_page'],
        'no_found_rows' => true // Disable pagination
    );
    // Add tax query if property_status is provided
    if (!empty($atts['property_status'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => $atts['property_status']
            ),
        );
    }
    $query = new WP_Query($args);

    // Get the current user's favorite properties
    $user_favorites = is_user_logged_in() ? get_user_meta(get_current_user_id(), 'user_favourites', true) : array();
    if (!$user_favorites) {
        $user_favorites = array();
    }

    // Output slider HTML markup
    ob_start(); // Start output buffering
    ?>
    <div class="slider-carousel">
        <?php if ($query->have_posts()): ?>
            <div class="carousel">
                <?php while ($query->have_posts()):
                    $query->the_post();

                    $post_id = get_the_ID();
                    $property_address = get_post_meta($post_id, '_property_address', true);
                    $property_price = get_post_meta($post_id, '_property_price', true);
                    $property_bathroom = get_post_meta($post_id, 'property_bedroom', true);
                    $property_bedrooms = get_post_meta($post_id, 'property_bathroom', true);
                    $property_year_built = get_post_meta($post_id, 'property_year_built', true);
                    $property_area_size = get_post_meta($post_id, '_area_size', true);
                    $is_favorite = in_array($post_id, $user_favorites);
                    ?>

                    <div class="slide">

                        <div class="tf-card-slider">
                            <div class="tf-card-image">
                                <a href="<?php the_permalink(); ?>" class="tf-card-link">
                                    <div class="featured-image"><?php the_post_thumbnail('large'); ?></div>
                                </a>
                            </div>
                            <div class="tf-card-content">

                                <h6> <a href="<?php the_permalink(); ?>" class="tf-card-link"><?php the_title(); ?> </a></h6>

                                <a href="<?php the_permalink(); ?>" class="tf-card-link">
                                    <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="14px"
                                        viewBox="0 0 395.71 395.71" xml:space="preserve">
                                        <g>
                                            <path d="M197.849,0C122.131,0,60.531,61.609,60.531,137.329c0,72.887,124.591,243.177,129.896,250.388l4.951,6.738
        c0.579,0.792,1.501,1.255,2.471,1.255c0.985,0,1.901-0.463,2.486-1.255l4.948-6.738c5.308-7.211,129.896-177.501,129.896-250.388
        C335.179,61.609,273.569,0,197.849,0z M197.849,88.138c27.13,0,49.191,22.062,49.191,49.191c0,27.115-22.062,49.191-49.191,49.191
        c-27.114,0-49.191-22.076-49.191-49.191C148.658,110.2,170.734,88.138,197.849,88.138z" />
                                        </g>
                                    </svg><?php echo esc_html($property_address); ?>
                                </a>
                                <p class="tf-publish-date"><strong> Added on:</strong><?php echo get_the_date(); ?></p>
                                <div class="tf-card-content-quantity" style="display: flex;gap: 10px;">
                                    <div>
                                        <p><strong>Bedrooms</strong></p>
                                        <p><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/bedroom.svg"
                                                alt=""> <?php echo wp_kses_post($property_bedrooms); ?></p>
                                    </div>
                                    <div>
                                        <p><strong>Bathrooms</strong></p>
                                        <p><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/bathroom.svg"
                                                alt=""> <?php echo wp_kses_post($property_bathroom); ?></p>
                                    </div>
                                    <div>
                                        <p><strong>Area</strong></p>
                                        <p><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/area.svg"
                                                alt=""> <?php echo wp_kses_post($property_area_size); ?> Sq Ft</p>
                                    </div>
                                </div>
                                <div class="tf_price_fav_box">
                                    <p class="tf-price"><strong>$</strong><?php echo esc_html($property_price); ?></p>
                                    <button class="add-to-favourites" data-post-id="<?php echo esc_attr($post_id); ?>">
                                        <?php if ($is_favorite): ?>
                                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                                    fill="#FF0000" />
                                            </svg>
                                        <?php else: ?>
                                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                                    fill="#000000" />
                                            </svg>
                                        <?php endif; ?>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else: ?>
            <p>No posts found</p>
        <?php endif; ?>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('.carousel').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                speed: 200,
                lazyLoad: 'ondemand',
                // dots: true,
                appendDots: '.slider-carousel',
                arrows: true,
                prevArrow: '<button type="button" class="slick-prev"><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/left-arrow.svg" ></button>',
                nextArrow: '<button type="button" class="slick-next"><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/right-arrow.svg" ></button>',
                responsive: [
                    {
                        breakpoint: 1300,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            // dots: true
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            // dots: true
                        }
                    },
                    {
                        breakpoint: 900,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            // Handle Add to Favourites button click
            $('.add-to-favourites').on('click', function () {
                var post_id = $(this).data('post-id');
                var button = $(this);
                var svg = button.find('svg path');
                var action = svg.attr('fill') === '#FF0000' ? 'remove_from_favourites' : 'add_to_favourites';

                $.ajax({
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    type: 'POST',
                    data: {
                        action: action,
                        post_id: post_id,
                        security: '<?php echo wp_create_nonce("favourites_nonce"); ?>'
                    },
                    success: function (response) {

                        if (action === 'add_to_favourites') {
                            svg.attr('fill', '#FF0000');
                        } else {
                            svg.attr('fill', '#000000');
                        }

                    }
                });
            });
        });
    </script>
    <?php
    return ob_get_clean(); // End output buffering and return content
}
add_shortcode('custom_slider', 'custom_slider_shortcode');



// Register AJAX action for logged-in users
add_action('wp_ajax_add_to_favourites', 'add_to_favourites');
add_action('wp_ajax_remove_from_favourites', 'remove_from_favourites');

// Register AJAX action for non-logged-in users
add_action('wp_ajax_nopriv_add_to_favourites', 'add_to_favourites');
add_action('wp_ajax_nopriv_remove_from_favourites', 'remove_from_favourites');

function add_to_favourites()
{
    // Verify nonce for security
    check_ajax_referer('favourites_nonce', 'security');

    // Get the post ID from the AJAX request
    $post_id = intval($_POST['post_id']);

    if ($post_id && is_user_logged_in()) {
        $user_id = get_current_user_id();
        $favourites = get_user_meta($user_id, 'user_favourites', true);

        if (!$favourites) {
            $favourites = array();
        }

        if (!in_array($post_id, $favourites)) {
            $favourites[] = $post_id;
            update_user_meta($user_id, 'user_favourites', $favourites);
            wp_send_json_success();
        }
    }

    wp_send_json_error();
}

function remove_from_favourites()
{
    // Verify nonce for security
    check_ajax_referer('favourites_nonce', 'security');

    // Get the post ID from the AJAX request
    $post_id = intval($_POST['post_id']);

    if ($post_id && is_user_logged_in()) {
        $user_id = get_current_user_id();
        $favourites = get_user_meta($user_id, 'user_favourites', true);

        if (!$favourites) {
            $favourites = array();
        }

        if (in_array($post_id, $favourites)) {
            $favourites = array_diff($favourites, array($post_id));
            update_user_meta($user_id, 'user_favourites', $favourites);
            wp_send_json_success();
        }
    }

    wp_send_json_error();
}





// Add shortcode to display carousel slider
function featured_property_slider_shortcode($atts)
{
    // Shortcode attributes
    $atts = shortcode_atts(
        array(
            'post_type' => 'property', // Default custom post type
            'posts_per_page' => -1, // Default to retrieve all posts
        ),
        $atts
    );

    // Retrieve custom post type data
    $args = array(
        'post_type' => $atts['post_type'],
        'posts_per_page' => $atts['posts_per_page']
    );
    $query = new WP_Query($args);


    // Get the current user's favorite properties
    $user_favorites = is_user_logged_in() ? get_user_meta(get_current_user_id(), 'user_favourites', true) : array();
    if (!$user_favorites) {
        $user_favorites = array();
    }
    // Output slider HTML markup
    ob_start(); // Start output buffering
    ?>
    <div class="featured-slider-carousel">
        <?php if ($query->have_posts()): ?>
            <div class="featured-carousel ">
                <?php while ($query->have_posts()):
                    $query->the_post();

                    $post_id = get_the_ID();
                    $property_address = get_post_meta($post_id, '_property_address', true);
                    $property_price = get_post_meta($post_id, '_property_price', true);
                    $property_bathroom = get_post_meta($post_id, 'property_bedroom', true);
                    $property_bedrooms = get_post_meta($post_id, 'property_bathroom', true);
                    $property_year_built = get_post_meta($post_id, 'property_year_built', true);
                    $property_area_size = get_post_meta($post_id, '_area_size', true);
                    $is_favorite = in_array($post_id, $user_favorites);
                    ?>

                    <div class="featured-slide">

                        <div class="featured-tf-card-slider">

                            <div class="featured-tf-card-content">
                                <div>

                                    <h3> <a href="<?php the_permalink(); ?>" class="tf-card-link"><?php the_title(); ?> </a></h3>


                                    <p> <a href="<?php the_permalink(); ?>" class="tf-card-link"></a>
                                        <?php echo esc_html($property_address); ?> </a></p>

                                </div>

                                <div class="tf-card-content-quantity" style="display: flex;gap: 10px;">
                                    <div>
                                        <p><strong>Bedrooms</strong></p>
                                        <p><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/bedroom.svg"
                                                alt=""> <?php echo wp_kses_post($property_bedrooms); ?></p>
                                    </div>
                                    <div>
                                        <p><strong>Bathrooms</strong></p>
                                        <p><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/bathroom.svg"
                                                alt=""> <?php echo wp_kses_post($property_bathroom); ?></p>
                                    </div>
                                    <div>
                                        <p><strong>Area</strong></p>
                                        <p><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/area.svg"
                                                alt=""> <?php echo wp_kses_post($property_area_size); ?> Sq Ft</p>
                                    </div>
                                </div>

                                <div class="tf-contact">
                                    <div class="tf-contact-mobile"><strong>Call:</strong>
                                        <p>(865) 234-5679</p>
                                    </div>
                                    <div class="tf-contact-agent"><strong>Agent:</strong>
                                        <p>demo</p>
                                    </div>

                                </div>
                                <div class="tf_price_fav_box">
                                    <p class="tf-price"><strong>$</strong><?php echo esc_html($property_price); ?></p>
                                    <button class="add-to-favourites" data-post-id="<?php echo esc_attr($post_id); ?>">
                                        <?php if ($is_favorite): ?>
                                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                                    fill="#FF0000" />
                                            </svg>
                                        <?php else: ?>
                                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                                                    fill="#000000" />
                                            </svg>
                                        <?php endif; ?>
                                    </button>
                                </div>
                            </div>
                            <div class="featured-tf-card-image">
                                <a href="<?php the_permalink(); ?>" class="tf-card-link">
                                    <div class="featured-image"><?php the_post_thumbnail('large'); ?></div>
                                </a>
                            </div>
                        </div>

                    </div>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else: ?>
            <p>No posts found</p>
        <?php endif; ?>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('.featured-carousel').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                autoplay: true,
                autoplaySpeed: 1000,
                cssEase: 'linear',
                appendDots: '.featured-slider-carousel',
                prevArrow: '<button type="button" class="slick-prev"><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/left-arrow.svg"></button>',
                nextArrow: '<button type="button" class="slick-next"><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/right-arrow.svg" ></button>',
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            autoplay: true,
                            autoplaySpeed: 1000,
                            cssEase: 'linear'
                            // dots: true
                        }
                    }
                ]
            });


            // Handle Add to Favourites button click
            $('.add-to-favourites').on('click', function () {
                var post_id = $(this).data('post-id');
                var button = $(this);
                var svg = button.find('svg path');
                var action = svg.attr('fill') === '#FF0000' ? 'remove_from_favourites' : 'add_to_favourites';

                $.ajax({
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    type: 'POST',
                    data: {
                        action: action,
                        post_id: post_id,
                        security: '<?php echo wp_create_nonce("favourites_nonce"); ?>'
                    },
                    success: function (response) {

                        if (action === 'add_to_favourites') {
                            svg.attr('fill', '#FF0000');
                        } else {
                            svg.attr('fill', '#000000');
                        }

                    }
                });
            });
        });
    </script>
    <?php
    return ob_get_clean(); // End output buffering and return content
}
add_shortcode('featured_property_slider', 'featured_property_slider_shortcode');

