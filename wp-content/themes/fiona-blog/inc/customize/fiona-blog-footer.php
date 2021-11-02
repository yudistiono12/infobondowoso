<?php
function fiona_blog_footer( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	// Footer Panel // 
	$wp_customize->add_panel( 
		'footer_section', 
		array(
			'priority'      => 34,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Footer', 'fiona-blog'),
		) 
	);
	
	// Footer Setting Section // 
	$wp_customize->add_section(
        'footer_copy_Section',
        array(
            'title' 		=> __('Below Footer','fiona-blog'),
			'panel'  		=> 'footer_section',
			'priority'      => 4,
		)
    );
	
	// footer first text // 
	$fiona_blog_footer_copyright = esc_html__('Copyright &copy; [current_year] [site_title] | Powered by [theme_author]', 'fiona-blog' );
	$wp_customize->add_setting(
    	'footer_first_custom',
    	array(
			'default' => $fiona_blog_footer_copyright,
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'wp_kses_post',
		)
	);	

	$wp_customize->add_control( 
		'footer_first_custom',
		array(
		    'label'   		=> __('Copyright','fiona-blog'),
		    'section'		=> 'footer_copy_Section',
			'type' 			=> 'textarea',
			'priority'      => 4,
			'transport'         => $selective_refresh,
		)  
	);	
}
add_action( 'customize_register', 'fiona_blog_footer' );
// Footer selective refresh
function fiona_blog_footer_partials( $wp_customize ){
	// footer_first_custom
	$wp_customize->selective_refresh->add_partial( 'footer_first_custom', array(
		'selector'            => '.footer-copyright .copyright-text',
		'settings'            => 'footer_first_custom',
		'render_callback'  => 'fiona_blog_footer_first_custom_render_callback',
	
	) );
	}
add_action( 'customize_register', 'fiona_blog_footer_partials' );

// footer_first_custom
function fiona_blog_footer_first_custom_render_callback() {
	return get_theme_mod( 'footer_first_custom' );
}