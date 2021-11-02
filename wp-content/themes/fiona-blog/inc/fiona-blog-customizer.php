<?php
/**
 * Fiona Theme Customizer.
 *
 * @package Fiona
 */

 if ( ! class_exists( 'Fiona_Blog_Customizer' ) ) {

	/**
	 * Customizer Loader
	 *
	 * @since 1.0.0
	 */
	class Fiona_Blog_Customizer {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object
		 */
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			/**
			 * Customizer
			 */
			add_action( 'customize_preview_init',array( $this, 'fiona_blog_customize_preview_js' ) );
			add_action( 'customize_register',array( $this, 'fiona_blog_customizer_register' ) );
			add_action( 'after_setup_theme',array( $this, 'fiona_blog_customizer_settings' ) );
		}
		
		/**
		 * Add postMessage support for site title and description for the Theme Customizer.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		function fiona_blog_customizer_register( $wp_customize ) {
			
			$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
			$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
			$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
			$wp_customize->get_setting('custom_logo')->transport = 'refresh';
			
			/**
			 * Helper files
			 */
			require FIONA_BLOG_PARENT_INC_DIR . '/custom-controls/font-control.php';
			require FIONA_BLOG_PARENT_INC_DIR . '/custom-controls/fiona-blog-category-dropdown-control.php';
			require FIONA_BLOG_PARENT_INC_DIR . '/sanitization.php';
		}

		/**
		 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
		 */
		function fiona_blog_customize_preview_js() {
			wp_enqueue_script( 'fiona-blog-customizer', FIONA_BLOG_PARENT_URI . '/assets/js/customizer-preview.js', array( 'customize-preview' ), '20151215', true );
		}
		
		// Include customizer customizer settings.
			
		function fiona_blog_customizer_settings() {
			require FIONA_BLOG_PARENT_INC_DIR . '/customize/fiona-blog-header.php';
			require FIONA_BLOG_PARENT_INC_DIR . '/customize/fiona-blog-feature-categories.php';
			require FIONA_BLOG_PARENT_INC_DIR . '/customize/fiona-blog-footer.php';
			require FIONA_BLOG_PARENT_INC_DIR . '/customize/fiona-blog-general.php';
			require FIONA_BLOG_PARENT_INC_DIR . '/customize/customizer_recommended_plugin.php';
			require FIONA_BLOG_PARENT_INC_DIR . '/customize/customizer_import_data.php';
			require FIONA_BLOG_PARENT_INC_DIR . '/customize/fiona-blog-premium.php';
		}

	}
}// End if().

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Fiona_Blog_Customizer::get_instance();