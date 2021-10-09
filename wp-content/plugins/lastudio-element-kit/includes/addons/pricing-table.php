<?php

/**
 * Class: LaStudioKit_Pricing_Table
 * Name: Pricing Table
 * Slug: lakit-pricing-table
 */

namespace Elementor;

if (!defined('WPINC')) {
    die;
}


/**
 * Pricing_Table Widget
 */
class LaStudioKit_Pricing_Table extends LaStudioKit_Base {

    protected function enqueue_addon_resources(){
        wp_register_style( $this->get_name(), lastudio_kit()->plugin_url('assets/css/addons/pricing-table.css'), ['lastudio-kit-base'], lastudio_kit()->get_version());
        $this->add_style_depends( $this->get_name() );
    }

    public function get_name() {
        return 'lakit-pricing-table';
    }

    protected function get_widget_title() {
        return esc_html__( 'Pricing Table', 'lastudio-kit' );
    }

    public function get_icon() {
        return 'lastudio-kit-icon-pricingtable';
    }

    protected function register_controls() {

        $this->_start_controls_section(
            'section_general',
            array(
                'label' => esc_html__( 'General', 'lastudio-kit' ),
            )
        );

        $this->_add_advanced_icon_control(
            'icon',
            array(
                'label'   => esc_html__( 'Icon', 'lastudio-kit' ),
                'type'    => Controls_Manager::ICONS
            )
        );

        $this->_add_control(
            'title',
            array(
                'label'   => esc_html__( 'Title', 'lastudio-kit' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Title', 'lastudio-kit' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->_add_control(
            'subtitle',
            array(
                'label'   => esc_html__( 'Subtitle', 'lastudio-kit' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Subtitle', 'lastudio-kit' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->_add_control(
            'featured',
            array(
                'label'        => esc_html__( 'Is Featured?', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $this->_add_control(
            'featured_badge',
            array(
                'label'   => esc_html__( 'Featured Badge', 'lastudio-kit' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => array(
                    'url' => lastudio_kit()->plugin_url('assets/images/placeholder-badge.svg'),
                ),
                'condition' => array(
                    'featured' => 'yes',
                ),
            )
        );

        $this->_add_control(
            'featured_position',
            array(
                'label'   => esc_html__( 'Featured Position', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => array(
                    'left'  => esc_html__( 'Left', 'lastudio-kit' ),
                    'right' => esc_html__( 'Right', 'lastudio-kit' ),
                ),
                'condition' => array(
                    'featured' => 'yes',
                ),
            )
        );

        $this->_add_responsive_control(
            'featured_width',
            array(
                'label'      => esc_html__( 'Image Width', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 500
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100
                    ),
                    'em' => array(
                        'min' => 0,
                        'max' => 100
                    ),
                ),
                'condition' => array(
                    'featured' => 'yes'
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .pricing-table__badge' => 'width: {{SIZE}}{{UNIT}};',
                )
            )
        );

        $this->_add_responsive_control(
            'featured_left',
            array(
                'label'      => esc_html__( 'Left Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -200,
                        'max' => 200,
                    ),
                    '%' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'featured_position' => 'left',
                    'featured' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .pricing-table__badge' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ),
            )
        );

        $this->_add_responsive_control(
            'featured_right',
            array(
                'label'      => esc_html__( 'Right Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -200,
                        'max' => 200,
                    ),
                    '%' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'featured_position' => 'right',
                    'featured' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .pricing-table__badge' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ),
            )
        );

        $this->_add_responsive_control(
            'featured_top',
            array(
                'label'      => esc_html__( 'Top Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -200,
                        'max' => 200,
                    ),
                    '%' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .pricing-table__badge' => 'top: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'featured' => 'yes',
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_price',
            array(
                'label' => esc_html__( 'Price', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'price_prefix',
            array(
                'label'   => esc_html__( 'Price Prefix', 'lastudio-kit' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( '$', 'lastudio-kit' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->_add_control(
            'price',
            array(
                'label'   => esc_html__( 'Price Value', 'lastudio-kit' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( '100', 'lastudio-kit' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->_add_control(
            'price_suffix',
            array(
                'label'   => esc_html__( 'Price Suffix', 'lastudio-kit' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( '/per month', 'lastudio-kit' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->_add_control(
            'price_desc',
            array(
                'label' => esc_html__( 'Price Description', 'lastudio-kit' ),
                'type'  => Controls_Manager::TEXTAREA,
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_features',
            array(
                'label' => esc_html__( 'Features', 'lastudio-kit' ),
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_text',
            array(
                'label' => esc_html__( 'Text', 'lastudio-kit' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Feature', 'lastudio-kit' ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $repeater->add_control(
            'item_included',
            array(
                'label'   => esc_html__( 'Is Included?', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'item-included',
                'options' => array(
                    'item-included'=> esc_html__( 'Included', 'lastudio-kit' ),
                    'item-excluded' => esc_html__( 'Excluded', 'lastudio-kit' ),
                ),
            )
        );

        $this->_add_control(
            'features_list',
            array(
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => array(
                    array(
                        'item_text'     => esc_html__( 'Feature #1', 'lastudio-kit' ),
                        'item_included' => 'item-included',
                    ),
                    array(
                        'item_text'     => esc_html__( 'Feature #2', 'lastudio-kit' ),
                        'item_included' => 'item-included',
                    ),
                    array(
                        'item_text'     => esc_html__( 'Feature #3', 'lastudio-kit' ),
                        'item_included' => 'item-excluded',
                    ),
                    array(
                        'item_text'     => esc_html__( 'Feature #4', 'lastudio-kit' ),
                        'item_included' => 'item-excluded',
                    ),
                ),
                'title_field' => '{{{ item_text }}}',
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_action',
            array(
                'label' => esc_html__( 'Action Button', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'button_before',
            array(
                'label'   => esc_html__( 'Text Before Action Button', 'lastudio-kit' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '',
            )
        );

        $this->_add_control(
            'button_text',
            array(
                'label'   => esc_html__( 'Button Text', 'lastudio-kit' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Buy', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'button_url',
            array(
                'label'   => esc_html__( 'Button URL', 'lastudio-kit' ),
                'type'    => Controls_Manager::URL,
                'dynamic' => array(
                    'active' => true
                ),
            )
        );

        $this->_add_control(
            'button_after',
            array(
                'label'   => esc_html__( 'Text After Action Button', 'lastudio-kit' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '',
            )
        );

        $this->_end_controls_section();

        $css_scheme = apply_filters(
            'LaStudioElement/pricing-table/css-scheme',
            array(
                'table'         => '.pricing-table',
                'header'        => '.pricing-table__heading',
                'icon_wrap'     => '.pricing-table__icon',
                'icon_box'      => '.pricing-table__icon-box',
                'icon'          => '.pricing-table__icon-box > *',
                'title'         => '.pricing-table__title',
                'subtitle'      => '.pricing-table__subtitle',
                'price'         => '.pricing-table__price',
                'price_prefix'  => '.pricing-table__price-prefix',
                'price_value'   => '.pricing-table__price-val',
                'price_suffix'  => '.pricing-table__price-suffix',
                'price_desc'    => '.pricing-table__price-desc',
                'features'      => '.pricing-table__features',
                'features_item' => '.pricing-feature',
                'included_item' => '.pricing-feature.item-included',
                'excluded_item' => '.pricing-feature.item-excluded',
                'action'        => '.pricing-table__action',
                'button'        => '.pricing-table__action .pricing-table-button',
                'button_icon'   => '.pricing-table__action .elementor-button-icon',
            )
        );

        $this->_start_controls_section(
            'section_table_style',
            array(
                'label'      => esc_html__( 'Table', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'table_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['table'],
            )
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'           => 'table_border',
                'label'          => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['table'],
                'fields_options' => array(
                    'border' => array(
                        'default' => 'solid',
                    ),
                    'width' => array(
                        'default' => array(
                            'top'      => '1',
                            'right'    => '1',
                            'bottom'   => '1',
                            'left'     => '1',
                            'isLinked' => true,
                        ),
                    )
                ),
            )
        );

        $this->_add_responsive_control(
            'table_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['table'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'table_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['table'],
            )
        );

        $this->_add_responsive_control(
            'table_padding',
            array(
                'label'      => esc_html__( 'Table Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['table'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_header_style',
            array(
                'label'      => esc_html__( 'Header', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_control(
            'header_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['header'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->_add_control(
            'header_title_style',
            array(
                'label'     => esc_html__( 'Title', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'title_color',
            array(
                'label'  => esc_html__( 'Title Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
            )
        );
        $this->_add_responsive_control(
            'title_space',
            array(
                'label'      => esc_html__( 'Title Space', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 200,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .pricing-table__title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                )
            )
        );

        $this->_add_control(
            'header_subtitle_style',
            array(
                'label'     => esc_html__( 'Subtitle', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'subtitle_color',
            array(
                'label'  => esc_html__( 'Subtitle Color', 'lastudio-kit' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['subtitle'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'subtitle_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['subtitle'],
            )
        );

        $this->_add_responsive_control(
            'header_padding',
            array(
                'label'      => esc_html__( 'Header Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['header'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_responsive_control(
            'header_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['header'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'           => 'header_border',
                'label'          => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['header'],
            )
        );

        $this->_add_responsive_control(
            'header_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['header'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_icon_style',
            array(
                'label'      => esc_html__( 'Icon', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_group_control(
            \LaStudioKit_Extension\Controls\Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'icon_style',
                'label'          => esc_html__( 'Icon Style', 'lastudio-kit' ),
                'selector'       => '{{WRAPPER}} ' . $css_scheme['icon']
            )
        );

        $this->_add_responsive_control(
            'icon_wrap_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['icon_wrap'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->_add_responsive_control(
            'icon_box_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['icon_wrap'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_pricing_style',
            array(
                'label'      => esc_html__( 'Pricing', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_control(
            'price_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->_add_control(
            'price_prefix_style',
            array(
                'label'     => esc_html__( 'Prefix', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'price_prefix_color',
            array(
                'label' => esc_html__( 'Price Prefix Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'price_prefix_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['price_prefix'],
            )
        );

        $this->_add_control(
            'price_prefix_vertical_align',
            array(
                'label'   => esc_html__( 'Vertical Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'baseline'    => esc_html__( 'Baseline', 'lastudio-elements' ),
                    'top'         => esc_html__( 'Top', 'lastudio-elements' ),
                    'middle'      => esc_html__( 'Middle', 'lastudio-elements' ),
                    'bottom'      => esc_html__( 'Bottom', 'lastudio-elements' ),
                    'sub'         => esc_html__( 'Sub', 'lastudio-elements' ),
                    'super'       => esc_html__( 'Super', 'lastudio-elements' ),
                    'text-top'    => esc_html__( 'Text Top', 'lastudio-elements' ),
                    'text-bottom' => esc_html__( 'Text Bottom', 'lastudio-elements' ),
                ),
                'default' => 'baseline',
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'vertical-align: {{VALUE}};',
                ),
            )
        );

        $this->_add_control(
            'price_prefix_dispaly',
            array(
                'label'   => esc_html__( 'Prefix Display', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'inline-block' => esc_html__( 'Inline', 'lastudio-kit' ),
                    'block'        => esc_html__( 'Block', 'lastudio-kit' ),
                ),
                'default' => 'inline-block',
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'display: {{VALUE}};',
                ),
            )
        );

        $this->_add_control(
            'price_val_style',
            array(
                'label'     => esc_html__( 'Price Value', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'price_color',
            array(
                'label' => esc_html__( 'Price Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_value'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'      => 'price_typography',
                'selector'  => '{{WRAPPER}}  ' . $css_scheme['price_value'],
            )
        );

        $this->_add_control(
            'price_suffix_style',
            array(
                'label'     => esc_html__( 'Suffix', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'price_suffix_color',
            array(
                'label' => esc_html__( 'Price Suffix Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'price_suffix_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['price_suffix'],
            )
        );

        $this->_add_control(
            'price_suffix_vertical_align',
            array(
                'label'   => esc_html__( 'Vertical Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'baseline'    => esc_html__( 'Baseline', 'lastudio-elements' ),
                    'top'         => esc_html__( 'Top', 'lastudio-elements' ),
                    'middle'      => esc_html__( 'Middle', 'lastudio-elements' ),
                    'bottom'      => esc_html__( 'Bottom', 'lastudio-elements' ),
                    'sub'         => esc_html__( 'Sub', 'lastudio-elements' ),
                    'super'       => esc_html__( 'Super', 'lastudio-elements' ),
                    'text-top'    => esc_html__( 'Text Top', 'lastudio-elements' ),
                    'text-bottom' => esc_html__( 'Text Bottom', 'lastudio-elements' ),
                ),
                'default' => 'baseline',
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'vertical-align: {{VALUE}};',
                ),
            )
        );

        $this->_add_control(
            'price_suffix_dispaly',
            array(
                'label'   => esc_html__( 'Suffix Display', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'inline-block' => esc_html__( 'Inline', 'lastudio-kit' ),
                    'block'        => esc_html__( 'Block', 'lastudio-kit' ),
                ),
                'default'   => 'inline-block',
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'display: {{VALUE}};',
                ),
            )
        );

        $this->_add_control(
            'price_desc_style',
            array(
                'label'     => esc_html__( 'Description', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'price_desc_color',
            array(
                'label' => esc_html__( 'Price Description Color', 'lastudio-kit' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_desc'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'price_desc_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['price_desc'],
            )
        );

        $this->_add_control(
            'price_desc_gap',
            array(
                'label' => esc_html__( 'Gap', 'lastudio-kit' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 30,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['price_desc'] => 'margin-top: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->_add_responsive_control(
            'price_padding',
            array(
                'label'      => esc_html__( 'Pricing Block Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['price'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'           => 'price_border',
                'label'          => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['price'],
            )
        );

        $this->_add_responsive_control(
            'price_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['price'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_responsive_control(
            'price_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['price'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_features_style',
            array(
                'label'      => esc_html__( 'Features', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_control(
            'features_custom_width',
            array(
                'label'        => esc_html__( 'Custom width', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'yes',
                'default'      => 'false',
            )
        );

        $this->_add_responsive_control(
            'features_width',
            array(
                'label'      => esc_html__( 'Width', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 1000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'size' => 350,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['features'] => 'width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto',
                ),
                'condition' => array(
                    'features_custom_width' => 'yes',
                )
            )
        );

        $this->_add_control(
            'features_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->_add_responsive_control(
            'features_padding',
            array(
                'label'      => esc_html__( 'Features Block Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['features'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'           => 'features_border',
                'label'          => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['features'],
            )
        );

        $this->_add_responsive_control(
            'features_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['features'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_responsive_control(
            'features_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['features'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'features_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['features_item'],
            )
        );

        $this->_add_control(
            'heading_included_feature_style',
            array(
                'label'     => esc_html__( 'Included Feature', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'inc_features_color',
            array(
                'label' => esc_html__( 'Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['included_item'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_advanced_icon_control(
            'included_bullet_icon',
            array(
                'label'       => esc_html__( 'Included Bullet Icon', 'lastudio-kit' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true
            )
        );

        $this->_add_control(
            'inc_bullet_icon_size',
            array(
                'label'   => esc_html__( 'Icon Size', 'lastudio-kit' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 14,
                    'unit' => 'px',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 6,
                        'max' => 90,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['included_item'] . ' .item-bullet:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['included_item'] . ' .item-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->_add_control(
            'inc_bullet_color',
            array(
                'label' => esc_html__( 'Bullet Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['included_item'] . ' .item-bullet:before' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_control(
            'heading_excluded_feature_style',
            array(
                'label'     => esc_html__( 'Excluded Feature', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'exc_features_color',
            array(
                'label' => esc_html__( 'Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['excluded_item'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_advanced_icon_control(
            'excluded_bullet_icon',
            array(
                'label'       => esc_html__( 'Excluded Bullet Icon', 'lastudio-kit' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
            )
        );

        $this->_add_control(
            'exc_bullet_icon_size',
            array(
                'label'   => esc_html__( 'Icon Size', 'lastudio-kit' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 14,
                    'unit' => 'px',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 6,
                        'max' => 90,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .item-bullet:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .item-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->_add_control(
            'exc_bullet_color',
            array(
                'label' => esc_html__( 'Bullet Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .item-bullet:before' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_control(
            'exc_text_decoration',
            array(
                'label'   => esc_html__( 'Text Decoration', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => array(
                    'none'         => esc_html__( 'None', 'lastudio-kit' ),
                    'line-through' => esc_html__( 'Line Through', 'lastudio-kit' ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .pricing-feature__text' => 'text-decoration: {{VALUE}}',
                ),
            )
        );

        $this->_add_control(
            'features_divider_style',
            array(
                'label'     => esc_html__( 'Features Divider', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'features_divider',
            array(
                'label'        => esc_html__( 'Divider', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $this->_add_control(
            'features_divider_line',
            array(
                'label' => esc_html__( 'Style', 'lastudio-kit' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'solid' => esc_html__( 'Solid', 'lastudio-kit' ),
                    'double' => esc_html__( 'Double', 'lastudio-kit' ),
                    'dotted' => esc_html__( 'Dotted', 'lastudio-kit' ),
                    'dashed' => esc_html__( 'Dashed', 'lastudio-kit' ),
                ),
                'default' => 'solid',
                'condition' => array(
                    'features_divider' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-style: {{VALUE}};',
                ),
            )
        );

        $this->_add_control(
            'features_divider_color',
            array(
                'label' => esc_html__( 'Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'condition' => array(
                    'features_divider' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-color: {{VALUE}};',
                ),
            )
        );

        $this->_add_control(
            'features_divider_weight',
            array(
                'label'   => esc_html__( 'Weight', 'lastudio-kit' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 1,
                    'unit' => 'px',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 10,
                    ),
                ),
                'condition' => array(
                    'features_divider' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->_add_control(
            'features_divider_width',
            array(
                'label' => esc_html__( 'Width', 'lastudio-kit' ),
                'type' => Controls_Manager::SLIDER,
                'condition' => array(
                    'features_divider' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'width: {{SIZE}}%',
                ),
            )
        );

        $this->_add_control(
            'features_divider_gap',
            array(
                'label' => esc_html__( 'Gap', 'lastudio-kit' ),
                'type' => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 15,
                    'unit' => 'px',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'features_divider' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_actions_style',
            array(
                'label'      => esc_html__( 'Action Box', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_control(
            'action_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['action'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->_add_control(
            'action_color',
            array(
                'label' => esc_html__( 'Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['action'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'action_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['action'],
            )
        );

        $this->_add_responsive_control(
            'action_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['action'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'           => 'action_border',
                'label'          => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['action'],
            )
        );

        $this->_add_responsive_control(
            'action_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['action'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_responsive_control(
            'action_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-kit' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['action'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_action_button_style',
            array(
                'label'      => esc_html__( 'Action Button', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_control(
            'button_size',
            array(
                'label'   => esc_html__( 'Size', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'auto',
                'options' => array(
                    'auto' => esc_html__( 'auto', 'lastudio-kit' ),
                    'full'  => esc_html__( 'full', 'lastudio-kit' ),
                ),
            )
        );

        $this->_add_control(
            'add_button_icon',
            array(
                'label'        => esc_html__( 'Add Icon', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $this->_add_advanced_icon_control(
            'button_icon',
            array(
                'label'       => esc_html__( 'Icon', 'lastudio-kit' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'condition' => array(
                    'add_button_icon' => 'yes',
                ),
            )
        );

        $this->_add_control(
            'button_icon_position',
            array(
                'label'   => esc_html__( 'Icon Position', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'left'  => esc_html__( 'Before Text', 'lastudio-kit' ),
                    'right' => esc_html__( 'After Text', 'lastudio-kit' ),
                ),
                'default'     => 'left',
                'condition' => array(
                    'add_button_icon' => 'yes',
                ),
            )
        );

        $this->_add_control(
            'button_icon_size',
            array(
                'label' => esc_html__( 'Icon Size', 'lastudio-kit' ),
                'type' => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 7,
                        'max' => 90,
                    ),
                ),
                'condition' => array(
                    'add_button_icon' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['button_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->_add_control(
            'button_icon_color',
            array(
                'label'     => esc_html__( 'Icon Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => array(
                    'add_button_icon' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['button_icon'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_responsive_control(
            'button_icon_margin',
            array(
                'label'      => esc_html__( 'Icon Margin', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'condition' => array(
                    'add_button_icon' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['button_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_start_controls_tabs( 'tabs_button_style' );

        $this->_start_controls_tab(
            'tab_button_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'button_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
                'fields_options' => array(
                    'background' => array(
                        'default' => 'classic',
                    ),
                    'color' => array(
                        'label'  => _x( 'Background Color', 'Background Control', 'lastudio-kit' ),
                    ),
                    'color_b' => array(
                        'label' => _x( 'Second Background Color', 'Background Control', 'lastudio-kit' ),
                    ),
                ),
                'exclude' => array(
                    'image',
                    'position',
                    'attachment',
                    'attachment_alert',
                    'repeat',
                    'size',
                ),
            )
        );

        $this->_add_control(
            'button_color',
            array(
                'label'     => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['button'],
            )
        );

        $this->_add_responsive_control(
            'button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_responsive_control(
            'button_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'button_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
            )
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
            )
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'tab_button_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'button_hover_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
                'fields_options' => array(
                    'background' => array(
                        'default' => 'classic',
                    ),
                    'color' => array(
                        'label' => _x( 'Background Color', 'Background Control', 'lastudio-kit' ),
                    ),
                    'color_b' => array(
                        'label' => _x( 'Second Background Color', 'Background Control', 'lastudio-kit' ),
                    ),
                ),
                'exclude' => array(
                    'image',
                    'position',
                    'attachment',
                    'attachment_alert',
                    'repeat',
                    'size',
                ),
            )
        );

        $this->_add_control(
            'button_hover_color',
            array(
                'label'     => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_hover_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['button'] . ':hover',
            )
        );

        $this->_add_responsive_control(
            'button_hover_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_responsive_control(
            'button_hover_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'button_hover_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
            )
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
            )
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_end_controls_section();

        /**
         * Order Style Section
         */
        $this->_start_controls_section(
            'section_order_style',
            array(
                'label'      => esc_html__( 'Content Order', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_control(
            'header_order',
            array(
                'label'   => esc_html__( 'Header Order', 'lastudio-kit' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => -1,
                'max'     => 10,
                'step'    => 1,
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['header'] => '-webkit-order: {{VALUE}};order: {{VALUE}};',
                ),
            )
        );

        $this->_add_control(
            'price_order',
            array(
                'label'   => esc_html__( 'Price Order', 'lastudio-kit' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => -1,
                'max'     => 10,
                'step'    => 1,
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['price'] => '-webkit-order: {{VALUE}};order: {{VALUE}};',
                ),
            )
        );

        $this->_add_control(
            'features_order',
            array(
                'label'   => esc_html__( 'Features Order', 'lastudio-kit' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => -1,
                'max'     => 10,
                'step'    => 1,
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['features'] => '-webkit-order: {{VALUE}};order: {{VALUE}};',
                ),
            )
        );

        $this->_add_control(
            'action_order',
            array(
                'label'   => esc_html__( 'Action Order', 'lastudio-kit' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => -1,
                'max'     => 10,
                'step'    => 1,
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['action'] => '-webkit-order: {{VALUE}};order: {{VALUE}};',
                ),
            )
        );

        $this->_end_controls_section();

    }

    protected function render() {

        $this->__context = 'render';

        $this->_open_wrap();
        include $this->_get_global_template( 'index' );
        $this->_close_wrap();
    }

    protected function _content_template() {}

    public function __generate_icon() {
        $icon = $this->get_settings_for_display( 'icon' );
        if ( empty($icon) || empty( $icon['value'] ) ) {
            return false;
        }
        ob_start();
        echo '<div class="pricing-table__icon"><div class="pricing-table__icon-box">';
        Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
        echo '</div></div>';
        return ob_get_clean();
    }

    public function __pricing_feature_icon() {
        return call_user_func( array( $this, sprintf( '__pricing_feature_icon_%s', $this->_context ) ) );
    }

    public function __pricing_feature_icon_render() {

        $item = $this->_processed_item;

        switch ( $item['item_included'] ) {
            case 'item-excluded':
                $icon = $this->get_settings_for_display( 'excluded_bullet_icon' );
                break;

            default:
                $icon = $this->get_settings_for_display( 'included_bullet_icon' );
                break;
        }

        if ( $icon ) {
            return sprintf( '<i class="item-bullet %s"></i>', $icon );
        }

    }

    public function __pricing_feature_icon_edit() {
        ?>
        <# if ( 'item-excluded' === item.item_included ) { #>
        <# if ( settings.excluded_bullet_icon ) { #>
        <i class="item-bullet {{{ settings.excluded_bullet_icon }}}"></i>
        <# } #>
        <# } else { #>
        <# if ( settings.included_bullet_icon ) { #>
        <i class="item-bullet {{{ settings.included_bullet_icon }}}"></i>
        <# } #>
        <# } #>
        <?php
    }

    public function get_badge_image( $class = '' ) {

        $image    = $this->get_settings_for_display('featured_badge');

        if ( ! $image ) {
            return;
        }
        if ( !empty( $image['id'] ) ) {
            $image_data = wp_get_attachment_image_src( $image['id'], 'full' );
            $params[0] = apply_filters('lastudio_wp_get_attachment_image_url', $image_data[0]);
            $params[1] = !empty($image_data[1]) ? $image_data[1] : 50;
            $params[2] = !empty($image_data[2]) ? $image_data[2] : 50;
        }
        else {
            $params[0] = $image['url'];
            $params[1] = 50;
            $params[2] = 50;
        }

        $srcset = sprintf('width="%d" height="%d"', $params[1], $params[2]);

        return sprintf( apply_filters('lastudio-kit/pricing-table/image-format', '<img src="%1$s" alt="" loading="lazy" class="la-lazyload-image %2$s" %3$s>'), $params[0], $class , $srcset);

    }
}