<?php
function fiona_blog_general_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'fiona_blog_general', array(
			'priority' => 31,
			'title' => esc_html__( 'General', 'fiona-blog' ),
		)
	);
	
	/*=========================================
	Scroller
	=========================================*/
	$wp_customize->add_section(
		'top_scroller', array(
			'title' => esc_html__( 'Scroller', 'fiona-blog' ),
			'priority' => 4,
			'panel' => 'fiona_blog_general',
		)
	);
	
	$wp_customize->add_setting( 
		'hs_scroller' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'hs_scroller', 
		array(
			'label'	      => esc_html__( 'Hide / Show Scroller', 'fiona-blog' ),
			'section'     => 'top_scroller',
			'type'        => 'checkbox'
		) 
	);

	/*=========================================
	Breadcrumb  Section
	=========================================*/
	$wp_customize->add_section(
		'breadcrumb_setting', array(
			'title' => esc_html__( 'Breadcrumb', 'fiona-blog' ),
			'priority' => 12,
			'panel' => 'fiona_blog_general',
		)
	);
	
	// Settings
	$wp_customize->add_setting(
		'breadcrumb_settings'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_settings',
		array(
			'type' => 'hidden',
			'label' => __('Settings','fiona-blog'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	// Breadcrumb Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'hs_breadcrumb' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'transport'         => $selective_refresh,
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hs_breadcrumb', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'fiona-blog' ),
			'section'     => 'breadcrumb_setting',
			'settings'    => 'hs_breadcrumb',
			'type'        => 'checkbox'
		) 
	);
	
	// Breadcrumb Content Section // 
	$wp_customize->add_setting(
		'breadcrumb_contents'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_contents',
		array(
			'type' => 'hidden',
			'label' => __('Content','fiona-blog'),
			'section' => 'breadcrumb_setting',
		)
	);

	if ( class_exists( 'Cleverfox_Customizer_Range_Slider_Control' ) ) {
	$wp_customize->add_setting(
    	'breadcrumb_min_height',
    	array(
			'default' => 236,
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_range_value',
			'transport'         => 'postMessage',
			'priority' => 8,
		)
	);
	$wp_customize->add_control( 
		new Cleverfox_Customizer_Range_Slider_Control( $wp_customize, 'breadcrumb_min_height', 
			array(
				'label'      => __( 'Min Height', 'fiona-blog'),
				'section'  => 'breadcrumb_setting',
				'input_attrs' => array(
					'min'    => 1,
					'max'    => 1000,
					'step'   => 1,
					//'suffix' => 'px', //optional suffix
				),
			) ) 
		);
	}	
		
	// Background // 
	$wp_customize->add_setting(
		'breadcrumb_bg_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 9,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_bg_head',
		array(
			'type' => 'hidden',
			'label' => __('Background','fiona-blog'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'breadcrumb_bg_img' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/bg/breadcrumbg.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_url',	
			'priority' => 10,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'breadcrumb_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'fiona-blog'),
			'section'        => 'breadcrumb_setting',
		) 
	));
	
	// Background Attachment // 
	$wp_customize->add_setting( 
		'breadcrumb_back_attach' , 
			array(
			'default' => 'scroll',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_select',
			'priority'  => 10,
		) 
	);
	
	$wp_customize->add_control(
	'breadcrumb_back_attach' , 
		array(
			'label'          => __( 'Background Attachment', 'fiona-blog' ),
			'section'        => 'breadcrumb_setting',
			'type'           => 'select',
			'choices'        => 
			array(
				'inherit' => __( 'Inherit', 'fiona-blog' ),
				'scroll' => __( 'Scroll', 'fiona-blog' ),
				'fixed'   => __( 'Fixed', 'fiona-blog' )
			) 
		) 
	);
	
	
	
	/*=========================================
	Fiona Blog
	=========================================*/
	$wp_customize->add_section(
        'fiona_blogs_general',
        array(
        	'priority'      => 2,
            'title' 		=> __('Blog','fiona-blog'),
			'panel'  		=> 'fiona_blog_general',
		)
    );
	
	// Post Format // 
	$wp_customize->add_setting(
    	'post_format_icon_hs',
    	array(
			'default' => '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 9,
		)
	);	
	
	$wp_customize->add_control( 
		'post_format_icon_hs',
		array(
		    'label'   => __('Hide / Show Post Format Icon','fiona-blog'),
		    'section' => 'fiona_blogs_general',
			'type'           => 'checkbox',
		)  
	);
	
	// Date Box // 
	$wp_customize->add_setting(
    	'post_date_box_hs',
    	array(
			'default' => '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 9,
		)
	);	
	
	$wp_customize->add_control( 
		'post_date_box_hs',
		array(
		    'label'   => __('Hide / Show Date Box','fiona-blog'),
		    'section' => 'fiona_blogs_general',
			'type'           => 'checkbox',
		)  
	);
	
	// Category // 
	$wp_customize->add_setting(
    	'post_cats_hs',
    	array(
			'default' => '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 9,
		)
	);	
	
	$wp_customize->add_control( 
		'post_cats_hs',
		array(
		    'label'   => __('Hide / Show Category Meta','fiona-blog'),
		    'section' => 'fiona_blogs_general',
			'type'           => 'checkbox',
		)  
	);
	
	// Tag // 
	$wp_customize->add_setting(
    	'post_tags_hs',
    	array(
			'default' => '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 9,
		)
	);	
	
	$wp_customize->add_control( 
		'post_tags_hs',
		array(
		    'label'   => __('Hide / Show Tag Meta','fiona-blog'),
		    'section' => 'fiona_blogs_general',
			'type'           => 'checkbox',
		)  
	);
}

add_action( 'customize_register', 'fiona_blog_general_setting' );


// breadcrumb selective refresh
function fiona_blog_breadcrumb_section_partials( $wp_customize ){

	// hs_breadcrumb
	$wp_customize->selective_refresh->add_partial(
		'hs_breadcrumb', array(
			'selector' => '#breadcrumb-section',
			'container_inclusive' => true,
			'render_callback' => 'breadcrumb_setting',
			'fallback_refresh' => true,
		)
	);
	}

add_action( 'customize_register', 'fiona_blog_breadcrumb_section_partials' );
