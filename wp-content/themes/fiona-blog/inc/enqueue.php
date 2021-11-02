<?php
 /**
 * Enqueue scripts and styles.
 */
function fiona_blog_scripts() {
	
	// Styles	
	wp_enqueue_style('tiny-slider',get_template_directory_uri().'/assets/css/tiny-slider.css');
	
	wp_enqueue_style('font-awesome',get_template_directory_uri().'/assets/css/fonts/font-awesome/css/font-awesome.min.css');
	
	wp_enqueue_style('fiona-blog-editor-style',get_template_directory_uri().'/assets/css/editor-style.css');

	wp_enqueue_style('fiona-blog-default', get_template_directory_uri() . '/assets/css/color/default.css');

	wp_enqueue_style('fiona-blog-theme-css',get_template_directory_uri().'/assets/css/theme.css');

	wp_enqueue_style('fiona-blog-menus', get_template_directory_uri() . '/assets/css/menu.css');

	wp_enqueue_style('fiona-blog-widgets',get_template_directory_uri().'/assets/css/widgets.css');

	wp_enqueue_style('fiona-blog-main', get_template_directory_uri() . '/assets/css/main.css');
	
	wp_enqueue_style('fiona-blog-media-query', get_template_directory_uri() . '/assets/css/responsive.css');

	wp_enqueue_style('fiona-blog-woocommerce',get_template_directory_uri().'/assets/css/woo.css');
	
	wp_enqueue_style( 'fiona-blog-style', get_stylesheet_uri() );
	
	// Scripts
	wp_enqueue_script('tiny-slider', get_template_directory_uri() . '/assets/js/tiny-slider.js');

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script('jquery-ripples', get_template_directory_uri() . '/assets/js/jquery.ripples.min.js', array('jquery'),false, true);
	
	wp_enqueue_script('wow-min', get_template_directory_uri() . '/assets/js/wow.min.js', array('jquery'), false, true);

	wp_enqueue_script('fiona-blog-theme-js', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), false, true);

	wp_enqueue_script('fiona-blog-custom-js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), false, true);
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fiona_blog_scripts' );

//Admin Enqueue for Admin
function fiona_blog_admin_enqueue_scripts(){
	wp_enqueue_style('fiona-blog-admin-style', get_template_directory_uri() . '/assets/css/admin.css');
	wp_enqueue_script( 'fiona-blog-admin-script', get_template_directory_uri() . '/assets/js/fiona-blog-admin-script.js', array( 'jquery' ), '', true );
    wp_localize_script( 'fiona-blog-admin-script', 'fiona_blog_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
}
add_action( 'admin_enqueue_scripts', 'fiona_blog_admin_enqueue_scripts' );