<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    wp_enqueue_style( 'splash-slick-style', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
    wp_enqueue_script( 'splash-slick-script', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js' );
    wp_enqueue_script( 'my-script', get_stylesheet_directory_uri() . '/js/script.js' );
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_fonts' );
function theme_enqueue_fonts() {
    wp_enqueue_style( 'splash-font-1', 'https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&display=swap' );
}

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
add_filter('upload_mimes', 'cc_mime_types');

function home_slider( $atts ) {
    $a = shortcode_atts( array(), $atts );
    
    $args = array(
        'numberposts' => -1,
        'meta_key' => 'slider_home',
        'meta_value' => true
    );

    $posts = get_posts($args);

    $sliderHome = '<div class="slider-home">';

    foreach($posts as $post) {
        $sliderHome .= '<div class="slider-home__item" style="background-image: url('.get_the_post_thumbnail_url($post->ID, 'full').')">';
        $sliderHome .= '<div class="container">';
        $sliderHome .= '<div class="row justify-content-center">';
        $sliderHome .= '<div class="col-sm-10 slider-home__content">';
        $sliderHome .= '<p class="slider-home__date"></p>';
        $sliderHome .= '</div>';
        $sliderHome .= '</div>';
        $sliderHome .= '</div>';
        $sliderHome .= '</div>';
    }

    $sliderHome .= '</div>';

	return $sliderHome;
}
add_shortcode( 'home_slider', 'home_slider' );