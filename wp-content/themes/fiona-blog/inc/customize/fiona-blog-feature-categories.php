<?php
function fiona_blog_section2_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	
	$wp_customize->add_panel(
		'fiona_blog_frontpage_sections', array(
			'priority' => 32,
			'title' => esc_html__( 'Homepage Sections', 'fiona-blog' ),
		)
	);
	
	/*=========================================
	Section 2
	=========================================*/
	$wp_customize->add_section(
		'section2_setting', array(
			'title' => esc_html__( 'Featured Categories', 'fiona-blog' ),
			'panel' => 'fiona_blog_frontpage_sections',
			'priority' => 2,
		)
	);
	
	//  Head
	$wp_customize->add_setting(
		'section2_setting_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'section2_setting_head',
		array(
			'type' => 'hidden',
			'label' => __('Setting','fiona-blog'),
			'section' => 'section2_setting',
		)
	);
	
	//  Hide / Show
	$wp_customize->add_setting(
		'section2_hs'
			,array(
			'default'     	=> '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_checkbox',
			'priority' => 2,
		)
	);

	$wp_customize->add_control(
	'section2_hs',
		array(
			'type' => 'checkbox',
			'label' => __('Hide / Show','fiona-blog'),
			'section' => 'section2_setting',
		)
	);
	
	//  Contents
	$wp_customize->add_setting(
		'section2_content_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_text',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'section2_content_head',
		array(
			'type' => 'hidden',
			'label' => __('Contents','fiona-blog'),
			'section' => 'section2_setting',
		)
	);
	
	// Title // 
	$wp_customize->add_setting(
    	'section2_title',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'fiona_blog_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 5,
		)
	);	
	
	$wp_customize->add_control( 
		'section2_title',
		array(
		    'label'   => __('Title','fiona-blog'),
		    'section' => 'section2_setting',
			'type'           => 'text',
		)  
	);
	
	// Section2 Category
	$wp_customize->add_setting(
    'section2_category_id',
		array(
		'capability' => 'edit_theme_options',
		'priority' => 5,
		'sanitize_callback' => 'fiona_blog_sanitize_text',
		)
	);	
	$wp_customize->add_control( new Fiona_Blog_Category_Dropdown_Control( $wp_customize, 
	'section2_category_id', 
		array(
		'label'   => __('Select category','fiona-blog'),
		'section' => 'section2_setting',
		) 
	) );
	
	
	// blog_display_num
	if ( class_exists( 'Cleverfox_Customizer_Range_Slider_Control' ) ) {
		$wp_customize->add_setting(
			'section2_display_num',
			array(
				'default' => '6',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'fiona_blog_sanitize_range_value',
				'priority' => 8,
			)
		);
		$wp_customize->add_control( 
		new Cleverfox_Customizer_Range_Slider_Control( $wp_customize, 'section2_display_num', 
			array(
				'label'      => __( 'No of Posts Display', 'fiona-blog' ),
				'section'  => 'section2_setting',
				'input_attrs' => array(
						'min'    => 1,
						'max'    => 1000,
						'step'   => 1,
						//'suffix' => 'px', //optional suffix
					),
			) ) 
		);
	}
}

add_action( 'customize_register', 'fiona_blog_section2_setting' );


//  selective refresh
function fiona_blog_feature_cat_section_partials( $wp_customize ){	
	// section2_title
	$wp_customize->selective_refresh->add_partial( 'section2_title', array(
		'selector'            => '.home-feature-categories .heading-default h3',
		'settings'            => 'section2_title',
		'render_callback'  => 'fiona_blog_section2_title_render_callback',
	) );
	
	// nav_btn_lbl
	$wp_customize->selective_refresh->add_partial( 'nav_btn_lbl', array(
		'selector'            => '.nav-area .av-button-area a',
		'settings'            => 'nav_btn_lbl',
		'render_callback'  => 'fiona_blog_nav_btn_lbl_render_callback',
	) );
}
add_action( 'customize_register', 'fiona_blog_feature_cat_section_partials' );

// section2_title
function fiona_blog_section2_title_render_callback() {
	return get_theme_mod( 'section2_title' );
}

// nav_btn_lbl
function fiona_blog_nav_btn_lbl_render_callback() {
	return get_theme_mod( 'nav_btn_lbl' );
}