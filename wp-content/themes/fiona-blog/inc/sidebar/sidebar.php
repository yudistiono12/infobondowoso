<?php	
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function fiona_blog_widgets_init() {	
	register_sidebar( array(
		'name' => __( 'Sidebar Widget Area', 'fiona-blog' ),
		'id' => 'fiona-blog-sidebar-primary',
		'description' => __( 'The Primary Widget Area', 'fiona-blog' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Widget Area', 'fiona-blog' ),
		'id' => 'fiona-blog-footer-widget-area',
		'description' => __( 'The Footer Widget Area', 'fiona-blog' ),
		'before_widget' => '<div class="av-column-3 mb-av-0 mb-4"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );	
	
	register_sidebar( array(
		'name' => __( 'Footer Layout Section', 'fiona-blog' ),
		'id' => 'fiona-blog-footer-layout-first',
		'description' => __( 'Footer Layout', 'fiona-blog' ),
		'before_widget' => ' <div class="widget-center text-av-center text-center"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );
	
	register_sidebar( array(
		'name' => __( 'WooCommerce Widget Area', 'fiona-blog' ),
		'id' => 'fiona-blog-woocommerce-sidebar',
		'description' => __( 'This Widget area for WooCommerce Widget', 'fiona-blog' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );
}
add_action( 'widgets_init', 'fiona_blog_widgets_init' );