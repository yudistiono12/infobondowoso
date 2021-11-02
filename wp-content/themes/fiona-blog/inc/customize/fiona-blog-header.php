<?php
function fiona_blog_header_settings( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Header Settings Panel
	=========================================*/
	$wp_customize->add_panel( 
		'header_section', 
		array(
			'priority'      => 2,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Header', 'fiona-blog'),
		) 
	);
	
	/*=========================================
	Header Navigation
	=========================================*/	
	$wp_customize->add_section(
        'header_navigation',
        array(
        	'priority'      => 4,
            'title' 		=> __('Header Navigation','fiona-blog'),
			'panel'  		=> 'header_section',
		)
    );
	
	// Search
	$wp_customize->add_setting(
		'hdr_nav_search'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_search',
		array(
			'type' => 'hidden',
			'label' => __('Search','fiona-blog'),
			'section' => 'header_navigation',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_search' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_search', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'fiona-blog' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
	
	
	// Social
	$wp_customize->add_setting(
		'hdr_nav_social_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 2,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_social_head',
		array(
			'type' => 'hidden',
			'label' => __('Social Icon','fiona-blog'),
			'section' => 'header_navigation',
		)
	);
	
	
	$wp_customize->add_setting( 
		'hs_nav_social' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hs_nav_social', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'fiona-blog' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
	
	/**
	 * Customizer Repeater
	 */
		$wp_customize->add_setting( 'hdr_nav_social_icons', 
			array(
			 'sanitize_callback' => 'fiona_blog_repeater_sanitize',
			 'priority' => 2,
		)
		);
		
		$wp_customize->add_control( 
			new FIONA_BLOG_Repeater( $wp_customize, 
				'hdr_nav_social_icons', 
					array(
						'label'   => esc_html__('Social Icons','fiona-blog'),
						'section' => 'header_navigation',
						'customizer_repeater_icon_control' => true,
						'customizer_repeater_link_control' => true,
					) 
				) 
			);
	

	// Flash
	$wp_customize->add_setting(
		'hdr_nav_flash'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_flash',
		array(
			'type' => 'hidden',
			'label' => __('Flash','fiona-blog'),
			'section' => 'header_navigation',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_flash' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 3,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_flash', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'fiona-blog' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
	
	
	// Bookmark
	$wp_customize->add_setting(
		'hdr_nav_bookmark'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_bookmark',
		array(
			'type' => 'hidden',
			'label' => __('Bookmark','fiona-blog'),
			'section' => 'header_navigation',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_bookmark' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 3,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_bookmark', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'fiona-blog' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
	
	// Cart
	$wp_customize->add_setting(
		'hdr_nav_cart'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_cart',
		array(
			'type' => 'hidden',
			'label' => __('Cart','fiona-blog'),
			'section' => 'header_navigation',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_cart' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 4,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_cart', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'fiona-blog' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
	
	// Button
	$wp_customize->add_setting(
		'hdr_nav_btn'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_btn',
		array(
			'type' => 'hidden',
			'label' => __('Button','fiona-blog'),
			'section' => 'header_navigation',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_nav_btn' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 6,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_nav_btn', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'fiona-blog' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
	
	// Button Label // 
	$wp_customize->add_setting(
    	'nav_btn_lbl',
    	array(
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'capability' => 'edit_theme_options',
			'transport'         => $selective_refresh,
			'priority' => 7,
		)
	);	

	$wp_customize->add_control( 
		'nav_btn_lbl',
		array(
		    'label'   		=> __('Button Label','fiona-blog'),
		    'section' 		=> 'header_navigation',
			'type'		 =>	'text'
		)  
	);
	
	// Button Link // 
	$wp_customize->add_setting(
    	'nav_btn_link',
    	array(
			'sanitize_callback' => 'fiona_blog_sanitize_url',
			'capability' => 'edit_theme_options',
			'priority' => 8,
		)
	);	

	$wp_customize->add_control( 
		'nav_btn_link',
		array(
		    'label'   		=> __('Button Link','fiona-blog'),
		    'section' 		=> 'header_navigation',
			'type'		 =>	'text'
		)  
	);
	
	// icon // 
	$wp_customize->add_setting(
    	'nav_btn_icon',
    	array(
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'priority' => 8,
		)
	);	

	$wp_customize->add_control(new Fiona_Blog_Icon_Picker_Control($wp_customize, 
		'nav_btn_icon',
		array(
		    'label'   		=> __('Icon','fiona-blog'),
		    'section' 		=> 'header_navigation',
			'iconset' => 'fa',
			
		))  
	);
	
	// Docker
	$wp_customize->add_setting(
		'hdr_nav_docker_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 11,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_docker_head',
		array(
			'type' => 'hidden',
			'label' => __('Docker','fiona-blog'),
			'section' => 'header_navigation',
		)
	);
	
	$wp_customize->add_setting( 
		'hs_hdr_nav_docker' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 13,
		) 
	);
	
	$wp_customize->add_control(
	'hs_hdr_nav_docker', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'fiona-blog' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
	
	$wp_customize->add_setting(
    	'hdr_nav_docker_custom',
    	array(
			'sanitize_callback' => 'fiona_blog_sanitize_html',
			'capability' => 'edit_theme_options',
			'priority' => 13,
		)
	);	

	$wp_customize->add_control( 
		'hdr_nav_docker_custom',
		array(
		    'label'   		=> __('Content','fiona-blog'),
		    'section' 		=> 'header_navigation',
			'type'		 =>	'textarea'
		)  
	);

	/*=========================================
	Sticky Header
	=========================================*/	
	$wp_customize->add_section(
        'sticky_header_set',
        array(
        	'priority'      => 4,
            'title' 		=> __('Sticky Header','fiona-blog'),
			'panel'  		=> 'header_section',
		)
    );
	
	// Heading
	$wp_customize->add_setting(
		'sticky_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'sticky_head',
		array(
			'type' => 'hidden',
			'label' => __('Sticky Header','fiona-blog'),
			'section' => 'sticky_header_set',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_sticky' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_sticky', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'fiona-blog' ),
			'section'     => 'sticky_header_set',
			'type'        => 'checkbox'
		) 
	);	
	
}
add_action( 'customize_register', 'fiona_blog_header_settings' );