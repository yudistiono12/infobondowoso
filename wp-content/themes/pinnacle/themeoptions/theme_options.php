<?php
define( 'LAYOUT_PATH', get_template_directory() . '/assets/css/skins/' );
load_theme_textdomain( 'pinnacle', get_template_directory() . '/languages' );
define( 'OPTIONS_PATH', get_template_directory_uri() . '/themeoptions/options_assets/' );
$alt_stylesheet_path = LAYOUT_PATH;
$alt_stylesheets = array();
if ( is_dir( $alt_stylesheet_path ) ) {
	if ( $alt_stylesheet_dir = opendir( $alt_stylesheet_path ) ) {
		while ( ( $alt_stylesheet_file = readdir( $alt_stylesheet_dir ) ) !== false ) {
			if ( stristr( $alt_stylesheet_file, '.css' ) !== false ) {
				$alt_stylesheets[ $alt_stylesheet_file ] = $alt_stylesheet_file;
			}
		}
		closedir( $alt_stylesheet_dir );
	}
}

// BEGIN Config

if ( ! class_exists( 'Redux' ) ) {
		return;
}
// This is your option name where all the Redux data is stored.
	$opt_name = 'pinnacle';

	// If Redux is running as a plugin, this will remove the demo notice and links
	add_action( 'redux/loaded', 'pinnacle_remove_demo' );

	$theme = wp_get_theme(); // For use with some settings. Not necessary.
	$args = array(
		'opt_name'             => $opt_name,
		'display_name'         => $theme->get( 'Name' ),
		'display_version'      => $theme->get( 'Version' ),
		'page_type'            => 'submenu',
		'allow_sub_menu'       => false,
		'menu_title'           => __( 'Theme Options', 'pinnacle' ),
		'page_title'           => __( 'Theme Options', 'pinnacle' ),
		'google_api_key'       => 'AIzaSyALkgUvb8LFAmrsczX56ZGJx-PPPpwMid0',
		'google_update_weekly' => false,
		'async_typography'     => false,
		'admin_bar'            => true,
		'admin_bar_icon'       => 'dashicons-admin-generic',
		'admin_bar_priority'   => 50,
		'use_cdn'              => false,
		'dev_mode'             => false,
		'forced_dev_mode_off'  => true,
		'update_notice'        => false,
		'customizer'           => true,
		'page_priority'        => 50,
		'page_permissions'     => 'manage_options',
		'menu_icon'            => '',
		'page_icon'            => 'kad_logo_header',
		'page_slug'            => 'ktoptions',
		'ajax_save'            => true,
		'default_show'         => false,
		'default_mark'         => '',
		'disable_tracking'     => true,
		'customizer_only'      => true,
		'save_defaults'        => false,
		'intro_text'           => 'Upgrade to <a href="https://www.kadencewp.com/product/pinnacle-premium-wordpress-theme/?utm_source=themeoptions&utm_medium=banner&utm_campaign=pinnacle_premium" target="_blank" >Pinnacle Premium!</a> More great features! Over 50 more theme options, premium sliders and carousels, breadcrumbs, custom post types and much much more!',
		'footer_credit'        => __( 'Thank you for using the Pinnacle Theme by <a href="https://kadencewp.com/" target="_blank">Kadence WP</a>.', 'pinnacle' ),
		'hints'                => array(
			'icon'          => 'icon-question',
			'icon_position' => 'right',
			'icon_color'    => '#444',
			'icon_size'     => 'normal',
			'tip_style'     => array(
				'color'   => 'dark',
				'shadow'  => true,
				'rounded' => false,
				'style'   => '',
			),
			'tip_position'  => array(
				'my' => 'top left',
				'at' => 'bottom right',
			),
			'tip_effect'    => array(
				'show' => array(
					'effect'   => 'slide',
					'duration' => '500',
					'event'    => 'mouseover',
				),
				'hide' => array(
					'effect'   => 'slide',
					'duration' => '500',
					'event'    => 'click mouseleave',
				),
			),
		),
	);
	// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
	$args['share_icons'][] = array(
		'url' => 'https://www.facebook.com/KadenceWP',
		'title' => 'Follow Kadence WP on Facebook',
		'icon' => 'dashicons dashicons-facebook',
	);
	$args['share_icons'][] = array(
		'url' => 'https://www.twitter.com/KadenceWP',
		'title' => 'Follow Kadence WP on Twitter',
		'icon' => 'dashicons dashicons-twitter',
	);
	$args['share_icons'][] = array(
		'url' => 'https://www.instagram.com/KadenceWP',
		'title' => 'Follow Kadence WP on Instagram',
		'icon' => 'dashicons dashicons-format-image',
	);
	$args['share_icons'][] = array(
		'url' => 'http://www.youtube.com/c/KadenceWP',
		'title' => 'Follow Kadence WP on YouTube',
		'icon' => 'dashicons dashicons-video-alt3',
	);
	$args = apply_filters( 'kadence_theme_options_args', $args );
	Redux::setArgs( $opt_name, $args );

	// -> START Basic Fields

	Redux::setSection(
		$opt_name,
		array(
			'title' => __( 'Site Header', 'pinnacle' ),
			'id' => 'site_header',
			'header' => '',
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Welcome to Pinnacle Theme Options', 'pinnacle' ) . '</h3>
            <p>' . __( 'This theme was developed by', 'pinnacle' ) . ' <a href="https://kadencewp.com/" target="_blank">Kadence WP</a></p>
            <p>' . __( 'For theme documentation visit', 'pinnacle' ) . ': <a href="http://docs.kadencethemes.com/pinnacle/" target="_blank">docs.kadencethemes.com/pinnacle/</a>
            <br />
            ' . __( 'For support please visit', 'pinnacle' ) . ': <a href="https://wordpress.org/support/theme/pinnacle" target="_blank">https://wordpress.org/support/theme/pinnacle</a></p></div>',
			'icon_class' => 'icon-large',
			'icon' => 'icon-desktop',
			'customizer' => true,
			'fields' => array(
				array(
					'id' => 'header_height',
					'type' => 'slider',
					'title' => __( 'Header Height', 'pinnacle' ),
					'default'       => '120',
					'min'       => '30',
					'step'      => '2',
					'customizer' => true,
					'max'       => '400',
				),
				array(
					'id' => 'transparentheader',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Transparent Header', 'pinnacle' ),
				),
				array(
					'id' => 'pagetitle_intoheader',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Enable Transparent header?', 'pinnacle' ),
					'subtitle' => __( 'This will make the page header background fill to the top of the page.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'th_header_menu_color',
					'type' => 'color',
					'title' => __( 'Menu Text Color (For Transparent Header)', 'pinnacle' ),
					'subtitle' => __( 'Choose the font color of the menu font while background is transparent', 'pinnacle' ),
					'transparent' => false,
					'default' => '#ffffff',
					'validate' => 'color',
					'output'    => array( '.kad-primary-nav ul.sf-menu a', '.nav-trigger-case.collapsed .kad-navbtn' ),
					'customizer' => true,
				),
				array(
					'id' => 'th_header_border_color',
					'type' => 'color',
					'title' => __( 'Border Color (For Transparent Header)', 'pinnacle' ),
					'subtitle' => __( 'Choose the color of bottom border while background is transparent', 'pinnacle' ),
					'transparent' => true,
					'default' => '',
					'output'    => array( 'border-color' => '.headerclass' ),
					'validate' => 'color',
					'customizer' => true,
				),
				array(
					'id' => 'th_header_logo_color',
					'type' => 'color',
					'title' => __( 'Site title font Color (For Transparent Header)', 'pinnacle' ),
					'subtitle' => __( 'Choose the font color for the logo while background is transparent', 'pinnacle' ),
					'transparent' => false,
					'validate' => 'color',
					'default' => '#ffffff',
					'output'    => array( '.sticky-wrapper #logo a.brand, .trans-header #logo a.brand' ),
					'customizer' => true,
				),
				array(
					'id' => 'th_x1_logo_upload',
					'type' => 'media',
					'url' => true,
					'customizer' => true,
					'title' => __( 'Logo (For Transparent Header)', 'pinnacle' ),
					'subtitle' => __( 'Upload your Logo.', 'pinnacle' ),
				),
				array(
					'id' => 'th_x2_logo_upload',
					'type' => 'media',
					'url' => true,
					'customizer' => true,
					'title' => __( '@2x Logo (For Transparent Header) ', 'pinnacle' ),
					'subtitle' => __( 'Should be twice the pixel size of your normal logo.', 'pinnacle' ),
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-trophy',
			'icon_class' => 'icon-large',
			'id' => 'logo_options',
			'title' => __( 'Logo Options', 'pinnacle' ),
			'fields' => array(
				array(
					'id' => 'logo_container_width',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Logo Container Width', 'pinnacle' ),
					'options' => array(
						'16' => __( '16%', 'pinnacle' ),
						'25' => __( '25%', 'pinnacle' ),
						'33' => __( '33%', 'pinnacle' ),
						'41' => __( '41%', 'pinnacle' ),
						'50' => __( '50%', 'pinnacle' ),
					),
					'default' => '33',
					'width' => 'width:60%',
				),
				array(
					'id' => 'x1_logo_upload',
					'type' => 'media',
					'url' => true,
					'customizer' => true,
					'title' => __( 'Logo', 'pinnacle' ),
					'subtitle' => __( 'Upload your Logo. If left blank theme will use site name.', 'pinnacle' ),
				),
				array(
					'id' => 'x2_logo_upload',
					'type' => 'media',
					'url' => true,
					'customizer' => true,
					'title' => __( 'Upload Your @2x Logo for Retina Screens', 'pinnacle' ),
					'subtitle' => __( 'Should be twice the pixel size of your normal logo.', 'pinnacle' ),
				),
				array(
					'id' => 'font_logo_style',
					'type' => 'typography',
					'title' => __( 'Sitename Logo Font', 'pinnacle' ),
					// 'compiler'=>true, // Use if you want to hook in your own CSS compiler
					'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'line-height' => false,
					'text-align' => false,
					'customizer' => false,
					'color' => true,
					'preview' => true,
					'output' => array( '.is-sticky header #logo a.brand', '.logofont', '.none-trans-header header #logo a.brand', 'header #logo a.brand' ),
					'subtitle' => __( "Choose size and style your sitename, if you don't use an image logo.", 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '#444444',
						'font-style' => '400',
						'font-size' => '32px',
					),
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-pencil',
			'icon_class' => 'icon-large',
			'id' => 'page_title',
			'title' => __( 'Page Title', 'pinnacle' ),
			'fields' => array(
				array(
					'id' => 'default_showpagetitle',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Show the page title by default', 'pinnacle' ),
					'subtitle' => __( 'This can be overridden on each page.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id'        => 'pageheader_background',
					'type'      => 'background',
					'customizer' => false,
					'output'    => array( '.titleclass' ),
					'title'     => __( 'Page Header Default Background', 'pinnacle' ),
				),
				array(
					'id' => 'pagetitle_color',
					'type' => 'color',
					'title' => __( 'Page Title Color', 'pinnacle' ),
					'subtitle' => __( 'Choose the default pagetitle color for your site.', 'pinnacle' ),
					'transparent' => false,
					'validate' => 'color',
					'default' => '#ffffff',
					'output'    => array( '.titleclass h1' ),
					'customizer' => true,
				),
				array(
					'id' => 'pagesubtitle_color',
					'type' => 'color',
					'title' => __( 'Page Subtitle Color', 'pinnacle' ),
					'subtitle' => __( 'Choose the default subtitle color for your site.', 'pinnacle' ),
					'transparent' => false,
					'validate' => 'color',
					'default' => '#ffffff',
					'output'    => array( '.titleclass .subtitle' ),
					'customizer' => true,
				),
				array(
					'id' => 'pagetitle_align',
					'type' => 'select',
					'title' => __( 'Page Title Align', 'pinnacle' ),
					'options' => array(
						'center' => __( 'Center', 'pinnacle' ),
						'left' => __( 'Left', 'pinnacle' ),
						'right' => __( 'Right', 'pinnacle' ),
					),
					'default' => 'center',
					'customizer' => true,
					'width' => 'width:60%',
				),
				array(
					'id' => 'info_pagetitle_settings_notice',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( '*NOTE: Make sure Kadence Toolkit plugin is activated* <br>Go to Apperance > Theme Options > Page Title settings for all settings', 'pinnacle' ),
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-laptop',
			'icon_class' => 'icon-large',
			'id' => 'footer_layout',
			'title' => __( 'Footer Layout', 'pinnacle' ),
			'fields' => array(
				array(
					'id' => 'footer_layout',
					'type' => 'image_select',
					'customizer' => true,
					'title' => __( 'Footer Widget Layout', 'pinnacle' ),
					'subtitle' => __( 'Select how many columns for footer widgets', 'pinnacle' ),
					'options' => array(
						'fourc' => array(
							'alt' => 'Four Column Layout',
							'img' => OPTIONS_PATH . 'img/footer-widgets-4.png',
						),
						'threec' => array(
							'alt' => 'Three Column Layout',
							'img' => OPTIONS_PATH . 'img/footer-widgets-3.png',
						),
						'twoc' => array(
							'alt' => 'Two Column Layout',
							'img' => OPTIONS_PATH . 'img/footer-widgets-2.png',
						),
					),
					'default' => 'fourc',
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-list-alt',
			'icon_class' => 'icon-large',
			'id' => 'topbar_settings',
			'title' => __( 'Topbar Settings', 'pinnacle' ),
			'fields' => array(
				array(
					'id' => 'topbar',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Use Topbar?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide topbar', 'pinnacle' ),
					'default'       => 0,
				),
				array(
					'id' => 'topbar_height',
					'type' => 'slider',
					'customizer' => true,
					'title' => __( 'Topbar Height', 'pinnacle' ),
					'default'       => '30',
					'min'       => '4',
					'step'      => '2',
					'max'       => '100',
				),
				array(
					'id' => 'topbar_mobile_hide',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Hide on mobile?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide topbar on mobile', 'pinnacle' ),
					'default'       => 1,
				),
				array(
					'id' => 'topbar_icons',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Use Topbar Icon Menu?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide topbar icon Menu', 'pinnacle' ),
					'default'       => 0,
				),
				array(
					'id' => 'topbar_icon_menu',
					'type' => 'kad_icons',
					'customizer' => false,
					'title' => __( 'Topbar Icon Menu', 'pinnacle' ),
					'subtitle' => __( 'Choose your icons for the topbar icon menu.', 'pinnacle' ),
				),
				array(
					'id' => 'topbar_iconmenu_fontsize',
					'type' => 'slider',
					'title' => __( 'Icon menu font size', 'pinnacle' ),
					'default'       => '14',
					'min'       => '8',
					'customizer' => true,
					'step'      => '1',
					'max'       => '36',
				),
				array(
					'id' => 'show_cartcount',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Show Cart total in topbar?', 'pinnacle' ),
					'subtitle' => __( 'This only works if using woocommerce', 'pinnacle' ),
					'default'       => 1,
				),
				array(
					'id' => 'topbar_search',
					'customizer' => true,
					'type' => 'switch',
					'title' => __( 'Display Search in Topbar?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide search in topbar', 'pinnacle' ),
					'default'       => 1,
				),
				array(
					'id' => 'topbar_widget',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Enable widget area in left of Topbar?', 'pinnacle' ),
					'default'       => 0,
				),
				array(
					'id' => 'topbar_layout',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Topbar Layout Switch', 'pinnacle' ),
					'subtitle' => __( 'This moves the left items to the right and right items to the left.', 'pinnacle' ),
					'default'       => 0,
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-picture',
			'icon_class' => 'icon-large',
			'id' => 'home_slider',
			'title' => __( 'Home Slider', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Home Page Slider Options', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'info_home_slider_settings_notice',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( '*NOTE: Make sure Kadence Toolkit plugin is activated* <br>Then go to Apperance > Theme Options > Home Slider for all Home slider settings', 'pinnacle' ),
				),
				array(
					'id' => 'choose_home_header',
					'type' => 'select',
					'title' => __( 'Choose a Home Image Slider', 'pinnacle' ),
					'subtitle' => __( "If you don't want an image slider on your home page choose none.", 'pinnacle' ),
					'options' => array(
						'none' => __( 'None', 'pinnacle' ),
						'pagetitle' => __( 'Page Title', 'pinnacle' ),
						'flex' => __( 'Flex Slider', 'pinnacle' ),
						'carousel' => __( 'Carousel Slider', 'pinnacle' ),
						'latest' => __( 'Latest Posts', 'pinnacle' ),
						'video' => __( 'Video', 'pinnacle' ),
					),
					'default' => 'pagetitle',
					'width' => 'width:60%',
					'customizer' => true,
				),
				array(
					'id' => 'hs_behindheader',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Place behind Header', 'pinnacle' ),
					'subtitle' => __( 'This enabled the transparent header on the home page.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'home_page_title',
					'type' => 'textarea',
					'customizer' => true,
					'title' => __( 'Home Page Title', 'pinnacle' ),
					'validate' => 'html',
					'default' => 'Welcome to [site-name]',
					'required' => array( 'choose_home_header', '=', 'pagetitle' ),
				),
				array(
					'id' => 'home_page_sub_title',
					'type' => 'textarea',
					'customizer' => true,
					'title' => __( 'Home Page SubTitle', 'pinnacle' ),
					'subtitle' => __( 'optional text below home page title', 'pinnacle' ),
					'validate' => 'html',
					'default' => '[site-tagline]',
					'required' => array( 'choose_home_header', '=', 'pagetitle' ),
				),
				array(
					'id' => 'home_page_title_ptop',
					'type' => 'slider',
					'customizer' => true,
					'title' => __( 'Home Page Title Padding Top', 'pinnacle' ),
					'default'       => '110',
					'min'       => '5',
					'step'      => '5',
					'max'       => '300',
					'required' => array( 'choose_home_header', '=', 'pagetitle' ),
				),
				array(
					'id' => 'home_page_title_pbottom',
					'type' => 'slider',
					'customizer' => true,
					'title' => __( 'Home Page Title Padding Bottom', 'pinnacle' ),
					'default'       => '110',
					'min'       => '5',
					'step'      => '5',
					'max'       => '300',
					'required' => array( 'choose_home_header', '=', 'pagetitle' ),
				),
				array(
					'id'        => 'home_pagetitle_background',
					'type'      => 'background',
					'customizer' => false,
					'required' => array( 'choose_home_header', '=', 'pagetitle' ),
				),
				array(
					'id' => 'home_slider',
					'type' => 'kad_slides',
					'customizer' => false,
					'title' => __( 'Slider Images', 'pinnacle' ),
					'subtitle' => __( 'Use large images for best results.', 'pinnacle' ),
					'required' => array( 'choose_home_header', '=', array( 'flex', 'carousel', 'imgcarousel' ) ),
				),
				array(
					'id' => 'slider_size',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Slider Max Height', 'pinnacle' ),
					'subtitle' => __( 'Note: does not work if images are smaller than max.', 'pinnacle' ),
					'default'       => '500',
					'min'       => '100',
					'step'      => '5',
					'max'       => '1000',
					'required' => array( 'choose_home_header', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'slider_size_width',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Slider Max Width', 'pinnacle' ),
					'subtitle' => __( 'Note: does not work if images are smaller than max.', 'pinnacle' ),
					'default'       => '1140',
					'min'       => '600',
					'step'      => '5',
					'max'       => '1400',
					'required' => array( 'choose_home_header', '=', array( 'flex', 'carousel', 'latest' ) ),
				),
				array(
					'id' => 'slider_autoplay',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Auto Play?', 'pinnacle' ),
					'subtitle' => __( 'This determines if a slider automatically scrolls', 'pinnacle' ),
					'default'       => 1,
					'required' => array( 'choose_home_header', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'slider_pausetime',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Slider Pause Time', 'pinnacle' ),
					'subtitle' => __( 'How long to pause on each slide, in milliseconds.', 'pinnacle' ),
					'default'       => '7000',
					'min'       => '3000',
					'step'      => '1000',
					'max'       => '12000',
					'required' => array( 'choose_home_header', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'trans_type',
					'type' => 'select',
					'customizer' => false,
					'title' => __( 'Transition Type', 'pinnacle' ),
					'subtitle' => __( 'Choose a transition type', 'pinnacle' ),
					'options' => array(
						'fade' => __( 'Fade', 'pinnacle' ),
						'slide' => __( 'Slide', 'pinnacle' ),
					),
					'default' => 'fade',
					'required' => array( 'choose_home_header', '=', array( 'flex', 'latest' ) ),
				),
				array(
					'id' => 'slider_transtime',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Slider Transition Time', 'pinnacle' ),
					'subtitle' => __( 'How long for slide transitions, in milliseconds.', 'pinnacle' ),
					'default'       => '600',
					'min'       => '200',
					'step'      => '100',
					'max'       => '1200',
					'required' => array( 'choose_home_header', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'slider_captions',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Show Captions?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide captions', 'pinnacle' ),
					'default'       => 0,
					'required' => array( 'choose_home_header', '=', array( 'flex', 'carousel' ) ),
				),
				array(
					'id' => 'video_embed',
					'type' => 'textarea',
					'customizer' => false,
					'title' => __( 'Video Embed Code', 'pinnacle' ),
					'subtitle' => __( 'If your using a video on the home page place video embed code here.', 'pinnacle' ),
					'default' => '',
					'required' => array( 'choose_home_header', '=', 'video' ),
				),
			),
		)
	);

	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-tablet',
			'icon_class' => 'icon-large',
			'id' => 'mobile_home_slider',
			'title' => __( 'Home Mobile Slider', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Create a different home slider for your mobile visitors.', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'mobile_switch',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Would you like to use this feature?', 'pinnacle' ),
					'subtitle' => __( 'Choose if you would like to show a different slider on your home page for your mobile visitors.', 'pinnacle' ),
					'default'       => 0,
				),
				array(
					'id' => 'choose_mobile_slider',
					'type' => 'select',
					'customizer' => false,
					'title' => __( 'Choose a Slider for Mobile', 'pinnacle' ),
					'subtitle' => __( 'Choose which slider you would like to show for mobile viewers.', 'pinnacle' ),
					'options' => array(
						'none' => __( 'None', 'pinnacle' ),
						'flex' => __( 'Flex Slider', 'pinnacle' ),
						'pagetitle' => __( 'Page Title', 'pinnacle' ),
						'video' => __( 'Video', 'pinnacle' ),
					),
					'default' => 'none',
					'width' => 'width:60%',
					'required' => array( 'mobile_switch', '=', '1' ),
				),
				array(
					'id' => 'm_home_page_title',
					'type' => 'textarea',
					'customizer' => false,
					'title' => __( 'Home Page Title', 'pinnacle' ),
					'validate' => 'html',
					'default' => 'Welcome to [site-name]',
					'required' => array( 'choose_mobile_slider', '=', 'pagetitle' ),
				),
				array(
					'id' => 'm_home_page_sub_title',
					'type' => 'textarea',
					'customizer' => false,
					'title' => __( 'Home Page SubTitle', 'pinnacle' ),
					'subtitle' => __( 'optional text below home page title', 'pinnacle' ),
					'validate' => 'html',
					'default' => '[site-tagline]',
					'required' => array( 'choose_mobile_slider', '=', 'pagetitle' ),
				),
				array(
					'id' => 'm_home_page_title_ptop',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Home Page Title Padding Top', 'pinnacle' ),
					'default'       => '35',
					'min'       => '5',
					'step'      => '5',
					'max'       => '200',
					'required' => array( 'choose_mobile_slider', '=', 'pagetitle' ),
				),
				array(
					'id' => 'm_home_page_title_pbottom',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Home Page Title Padding Bottom', 'pinnacle' ),
					'default'       => '35',
					'min'       => '5',
					'step'      => '5',
					'max'       => '200',
					'required' => array( 'choose_mobile_slider', '=', 'pagetitle' ),
				),
				array(
					'id'        => 'm_home_pagetitle_background',
					'type'      => 'background',
					'customizer' => false,
					'output'    => array( '.home_titleclass' ),
					'required' => array( 'choose_mobile_slider', '=', 'pagetitle' ),
				),
				array(
					'id' => 'home_mobile_slider',
					'type' => 'kad_slides',
					'customizer' => false,
					'title' => __( 'Slider Images', 'pinnacle' ),
					'subtitle' => __( 'Use large images for best results.', 'pinnacle' ),
					'required' => array( 'choose_mobile_slider', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'mobile_slider_size',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Slider Max Height', 'pinnacle' ),
					'subtitle' => __( 'Note: does not work if images are smaller than max.', 'pinnacle' ),
					'default'       => '300',
					'min'       => '100',
					'step'      => '5',
					'max'       => '800',
					'required' => array( 'choose_mobile_slider', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'mobile_slider_size_width',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Slider Max Width', 'pinnacle' ),
					'subtitle' => __( 'Note: does not work if images are smaller than max.', 'pinnacle' ),
					'default'       => '480',
					'min'       => '200',
					'step'      => '5',
					'max'       => '800',
					'required' => array( 'choose_mobile_slider', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'mobile_slider_autoplay',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Auto Play?', 'pinnacle' ),
					'subtitle' => __( 'This determines if a slider automatically scrolls', 'pinnacle' ),
					'default'       => 1,
					'required' => array( 'choose_mobile_slider', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'mobile_slider_pausetime',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Slider Pause Time', 'pinnacle' ),
					'subtitle' => __( 'How long to pause on each slide, in milliseconds.', 'pinnacle' ),
					'default'       => '7000',
					'min'       => '3000',
					'step'      => '1000',
					'max'       => '12000',
					'required' => array( 'choose_mobile_slider', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'mobile_trans_type',
					'type' => 'select',
					'customizer' => false,
					'title' => __( 'Transition Type', 'pinnacle' ),
					'subtitle' => __( 'Choose a transition type', 'pinnacle' ),
					'options' => array(
						'fade' => __( 'Fade', 'pinnacle' ),
						'slide' => __( 'Slide', 'pinnacle' ),
					),
					'default' => 'fade',
					'required' => array( 'choose_mobile_slider', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'mobile_slider_transtime',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Slider Transition Time', 'pinnacle' ),
					'subtitle' => __( 'How long for slide transitions, in milliseconds.', 'pinnacle' ),
					'default'       => '600',
					'min'       => '200',
					'step'      => '100',
					'max'       => '1200',
					'required' => array( 'choose_mobile_slider', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'mobile_slider_captions',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Show Captions?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide captions', 'pinnacle' ),
					'default'       => 0,
					'required' => array( 'choose_mobile_slider', '=', array( 'flex', 'carousel', 'imgcarousel', 'latest' ) ),
				),
				array(
					'id' => 'mobile_video_embed',
					'type' => 'textarea',
					'customizer' => false,
					'title' => __( 'Video Embed Code', 'pinnacle' ),
					'subtitle' => __( 'If your using a video on the home page place video embed code here.', 'pinnacle' ),
					'default' => '',
					'required' => array( 'choose_mobile_slider', '=', 'video' ),
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-home',
			'icon_class' => 'icon-large',
			'id' => 'home_layout',
			'title' => __( 'Home Layout', 'pinnacle' ),
			'desc' => '',
			'fields' => array(
				array(
					'id' => 'home_sidebar_layout',
					'type' => 'image_select',
					'compiler' => false,
					'customizer' => true,
					'title' => __( 'Display a sidebar on the Home Page?', 'pinnacle' ),
					'subtitle' => __( 'This determines if there is a sidebar on the home page.', 'pinnacle' ),
					'options' => array(
						'full' => array(
							'alt' => 'Full Layout',
							'img' => OPTIONS_PATH . 'img/1col.png',
						),
						'sidebar' => array(
							'alt' => 'Sidebar Layout',
							'img' => OPTIONS_PATH . 'img/2cr.png',
						),
					),
					'default' => 'full',
				),
				array(
					'id' => 'home_sidebar',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Choose a Sidebar for your Home Page', 'pinnacle' ),
					'data' => 'sidebars',
					'default' => 'sidebar-primary',
					'width' => 'width:60%',
				),
				array(
					'id' => 'homepage_layout',
					'type' => 'sorter',
					'customizer' => false,
					'title' => __( 'Homepage Layout Manager', 'pinnacle' ),
					'subtitle' => __( 'Organize how you want the layout to appear on the homepage', 'pinnacle' ),
					'options' => array(
						'disabled' => array(
							'block_six'   => __( 'Portfolio Carousel', 'pinnacle' ),
							'block_seven' => __( 'Icon Menu', 'pinnacle' ),
							'block_one'   => __( 'Call to Action', 'pinnacle' ),
							'block_five'  => __( 'Latest Blog Posts', 'pinnacle' ),
						),
						'enabled' => array(
							'block_four'  => __( 'Page Content', 'pinnacle' ),
						),
					),
				),
				array(
					'id' => 'info_blog_settings',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Home Blog Settings', 'pinnacle' ),
				),
				array(
					'id' => 'blog_title',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Home Blog Title', 'pinnacle' ),
					'subtitle' => __( 'e.g. = Latest from the blog', 'pinnacle' ),
				),
				array(
					'id' => 'home_post_count',
					'type' => 'slider',
					'title' => __( 'Choose How many posts on Homepage', 'pinnacle' ),
					'default'       => '6',
					'min'       => '2',
					'customizer' => false,
					'step'      => '1',
					'max'       => '18',
				),
				array(
					'id' => 'home_post_column',
					'type' => 'slider',
					'title' => __( 'Choose how many post columns on Homepage', 'pinnacle' ),
					'default'       => '3',
					'min'       => '2',
					'step'      => '1',
					'customizer' => false,
					'max'       => '4',
				),
				array(
					'id' => 'home_post_type',
					'type' => 'select',
					'data' => 'categories',
					'customizer' => false,
					'title' => __( 'Limit posts to a Category', 'pinnacle' ),
					'subtitle' => __( 'Leave blank to select all', 'pinnacle' ),
					'width' => 'width:60%',
				),
				array(
					'id' => 'info_portfolio_settings',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Home Portfolio Carousel Settings', 'pinnacle' ),
				),
				array(
					'id' => 'portfolio_title',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Home Portfolio Carousel title', 'pinnacle' ),
					'subtitle' => __( 'e.g. = Portfolio Carousel title', 'pinnacle' ),
				),
				array(
					'id' => 'portfolio_type',
					'type' => 'select',
					'data' => 'terms',
					'customizer' => false,
					'args' => array(
						'taxonomies' => 'portfolio-type',
						'args' => array(),
					),
					'title' => __( 'Portfolio Carousel Category Type', 'pinnacle' ),
					'subtitle' => __( 'Leave blank to select all types', 'pinnacle' ),
					'width' => 'width:60%',
				),
				array(
					'id' => 'home_portfolio_carousel_column',
					'type' => 'slider',
					'title' => __( 'Choose how many columns are in carousel', 'pinnacle' ),
					'default'       => '3',
					'min'       => '2',
					'customizer' => false,
					'step'      => '1',
					'max'       => '6',
				),
				array(
					'id' => 'home_port_car_layoutstyle',
					'type' => 'select',
					'title' => __( 'Portfolio Layout Style', 'pinnacle' ),
					'options' => array(
						'default' => __( 'Default', 'pinnacle' ),
						'padded_style' => __( 'Post Boxes', 'pinnacle' ),
						'flat-w-margin' => __( 'Flat with Margin', 'pinnacle' ),
					),
					'default' => 'default',
					'customizer' => false,
					'width' => 'width:60%',
				),
				array(
					'id' => 'home_port_car_hoverstyle',
					'type' => 'select',
					'title' => __( 'Portfolio Hover Style', 'pinnacle' ),
					'options' => array(
						'default' => __( 'Default', 'pinnacle' ),
						'p_lightstyle' => __( 'Light', 'pinnacle' ),
						'p_darkstyle' => __( 'Dark', 'pinnacle' ),
						'p_primarystyle' => __( 'Primary Color', 'pinnacle' ),
					),
					'default' => 'default',
					'customizer' => false,
					'width' => 'width:60%',
				),
				array(
					'id' => 'home_port_car_imageratio',
					'type' => 'select',
					'title' => __( 'Portfolio Image Ratio', 'pinnacle' ),
					'options' => array(
						'default' => __( 'Default', 'pinnacle' ),
						'square' => __( 'Square 1:1', 'pinnacle' ),
						'portrait' => __( 'Portrait 3:4', 'pinnacle' ),
						'landscape' => __( 'Landscape 4:3', 'pinnacle' ),
						'widelandscape' => __( 'Wide Landscape 4:2', 'pinnacle' ),
					),
					'default' => 'default',
					'customizer' => false,
					'width' => 'width:60%',
				),
				array(
					'id' => 'home_portfolio_carousel_count',
					'type' => 'slider',
					'title' => __( 'Choose how many portfolio items are in carousel', 'pinnacle' ),
					'default'       => '6',
					'min'       => '4',
					'customizer' => false,
					'step'      => '1',
					'max'       => '18',
				),
				array(
					'id' => 'home_portfolio_carousel_speed',
					'type' => 'slider',
					'title' => __( 'Choose the carousel speed (in seconds).', 'pinnacle' ),
					'default'       => '9',
					'min'       => '2',
					'step'      => '1',
					'customizer' => false,
					'max'       => '12',
				),
				array(
					'id' => 'home_portfolio_carousel_scroll',
					'type' => 'select',
					'title' => __( 'Portfolio Carousel Scroll', 'pinnacle' ),
					'subtitle' => __( 'Choose how the portfolio items scroll.', 'pinnacle' ),
					'options' => array(
						'oneitem' => __( 'One Item', 'pinnacle' ),
						'all' => __( 'All Visible', 'pinnacle' ),
					),
					'default' => 'oneitem',
					'customizer' => false,
					'width' => 'width:60%',
				),
				array(
					'id' => 'home_portfolio_order',
					'type' => 'select',
					'title' => __( 'Portfolio Carousel Order by', 'pinnacle' ),
					'subtitle' => __( 'Choose how the portfolio items should be ordered in the carousel.', 'pinnacle' ),
					'options' => array(
						'menu_order' => __( 'Menu Order', 'pinnacle' ),
						'title' => __( 'Title', 'pinnacle' ),
						'date' => __( 'Date', 'pinnacle' ),
						'rand' => __( 'Random', 'pinnacle' ),
					),
					'default' => 'menu_order',
					'customizer' => false,
					'width' => 'width:60%',
				),
				array(
					'id' => 'portfolio_car_lightbox',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Display lightbox link in portfolio item?', 'pinnacle' ),
					'default'       => 0,
				),
				array(
					'id' => 'portfolio_show_type',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Display Portfolio Types under Title', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'portfolio_show_excerpt',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Display Portfolio excerpt under Title', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'info_iconmenu_settings',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Home Icon Menu', 'pinnacle' ),
				),
				array(
					'id' => 'icon_menu',
					'type' => 'kad_icons',
					'customizer' => false,
					'title' => __( 'Icon Menu', 'pinnacle' ),
					'subtitle' => __( 'Choose your icons for the icon menu.', 'pinnacle' ),
				),
				array(
					'id' => 'home_icon_menu_column',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Choose how many columns in each row', 'pinnacle' ),
					'default'       => '3',
					'min'       => '2',
					'step'      => '1',
					'max'       => '6',
				),
				array(
					'id' => 'home_icon_menu_btn',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Icon menu button text (optional)', 'pinnacle' ),
					'subtitle' => __( 'e.g. = Read More', 'pinnacle' ),
				),
				array(
					'id' => 'icon_font_color',
					'type' => 'color',
					'customizer' => false,
					'title' => __( 'Icon Color', 'pinnacle' ),
					'subtitle' => __( 'Choose the color for icon.', 'pinnacle' ),
					'default' => '',
					'customizer' => false,
					'transparent' => false,
					'output' => array( 'color' => '.home-iconmenu .home-icon-item i' ),
					'validate' => 'color',
				),
				array(
					'id' => 'icon_bg_color',
					'type' => 'color',
					'customizer' => false,
					'title' => __( 'Icon Background Color', 'pinnacle' ),
					'subtitle' => __( 'Choose the background color for icon. * Note the hover color is set by your primary color in basic styling.', 'pinnacle' ),
					'default' => '',
					'validate' => 'color',
					'output' => array( 'background-color' => '.home-iconmenu .home-icon-item i' ),
				),
				array(
					'id' => 'icon_text_font_color',
					'type' => 'color',
					'customizer' => false,
					'title' => __( 'Title and Description Font Color', 'pinnacle' ),
					'subtitle' => __( 'Choose the color for icon menu title and description Font.', 'pinnacle' ),
					'default' => '',
					'transparent' => false,
					'validate' => 'color',
					'output' => array(
						'color' => '.home-iconmenu .home-icon-item h4, .home-iconmenu .home-icon-item p ',
						'background-color' => '.home-iconmenu .home-icon-item h4:after',
					),
				),
				array(
					'id' => 'info_calltoaction_home_settings',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Home Call To Action Settings', 'pinnacle' ),
				),
				array(
					'id' => 'home_action_text',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Call to Action Text', 'pinnacle' ),
				),
				array(
					'id' => 'home_action_color',
					'type' => 'color',
					'customizer' => false,
					'title' => __( 'Call to Action Text Color', 'pinnacle' ),
					'default' => '',
					'validate' => 'color',
					'transparent' => false,
					'output' => array( 'color' => '.kad-call-title-case h1.kad-call-title' ),
				),
				array(
					'id' => 'home_action_text_tag',
					'type' => 'select',
					'title' => __( 'Text Tag', 'pinnacle' ),
					'options' => array(
						'h1' => __( 'h1', 'pinnacle' ),
						'h2' => __( 'h2', 'pinnacle' ),
						'h3' => __( 'h3', 'pinnacle' ),
						'span' => __( 'span', 'pinnacle' ),
					),
					'default' => 'h1',
					'width' => 'width:60%',
				),
				array(
					'id' => 'home_action_text_btn',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Call to Action Button Text', 'pinnacle' ),
					'subtitle' => __( 'e.g. = Read More', 'pinnacle' ),
				),
				array(
					'id' => 'home_action_link',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Call to Action Button Link', 'pinnacle' ),
				),
				array(
					'id' => 'home_action_btn_color',
					'type' => 'color',
					'customizer' => false,
					'title' => __( 'Button Text Color', 'pinnacle' ),
					'default' => '',
					'validate' => 'color',
					'transparent' => false,
					'output' => array( 'color' => '.kad-call-button-case a.kad-btn-primary' ),
				),
				array(
					'id' => 'home_action_bg_color',
					'type' => 'color',
					'customizer' => false,
					'title' => __( 'Button Background Color', 'pinnacle' ),
					'default' => '',
					'validate' => 'color',
					'output' => array( 'background-color' => '.kad-call-button-case a.kad-btn-primary' ),
				),
				array(
					'id' => 'home_action_btn_color_hover',
					'type' => 'color',
					'customizer' => false,
					'title' => __( 'Button Hover Text Color', 'pinnacle' ),
					'default' => '',
					'validate' => 'color',
					'transparent' => false,
					'output' => array( 'color' => '.kad-call-button-case a.kad-btn-primary:hover' ),
				),
				array(
					'id' => 'home_action_bg_color_hover',
					'type' => 'color',
					'customizer' => false,
					'title' => __( 'Button Hover Background Color', 'pinnacle' ),
					'default' => '',
					'validate' => 'color',
					'output' => array( 'background-color' => '.kad-call-button-case a.kad-btn-primary:hover' ),
				),
				array(
					'id' => 'home_action_padding',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Call to action top and bottom padding.', 'pinnacle' ),
					'default'       => '20',
					'min'       => '4',
					'step'      => '2',
					'max'       => '180',
				),
				array(
					'id'        => 'home_action_background',
					'type'      => 'background',
					'customizer' => false,
					'output'    => array( '.kt-home-call-to-action' ),
					'title'     => __( 'Call to action background', 'pinnacle' ),
				),
				array(
					'id' => 'info_page_content',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Page Content Options (if home page is latest post page)', 'pinnacle' ),
				),
				array(
					'id' => 'home_post_summery',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Latest Post Display', 'pinnacle' ),
					'subtitle' => __( 'If Latest Post page is front page. Choose how to show the posts.', 'pinnacle' ),
					'options' => array(
						'summary' => __( 'Normal Post Excerpt', 'pinnacle' ),
						'full' => __( 'Normal Full Post', 'pinnacle' ),
						'grid' => __( 'Grid Post', 'pinnacle' ),
					),
					'default' => 'summery',
					'width' => 'width:60%',
				),
				array(
					'id' => 'home_post_grid_columns',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Post Grid Columns', 'pinnacle' ),
					'options' => array(
						'2' => __( 'Two', 'pinnacle' ),
						'3' => __( 'Three', 'pinnacle' ),
						'4' => __( 'Four', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => '3',
					'required' => array( 'home_post_summery', '=', array( 'grid' ) ),
				),
				array(
					'id' => 'info_home_layout_settings_notice',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( '*NOTE: Make sure Kadence Toolkit plugin is activated* <br>Then go to Apperance > Theme Options > Home Layout for all home layout settings', 'pinnacle' ),
				),

			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-shopping-cart',
			'icon_class' => 'icon-large',
			'id' => 'shop_settings',
			'title' => __( 'Shop Settings', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Shop Archive Page Settings (Woocommerce plugin required)', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'product_shop_layout',
					'type' => 'select',
					'customizer' => false,
					'title' => __( 'Shop Product Column Layout', 'pinnacle' ),
					'subtitle' => __( 'Choose how many product columns on the shop and category pages', 'pinnacle' ),
					'options' => array(
						'3' => __( 'Three Column', 'pinnacle' ),
						'4' => __( 'Four Column', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => '4',
				),
				array(
					'id' => 'shop_layout',
					'type' => 'image_select',
					'compiler' => false,
					'customizer' => false,
					'title' => __( 'Display the sidebar on Shop Page?', 'pinnacle' ),
					'subtitle' => __( 'This determines if there is a sidebar on the shop page.', 'pinnacle' ),
					'options' => array(
						'full' => array(
							'alt' => 'Full Layout',
							'img' => OPTIONS_PATH . 'img/1col.png',
						),
						'sidebar' => array(
							'alt' => 'Sidebar Layout',
							'img' => OPTIONS_PATH . 'img/2cr.png',
						),
					),
					'default' => 'full',
				),
				array(
					'id' => 'shop_sidebar',
					'type' => 'select',
					'customizer' => false,
					'title' => __( 'Choose a Sidebar for your shop page', 'pinnacle' ),
					'data' => 'sidebars',
					'default' => 'sidebar-primary',
					'width' => 'width:60%',
				),
				array(
					'id' => 'shop_cat_layout',
					'type' => 'image_select',
					'compiler' => false,
					'customizer' => false,
					'title' => __( 'Display the sidebar on Product Category Pages?', 'pinnacle' ),
					'subtitle' => __( 'This determines if there is a sidebar on the product category pages.', 'pinnacle' ),
					'options' => array(
						'full' => array(
							'alt' => 'Full Layout',
							'img' => OPTIONS_PATH . 'img/1col.png',
						),
						'sidebar' => array(
							'alt' => 'Sidebar Layout',
							'img' => OPTIONS_PATH . 'img/2cr.png',
						),
					),
					'default' => 'full',
				),
				array(
					'id' => 'shop_cat_sidebar',
					'type' => 'select',
					'customizer' => false,
					'title' => __( 'Choose a Sidebar for your Product Category Pages', 'pinnacle' ),
					'data' => 'sidebars',
					'default' => 'sidebar-primary',
					'width' => 'width:60%',
				),
				array(
					'id' => 'products_per_page',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'How many products per page', 'pinnacle' ),
					'default'       => '12',
					'min'       => '2',
					'step'      => '1',
					'max'       => '40',
				),
				array(
					'id' => 'shop_rating',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Show Ratings in Shop and Category Pages', 'pinnacle' ),
					'subtitle' => __( 'This determines if the rating is displayed in the product archive pages', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'shop_hide_action',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Hide Add to Cart Till Mouse Hover', 'pinnacle' ),
					'subtitle' => __( 'This determines if add to cart button will be hidden till the mouse hovers over the product', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'product_quantity_input',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Quantity box plus and minus', 'pinnacle' ),
					'subtitle' => __( 'Turn this off if you would like to use browser added plus and minus for number boxes', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'info_cat_product_size',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Shop Category Image Size', 'pinnacle' ),
				),
				array(
					'id' => 'product_cat_layout',
					'type' => 'select',
					'customizer' => false,
					'title' => __( 'Shop Category Column Layout', 'pinnacle' ),
					'subtitle' => __( 'Choose how many Category Image columns to show on the shop and category pages', 'pinnacle' ),
					'options' => array(
						'3' => __( 'Three Column', 'pinnacle' ),
						'4' => __( 'Four Column', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => '3',
				),
				array(
					'id' => 'info_shop_product_title',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Shop Product Title Settings', 'pinnacle' ),
				),
				array(
					'id' => 'font_shop_title',
					'type' => 'typography',
					'title' => __( 'Shop & archive Product title Font', 'pinnacle' ),
					'font-family' => true,
					'customizer' => false,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'line-height' => true,
					'color' => true,
					'preview' => true, // Disable the previewer
					'output' => array( '.product_item .product_details h5, .product-category.grid_item a h5' ),
					'subtitle' => __( 'Choose Size and Style for product titles on category and archive pages.', 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '',
						'font-style' => '700',
						'font-size' => '15px',
						'line-height' => '20px',
					),
				),
				array(
					'id' => 'shop_title_uppercase',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Set Product Title to Uppercase?', 'pinnacle' ),
					'subtitle' => __( 'This makes your product titles uppercase on Category pages', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'shop_title_min_height',
					'type' => 'slider',
					'customizer' => false,
					'title' => __( 'Product title Min Height', 'pinnacle' ),
					'subtitle' => __( 'If your titles are long increase this to help align your products height.', 'pinnacle' ),
					'default'       => '50',
					'min'       => '20',
					'step'      => '5',
					'max'       => '120',
				),
				array(
					'id' => 'info_shop_img_size',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Product Image Sizes', 'pinnacle' ),
				),
				array(
					'id' => 'product_img_resize',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Enable Product Image Aspect Ratio on Catalog pages', 'pinnacle' ),
					'subtitle' => __( 'If turned off image dimensions are set by woocommerce settings - recommended width: 270px for Catalog Images', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'product_simg_resize',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Enable Product Image Aspect Ratio on product Page', 'pinnacle' ),
					'subtitle' => __( 'If turned off image dimensions are set by woocommerce settings - recommended width: 468px for Single Product Image', 'pinnacle' ),
					'default' => 1,
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-barcode',
			'id' => 'product_settings',
			'icon_class' => 'icon-large',
			'title' => __( 'Product Settings', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Single Product Page Header (Woocommerce plugin required)', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'default_showproducttitle',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Show the Title in header by default', 'pinnacle' ),
					'subtitle' => __( 'This can be overridden on each page.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'default_showproducttitle_inpost',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Show the Title in post', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'single_product_header_title',
					'type' => 'select',
					'customizer' => false,
					'title' => __( 'Product Default Title Text', 'pinnacle' ),
					'options' => array(
						'category' => __( 'Category of product', 'pinnacle' ),
						'posttitle' => __( 'Product Title', 'pinnacle' ),
						'custom' => __( 'Custom', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => 'category',
				),
				array(
					'id' => 'product_header_title_text',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Post Default Title', 'pinnacle' ),
					'subtitle' => __( 'Example: My Shop', 'pinnacle' ),
					'required' => array( 'single_product_header_title', '=', 'custom' ),
				),
				array(
					'id' => 'product_header_subtitle_text',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Post Default Subtitle', 'pinnacle' ),
					'required' => array( 'single_product_header_title', '=', 'custom' ),
				),
				array(
					'id' => 'product_gallery_slider',
					'type' => 'switch',
					'title' => __( 'Enable woocommerce slider for product gallery? (must be woocommerce 3.0+)', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'product_gallery_zoom',
					'type' => 'switch',
					'title' => __( 'Enable woocommerce hover zoom for product gallery? (must be woocommerce 3.0+)', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'product_tabs',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Display product tabs?', 'pinnacle' ),
					'subtitle' => __( 'This determines if product tabs are displayed', 'pinnacle' ),
					'default'       => 1,
				),
				array(
					'id' => 'related_products',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Display related products?', 'pinnacle' ),
					'subtitle' => __( 'This determines related products are displayed', 'pinnacle' ),
					'default'       => 1,
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-camera-retro',
			'icon_class' => 'icon-large',
			'id' => 'portfolio_options',
			'title' => __( 'Portfolio Options', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Portfolio Options (Kadence Toolkit plugin required)', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'portfolio_comments',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Allow Comments on Portfolio Posts', 'pinnacle' ),
					'subtitle' => __( 'Turn on to allow Comments on Portfolio posts', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'info_portfolio_grid_options',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Portfolio Grid Options', 'pinnacle' ),
				),
				array(
					'id' => 'portfolio_style_default',
					'type' => 'select',
					'width' => 'width:60%',
					'customizer' => true,
					'default' => 'flat-w-margin',
					'title' => __( 'Default Portfolio Layout Style', 'pinnacle' ),
					'subtitle' => __( 'This sets the defualt layout style for the portfolio post.', 'pinnacle' ),
					'options' => array(
						'padded_style' => __( 'Post Boxes', 'pinnacle' ),
						'flat-w-margin' => __( 'Flat with Margin', 'pinnacle' ),
					),
				),
				array(
					'id' => 'portfolio_hover_style_default',
					'type' => 'select',
					'width' => 'width:60%',
					'customizer' => true,
					'default' => 'p_primarystyle',
					'title' => __( 'Default Hover Style', 'pinnacle' ),
					'subtitle' => __( 'This sets the defualt hover style for the portfolio post.', 'pinnacle' ),
					'options' => array(
						'p_primarystyle' => __( 'Primary Color Style', 'pinnacle' ),
						'p_lightstyle' => __( 'Light Style', 'pinnacle' ),
						'p_darkstyle' => __( 'Dark Style', 'pinnacle' ),
					),
				),
				array(
					'id' => 'info_portfolio_ph_defaults',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Single Portfolio Page Header', 'pinnacle' ),
				),
				array(
					'id' => 'default_showportfoliotitle',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Show the Title in header by default', 'pinnacle' ),
					'subtitle' => __( 'This can be overridden on each page.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'default_showportfoliotitle_inpost',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Show the Title in post', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'single_portfolio_header_title',
					'type' => 'select',
					'title' => __( 'Portfolio Default Title Text', 'pinnacle' ),
					'options' => array(
						'category' => __( 'Category of Portfolio', 'pinnacle' ),
						'posttitle' => __( 'Portfolio Title', 'pinnacle' ),
						'custom' => __( 'Custom', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'customizer' => false,
					'default' => 'posttitle',
				),
				array(
					'id' => 'portfolio_header_title_text',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Post Default Title', 'pinnacle' ),
					'subtitle' => __( 'Example: My Shop', 'pinnacle' ),
					'required' => array( 'single_portfolio_header_title', '=', 'custom' ),
				),
				array(
					'id' => 'portfolio_header_subtitle_text',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Post Default Subtitle', 'pinnacle' ),
					'required' => array( 'single_portfolio_header_title', '=', 'custom' ),
				),
				array(
					'id' => 'info_portfolio_nav_options',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Single Portfolio Navigation Options', 'pinnacle' ),
				),
				array(
					'id' => 'portfolio_header_nav',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Show portfolio nav below post title', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'portfolio_link',
					'type' => 'select',
					'data' => 'pages',
					'customizer' => true,
					'width' => 'width:60%',
					'title' => __( 'All Projects Default Portfolio Page', 'pinnacle' ),
					'subtitle' => __( 'This sets the link in every portfolio post.', 'pinnacle' ),
				),
				array(
					'id' => 'info_portfolio_carousel_options',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Portfolio Post Bottom Carousel', 'pinnacle' ),
				),
				array(
					'id' => 'single_portfolio_carousel_default',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Display Bottom Portfolio carousel by Default', 'pinnacle' ),
					'options' => array(
						'no' => __( 'No', 'pinnacle' ),
						'yes' => __( 'Yes', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => 'no',
				),
				array(
					'id' => 'single_portfolio_carousel_items',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Bottom Portfolio Carousel Items', 'pinnacle' ),
					'options' => array(
						'all' => __( 'All Portfolio Posts', 'pinnacle' ),
						'cat' => __( 'Only of same Portfolio Type', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => 'all',
				),
				array(
					'id' => 'portfolio_recent_car_column',
					'type' => 'slider',
					'customizer' => true,
					'title' => __( 'Choose how many columns to show on recent portfolio carousel.', 'pinnacle' ),
					'default'       => '4',
					'min'       => '2',
					'step'      => '1',
					'max'       => '6',
				),
				array(
					'id' => 'info_portfolio_cat_defaults',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Portfolio Category Pages', 'pinnacle' ),
				),
				array(
					'id' => 'portfolio_tax_column',
					'type' => 'slider',
					'customizer' => true,
					'title' => __( 'Choose how many portfolio columns to show on portfolio catagory pages.', 'pinnacle' ),
					'default'       => '4',
					'min'       => '2',
					'step'      => '1',
					'max'       => '6',
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-paperclip',
			'icon_class' => 'icon-large',
			'id' => 'blog_options',
			'title' => __( 'Blog Options', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Blog Options', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'close_comments',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Show Comments Closed Text?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide comments closed alert below posts.', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'hide_author_img',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Show Author image with posts?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide author image beside post title.', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'hide_author',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Show author name with posts?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide author name under post title.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'hide_postedin',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Show categories with posts?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide categories in the post footer.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'hide_posttags',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Show tags with posts?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide tags in the post footer.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'hide_commenticon',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Show comment count with posts?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide comment count under post title.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'hide_postdate',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Show date with posts?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide date under post title.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'show_postlinks',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Show Previous and Next posts links?', 'pinnacle' ),
					'subtitle' => __( 'Choose to show or hide previous and next post links in the footer of a single post.', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'postexcerpt_hard_crop',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Hard Crop excerpt images to the same height.', 'pinnacle' ),
					'subtitle' => __( 'Makes the excerpt images the same size instead of whatever ratio was uploaded.', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'info_blog_defaults',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Blog Post Page Header', 'pinnacle' ),
				),
				array(
					'id' => 'default_showposttitle',
					'type' => 'switch',
					'title' => __( 'Show the post title in head by default', 'pinnacle' ),
					'subtitle' => __( 'This can be overridden on each page.', 'pinnacle' ),
					'default' => 1,
					'customizer' => false,
				),
				array(
					'id' => 'single_post_header_title',
					'type' => 'select',
					'title' => __( 'Blog Post Default Head Title', 'pinnacle' ),
					'options' => array(
						'category' => __( 'Category', 'pinnacle' ),
						'posttitle' => __( 'Post Title', 'pinnacle' ),
						'custom' => __( 'Custom', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'customizer' => false,
					'default' => 'category',
				),
				array(
					'id' => 'default_showposttitle_below',
					'type' => 'switch',
					'title' => __( 'Show the post title below the header', 'pinnacle' ),
					'default' => 1,
					'customizer' => false,
					'required' => array( 'single_post_header_title', '=', 'posttitle' ),
				),
				array(
					'id' => 'post_header_title_text',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Post Default Title', 'pinnacle' ),
					'subtitle' => __( 'Example: Blog', 'pinnacle' ),
					'required' => array( 'single_post_header_title', '=', 'custom' ),
				),
				array(
					'id' => 'post_header_subtitle_text',
					'type' => 'text',
					'customizer' => false,
					'title' => __( 'Post Default Subtitle', 'pinnacle' ),
					'required' => array( 'single_post_header_title', '=', 'custom' ),
				),
				array(
					'id' => 'single_post_title_output',
					'type' => 'select',
					'title' => __( 'Blog Post non-Head Title Output', 'pinnacle' ),
					'options' => array(
						'h1' => __( 'Use H1 tag', 'pinnacle' ),
						'h2' => __( 'Use H2 tag', 'pinnacle' ),
						'none' => __( 'Do not display', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'customizer' => false,
					'default' => 'h1',
				),
				array(
					'id' => 'info_blog_defaults',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Blog Post Defaults', 'pinnacle' ),
				),
				array(
					'id' => 'blogpost_sidebar_default',
					'type' => 'select',
					'title' => __( 'Blog Post Sidebar Default', 'pinnacle' ),
					'options' => array(
						'yes' => __( 'Yes, Show', 'pinnacle' ),
						'no' => __( 'No, Do not Show', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'customizer' => true,
					'default' => 'yes',
				),
				array(
					'id' => 'post_author_default',
					'type' => 'select',
					'title' => __( 'Blog Post Author Box Default', 'pinnacle' ),
					'options' => array(
						'no' => __( 'No, Do not Show', 'pinnacle' ),
						'yes' => __( 'Yes, Show', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'customizer' => true,
					'default' => 'no',
				),
				array(
					'id' => 'post_summery_default_image',
					'type' => 'media',
					'url' => true,
					'title' => __( 'Default post summary feature Image', 'pinnacle' ),
					'subtitle' => __( 'Replace theme default feature image for posts without a featured image', 'pinnacle' ),
				),
				array(
					'id' => 'post_carousel_default',
					'type' => 'select',
					'title' => __( 'Blog Post Bottom Carousel Default', 'pinnacle' ),
					'options' => array(
						'no' => __( 'No, Do not Show', 'pinnacle' ),
						'recent' => __( 'Yes - Display Recent Posts', 'pinnacle' ),
						'similar' => __( 'Yes - Display Similar Posts', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'customizer' => true,
					'default' => 'no',
				),
				array(
					'id' => 'info_blog_defaults_stand',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Blog Post Defaults Standard', 'pinnacle' ),
				),
				array(
					'id' => 'post_summery_default',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Standard Blog Post Summary Default', 'pinnacle' ),
					'options' => array(
						'text' => __( 'Text', 'pinnacle' ),
						'img_portrait' => __( 'Portrait Image', 'pinnacle' ),
						'img_landscape' => __( 'Landscape Image', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => 'img_landscape',
				),
				array(
					'id' => 'info_blog_defaults_image',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Blog Post Defaults Image', 'pinnacle' ),
				),
				array(
					'id' => 'image_post_summery_default',
					'type' => 'select',
					'title' => __( 'Image Blog Post Summary Default', 'pinnacle' ),
					'options' => array(
						'text' => __( 'Text', 'pinnacle' ),
						'img_portrait' => __( 'Portrait Image', 'pinnacle' ),
						'img_landscape' => __( 'Landscape Image', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'customizer' => true,
					'default' => 'img_portrait',
				),
				array(
					'id' => 'image_post_blog_default',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Single Image Post Head Content', 'pinnacle' ),
					'options' => array(
						'none' => __( 'None', 'pinnacle' ),
						'image' => __( 'Image', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => 'image',
				),
				array(
					'id' => 'info_blog_defaults_gallery',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Blog Post Defaults gallery', 'pinnacle' ),
				),
				array(
					'id' => 'gallery_post_summery_default',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Gallery Blog Post Summary Default', 'pinnacle' ),
					'options' => array(
						'text' => __( 'Text', 'pinnacle' ),
						'img_portrait' => __( 'Portrait Image', 'pinnacle' ),
						'img_landscape' => __( 'Landscape Image', 'pinnacle' ),
						'slider_portrait' => __( 'Portrait Slider', 'pinnacle' ),
						'slider_landscape' => __( 'Landscape Slider', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => 'slider_landscape',
				),
				array(
					'id' => 'gallery_post_blog_default',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Single Gallery Post Head Content', 'pinnacle' ),
					'options' => array(
						'none' => __( 'None', 'pinnacle' ),
						'flex' => __( 'Image Slider (Flex Slider)', 'pinnacle' ),
						'carouselslider' => __( 'Carousel Slider (Caroufedsel Slider)', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => 'flex',
				),
				array(
					'id' => 'info_blog_defaults_video',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Blog Post Defaults Video', 'pinnacle' ),
				),
				array(
					'id' => 'video_post_summery_default',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Video Blog Post Summary Default', 'pinnacle' ),
					'options' => array(
						'text' => __( 'Text', 'pinnacle' ),
						'img_portrait' => __( 'Portrait Image', 'pinnacle' ),
						'img_landscape' => __( 'Landscape Image', 'pinnacle' ),
						'video' => __( 'Video', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => 'video',
				),
				array(
					'id' => 'video_post_blog_default',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Single Video Post Head Content', 'pinnacle' ),
					'options' => array(
						'none' => __( 'None', 'pinnacle' ),
						'video' => __( 'Video', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => 'video',
				),
				array(
					'id' => 'info_blog_category',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Blog Category/Archive Defaults', 'pinnacle' ),
				),
				array(
					'id' => 'category_post_summary',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Category Display Type', 'pinnacle' ),
					'options' => array(
						'summary' => __( 'Normal Post Excerpt', 'pinnacle' ),
						'full' => __( 'Normal Full Post', 'pinnacle' ),
						'grid' => __( 'Grid Post', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => 'summary',
				),
				array(
					'id' => 'category_post_grid_columns',
					'type' => 'select',
					'customizer' => true,
					'title' => __( 'Category Grid Columns', 'pinnacle' ),
					'options' => array(
						'2' => __( 'Two', 'pinnacle' ),
						'3' => __( 'Three', 'pinnacle' ),
						'4' => __( 'Four', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'default' => '3',
					'required' => array( 'category_post_summary', '=', array( 'grid' ) ),
				),
				array(
					'id' => 'blog_cat_layout',
					'type' => 'image_select',
					'compiler' => false,
					'customizer' => true,
					'title' => __( 'Display the sidebar on blog archives?', 'pinnacle' ),
					'subtitle' => __( 'This determines if there is a sidebar on the blog category pages.', 'pinnacle' ),
					'options' => array(
						'full' => array(
							'alt' => 'Full Layout',
							'img' => OPTIONS_PATH . 'img/1col.png',
						),
						'sidebar' => array(
							'alt' => 'Sidebar Layout',
							'img' => OPTIONS_PATH . 'img/2cr.png',
						),
					),
					'default' => 'sidebar',
				),
				array(
					'id' => 'blog_cat_sidebar',
					'type' => 'select',
					'title' => __( 'Choose a Sidebar for your Category/Archive Pages', 'pinnacle' ),
					'data' => 'sidebars',
					'customizer' => true,
					'default' => 'sidebar-primary',
					'width' => 'width:60%',
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-file-text',
			'icon_class' => 'icon-large',
			'id' => 'page_options',
			'title' => __( 'Page Options', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Page Options', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'page_comments',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Allow Comments on Pages', 'pinnacle' ),
					'subtitle' => __( 'Turn on to allow comments on pages.', 'pinnacle' ),
					'default' => 0,
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-edit',
			'icon_class' => 'icon-large',
			'id' => 'basic_styling',
			'title' => __( 'Basic Styling', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Basic Stylng', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'skin_stylesheet',
					'type' => 'select',
					'title' => __( 'Theme Skin Stylesheet', 'pinnacle' ),
					'subtitle' => __( 'Note* changes made in options panel will override this stylesheet. Example: Colors set in typography.', 'pinnacle' ),
					'options' => $alt_stylesheets,
					'default' => 'default.css',
					'width' => 'width:60%',
					'customizer' => true,
				),
				array(
					'id' => 'primary_color',
					'type' => 'color',
					'title' => __( 'Primary Color', 'pinnacle' ),
					'subtitle' => __( 'Choose the default Highlight color for your site.', 'pinnacle' ),
					'transparent' => false,
					'validate' => 'color',
					'customizer' => true,
				),
				array(
					'id' => 'primary20_color',
					'type' => 'color',
					'title' => __( 'Primary Hover Color', 'pinnacle' ),
					'subtitle' => __( 'Recomended to be 20% lighter than primary color', 'pinnacle' ),
					'default' => '',
					'transparent' => false,
					'validate' => 'color',
					'customizer' => true,
				),
				array(
					'id' => 'gray_font_color',
					'type' => 'color',
					'title' => __( 'Sitewide Gray Fonts', 'pinnacle' ),
					'default' => '',
					'transparent' => false,
					'validate' => 'color',
					'customizer' => true,
				),
				array(
					'id' => 'footerfont_color',
					'type' => 'color',
					'title' => __( 'Footer Font Color', 'pinnacle' ),
					'default' => '',
					'transparent' => false,
					'validate' => 'color',
					'customizer' => true,
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-cogs',
			'icon_class' => 'icon-large',
			'id' => 'advanced_styling',
			'title' => __( 'Advanced Styling', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Main Content Background', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id'        => 'content_background',
					'type'      => 'background',
					'output'    => array( '.contentclass' ),
					'customizer' => false,
					'title'     => __( 'Content Background', 'pinnacle' ),
				),
				array(
					'id' => 'info_topbar_background',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Topbar Background', 'pinnacle' ),
				),
				array(
					'id'        => 'topbar_background',
					'type'      => 'background',
					'output'    => array( '.topclass' ),
					'customizer' => false,
					'title'     => __( 'Topbar Background', 'pinnacle' ),
				),
				array(
					'id' => 'info_header_background',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Header Background', 'pinnacle' ),
				),
				array(
					'id' => 'header_background_choice',
					'type' => 'select',
					'title' => __( 'Header Background Style', 'pinnacle' ),
					'options' => array(
						'simple' => __( 'Simple', 'pinnacle' ),
						'full' => __( 'Full', 'pinnacle' ),
					),
					'width' => 'width:60%',
					'customizer' => false,
					'default' => 'simple',
				),
				array(
					'id'        => 'header_background',
					'type'      => 'background',
					'output'    => array( '.is-sticky .headerclass', '.none-trans-header .headerclass' ),
					'title'     => __( 'Header Background', 'pinnacle' ),
					'customizer' => false,
					'required' => array( 'header_background_choice', '=', 'full' ),
				),
				array(
					'id' => 'header_background_color',
					'type' => 'color',
					'title' => __( 'Header Background Color', 'pinnacle' ),
					'default' => '',
					'transparent' => false,
					'validate' => 'color',
					'customizer' => false,
					'required' => array( 'header_background_choice', '=', 'simple' ),
				),
				array(
					'id' => 'header_background_transparency',
					'type' => 'select',
					'title' => __( 'If background is color, select Transparency', 'pinnacle' ),
					'options' => array(
						'1' => '1',
						'0.9' => '0.9',
						'0.8' => '0.8',
						'0.7' => '0.7',
						'0.6' => '0.6',
						'0.5' => '0.5',
						'0.4' => '0.4',
						'0.3' => '0.3',
						'0.2' => '0.2',
						'0.1' => '0.1',
						'0' => '0',
					),
					'default' => '1',
					'width' => 'width:60%',
					'customizer' => false,
					'required' => array( 'header_background_choice', '=', 'simple' ),
				),
				array(
					'id' => 'info_menu_background',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Menu Background', 'pinnacle' ),
				),
				array(
					'id'        => 'menu_background',
					'type'      => 'background',
					'output'    => array( '.kad-primary-nav > ul' ),
					'customizer' => false,
					'title'     => __( 'Menu Background', 'pinnacle' ),
				),
				array(
					'id' => 'info_mobile_background',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Mobile Menu Background', 'pinnacle' ),
				),
				array(
					'id'        => 'mobile_background',
					'type'      => 'background',
					'customizer' => false,
					'output'    => array( '.mobileclass' ),
					'title'     => __( 'Mobile Menu Background', 'pinnacle' ),
				),
				array(
					'id' => 'info_post_background',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Post and Page Content area Background', 'pinnacle' ),
				),
				array(
					'id'        => 'post_background',
					'type'      => 'background',
					'output'    => array( '.postclass' ),
					'customizer' => false,
					'title'     => __( 'Post Background', 'pinnacle' ),
				),
				array(
					'id' => 'info_footer_background',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Footer Background', 'pinnacle' ),
				),
				array(
					'id'        => 'footer_background',
					'type'      => 'background',
					'customizer' => false,
					'output'    => array( '.footerclass' ),
					'title'     => __( 'Footer Background', 'pinnacle' ),
				),
				array(
					'id' => 'info_body_background',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Body Background', 'pinnacle' ),
				),
				array(
					'id'        => 'body_background',
					'type'      => 'background',
					'customizer' => false,
					'output'    => array( 'body' ),
					'title'     => __( 'Body Background', 'pinnacle' ),
					'subtitle'  => __( 'This shows if site is using the boxed layout option.', 'pinnacle' ),
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-text-width',
			'icon_class' => 'icon-large',
			'id' => 'typography',
			'title' => __( 'Typography', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Header Font Options', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'info_typography_settings_notice',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( '*NOTE: Make sure Kadence Toolkit plugin is activated* <br>Then go to Apperance > Theme Options > Typography settings for all Typography settings', 'pinnacle' ),
				),
				array(
					'id' => 'font_h1',
					'type' => 'typography',
					'title' => __( 'H1 Headings', 'pinnacle' ),
					'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'line-height' => true,
					'text-align' => false,
					'customizer' => false,
					'color' => true,
					'preview' => true, // Disable the previewer
					'output' => array( 'h1' ),
					'subtitle' => __( 'Choose Size and Style for h1 (This Styles Your Page Titles)', 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '',
						'font-style' => '700',
						'font-size' => '44px',
						'line-height' => '50px',
					),
				),
				array(
					'id' => 'font_h2',
					'type' => 'typography',
					'title' => __( 'H2 Headings', 'pinnacle' ),
					// 'compiler'=>true, // Use if you want to hook in your own CSS compiler
					  'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'line-height' => true,
					'text-align' => false,
					'customizer' => false,
					// 'word-spacing'=>false, // Defaults to false
					// 'all_styles' => true,
					'color' => true,
					'preview' => true, // Disable the previewer
					'output' => array( 'h2' ),
					'subtitle' => __( 'Choose Size and Style for h2', 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '',
						'font-style' => '400',
						'font-size' => '32px',
						'line-height' => '40px',
					),
				),
				array(
					'id' => 'font_h3',
					'type' => 'typography',
					'title' => __( 'H3 Headings', 'pinnacle' ),
					// 'compiler'=>true, // Use if you want to hook in your own CSS compiler
					'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'line-height' => true,
					'text-align' => false,
					'customizer' => false,
					// 'word-spacing'=>false, // Defaults to false
					// 'all_styles' => true,
					'color' => true,
					'preview' => true, // Disable the previewer
					'output' => array( 'h3' ),
					'subtitle' => __( 'Choose Size and Style for h3', 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '',
						'font-style' => '400',
						'font-size' => '26px',
						'line-height' => '40px',
					),
				),
				array(
					'id' => 'font_h4',
					'type' => 'typography',
					'title' => __( 'H4 Headings', 'pinnacle' ),
					// 'compiler'=>true, // Use if you want to hook in your own CSS compiler
					'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'customizer' => false,
					'line-height' => true,
					'text-align' => false,
					// 'word-spacing'=>false, // Defaults to false
					// 'all_styles' => true,
					'color' => true,
					'preview' => true, // Disable the previewer
					'output' => array( 'h4' ),
					'subtitle' => __( 'Choose Size and Style for h4', 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '',
						'font-style' => '400',
						'font-size' => '24px',
						'line-height' => '34px',
					),
				),
				array(
					'id' => 'font_h5',
					'type' => 'typography',
					'title' => __( 'H5 Headings', 'pinnacle' ),
					// 'compiler'=>true, // Use if you want to hook in your own CSS compiler
					'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'text-align' => false,
					'line-height' => true,
					'customizer' => false,
					'color' => true,
					'preview' => true, // Disable the previewer
					'output' => array( 'h5' ),
					'subtitle' => __( 'Choose Size and Style for h5', 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '',
						'font-style' => '400',
						'font-size' => '18px',
						'line-height' => '26px',
					),
				),
				array(
					'id' => 'font_subtitle',
					'type' => 'typography',
					'title' => __( 'Page Subtitle', 'pinnacle' ),
					'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'text-align' => false,
					'customizer' => false,
					'line-height' => true,
					'color' => true,
					'preview' => true, // Disable the previewer
					'output' => array( '.subtitle' ),
					'subtitle' => __( 'Choose Size and Style for Page Subtitle', 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '',
						'font-style' => '400',
						'font-size' => '16px',
						'line-height' => '22px',
					),
				),
				array(
					'id' => 'info_body_font',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Body Font Options', 'pinnacle' ),
				),
				array(
					'id' => 'font_p',
					'type' => 'typography',
					'title' => __( 'Body Font', 'pinnacle' ),
					// 'compiler'=>true, // Use if you want to hook in your own CSS compiler
					'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'line-height' => true,
					'text-align' => false,
					// 'word-spacing'=>false, // Defaults to false
					'all_styles' => true,
					'color' => true,
					'customizer' => false,
					'preview' => true, // Disable the previewer
					'output' => array( 'body' ),
					'subtitle' => __( 'Choose Size and Style for paragraphs', 'pinnacle' ),
					'default' => array(
						'font-family' => '',
						'color' => '',
						'font-style' => '400',
						'font-size' => '14px',
						'line-height' => '20px',
					),
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-reorder',
			'icon_class' => 'icon-large',
			'id' => 'menu_settings',
			'title' => __( 'Menu Settings', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Primary Menu Options', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'info_menu_settings_notice',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( '*NOTE: Make sure Kadence Toolkit plugin is activated* <br>Then go to Apperance > Theme Options > Menu settings for all menu settings', 'pinnacle' ),
				),
				array(
					'id' => 'font_primary_menu',
					'type' => 'typography',
					'title' => __( 'Primary Menu Font', 'pinnacle' ),
					// 'compiler'=>true, // Use if you want to hook in your own CSS compiler
					'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'line-height' => false,
					'text-align' => false,
					'customizer' => false,
					// 'word-spacing'=>false, // Defaults to false
					// 'all_styles' => true,
					'color' => true,
					'preview' => true, // Disable the previewer
					'output' => array( '.is-sticky .kad-primary-nav ul.sf-menu a, ul.sf-menu a, .none-trans-header .kad-primary-nav ul.sf-menu a' ),
					'subtitle' => __( 'Choose Size and Style for primary menu', 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '#444444',
						'font-style' => '400',
						'font-size' => '16px',
					),
				),
				array(
					'id' => 'info_menu_mobile_font',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Mobile Menu Options', 'pinnacle' ),
				),
				array(
					'id' => 'mobile_submenu_collapse',
					'type' => 'switch',
					'customizer' => false,
					'title' => __( 'Submenu items collapse until opened', 'pinnacle' ),
					'default' => 0,
				),
				array(
					'id' => 'font_mobile_menu',
					'type' => 'typography',
					'title' => __( 'Mobile Menu Font', 'pinnacle' ),
					// 'compiler'=>true, // Use if you want to hook in your own CSS compiler
					'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'line-height' => true,
					'customizer' => false,
					'text-align' => false,
					// 'word-spacing'=>false, // Defaults to false
					// 'all_styles' => true,
					'color' => true,
					'preview' => true, // Disable the previewer
					'output' => array( '.kad-nav-inner .kad-mnav, .kad-mobile-nav .kad-nav-inner li a, .kad-mobile-nav .kad-nav-inner li .kad-submenu-accordion' ),
					'subtitle' => __( 'Choose Size and Style for Mobile Menu', 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '',
						'font-style' => '400',
						'font-size' => '16px',
						'line-height' => '20px',
					),
				),
				array(
					'id' => 'info_menu_topbar_font',
					'type' => 'info',
					'customizer' => false,
					'desc' => __( 'Topbar Menu Options', 'pinnacle' ),
				),
				array(
					'id' => 'topbar-menu-font-size',
					'type' => 'typography',
					'title' => __( 'Topbar Menu Font', 'pinnacle' ),
					'font-family' => true,
					'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup' => false, // Select a backup non-google font in addition to a google font
					'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
					'subsets' => true, // Only appears if google is true and subsets not set to false
					'font-size' => true,
					'line-height' => false,
					'text-align' => false,
					'customizer' => false,
					'color' => true,
					'preview' => true, // Disable the previewer
					'output' => array( '#topbar ul.sf-menu > li > a, #topbar .top-menu-cart-btn, #topbar .top-menu-search-btn, #topbar .nav-trigger-case .kad-navbtn, #topbar .topbarsociallinks li a' ),
					'subtitle' => __( 'Choose Size and Style for topbar menu', 'pinnacle' ),
					'default' => array(
						'font-family' => 'Raleway',
						'color' => '',
						'font-style' => '400',
						'font-size' => '11px',
					),
				),
			),
		)
	);

	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-wrench',
			'icon_class' => 'icon-large',
			'id' => 'misc_settings',
			'title' => __( 'Misc Settings', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Misc Settings', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'footer_text',
					'type' => 'textarea',
					'customizer' => true,
					'title' => __( 'Footer Copyright Text', 'pinnacle' ),
					'subtitle' => __( 'Write your own copyright text here. You can use the following shortcodes in your footer text: [copyright] [site-name] [the-year]', 'pinnacle' ),
					'default' => '[copyright] [the-year] [site-name] [theme-credit]',
				),
				array(
					'id' => 'info_search_sidebars',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Search Results Sidebars', 'pinnacle' ),
				),
				array(
					'id' => 'search_sidebar',
					'type' => 'select',
					'title' => __( 'Search Results - choose Sidebar', 'pinnacle' ),
					'data' => 'sidebars',
					'customizer' => true,
					'default' => 'sidebar-primary',
					'width' => 'width:60%',
				),
				array(
					'id' => 'info_sidebars',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'Create Sidebars', 'pinnacle' ),
				),
				array(
					'id' => 'cust_sidebars',
					'type' => 'multi_text',
					'customizer' => true,
					'title' => __( 'Create Custom Sidebars', 'pinnacle' ),
					'subtitle' => __( 'Type new sidebar name into textbox', 'pinnacle' ),
					'default' => __( 'Extra Sidebar', 'pinnacle' ),
				),
				array(
					'id' => 'info_wpgallerys',
					'type' => 'info',
					'customizer' => true,
					'desc' => __( 'WordPress Galleries', 'pinnacle' ),
				),
				array(
					'id' => 'pinnacle_gallery',
					'type' => 'switch',
					'customizer' => true,
					'title' => __( 'Enable Pinnacle Galleries to override WordPress', 'pinnacle' ),
					'subtitle' => __( 'You must have Kadence toolkit installed to use.', 'pinnacle' ),
					'default' => 1,
				),
				array(
					'id' => 'info_gmaps',
					'type' => 'info',
					'desc' => __( 'Theme Google Maps', 'pinnacle' ),
				),
				array(
					'id' => 'google_map_api',
					'type' => 'text',
					'title' => __( 'Google Map API', 'pinnacle' ),
					'subtitle' => __( 'For best performance add your own API for google maps.', 'pinnacle' ),
					'description' => '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">Get an API code Here</a>',
					'default' => '',
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'icon' => 'icon-code',
			'icon_class' => 'icon-large',
			'id' => 'custom_css',
			'title' => __( 'Custom CSS', 'pinnacle' ),
			'desc' => "<div class='redux-info-field'><h3>" . __( 'Custom CSS Box', 'pinnacle' ) . '</h3></div>',
			'fields' => array(
				array(
					'id' => 'custom_css',
					'type' => 'textarea',
					'customizer' => true,
					'title' => __( 'Custom CSS', 'pinnacle' ),
					'subtitle' => __( 'Quickly add some CSS to your theme by adding it to this block.', 'pinnacle' ),
					'validate' => 'css',
				),
			),
		)
	);
	Redux::setSection(
		$opt_name,
		array(
			'id' => 'inportexport_settings',
			'title'  => __( 'Import / Export', 'pinnacle' ),
			'desc'   => __( 'Import and Export your Theme Options from text or URL.', 'pinnacle' ),
			'icon'   => 'icon-large icon-hdd',
			'fields' => array(
				array(
					'id'         => 'opt-import-export',
					'type'       => 'import_export',
					'title'      => '',
					'customizer' => false,
					'subtitle'   => '',
					'full_width' => true,
				),
			),
		)
	);

	function kadence_override_redux_icons_css() {
		wp_dequeue_style( 'redux-admin-css' );
		wp_register_style( 'pinncale-redux-custom-css', get_template_directory_uri() . '/themeoptions/options_assets/css/style.css', false, 134 );
		wp_enqueue_style( 'pinncale-redux-custom-css' );
		wp_dequeue_style( 'select2-css' );
		wp_dequeue_script( 'select2-js' );
		wp_dequeue_style( 'redux-elusive-icon' );
		wp_dequeue_style( 'redux-elusive-icon-ie7' );
	}

	add_action( 'redux-enqueue-pinnacle', 'kadence_override_redux_icons_css' );

	function pinnacle_remove_demo() {

		// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter(
				'plugin_row_meta',
				array(
					ReduxFrameworkPlugin::instance(),
					'plugin_metalinks',
				),
				null,
				2
			);

			// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
		}
	}

