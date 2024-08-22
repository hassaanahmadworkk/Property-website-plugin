<?php

get_header();
?>
<div class="tf-property-container">
    <section id="tf-banner-attachment-parallax" class="tf_banner_inner tf_banner__image"
        style="background-image: url('http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/slide-two.jpg');">
        <div class="tf_container">
            <div class="tf_banner__wrap">
                <h1 class="tf_banner__title"><?php echo get_the_title(); ?></h1>
            </div>
        </div>
    </section>
    <?php
    ?>

    <section class="single_product_page tf_container">


        <?php
        // Get the current user's favorite properties
        $user_favorites = is_user_logged_in() ? get_user_meta(get_current_user_id(), 'user_favourites', true) : array();
        if (!$user_favorites) {
            $user_favorites = array();
        }
        // Start the loop
        if (have_posts()) {
            while (have_posts()) {
                the_post();

                // Get the post ID
                $post_id = get_the_ID();

                // Retrieve field values using CMB2 functions
                $property_address = get_post_meta($post_id, '_property_address', true);
                $property_price = get_post_meta($post_id, '_property_price', true);
                $property_description = get_post_meta($post_id, 'property_description', true);
                $gallery_images = get_post_meta($post_id, 'property_gallery', true);
                $property_bathroom = get_post_meta($post_id, 'property_bedroom', true);
                $property_bedrooms = get_post_meta($post_id, 'property_bathroom', true);
                $property_garage = get_post_meta($post_id, 'property_garage', true);
                $property_year_built = get_post_meta($post_id, 'property_year_built', true);
                $property_area_size = get_post_meta($post_id, '_area_size', true);
                $property_lot_size = get_post_meta($post_id, '_lot_size', true);
                $property_common_note = get_post_meta($post_id, 'tf_property_note', true);
                $is_favorite = in_array($post_id, $user_favorites);
                // Output the field values
                ?>

                <div class="tf-container">
                    <div class="tf_page_property_head">
                        <div class="tf_page_property_title">
                            <h1 class="tf_page_title">
                                <?php the_title(); ?>
                            </h1>
                            <p class="tf_property_address">
                                <?php echo esc_html($property_address); ?>
                            </p>
                        </div>
                        <div class="tf_page_property_price">
                            <p class="tf_status">
                                <?php
                                // Get Property Status
                                $property_status = get_the_terms($post_id, 'property_status');
                                $is_for_rent = false; // Flag to check if the property is for rent
                        
                                if ($property_status && !is_wp_error($property_status)) {
                                    $status_names = array();
                                    foreach ($property_status as $status) {
                                        $status_names[] = $status->name;
                                        if (strtolower($status->name) == 'for rent') {
                                            $is_for_rent = true;
                                        }
                                    }
                                    echo implode(', ', $status_names);
                                }
                                ?>
                            </p>
                            <p class="tf_price">
                                $<?php echo esc_html($property_price); ?>
                                <?php if ($is_for_rent) {
                                    echo ' monthly';
                                } ?>
                            </p>
                        </div>

                    </div>
                    <div class="tf_property_gallery">
                        <?php
                        // Check if gallery images exist
                        if ($gallery_images) {
                            ?>
                            <div class="gallery">

                                <div class="gallery-images">
                                    <?php
                                    foreach ($gallery_images as $image_id => $image_url) {
                                        ?>
                                        <div class="gallery-image">
                                            <img src="<?php echo esc_url($image_url); ?>" alt="Gallery Image">
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <script>
                                jQuery(document).ready(function ($) {
                                    $('.gallery-images').slick({
                                        infinite: true,
                                        slidesToShow: 1,
                                        adaptiveHeight: true,
                                        arrows: true,
                                        prevArrow: '<button type="button" class="product_page_slick-prev"><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/left-arrow.svg" ></button>',
                                        nextArrow: '<button type="button" class="product_page_slick-next"><img src="http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/right-arrow.svg" ></button>',
                                        responsive: [
                                            {
                                                breakpoint: 600,
                                                settings: {
                                                    slidesToShow: 1,
                                                    slidesToScroll: 1,
                                                    arrows: false,

                                                    speed: 300,
                                                    lazyLoad: 'ondemand',
                                                    autoplay: true, // Enabling autoplay
                                                    autoplaySpeed: 1000, // Setting autoplay speed in milliseconds
                                                }
                                            }
                                        ]
                                    });
                                });

                            </script>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="tf_property_wrap">
                        <div class="tf_property_product_main">
                            <div class="tf_property_product_content">
                                <div class="tf_property_product_content_overview">
                                    <div class="tf_property_product_content_meta_row">
                                        <div class="tf_property_product_content_id">
                                            <p class="title">Property ID: <span>RH-2017-06</span></p>
                                            <p></p>

                                        </div>
                                        <div class="tf_property_product_content_print">
                                            <a href="#" class="share" id="social-share" data-tooltip="Share"><svg height="24px"
                                                    style="enable-background:new 0 0 80 90;" version="1.1" viewBox="0 0 80 90"
                                                    width="18px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <g>
                                                        <path
                                                            d="M65,60c-3.436,0-6.592,1.168-9.121,3.112L29.783,47.455C29.914,46.654,30,45.837,30,45c0-0.839-0.086-1.654-0.217-2.456   l26.096-15.657C58.408,28.833,61.564,30,65,30c8.283,0,15-6.717,15-15S73.283,0,65,0S50,6.717,50,15   c0,0.837,0.086,1.654,0.219,2.455L24.123,33.112C21.594,31.168,18.438,30,15,30C6.717,30,0,36.717,0,45s6.717,15,15,15   c3.438,0,6.594-1.167,9.123-3.113l26.096,15.657C50.086,73.346,50,74.161,50,75c0,8.283,6.717,15,15,15s15-6.717,15-15   S73.283,60,65,60z">
                                                        </path>
                                                    </g>

                                                </svg>
                                            </a>


                                            <button class="add-to-favourites" data-post-id="<?php echo esc_attr($post_id); ?>">
                                                <?php if ($is_favorite): ?>
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="#1ea69a"
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
                                                            fill="#1ea69a" />
                                                    </svg>
                                                <?php endif; ?>
                                            </button>
                                            <script>
                                                jQuery(document).ready(function ($) {
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
                                                                    svg.attr('fill', '#1ea69a');
                                                                }
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                            <a href="javascript:window.print()" class="print" data-tooltip="Print">
                                                <svg height="24px" version="1.1" viewBox="0 0 16 16" width="24px"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1">
                                                        <g fill="#1ea69a" transform="translate(-672.000000, -48.000000)">
                                                            <path
                                                                d="M672,54 C672,53 673,52 674,52 L675,52 L675,54 L675,55 L685,55 L685,54 L685,52 L686,52 C687,52 688,53 688,54 L688,59 C688,60 687,61 686,61 L685,61 L685,59 L685,58 L675,58 L675,59 L675,61 L674,61 C673,61 672,60 672,59 L672,54 L672,54 Z M676,61 L676,59 L684,59 L684,61 L684,64 L676,64 L676,61 L676,61 Z M684,52 L684,54 L676,54 L676,52 L676,49 L684,49 L684,52 L684,52 Z M677,60 L677,61 L683,61 L683,60 L677,60 L677,60 Z M677,62 L677,63 L683,63 L683,62 L677,62 L677,62 Z M677,62">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </a>
                                        </div>

                                    </div>
                                    <div class="tf_property_product_content_meta_row meta_row_quantity">
                                        <div>
                                            <p><strong>Bedrooms</strong></p>
                                            <p><svg class="rh_svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="#1ea69a">
                                                    <path
                                                        d="M1111.91,600.993h16.17a2.635,2.635,0,0,1,2.68,1.773l1.21,11.358a2.456,2.456,0,0,1-2.61,2.875h-18.73a2.46,2.46,0,0,1-2.61-2.875l1.21-11.358A2.635,2.635,0,0,1,1111.91,600.993Zm0.66-7.994h3.86c1.09,0,2.57.135,2.57,1l0.01,3.463c0.14,0.838-1.72,1.539-2.93,1.539h-4.17c-1.21,0-2.07-.7-1.92-1.539l0.37-3.139A2.146,2.146,0,0,1,1112.57,593Zm11,0h3.86a2.123,2.123,0,0,1,2.2,1.325l0.38,3.139c0.14,0.838-.72,1.539-1.93,1.539h-5.17c-1.21,0-2.07-.7-1.92-1.539L1121,594C1121,593.1,1122.48,593,1123.57,593Z"
                                                        transform="translate(-1108 -593)"></path>
                                                </svg>
                                                <?php echo wp_kses_post($property_bedrooms); ?></p>
                                        </div>
                                        <div>
                                            <p><strong>Bathrooms</strong></p>
                                            <p><svg class="rh_svg" xmlns="http://www.w3.org/2000/svg" width="23.69" height="24"
                                                    viewBox="0 0 23.69 24" fill="#1ea69a">
                                                    <path
                                                        d="M1204,601a8,8,0,0,1,16,0v16h-2V601a6,6,0,0,0-12,0v1h-2v-1Zm7,6a6,6,0,0,0-12,0h12Zm-6,2a1,1,0,0,1,1,1v1a1,1,0,0,1-2,0v-1A1,1,0,0,1,1205,609Zm0,5a1,1,0,0,1,1,1v1a1,1,0,0,1-2,0v-1A1,1,0,0,1,1205,614Zm4.94-5.343a1,1,0,0,1,1.28.6l0.69,0.878a1,1,0,0,1-1.88.685l-0.69-.879A1,1,0,0,1,1209.94,608.657Zm2.05,4.638a1,1,0,0,1,1.28.6l0.35,0.94a1.008,1.008,0,0,1-.6,1.282,1,1,0,0,1-1.28-.6l-0.35-.939A1.008,1.008,0,0,1,1211.99,613.295Zm-11.93-4.638a1,1,0,0,1,.6,1.282l-0.69.879a1,1,0,1,1-1.87-.682l0.68-.88A1,1,0,0,1,1200.06,608.657Zm-2.05,4.639a1,1,0,0,1,.6,1.281l-0.34.941a1,1,0,0,1-1.88-.683l0.34-.94A1,1,0,0,1,1198.01,613.3Z"
                                                        transform="translate(-1196.31 -593)"></path>
                                                </svg>
                                                <?php echo wp_kses_post($property_bathroom); ?></p>
                                        </div>
                                        <div>
                                            <p><strong>Garage</strong></p>
                                            <p><svg class="rh_svg" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px"
                                                    height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24"
                                                    xml:space="preserve" fill="#1ea69a">
                                                    <g>
                                                        <path d="M16.277,11H7.722c-0.513,0-0.941,0.315-1.104,0.757L5,16.25v6C5,22.662,5.351,23,5.778,23h0.778
        c0.427,0,0.778-0.338,0.778-0.75V21.5h9.333v0.75c0,0.412,0.35,0.75,0.777,0.75h0.778C18.649,23,19,22.662,19,22.25v-6
        l-1.618-4.493C17.228,11.315,16.791,11,16.277,11z M7.875,19.25c-0.623,0-1.125-0.502-1.125-1.125S7.252,17,7.875,17
        S9,17.502,9,18.125S8.498,19.25,7.875,19.25z M16.125,19.25c-0.623,0-1.125-0.502-1.125-1.125S15.502,17,16.125,17
        s1.125,0.502,1.125,1.125S16.748,19.25,16.125,19.25z M6.556,15.5l1.167-3.375h8.555l1.167,3.375H6.556z"></path>
                                                        <path d="M23,0h-1h-2H4H2H1C0.448,0,0,0.448,0,1v1c0,0.552,0.448,1,1,1h1v21h2V3h16v21h2V3h1c0.553,0,1-0.448,1-1V1
        C24,0.448,23.553,0,23,0z"></path>
                                                        <path
                                                            d="M18,4H6C5.448,4,5,4.448,5,5s0.448,1,1,1h12c0.553,0,1-0.448,1-1S18.553,4,18,4z">
                                                        </path>
                                                        <path
                                                            d="M18,7H6C5.448,7,5,7.448,5,8s0.448,1,1,1h12c0.553,0,1-0.448,1-1S18.553,7,18,7z">
                                                        </path>
                                                    </g>
                                                </svg>
                                                <?php echo wp_kses_post($property_garage); ?></p>
                                        </div>
                                        <div>
                                            <p><strong>Year Built</strong></p>
                                            <p><svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px"
                                                    height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24"
                                                    fill="#1ea69a" xml:space="preserve">
                                                    <g class="rh_svg">
                                                        <path
                                                            d="M20,2h-1V1c0-0.552-0.447-1-1-1s-1,0.448-1,1v1H7V1c0-0.552-0.447-1-1-1S5,0.448,5,1v1H4C1.794,2,0,3.794,0,6v14
        c0,2.206,1.794,4,4,4h16c2.206,0,4-1.794,4-4V6C24,3.794,22.206,2,20,2z M22,20c0,1.104-0.896,2-2,2H4c-1.104,0-2-0.896-2-2V6
        c0-1.104,0.896-2,2-2h1v1c0,0.552,0.447,1,1,1s1-0.448,1-1V4h10v1c0,0.552,0.447,1,1,1s1-0.448,1-1V4h1c1.104,0,2,0.896,2,2V20z">
                                                        </path>
                                                        <circle cx="6" cy="12" r="2"></circle>
                                                        <circle cx="18" cy="12" r="2"></circle>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <circle cx="6" cy="18" r="2"></circle>
                                                        <circle cx="18" cy="18" r="2"></circle>
                                                        <circle cx="12" cy="18" r="2"></circle>
                                                    </g>
                                                </svg>
                                                <?php echo wp_kses_post($property_year_built); ?></p>
                                        </div>
                                        <div>
                                            <p><strong>Area</strong></p>
                                            <p><svg class="rh_svg" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px"
                                                    height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24"
                                                    xml:space="preserve" fill="#1ea69a">
                                                    <g>
                                                        <circle cx="2" cy="2" r="2"></circle>
                                                    </g>
                                                    <g>
                                                        <circle cx="2" cy="22" r="2"></circle>
                                                    </g>
                                                    <g>
                                                        <circle cx="22" cy="2" r="2"></circle>
                                                    </g>
                                                    <rect x="1" y="1" width="2" height="22"></rect>
                                                    <rect x="1" y="1" width="22" height="2"></rect>
                                                    <path opacity="0.5" d="M23,20.277V1h-2v19.277C20.7,20.452,20.452,20.7,20.277,21H1v2h19.277c0.347,0.596,0.984,1,1.723,1
    c1.104,0,2-0.896,2-2C24,21.262,23.596,20.624,23,20.277z"></path>
                                                </svg>
                                                <?php echo wp_kses_post($property_area_size); ?> Sq Ft</p>
                                        </div>
                                        <div>
                                            <p><strong>Lot Size:</strong></p>
                                            <p><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <rect fill="none" height="26" width="26" y="-1" x="-1"></rect>
                                                    </g>
                                                    <g>
                                                        <rect x="1" y="1" id="svg_1" width="32" height="32" fill="none"></rect>
                                                        <path class="rh_svg" stroke="null" fill="#1ea69a" id="svg_2"
                                                            d="m23.952237,12l-4.482089,-4.170255l0,2.78017l-1.49403,0l0,-4.170255l-4.482089,0l0,-1.390085l2.988059,0l-4.482089,-4.170255l-4.482089,4.170255l2.988059,0l0,1.390085l-4.482089,0l0,4.170255l-1.49403,0l0,-2.78017l-4.482089,4.170255l4.482089,4.170255l0,-2.78017l1.49403,0l0,4.170255l4.482089,0l0,1.390085l-2.988059,0l4.482089,4.170255l4.482089,-4.170255l-2.988059,0l0,-1.390085l4.482089,0l0,-4.170255l1.49403,0l0,2.78017l4.482089,-4.170255zm-7.470148,4.170255l-8.964178,0l0,-8.34051l8.964178,0l0,8.34051z">
                                                        </path>
                                                    </g>
                                                </svg>
                                                <?php echo wp_kses_post($property_lot_size); ?> Sq Ft</p>
                                        </div>
                                    </div>
                                    <div class="tf_property_product_content_description">
                                        <h4 class="tf_property__heading">Description</h4>
                                        <div class="tf_content">
                                            <p> <?php echo wp_kses_post($property_description); ?></p>
                                        </div>
                                    </div>


                                    <?php
                                    // Get post ID
                                    $post_id = get_the_ID();

                                    // Define prefix
                                    $prefix_additional = 'additional_details_';

                                    // Get the field values
                                    $bedroom_features = get_post_meta($post_id, $prefix_additional . 'bedroom_features', true);
                                    $dining_area = get_post_meta($post_id, $prefix_additional . 'dining_area', true);
                                    $doors_windows = get_post_meta($post_id, $prefix_additional . 'doors_windows', true);
                                    $entry_location = get_post_meta($post_id, $prefix_additional . 'entry_location', true);
                                    $exterior_construction = get_post_meta($post_id, $prefix_additional . 'exterior_construction', true);
                                    $fireplace_fuel = get_post_meta($post_id, $prefix_additional . 'fireplace_fuel', true);
                                    $fireplace_location = get_post_meta($post_id, $prefix_additional . 'fireplace_location', true);
                                    $floors = get_post_meta($post_id, $prefix_additional . 'floors', true);
                                    ?>

                                    <div class="tf_property_product_content_Additional Details">
                                        <h4 class="tf_property__heading">Additional Details</h4>
                                        <div class="tf_product_page_addition-details">
                                            <p><strong>BEDROOM FEATURES:</strong> <?php echo esc_html($bedroom_features); ?></p>
                                            <p><strong>DINING AREA:</strong> <?php echo esc_html($dining_area); ?></p>
                                            <p><strong>DOORS & WINDOWS:</strong> <?php echo esc_html($doors_windows); ?></p>
                                            <p><strong>ENTRY LOCATION:</strong> <?php echo esc_html($entry_location); ?></p>
                                            <p><strong>EXTERIOR
                                                    CONSTRUCTION:</strong><?php echo esc_html($exterior_construction); ?></p>
                                            <p><strong>FIREPLACE FUEL:</strong> <?php echo esc_html($fireplace_fuel); ?></p>
                                            <p><strong>FIREPLACE LOCATION:</strong> <?php echo esc_html($fireplace_location); ?>
                                            </p>
                                            <p><strong>FLOORS:</strong> <?php echo esc_html($floors); ?></p>
                                        </div>
                                    </div>

                                </div>
                                <div class="tf_property_product_content_features">
                                    <h4 class="tf_property__heading">Features</h4>
                                    <div class="tf_property_product_content_features_inner">
                                        <?php
                                        // Get Property Features
                                        $property_features = get_the_terms($post_id, 'property_feature');
                                        if ($property_features && !is_wp_error($property_features)) {
                                            echo '<ul>';
                                            foreach ($property_features as $feature) {
                                                echo '<li> <span class="tf_done_icon"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="10px" height="10px" viewBox="0 0 405.272 405.272" xml:space="preserve">
                                                    <path d="M393.401,124.425L179.603,338.208c-15.832,15.835-41.514,15.835-57.361,0L11.878,227.836
                                                        c-15.838-15.835-15.838-41.52,0-57.358c15.841-15.841,41.521-15.841,57.355-0.006l81.698,81.699L336.037,67.064
                                                        c15.841-15.841,41.523-15.829,57.358,0C409.23,82.902,409.23,108.578,393.401,124.425z"></path>
                                                </svg></span>' . esc_html($feature->name) . '</li>';
                                            }
                                            echo '</ul>';
                                        }
                                        ?>

                                    </div>
                                </div>
                                <?php
                                // Retrieve the custom meta box data
                                $entries = get_post_meta($post->ID, 'property_floor_plans', true);

                                if (!empty($entries)):
                                    ?>
                                    <div class="tf_property_product_content_accordian">
                                        <h4 class="tf_property__heading">Floor Plans</h4>
                                        <div class="accordion">
                                            <?php foreach ($entries as $index => $entry): ?>
                                                <div class="accordion-item">
                                                    <button id="accordion-button-<?php echo $index + 1; ?>" class="accordian-button"
                                                        aria-expanded="false">
                                                        <span class="accordion-title"><?php echo esc_html($entry['title']); ?></span>
                                                        <span class="icon" aria-hidden="true"></span>
                                                    </button>
                                                    <div class="accordion-content">
                                                        <p><?php echo esc_html($entry['description']); ?></p>
                                                        <?php if (!empty($entry['image'])): ?>
                                                            <img src="<?php echo esc_url($entry['image']); ?>" class="accordian-image"
                                                                alt="<?php echo esc_attr($entry['title']); ?>">
                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <script>
                                        const items = document.querySelectorAll(".accordion button");

                                        function toggleAccordion() {
                                            const itemToggle = this.getAttribute('aria-expanded');

                                            for (i = 0; i < items.length; i++) {
                                                items[i].setAttribute('aria-expanded', 'false');
                                            }

                                            if (itemToggle == 'false') {
                                                this.setAttribute('aria-expanded', 'true');
                                            }
                                        }

                                        items.forEach(item => item.addEventListener('click', toggleAccordion));
                                    </script>
                                    <?php
                                endif;
                                ?>
                                <div class="tf_property_product_common_note">
                                    <h4 class="tf_property__heading">Common Note</h4>
                                    <?php echo '<p class="common-note">' . wpautop($property_common_note) . '</p>'; ?>
                                </div>
                            </div>

                        </div>
                        <aside class="tf_property_sidebar">
                            <div class="tf_property_agents">
                                <?php
                                // Get the agent associated with this property
                                $agents = get_the_terms($post_id, 'agent');
                                if ($agents && !is_wp_error($agents)) {
                                    foreach ($agents as $agent) {
                                        // Retrieve agent fields using CMB2 functions
                                        $agent_profile_picture = get_term_meta($agent->term_id, 'agent_profile_picture', true);
                                        $agent_office_number = get_term_meta($agent->term_id, 'agent_office_number', true);
                                        $agent_mobile_number = get_term_meta($agent->term_id, 'agent_mobile_number', true);
                                        $agent_fax_number = get_term_meta($agent->term_id, 'agent_fax_number', true);
                                        $agent_whatsapp_number = get_term_meta($agent->term_id, 'agent_whatsaap_number', true);
                                        $agent_email_address = get_term_meta($agent->term_id, 'agent_email_address', true);
                                        ?>
                                        <a href="" class="agent-image"><img src="<?php echo esc_url($agent_profile_picture); ?>"
                                                alt=""></a>
                                        <h3 class="tf_property_agent_title">
                                            <a href="<?php echo esc_url(get_term_link($agent->term_id)); ?>"><span>Agent
                                                </span><?php echo esc_html($agent->name); ?></a>
                                        </h3>
                                        <div class="tf_property_agent_info">
                                            <p class="contact office"><span>Office:</span><?php echo esc_html($agent_office_number); ?>
                                            </p>
                                            <p class="contact mobile"><span>Mobile:</span><?php echo esc_html($agent_mobile_number); ?>
                                            </p>
                                            <p class="contact fax"><span>Fax:</span><?php echo esc_html($agent_fax_number); ?></p>
                                            <p class="contact whatsapp">
                                                <span>Whatsap:</span><?php echo esc_html($agent_whatsapp_number); ?></p>
                                            <p class="contact email"><span>Email:</span><?php echo esc_html($agent_email_address); ?>
                                            </p>
                                        </div>
                                        <button class="view-agent-listing"
                                            onclick="window.location.href='<?php echo esc_url(get_term_link($agent->term_id)); ?>?view=listings'">View
                                            My Listings</button>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="tf-contact-sidebar ">
                                <?php
                                echo do_shortcode('[forminator_form id="784"]');
                                ?>
                            </div>
                        </aside>

                    </div>
                </div>
        </div>

        </div>


        </div>
        <?php
            }
        }
        ?>


</section>

</div>

<?php

get_footer();
?>