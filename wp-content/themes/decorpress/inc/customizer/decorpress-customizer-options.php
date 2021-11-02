<?php
/**
 * Customizer section options.
 *
 * @package decorpress
 *
 */

function decorpress_customizer_theme_settings( $wp_customize ){
	
	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';	
		
		$wp_customize->add_setting(
			'arilewp_footer_copright_text',
			array(
				'sanitize_callback' =>  'decorpress_sanitize_text',
				'default' => __('Copyright &copy; 2021 | Powered by <a href="//wordpress.org/">WordPress</a> <span class="sep"> | </span> DecorPress theme by <a target="_blank" href="//themearile.com/">ThemeArile</a>', 'decorpress'),
				'transport'         => $selective_refresh,
			)	
		);
		$wp_customize->add_control('arilewp_footer_copright_text', array(
				'label' => esc_html__('Footer Copyright','decorpress'),
				'section' => 'arilewp_footer_copyright',
				'priority'        => 10,
				'type'    =>  'textarea'
		));

}
add_action( 'customize_register', 'decorpress_customizer_theme_settings' );

function decorpress_sanitize_text( $input ) {
		return wp_kses_post( force_balance_tags( $input ) );
}