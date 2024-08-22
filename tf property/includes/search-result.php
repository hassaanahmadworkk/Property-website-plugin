<?php
/*
 * Template Name:Property Search Template
 */

get_header();


?>
<div class="search-container">
<div id="loading" style="display: none;">
    Loading...
</div>
<section id="tf-banner-attachment-parallax" class="tf_banner_inner tf_banner_inner_search tf_banner__image" style="background-image: url('http://pedisarealtyhunters.grow9x.com/wp-content/uploads/2024/05/slide-two.jpg');">
    <div class="tf_container">
        <div class="tf_banner__wrap">
            <h1 class="tf_banner__title"><?php echo get_the_title(); ?></h1>
        </div>
    </div>
</section>
<div class="tf_container">

    <?php
    // Your property search shortcode function
    echo do_shortcode('[property_search]');
    
    
    ?>
    </div>
</div>
<script>
jQuery(document).ready(function($) {
    $('#property-sort').change(function() {
        var formData = $('.tf-search-form').serialize();

        // Show the loading indicator
        $('#loading').show();
        $('.slides-container').hide()

        $.ajax({
            type: 'GET',
            url: 'https://pedisarealtyhunters.grow9x.com/index.php/search-result/',
            data: formData,
            success: function(response) {
                $('.slides-container').html($(response).find('.slides-container').html());
            },
            complete: function() {
                // Hide the loading indicator
                $('#loading').hide();
                $('.slides-container').show()
            }
        });
    });
});

</script>

<?php

get_footer();
