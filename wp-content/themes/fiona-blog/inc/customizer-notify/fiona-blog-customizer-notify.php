<?php

class Fiona_Blog_Customizer_Notify {

	private $recommended_actions;

	
	private $recommended_plugins;

	
	private static $instance;

	
	private $recommended_actions_title;

	
	private $recommended_plugins_title;

	
	private $dismiss_button;

	
	private $install_button_label;

	
	private $activate_button_label;

	
	private $fiona_blog_deactivate_button_label;

	
	public static function init( $config ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Fiona_Blog_Customizer_Notify ) ) {
			self::$instance = new Fiona_Blog_Customizer_Notify;
			if ( ! empty( $config ) && is_array( $config ) ) {
				self::$instance->config = $config;
				self::$instance->setup_config();
				self::$instance->setup_actions();
			}
		}

	}

	
	public function setup_config() {

		global $fiona_blog_customizer_notify_recommended_plugins;
		global $fiona_blog_customizer_notify_recommended_actions;

		global $install_button_label;
		global $activate_button_label;
		global $fiona_blog_deactivate_button_label;

		$this->recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
		$this->recommended_plugins = isset( $this->config['recommended_plugins'] ) ? $this->config['recommended_plugins'] : array();

		$this->recommended_actions_title = isset( $this->config['recommended_actions_title'] ) ? $this->config['recommended_actions_title'] : '';
		$this->recommended_plugins_title = isset( $this->config['recommended_plugins_title'] ) ? $this->config['recommended_plugins_title'] : '';
		$this->dismiss_button            = isset( $this->config['dismiss_button'] ) ? $this->config['dismiss_button'] : '';

		$fiona_blog_customizer_notify_recommended_plugins = array();
		$fiona_blog_customizer_notify_recommended_actions = array();

		if ( isset( $this->recommended_plugins ) ) {
			$fiona_blog_customizer_notify_recommended_plugins = $this->recommended_plugins;
		}

		if ( isset( $this->recommended_actions ) ) {
			$fiona_blog_customizer_notify_recommended_actions = $this->recommended_actions;
		}

		$install_button_label    = isset( $this->config['install_button_label'] ) ? $this->config['install_button_label'] : '';
		$activate_button_label   = isset( $this->config['activate_button_label'] ) ? $this->config['activate_button_label'] : '';
		$fiona_blog_deactivate_button_label = isset( $this->config['fiona_blog_deactivate_button_label'] ) ? $this->config['fiona_blog_deactivate_button_label'] : '';

	}

	
	public function setup_actions() {

		// Register the section
		add_action( 'customize_register', array( $this, 'fiona_blog_plugin_notification_customize_register' ) );

		// Enqueue scripts and styles
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'fiona_blog_customizer_notify_scripts_for_customizer' ), 0 );

		/* ajax callback for dismissable recommended actions */
		add_action( 'wp_ajax_quality_customizer_notify_dismiss_action', array( $this, 'fiona_blog_customizer_notify_dismiss_recommended_action_callback' ) );

		add_action( 'wp_ajax_ti_customizer_notify_dismiss_recommended_plugins', array( $this, 'fiona_blog_customizer_notify_dismiss_recommended_plugins_callback' ) );

	}

	
	public function fiona_blog_customizer_notify_scripts_for_customizer() {

		wp_enqueue_style( 'fiona-blog-customizer-notify-css', get_template_directory_uri() . '/inc/customizer-notify/css/fiona-blog-customizer-notify.css', array());

		wp_enqueue_style( 'fiona-blog-plugin-install' );
		wp_enqueue_script( 'fiona-blog-plugin-install' );
		wp_add_inline_script( 'fiona-blog-plugin-install', 'var pagenow = "customizer";' );

		wp_enqueue_script( 'fiona-blog-updates' );

		wp_enqueue_script( 'fiona-blog-customizer-notify-js', get_template_directory_uri() . '/inc/customizer-notify/js/fiona-blog-customizer-notify.js', array( 'customize-controls' ));
		wp_localize_script(
			'fiona-blog-customizer-notify-js', 'FionaCustomizercompanionObject', array(
				'fiona_blog_ajaxurl'            => esc_url(admin_url( 'admin-ajax.php' )),
				'fiona_blog_template_directory' => esc_url(get_template_directory_uri()),
				'fiona_blog_base_path'          => esc_url(admin_url()),
				'fiona_blog_activating_string'  => __( 'Activating', 'fiona-blog' ),
			)
		);

	}

	
	public function fiona_blog_plugin_notification_customize_register( $wp_customize ) {

		
		require_once get_template_directory() . '/inc/customizer-notify/fiona-blog-customizer-notify-section.php';

		$wp_customize->register_section_type( 'Fiona_Blog_Customizer_Notify_Section' );

		$wp_customize->add_section(
			new Fiona_Blog_Customizer_Notify_Section(
				$wp_customize,
				'Fiona-customizer-notify-section',
				array(
					'title'          => $this->recommended_actions_title,
					'plugin_text'    => $this->recommended_plugins_title,
					'dismiss_button' => $this->dismiss_button,
					'priority'       => 0,
				)
			)
		);

	}

	
	public function fiona_blog_customizer_notify_dismiss_recommended_action_callback() {

		global $fiona_blog_customizer_notify_recommended_actions;

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			
			if ( get_theme_mod( 'fiona_blog_customizer_notify_show' ) ) {

				$fiona_blog_customizer_notify_show_recommended_actions = get_theme_mod( 'fiona_blog_customizer_notify_show' );
				switch ( $_GET['todo'] ) {
					case 'add':
						$fiona_blog_customizer_notify_show_recommended_actions[ $action_id ] = true;
						break;
					case 'dismiss':
						$fiona_blog_customizer_notify_show_recommended_actions[ $action_id ] = false;
						break;
				}
				echo esc_html($fiona_blog_customizer_notify_show_recommended_actions);
				
			} else {
				$fiona_blog_customizer_notify_show_recommended_actions = array();
				if ( ! empty( $fiona_blog_customizer_notify_recommended_actions ) ) {
					foreach ( $fiona_blog_customizer_notify_recommended_actions as $fiona_blog_lite_customizer_notify_recommended_action ) {
						if ( $fiona_blog_lite_customizer_notify_recommended_action['id'] == $action_id ) {
							$fiona_blog_customizer_notify_show_recommended_actions[ $fiona_blog_lite_customizer_notify_recommended_action['id'] ] = false;
						} else {
							$fiona_blog_customizer_notify_show_recommended_actions[ $fiona_blog_lite_customizer_notify_recommended_action['id'] ] = true;
						}
					}
					echo esc_html($fiona_blog_customizer_notify_show_recommended_actions);
				}
			}
		}
		die(); 
	}

	
	public function fiona_blog_customizer_notify_dismiss_recommended_plugins_callback() {

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			$fiona_blog_lite_customizer_notify_show_recommended_plugins = get_theme_mod( 'fiona_blog_customizer_notify_show_recommended_plugins' );

			switch ( $_GET['todo'] ) {
				case 'add':
					$fiona_blog_lite_customizer_notify_show_recommended_plugins[ $action_id ] = false;
					break;
				case 'dismiss':
					$fiona_blog_lite_customizer_notify_show_recommended_plugins[ $action_id ] = true;
					break;
			}
			echo esc_html($fiona_blog_customizer_notify_show_recommended_actions);
		}
		die(); 
	}

}
