<?php
/* Notifications in customizer */


require get_template_directory() . '/inc/customizer-notify/fiona-blog-customizer-notify.php';
$fiona_blog_config_customizer = array(
	'recommended_plugins'       => array(
		'clever-fox' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>cleverfox</strong> plugin for taking full advantage of all the features this theme has to offer Fiona Blog.', 'fiona-blog')),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'fiona-blog' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'fiona-blog' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'fiona-blog' ),
	'activate_button_label'     => esc_html__( 'Activate', 'fiona-blog' ),
	'fiona_blog_deactivate_button_label'   => esc_html__( 'Deactivate', 'fiona-blog' ),
);
Fiona_Blog_Customizer_Notify::init( apply_filters( 'fiona_blog_customizer_notify_array', $fiona_blog_config_customizer ) );