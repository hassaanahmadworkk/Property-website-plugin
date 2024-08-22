<?php get_header(); ?>

<div class="agent-listings tf_container tf-container">
<section id="tf-banner-attachment-parallax" class="tf_banner_inner tf_banner__image"
        style="background-image: url('http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/slide-two.jpg');">
        <div class="tf_container">
            <div class="tf_banner__wrap">
                <h1 class="tf_banner__title"><?php
                $term = get_queried_object();
                echo esc_html($term->name); ?></h1>
            </div>
        </div>
    </section>
    <?php
    // Get the current term
    $term = get_queried_object();

    // Display the agent's information
    $agent_profile_picture = get_term_meta($term->term_id, 'agent_profile_picture', true);
    $agent_office_number = get_term_meta($term->term_id, 'agent_office_number', true);
    $agent_mobile_number = get_term_meta($term->term_id, 'agent_mobile_number', true);
    $agent_fax_number = get_term_meta($term->term_id, 'agent_fax_number', true);
    $agent_whatsapp_number = get_term_meta($term->term_id, 'agent_whatsaap_number', true);
    $agent_email_address = get_term_meta($term->term_id, 'agent_email_address', true);
    ?>

    <div class="agent-info">
        <img class="listing-agent-img" src="<?php echo esc_url($agent_profile_picture); ?>" alt="<?php echo esc_html($term->name); ?>">
      
        <p><strong>Office:</strong> <?php echo esc_html($agent_office_number); ?></p>
        <p><strong>Mobile:</strong> <?php echo esc_html($agent_mobile_number); ?></p>
        <p><strong>Fax:</strong> <?php echo esc_html($agent_fax_number); ?></p>
        <p><strong>WhatsApp:</strong> <?php echo esc_html($agent_whatsapp_number); ?></p>
        <p><strong>Email:</strong> <?php echo esc_html($agent_email_address); ?></p>
    </div>

  
        <?php
          echo '<div class="slides-container">'; // Add container div for slides
        // Query custom post type associated with this agent
        $args = array(
            'post_type' => 'property', // Replace with your custom post type name
            'tax_query' => array(
                array(
                    'taxonomy' => 'agent',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id,
                ),
            ),
        );
        $listings_query = new WP_Query($args);

        if ($listings_query->have_posts()) :
            while ($listings_query->have_posts()) : $listings_query->the_post();
                $post_id = get_the_ID();
                $property_address = get_post_meta($post_id, '_property_address', true);
                $property_price = get_post_meta($post_id, '_property_price', true);
                $property_bathroom = get_post_meta($post_id, 'property_bedroom', true);
                $property_bedrooms = get_post_meta($post_id, 'property_bathroom', true);
                $property_year_built = get_post_meta($post_id, 'property_year_built', true);
                $property_area_size = get_post_meta($post_id, '_area_size', true);
               
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
                               
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p><?php esc_html_e('No listings found for this agent.', 'text-domain'); ?></p>
        <?php endif; ?>
        
    </div>
</div>

<?php get_footer(); ?>
