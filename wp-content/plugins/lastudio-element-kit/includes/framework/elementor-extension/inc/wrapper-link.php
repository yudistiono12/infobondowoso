<?php

namespace LaStudioKit_Extension\Modules;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Wrapper_Link {
    public function __construct() {
        add_action('elementor/element/after_section_end', [ $this, 'init_module'], 10, 2);
        add_action('elementor/frontend/after_register_styles', [ $this, 'register_enqueue_scripts']);
        add_action('elementor/frontend/before_render', [ $this, 'enqueue_in_widget']);
    }

    public function register_enqueue_scripts(){
        wp_register_script( 'lastudio-kit-wrapper-links', lastudio_kit()->plugin_url('assets/js/addons/wrapper-links.min.js'), [], lastudio_kit()->get_version(), true);
    }

    public function enqueue_in_widget( $element ) {
        $link_settings = $element->get_settings_for_display('lakit_element_link');
        if (!empty($link_settings) && !empty($link_settings['url'])) {
            $element->add_render_attribute('_wrapper', [
                'data-lakit-element-link' => json_encode($link_settings),
                'style' => 'cursor: pointer'
            ]);
            $element->add_script_depends('lastudio-kit-wrapper-links');
        }
    }

    public function init_module( $controls_stack, $section_id ){
        $stack_name = $controls_stack->get_name();
        if( (($stack_name === 'column' || $stack_name === 'section') && $section_id === 'section_advanced') || ($stack_name === 'common' && $section_id === '_section_style') ){
            $tabs = \Elementor\Controls_Manager::TAB_CONTENT;
            if($stack_name === 'column' || $stack_name === 'section'){
                $tabs = \Elementor\Controls_Manager::TAB_LAYOUT;
            }
            $controls_stack->start_controls_section(
                '_section_lakit_wrapper_link',
                [
                    'label' => __( 'LA-Kit Wrapper Link', 'lastudio' ),
                    'tab'   => $tabs,
                ]
            );
            $controls_stack->add_control(
                'lakit_element_link',
                [
                    'label'       => __( 'Link', 'lastudio' ),
                    'type'        => \Elementor\Controls_Manager::URL,
                    'dynamic'     => [
                        'active' => true,
                    ],
                    'placeholder' => 'https://example.com',
                ]
            );
            $controls_stack->end_controls_section();
        }
    }
}

new Wrapper_Link();