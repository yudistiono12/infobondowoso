<?php
/**
 * Class: LaStudioKit_Nav_Menu
 * Name: Nav Menu
 * Slug: lakit-nav-menu
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LaStudioKit_Nav_Menu extends LaStudioKit_Base {

    protected function enqueue_addon_resources(){
        wp_register_style( $this->get_name(), lastudio_kit()->plugin_url('assets/css/addons/nav-menu.css'), ['lastudio-kit-base'], lastudio_kit()->get_version());
        wp_register_script( $this->get_name(), lastudio_kit()->plugin_url('assets/js/addons/nav-menu.js'), ['hoverIntent', 'lastudio-kit-base'], lastudio_kit()->get_version(), true);

        $this->add_style_depends( $this->get_name() );
        $this->add_script_depends( $this->get_name() );
    }

	public function get_name() {
		return 'lakit-nav-menu';
	}

	public function get_widget_title() {
		return esc_html__( 'Nav Menu', 'lastudio-kit' );
	}

	public function get_icon() {
		return 'lastudio-kit-icon-nav-menu';
	}

    protected function register_controls() {

        $this->_start_controls_section(
            'section_menu',
            array(
                'label' => esc_html__( 'Menu', 'lastudio-kit' ),
            )
        );

        $menus   = $this->get_available_menus();
        $default = '';

        if ( ! empty( $menus ) ) {
            $ids     = array_keys( $menus );
            $default = $ids[0];
        }

        $this->_add_control(
            'nav_menu',
            array(
                'label'   => esc_html__( 'Select Menu', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => $default,
                'options' => $menus,
            )
        );

        $this->_add_control(
            'layout',
            array(
                'label'   => esc_html__( 'Layout', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => array(
                    'horizontal' => esc_html__( 'Horizontal', 'lastudio-kit' ),
                    'vertical'   => esc_html__( 'Vertical', 'lastudio-kit' ),
                ),
            )
        );

        $this->_add_control(
            'dropdown_position',
            array(
                'label'   => esc_html__( 'Dropdown Placement', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right-side',
                'options' => array(
                    'left-side'  => esc_html__( 'Left Side', 'lastudio-kit' ),
                    'right-side' => esc_html__( 'Right Side', 'lastudio-kit' ),
                    'bottom'     => esc_html__( 'At the bottom', 'lastudio-kit' ),
                ),
                'condition' => array(
                    'layout' => 'vertical',
                )
            )
        );

        $this->_add_control(
            'dropdown_icon',
            array(
                'label'   => esc_html__( 'Dropdown Icon', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'fa fa-angle-down',
                'options' => $this->dropdown_arrow_icons_list(),
            )
        );

        $this->_add_control(
            'show_items_desc',
            array(
                'label'   => esc_html__( 'Show Items Description', 'lastudio-kit' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->_add_responsive_control(
            'menu_alignment',
            array(
                'label'   => esc_html__( 'Menu Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'flex-start',
                'options' => array(
                    'flex-start' => array(
                        'title' => esc_html__( 'Left', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Right', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-right',
                    ),
                    'space-between' => array(
                        'title' => esc_html__( 'Justified', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-stretch',
                    ),
                ),
                'selectors_dictionary' => array(
                    'flex-start'    => 'justify-content: flex-start; text-align: left;',
                    'center'        => 'justify-content: center; text-align: center;',
                    'flex-end'      => 'justify-content: flex-end; text-align: right;',
                    'space-between' => 'justify-content: space-between; text-align: left;',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav--horizontal' => '{{VALUE}}',
                    '{{WRAPPER}} .lakit-nav--vertical .menu-item-link-top' => '{{VALUE}}',
                    '{{WRAPPER}} .lakit-nav--vertical-sub-bottom .menu-item-link-sub' => '{{VALUE}}',

                    '(mobile){{WRAPPER}} .lakit-mobile-menu .menu-item-link' => '{{VALUE}}',
                ),
                'prefix_class' => 'lakit-nav%s-align-',
            )
        );

        $this->_add_control(
            'menu_alignment_style',
            array(
                'type'       => Controls_Manager::HIDDEN,
                'default'    => 'style',
                'selectors'  => array(
                    'body:not(.rtl) {{WRAPPER}} .lakit-nav--horizontal .lakit-nav__sub' => 'text-align: left;',
                    'body.rtl {{WRAPPER}} .lakit-nav--horizontal .lakit-nav__sub' => 'text-align: right;',
                ),
                'condition' => array(
                    'layout' => 'horizontal',
                ),
            )
        );

        $this->_add_control(
            'mobile_trigger_visible',
            array(
                'label'     => esc_html__( 'Enable Mobile Trigger', 'lastudio-kit' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'mobile_trigger_alignment',
            array(
                'label'   => esc_html__( 'Mobile Trigger Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => array(
                    'left' => array(
                        'title' => esc_html__( 'Left', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-right',
                    ),
                ),
                'condition' => array(
                    'mobile_trigger_visible' => 'yes',
                ),
            )
        );

        $this->_add_advanced_icon_control(
            'mobile_trigger_icon',
            array(
                'label'       => esc_html__( 'Mobile Trigger Icon', 'lastudio-kit' ),
                'label_block' => false,
                'type'        => Controls_Manager::ICON,
                'skin'        => 'inline',
                'default'     => 'fa fa-bars',
                'fa5_default' => array(
                    'value'   => 'fas fa-bars',
                    'library' => 'fa-solid',
                ),
                'condition'   => array(
                    'mobile_trigger_visible' => 'yes',
                ),
            )
        );

        $this->_add_advanced_icon_control(
            'mobile_trigger_close_icon',
            array(
                'label'       => esc_html__( 'Mobile Trigger Close Icon', 'lastudio-kit' ),
                'label_block' => false,
                'type'        => Controls_Manager::ICON,
                'skin'        => 'inline',
                'default'     => 'fa fa-times',
                'fa5_default' => array(
                    'value'   => 'fas fa-times',
                    'library' => 'fa-solid',
                ),
                'condition'   => array(
                    'mobile_trigger_visible' => 'yes',
                ),
            )
        );

        $this->_add_control(
            'mobile_menu_layout',
            array(
                'label' => esc_html__( 'Mobile Menu Layout', 'lastudio-kit' ),
                'type'  => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => array(
                    'default'    => esc_html__( 'Default', 'lastudio-kit' ),
                    'full-width' => esc_html__( 'Full Width', 'lastudio-kit' ),
                    'left-side'  => esc_html__( 'Slide From The Left Side ', 'lastudio-kit' ),
                    'right-side' => esc_html__( 'Slide From The Right Side ', 'lastudio-kit' ),
                ),
                'condition' => array(
                    'mobile_trigger_visible' => 'yes',
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'nav_items_style',
            array(
                'label'      => esc_html__( 'Top Level Items', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_responsive_control(
            'nav_vertical_menu_width',
            array(
                'label' => esc_html__( 'Vertical Menu Width', 'lastudio-kit' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range' => array(
                    'px' => array(
                        'min' => 100,
                        'max' => 1000,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav-wrap' => 'width: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'layout' => 'vertical',
                ),
            ),
            50
        );

        $this->_add_responsive_control(
            'nav_vertical_menu_align',
            array(
                'label'       => esc_html__( 'Vertical Menu Alignment', 'lastudio-kit' ),
                'label_block' => true,
                'type'        => Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array(
                        'title' => esc_html__( 'Left', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-right',
                    ),
                ),
                'selectors_dictionary' => array(
                    'left'   => 'margin-left: 0; margin-right: auto;',
                    'center' => 'margin-left: auto; margin-right: auto;',
                    'right'  => 'margin-left: auto; margin-right: 0;',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav-wrap' => '{{VALUE}}',
                ),
                'condition'  => array(
                    'layout' => 'vertical',
                ),
            ),
            50
        );

        $this->_start_controls_tabs( 'tabs_nav_items_style' );

        $this->_start_controls_tab(
            'nav_items_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'nav_items_bg_color',
            array(
                'label'  => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item-link-top' => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'nav_items_color',
            array(
                'label'  => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item-link-top' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'nav_items_text_bg_color',
            array(
                'label'  => esc_html__( 'Text Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item-link-top .lakit-nav-link-text' => 'background-color: {{VALUE}}',
                ),
            ),
            75
        );

        $this->_add_control(
            'nav_items_text_icon_color',
            array(
                'label'  => esc_html__( 'Dropdown Icon Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item-link-top .lakit-nav-arrow' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'nav_items_typography',
                'selector' => '{{WRAPPER}} .menu-item-link-top .lakit-nav-link-text',
            ),
            50
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'nav_items_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'nav_items_bg_color_hover',
            array(
                'label'  => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item:hover > .menu-item-link-top' => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'nav_items_color_hover',
            array(
                'label'  => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item:hover > .menu-item-link-top' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'nav_items_text_bg_color_hover',
            array(
                'label'  => esc_html__( 'Text Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item:hover > .menu-item-link-top .lakit-nav-link-text' => 'background-color: {{VALUE}}',
                ),
            ),
            75
        );

        $this->_add_control(
            'nav_items_hover_border_color',
            array(
                'label' => esc_html__( 'Border Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'condition' => array(
                    'nav_items_border_border!' => '',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .menu-item:hover > .menu-item-link-top' => 'border-color: {{VALUE}};',
                ),
            ),
            75
        );

        $this->_add_control(
            'nav_items_text_icon_color_hover',
            array(
                'label'  => esc_html__( 'Dropdown Icon Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item:hover > .menu-item-link-top .lakit-nav-arrow' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'nav_items_typography_hover',
                'selector' => '{{WRAPPER}} .menu-item:hover > .menu-item-link-top .lakit-nav-link-text',
            ),
            50
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'nav_items_active',
            array(
                'label' => esc_html__( 'Active', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'nav_items_bg_color_active',
            array(
                'label'  => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top' => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'nav_items_color_active',
            array(
                'label'  => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'nav_items_text_bg_color_active',
            array(
                'label'  => esc_html__( 'Text Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top .lakit-nav-link-text' => 'background-color: {{VALUE}}',
                ),
            ),
            75
        );

        $this->_add_control(
            'nav_items_active_border_color',
            array(
                'label' => esc_html__( 'Border Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'condition' => array(
                    'nav_items_border_border!' => '',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top' => 'border-color: {{VALUE}};',
                ),
            ),
            75
        );

        $this->_add_control(
            'nav_items_text_icon_color_active',
            array(
                'label'  => esc_html__( 'Dropdown Icon Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top .lakit-nav-arrow' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'nav_items_typography_active',
                'selector' => '{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top .lakit-nav-link-text',
            ),
            50
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_responsive_control(
            'nav_items_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .menu-item-link-top' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            ),
            25
        );

        $this->_add_responsive_control(
            'nav_items_margin',
            array(
                'label'      => esc_html__( 'Margin', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-nav > .lakit-nav__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'nav_items_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} .menu-item-link-top',
            ),
            75
        );

        $this->_add_responsive_control(
            'nav_items_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .menu-item-link-top' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            75
        );

        $this->_add_responsive_control(
            'nav_items_icon_size',
            array(
                'label'      => esc_html__( 'Dropdown Icon Size', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'condition' => array(
                    'dropdown_icon!' => '',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .menu-item-link-top .lakit-nav-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            ),
            50
        );

        $this->_add_responsive_control(
            'nav_items_icon_gap',
            array(
                'label'      => esc_html__( 'Gap Before Dropdown Icon', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
                'condition' => array(
                    'dropdown_icon!' => '',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .menu-item-link-top .lakit-nav-arrow' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lakit-nav--vertical-sub-left-side .menu-item-link-top .lakit-nav-arrow' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',

                    '(mobile){{WRAPPER}} .lakit-mobile-menu .lakit-nav--vertical-sub-left-side .menu-item-link-top .lakit-nav-arrow' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
                ),
            ),
            50
        );

        $this->_add_control(
            'nav_items_desc_heading',
            array(
                'label'     => esc_html__( 'Description', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'show_items_desc' => 'yes',
                ),
            ),
            50
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'      => 'nav_items_desc_typography',
                'selector'  => '{{WRAPPER}} .menu-item-link-top .lakit-nav-item-desc',
                'condition' => array(
                    'show_items_desc' => 'yes',
                ),
            ),
            50
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'sub_items_style',
            array(
                'label'      => esc_html__( 'Dropdown', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_control(
            'sub_items_container_style_heading',
            array(
                'label' => esc_html__( 'Container Styles', 'lastudio-kit' ),
                'type'  => Controls_Manager::HEADING,
            ),
            25
        );

        $this->_add_responsive_control(
            'sub_items_container_width',
            array(
                'label'      => esc_html__( 'Container Width', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 100,
                        'max' => 500,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav__sub' => 'width: {{SIZE}}{{UNIT}};',
                ),
                'conditions' => array(
                    'relation' => 'or',
                    'terms' => array(
                        array(
                            'name'     => 'layout',
                            'operator' => '===',
                            'value'    => 'horizontal',
                        ),
                        array(
                            'relation' => 'and',
                            'terms' => array(
                                array(
                                    'name'     => 'layout',
                                    'operator' => '===',
                                    'value'    => 'vertical',
                                ),
                                array(
                                    'name'     => 'dropdown_position',
                                    'operator' => '!==',
                                    'value'    => 'bottom',
                                )
                            ),
                        ),
                    ),
                ),
            ),
            25
        );

        $this->_add_control(
            'sub_items_container_bg_color',
            array(
                'label'  => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav__sub' => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'sub_items_container_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} .lakit-nav__sub',
            ),
            75
        );

        $this->_add_responsive_control(
            'sub_items_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-nav__sub' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .lakit-nav__sub > .menu-item:first-child > .menu-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
                    '{{WRAPPER}} .lakit-nav__sub > .menu-item:last-child > .menu-item-link' => 'border-radius: 0 0 {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            75
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'sub_items_container_box_shadow',
                'selector' => '{{WRAPPER}} .lakit-nav__sub',
            ),
            75
        );


        $this->_add_responsive_control(
            'sub_items_container_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-nav__sub' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            25
        );

        $this->_add_responsive_control(
            'sub_items_container_top_gap',
            array(
                'label'      => esc_html__( 'Gap Before 1st Level Sub', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-nav--horizontal .lakit-nav-depth-0' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lakit-nav--vertical-sub-left-side .lakit-nav-depth-0' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lakit-nav--vertical-sub-right-side .lakit-nav-depth-0' => 'margin-left: {{SIZE}}{{UNIT}};',
                ),
                'conditions' => array(
                    'relation' => 'or',
                    'terms' => array(
                        array(
                            'name'     => 'layout',
                            'operator' => '===',
                            'value'    => 'horizontal',
                        ),
                        array(
                            'relation' => 'and',
                            'terms' => array(
                                array(
                                    'name'     => 'layout',
                                    'operator' => '===',
                                    'value'    => 'vertical',
                                ),
                                array(
                                    'name'     => 'dropdown_position',
                                    'operator' => '!==',
                                    'value'    => 'bottom',
                                )
                            ),
                        ),
                    ),
                ),
            ),
            50
        );

        $this->_add_responsive_control(
            'sub_items_container_left_gap',
            array(
                'label'      => esc_html__( 'Gap Before 2nd Level Sub', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-nav-depth-0 .lakit-nav__sub' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lakit-nav--vertical-sub-left-side .lakit-nav-depth-0 .lakit-nav__sub' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
                ),
                'conditions' => array(
                    'relation' => 'or',
                    'terms' => array(
                        array(
                            'name'     => 'layout',
                            'operator' => '===',
                            'value'    => 'horizontal',
                        ),
                        array(
                            'relation' => 'and',
                            'terms' => array(
                                array(
                                    'name'     => 'layout',
                                    'operator' => '===',
                                    'value'    => 'vertical',
                                ),
                                array(
                                    'name'     => 'dropdown_position',
                                    'operator' => '!==',
                                    'value'    => 'bottom',
                                )
                            ),
                        ),
                    ),
                ),
            ),
            50
        );

        $this->_add_control(
            'sub_items_style_heading',
            array(
                'label'     => esc_html__( 'Items Styles', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'sub_items_typography',
                'selector' => '{{WRAPPER}} .menu-item-link-sub .lakit-nav-link-text',
            ),
            50
        );

        $this->_start_controls_tabs( 'tabs_sub_items_style' );

        $this->_start_controls_tab(
            'sub_items_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'sub_items_bg_color',
            array(
                'label'  => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item-link-sub' => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'sub_items_color',
            array(
                'label'  => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item-link-sub' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'sub_items_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'sub_items_bg_color_hover',
            array(
                'label'  => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item:hover > .menu-item-link-sub' => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'sub_items_color_hover',
            array(
                'label'  => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item:hover > .menu-item-link-sub' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'sub_items_active',
            array(
                'label' => esc_html__( 'Active', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'sub_items_bg_color_active',
            array(
                'label'  => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item.current-menu-item > .menu-item-link-sub' => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'sub_items_color_active',
            array(
                'label'  => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .menu-item.current-menu-item > .menu-item-link-sub' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_responsive_control(
            'sub_items_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .menu-item-link-sub' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            ),
            25
        );
        $this->_add_responsive_control(
            'sub_items_margin',
            array(
                'label'      => esc_html__( 'Margin', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .menu-item-link-sub' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            ),
            25
        );

        $this->_add_responsive_control(
            'sub_items_icon_size',
            array(
                'label'      => esc_html__( 'Dropdown Icon Size', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'condition' => array(
                    'dropdown_icon!' => '',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .menu-item-link-sub .lakit-nav-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            ),
            50
        );

        $this->_add_responsive_control(
            'sub_items_icon_gap',
            array(
                'label'      => esc_html__( 'Gap Before Dropdown Icon', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
                'condition' => array(
                    'dropdown_icon!' => '',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .menu-item-link-sub .lakit-nav-arrow' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .lakit-nav--vertical-sub-left-side .menu-item-link-sub .lakit-nav-arrow' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',

                    '(mobile){{WRAPPER}} .lakit-mobile-menu .lakit-nav--vertical-sub-left-side .menu-item-link-sub .lakit-nav-arrow' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
                ),
            ),
            50
        );

        $this->_add_control(
            'sub_items_divider_heading',
            array(
                'label'     => esc_html__( 'Divider', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ),
            75
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'sub_items_divider',
                'selector' => '{{WRAPPER}} .lakit-nav__sub > .lakit-nav-item-sub:not(:last-child)',
                'exclude'  => array( 'width' ),
            ),
            75
        );

        $this->_add_control(
            'sub_items_divider_width',
            array(
                'label' => esc_html__( 'Border Width', 'lastudio-kit' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 50,
                    ),
                ),
                'default' => array(
                    'size' => 1,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav__sub > .lakit-nav-item-sub:not(:last-child)' => 'border-width: 0; border-bottom-width: {{SIZE}}{{UNIT}}',
                ),
                'condition' => array(
                    'sub_items_divider_border!' => '',
                ),
            ),
            75
        );

        $this->_add_control(
            'sub_items_desc_heading',
            array(
                'label'     => esc_html__( 'Description', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'show_items_desc' => 'yes',
                ),
            ),
            50
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'      => 'sub_items_desc_typography',
                'selector'  => '{{WRAPPER}} .menu-item-link-sub .lakit-nav-item-desc',
                'condition' => array(
                    'show_items_desc' => 'yes',
                ),
            ),
            50
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'mobile_trigger_styles',
            array(
                'label'      => esc_html__( 'Mobile Trigger', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_start_controls_tabs( 'tabs_mobile_trigger_style' );

        $this->_start_controls_tab(
            'mobile_trigger_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'mobile_trigger_bg_color',
            array(
                'label'  => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav__mobile-trigger' => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'mobile_trigger_color',
            array(
                'label'  => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav__mobile-trigger' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'mobile_trigger_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'mobile_trigger_bg_color_hover',
            array(
                'label'  => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav__mobile-trigger:hover' => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'mobile_trigger_color_hover',
            array(
                'label'  => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav__mobile-trigger:hover' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'mobile_trigger_hover_border_color',
            array(
                'label' => esc_html__( 'Border Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'condition' => array(
                    'mobile_trigger_border_border!' => '',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav__mobile-trigger:hover' => 'border-color: {{VALUE}};',
                ),
            ),
            75
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'mobile_trigger_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} .lakit-nav__mobile-trigger',
                'separator'   => 'before',
            ),
            75
        );

        $this->_add_control(
            'mobile_trigger_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-nav__mobile-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            75
        );

        $this->_add_control(
            'mobile_trigger_width',
            array(
                'label'      => esc_html__( 'Width', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 20,
                        'max' => 200,
                    ),
                    '%' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-nav__mobile-trigger' => 'width: {{SIZE}}{{UNIT}};',
                ),
                'separator' => 'before',
            ),
            50
        );

        $this->_add_control(
            'mobile_trigger_height',
            array(
                'label'      => esc_html__( 'Height', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 20,
                        'max' => 200,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-nav__mobile-trigger' => 'height: {{SIZE}}{{UNIT}};',
                ),
            ),
            50
        );

        $this->_add_control(
            'mobile_trigger_icon_size',
            array(
                'label'      => esc_html__( 'Icon Size', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-nav__mobile-trigger' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            ),
            50
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'mobile_menu_styles',
            array(
                'label' => esc_html__( 'Mobile Menu', 'lastudio-kit' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->_add_control(
            'mobile_menu_width',
            array(
                'label' => esc_html__( 'Width', 'lastudio-kit' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range' => array(
                    'px' => array(
                        'min' => 150,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => 30,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '(mobile){{WRAPPER}} .lakit-nav' => 'width: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'mobile_menu_layout' => array(
                        'left-side',
                        'right-side',
                    ),
                ),
            ),
            25
        );

        $this->_add_control(
            'mobile_menu_max_height',
            array(
                'label' => esc_html__( 'Max Height', 'lastudio-kit' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'vh' ),
                'range' => array(
                    'px' => array(
                        'min' => 100,
                        'max' => 500,
                    ),
                    'vh' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '(mobile){{WRAPPER}} .lakit-nav' => 'max-height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'mobile_menu_layout' => 'full-width',
                ),
            ),
            25
        );

        $this->_add_control(
            'mobile_menu_bg_color',
            array(
                'label' => esc_html__( 'Background color', 'lastudio-kit' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '(mobile){{WRAPPER}} .lakit-nav' => 'background-color: {{VALUE}};',
                ),
            ),
            25
        );

        $this->_add_control(
            'mobile_menu_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '(mobile){{WRAPPER}} .lakit-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'mobile_menu_box_shadow',
                'selector' => '(mobile){{WRAPPER}} .lakit-mobile-menu-active .lakit-nav',
            ),
            75
        );

        $this->_add_control(
            'mobile_close_icon_heading',
            array(
                'label' => esc_html__( 'Close icon', 'lastudio-kit' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'mobile_menu_layout' => array(
                        'left-side',
                        'right-side',
                    ),
                ),
            ),
            25
        );

        $this->_add_control(
            'mobile_close_icon_color',
            array(
                'label' => esc_html__( 'Color', 'lastudio-kit' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav__mobile-close-btn' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'mobile_menu_layout' => array(
                        'left-side',
                        'right-side',
                    ),
                ),
            ),
            25
        );

        $this->_add_control(
            'mobile_close_icon_font_size',
            array(
                'label' => esc_html__( 'Font size', 'lastudio-kit' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range' => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .lakit-nav__mobile-close-btn' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'mobile_menu_layout' => array(
                        'left-side',
                        'right-side',
                    ),
                ),
            ),
            50
        );

        $this->_end_controls_section();
    }

    /**
     * Returns available icons for dropdown list
     *
     * @return array
     */
    public function dropdown_arrow_icons_list() {

        return apply_filters( 'lastudio-kit/nav-menu/dropdown-icons', array(
            'fa fa-angle-down'          => esc_html__( 'Angle', 'lastudio-kit' ),
            'fa fa-angle-double-down'   => esc_html__( 'Angle Double', 'lastudio-kit' ),
            'fa fa-chevron-down'        => esc_html__( 'Chevron', 'lastudio-kit' ),
            'fa fa-chevron-circle-down' => esc_html__( 'Chevron Circle', 'lastudio-kit' ),
            'fa fa-caret-down'          => esc_html__( 'Caret', 'lastudio-kit' ),
            'fa fa-plus'                => esc_html__( 'Plus', 'lastudio-kit' ),
            'fa fa-plus-square-o'       => esc_html__( 'Plus Square', 'lastudio-kit' ),
            'fa fa-plus-circle'         => esc_html__( 'Plus Circle', 'lastudio-kit' ),
            ''                          => esc_html__( 'None', 'lastudio-kit' ),
        ) );

    }

    /**
     * Get available menus list
     *
     * @return array
     */
    public function get_available_menus() {

        $raw_menus = wp_get_nav_menus();
        $menus     = wp_list_pluck( $raw_menus, 'name', 'term_id' );

        return $menus;
    }

    protected function render() {

        $settings = $this->get_settings();

        if ( ! $settings['nav_menu'] ) {
            return;
        }

        $trigger_visible = filter_var( $settings['mobile_trigger_visible'], FILTER_VALIDATE_BOOLEAN );
        $trigger_align   = $settings['mobile_trigger_alignment'];

        require_once lastudio_kit()->plugin_path( 'includes/class-nav-walker.php' );

        $this->add_render_attribute( 'nav-wrapper', 'class', 'lakit-nav-wrap' );

        if ( $trigger_visible ) {
            $this->add_render_attribute( 'nav-wrapper', 'class', 'lakit-mobile-menu' );

            if ( isset( $settings['mobile_menu_layout'] ) ) {
                $this->add_render_attribute( 'nav-wrapper', 'class', sprintf( 'lakit-mobile-menu--%s', esc_attr( $settings['mobile_menu_layout'] ) ) );
                $this->add_render_attribute( 'nav-wrapper', 'data-mobile-layout', esc_attr( $settings['mobile_menu_layout'] ) );
            }
        }

        $this->add_render_attribute( 'nav-menu', 'class', 'lakit-nav' );

        if ( isset( $settings['layout'] ) ) {
            $this->add_render_attribute( 'nav-menu', 'class', 'lakit-nav--' . esc_attr( $settings['layout'] ) );

            if ( 'vertical' === $settings['layout'] && isset( $settings['dropdown_position'] ) ) {
                $this->add_render_attribute( 'nav-menu', 'class', 'lakit-nav--vertical-sub-' . esc_attr( $settings['dropdown_position'] ) );
            }
        }

        $menu_html = '<div ' . $this->get_render_attribute_string( 'nav-menu' ) . '>%3$s</div>';

        if ( $trigger_visible && in_array( $settings['mobile_menu_layout'], array( 'left-side', 'right-side' ) ) ) {
            $close_btn = $this->_get_icon( 'mobile_trigger_close_icon', '<div class="lakit-nav__mobile-close-btn lakit-blocks-icon">%s</div>' );

            $menu_html = '<div ' . $this->get_render_attribute_string( 'nav-menu' ) . '>%3$s' . $close_btn . '</div>';
        }

        $args = array(
            'menu'            => $settings['nav_menu'],
            'fallback_cb'     => '',
            'items_wrap'      => $menu_html,
            'walker'          => new \LaStudio_Kit_Nav_Walker,
            'widget_settings' => array(
                'dropdown_icon'   => $settings['dropdown_icon'],
                'show_items_desc' => $settings['show_items_desc'],
            ),
        );

        echo '<div ' . $this->get_render_attribute_string( 'nav-wrapper' ) . '>';
        if ( $trigger_visible ) {
            include $this->_get_global_template( 'mobile-trigger' );
        }
        wp_nav_menu( $args );
        echo '</div>';

    }

}
