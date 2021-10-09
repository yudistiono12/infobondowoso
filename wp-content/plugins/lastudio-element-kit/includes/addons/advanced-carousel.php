<?php

/**
 * Class: LaStudioKit_Advanced_Carousel
 * Name: Advanced Carousel
 * Slug: lakit-carousel
 */

namespace Elementor;

if (!defined('WPINC')) {
    die;
}

use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

// Elementor Classes
use Elementor\Modules\DynamicTags\Module as TagsModule;

/**
 * Advanced_Carousel Widget
 */
class LaStudioKit_Advanced_Carousel extends LaStudioKit_Base {

    protected function enqueue_addon_resources(){
        wp_register_style( 'lakit-banner', lastudio_kit()->plugin_url('assets/css/addons/banner.css'), ['lastudio-kit-base'], lastudio_kit()->get_version());
        wp_register_style( $this->get_name(), lastudio_kit()->plugin_url('assets/css/addons/advanced-carousel.css'), ['lakit-banner'], lastudio_kit()->get_version());

        $this->add_style_depends( $this->get_name() );
        $this->add_script_depends( 'lastudio-kit-base' );
    }

    public function get_name() {
        return 'lakit-advanced-carousel';
    }

    protected function get_widget_title() {
        return esc_html__( 'Advanced Carousel', 'lastudio-kit');
    }

    public function get_icon() {
        return 'lastudio-kit-icon-carousel';
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_slides',
            array(
                'label' => esc_html__( 'Slides', 'lastudio-kit' ),
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_image',
            array(
                'label'   => esc_html__( 'Image', 'lastudio-kit' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => array(
                    'url' => Utils::get_placeholder_image_src(),
                ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $repeater->add_control(
            'item_content_type',
            array(
                'label'   => esc_html__( 'Content Type', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => array(
                    'default'  => esc_html__( 'Default', 'lastudio-kit' ),
                    'template' => esc_html__( 'Template', 'lastudio-kit' ),
                ),
            )
        );

        $repeater->add_control(
            'item_title',
            array(
                'label'       => esc_html__( 'Item Title', 'lastudio-kit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array( 'active' => true ),
                'condition'   => array(
                    'item_content_type' => 'default',
                ),
            )
        );

        $repeater->add_control(
            'item_text',
            array(
                'label'       => esc_html__( 'Item Description', 'lastudio-kit' ),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => array( 'active' => true ),
                'condition'   => array(
                    'item_content_type' => 'default',
                ),
            )
        );

        $repeater->add_control(
            'item_link',
            array(
                'label'       => esc_html__( 'Item Link', 'lastudio-kit' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array(
                    'active'     => true,
                    'categories' => array(
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY,
                    ),
                ),
                'condition'   => array(
                    'item_content_type' => 'default',
                ),
            )
        );

        $repeater->add_control(
            'item_link_target',
            array(
                'label'        => esc_html__( 'Open link in new window', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => '_blank',
                'condition'    => array(
                    'item_content_type' => 'default',
                    'item_link!'        => '',
                ),
            )
        );

        $repeater->add_control(
            'item_link_rel',
            array(
                'label'        => esc_html__( 'Add nofollow', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'nofollow',
                'condition'    => array(
                    'item_content_type' => 'default',
                    'item_link!'        => '',
                ),
            )
        );

        $repeater->add_control(
            'item_button_text',
            array(
                'label'       => esc_html__( 'Item Button Text', 'lastudio-kit' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'dynamic'     => array(
                    'active' => true
                ),
                'condition'   => array(
                    'item_content_type' => 'default',
                ),
            )
        );

        $repeater->add_control(
            'template_id',
            array(
                'label'       => esc_html__( 'Choose Template', 'lastudio-kit' ),
                'label_block' => 'true',
                'type'        => 'lastudiokit-query',
                'object_type' => \Elementor\TemplateLibrary\Source_Local::CPT,
                'filter_type' => 'by_id',
                'condition'   => array(
                    'item_content_type' => 'template',
                ),
            )
        );

        $this->_add_control(
            'items_list',
            array(
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => array(
                    array(
                        'item_image' => array(
                            'url' => Utils::get_placeholder_image_src(),
                        ),
                        'item_title' => esc_html__( 'Item #1', 'lastudio-kit' ),
                        'item_text'  => esc_html__( 'Item #1 Description', 'lastudio-kit' ),
                        'item_link'  => '#',
                        'item_link_target'  => '',
                    ),
                ),
                'title_field' => '{{{ item_title }}}',
            )
        );

        $this->_add_control(
            'item_link_type',
            array(
                'label'   => esc_html__( 'Item link type', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'link',
                'options' => array(
                    'link'     => esc_html__( 'Url', 'lastudio-kit' ),
                    'lightbox' => esc_html__( 'Lightbox', 'lastudio-kit' ),
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_settings',
            array(
                'label' => esc_html__( 'Settings', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'item_layout',
            array(
                'label'   => esc_html__( 'Items Layout', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'simple',
                'options' => array(
                    'banners'=> esc_html__( 'Banners', 'lastudio-kit' ),
                    'simple' => esc_html__( 'Simple', 'lastudio-kit' ),
                ),
            )
        );

        $this->_add_control(
            'animation_effect',
            array(
                'label'   => esc_html__( 'Animation Effect', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'lily',
                'options' => array(
                    'lily'   => esc_html__( 'Lily', 'lastudio-kit' ),
                    'sadie'  => esc_html__( 'Sadie', 'lastudio-kit' ),
                    'layla'  => esc_html__( 'Layla', 'lastudio-kit' ),
                    'oscar'  => esc_html__( 'Oscar', 'lastudio-kit' ),
                    'marley' => esc_html__( 'Marley', 'lastudio-kit' ),
                    'ruby'   => esc_html__( 'Ruby', 'lastudio-kit' ),
                    'roxy'   => esc_html__( 'Roxy', 'lastudio-kit' ),
                    'bubba'  => esc_html__( 'Bubba', 'lastudio-kit' ),
                    'romeo'  => esc_html__( 'Romeo', 'lastudio-kit' ),
                    'sarah'  => esc_html__( 'Sarah', 'lastudio-kit' ),
                    'chico'  => esc_html__( 'Chico', 'lastudio-kit' ),
                ),
                'condition' => array(
                    'item_layout' => 'banners',
                ),
            )
        );

        $this->_add_control(
            'img_size',
            array(
                'type'       => 'select',
                'label'      => esc_html__( 'Images Size', 'lastudio-kit' ),
                'default'    => 'full',
                'options'    => lastudio_kit_helper()->get_image_sizes(),
            )
        );

        $this->_add_control(
            'title_html_tag',
            array(
                'label'   => esc_html__( 'Title HTML Tag', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'options' => lastudio_kit_helper()->get_available_title_html_tags(),
                'default' => 'h5',
            )
        );

        $this->_add_control(
            'link_title',
            array(
                'label'     => esc_html__( 'Link Title', 'lastudio-kit' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
                'condition' => array(
                    'item_layout' => 'simple',
                ),
            )
        );

        $this->_add_control(
            'equal_height_cols',
            array(
                'label'        => esc_html__( 'Equal Columns Height', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'true',
                'default'      => '',
            )
        );

        $this->_add_control(
            'equal_custom_img_height',
            array(
                'label'        => esc_html__( 'Equal Custom Image Height', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'true',
                'default'      => '',
            )
        );

        $this->_add_responsive_control(
            'custom_img_height',
            array(
                'label'      => esc_html__( 'Image Height', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'em', 'vw', 'vh', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-banner__img,{{WRAPPER}} .lakit-carousel .lakit-carousel__item-img' => 'height: {{SIZE}}{{UNIT}}',
                ),
                'condition' => array(
                    'equal_custom_img_height' => 'true',
                ),
            )
        );
        $this->_add_control(
            'custom_img_position',
            array(
                'label'   => esc_html__( 'Cropped Image Position', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'center' => esc_html__( 'Center', 'lastudio-kit' ),
                    'top' => esc_html__( 'Top', 'lastudio-kit' ),
                    'bottom' => esc_html__( 'Bottom', 'lastudio-kit' ),
                ],
                'default' => 'center',
                'condition' => array(
                    'equal_custom_img_height' => 'true',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-banner__img,{{WRAPPER}} .lakit-carousel .lakit-carousel__item-img' => 'object-position: {{value}}',
                ),
            )
        );

        $this->_end_controls_section();

        $this->register_carousel_section([], false, false);

        $css_scheme = apply_filters(
            'lastudio-kit/advanced-carousel/css-scheme',
            array(
                'arrow_next'     => '.lakit-carousel .lakit-arrow.next-arrow',
                'arrow_prev'     => '.lakit-carousel .lakit-arrow.prev-arrow',
                'arrow_next_hov' => '.lakit-carousel .lakit-arrow.next-arrow:hover',
                'arrow_prev_hov' => '.lakit-carousel .lakit-arrow.prev-arrow:hover',
                'dot'            => '.lakit-carousel .lakit-carousel__dots .swiper-pagination-bullet',
                'dot_hover'      => '.lakit-carousel .lakit-carousel__dots .swiper-pagination-bullet:hover',
                'dot_active'     => '.lakit-carousel .lakit-carousel__dots .swiper-pagination-bullet-active',
                'wrap'           => '.lakit-carousel',
                'column'         => '.lakit-carousel .lakit-carousel__item',
                'image'          => '.lakit-carousel__item-img',
                'items'          => '.lakit-carousel__content',
                'items_title'    => '.lakit-carousel__content .lakit-carousel__item-title',
                'items_text'     => '.lakit-carousel__content .lakit-carousel__item-text',
                'items_button'   => '.lakit-carousel__content .lakit-carousel__item-button',
                'banner'         => '.lakit-banner',
                'banner_content' => '.lakit-banner__content',
                'banner_overlay' => '.lakit-banner__overlay',
                'banner_title'   => '.lakit-banner__title',
                'banner_text'    => '.lakit-banner__text',
            )
        );

        $this->_start_controls_section(
            'section_column_style',
            array(
                'label'      => esc_html__( 'Column', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_control(
            'column_padding',
            array(
                'label'       => esc_html__( 'Column Padding', 'lastudio-kit' ),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => array( 'px' ),
                'render_type' => 'template',
                'selectors'   => array(
                    '{{WRAPPER}} ' . $css_scheme['column'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['wrap'] => 'margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}};',
                ),
            ),
            50
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'column_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['column'] . ' .lakit-carousel__item-inner',
            ),
            50
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_simple_item_style',
            array(
                'label'      => esc_html__( 'Simple Item', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition'  => array(
                    'item_layout' => 'simple',
                ),
            )
        );

        $this->_add_control(
            'item_image_heading',
            array(
                'label' => esc_html__( 'Image', 'lastudio-kit' ),
                'type'  => Controls_Manager::HEADING,
            ),
            75
        );

        $this->_add_responsive_control(
            'item_image_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['image'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            75
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'item_image_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['image'],
            ),
            75
        );

        $this->_add_control(
            'item_content_heading',
            array(
                'label'     => esc_html__( 'Content', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ),
            25
        );

        $this->_start_controls_tabs( 'tabs_item_style' );

        $this->_start_controls_tab(
            'tab_item_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'simple_item_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['items'],
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'item_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['items'],
            ),
            75
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'item_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['items'],
            ),
            100
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'tab_item_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'simple_item_bg_hover',
                'selector' => '{{WRAPPER}} .lakit-carousel__item:hover ' . $css_scheme['items'],
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'item_border_hover',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .lakit-carousel__item:hover ' . $css_scheme['items'],
            ),
            75
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'item_box_shadow_hover',
                'selector' => '{{WRAPPER}} .lakit-carousel__item:hover ' . $css_scheme['items'],
            ),
            100
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_responsive_control(
            'items_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'left',
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
                'separator' => 'before',
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items'] => 'text-align: {{VALUE}};',
                ),
            ),
            25
        );

        $this->_add_responsive_control(
            'items_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            50
        );

        $this->_add_responsive_control(
            'items_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            75
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_banner_item_style',
            array(
                'label'      => esc_html__( 'Banner Item', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition'  => array(
                    'item_layout' => 'banners',
                ),
            )
        );

        $this->_start_controls_tabs( 'tabs_background' );

        $this->_start_controls_tab(
            'tab_background_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'items_content_color',
            array(
                'label'     => esc_html__( 'Additional Elements Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-effect-layla ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-layla ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-oscar ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-marley ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-ruby ' . $css_scheme['banner_text'] => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-roxy ' . $css_scheme['banner_text'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-roxy ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-bubba ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-bubba ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-romeo ' . $css_scheme['banner_content'] . '::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-romeo ' . $css_scheme['banner_content'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-sarah ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-chico ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['banner_overlay'],
            ),
            25
        );

        $this->_add_control(
            'normal_opacity',
            array(
                'label'   => esc_html__( 'Opacity', 'lastudio-kit' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '0',
                'min'     => 0,
                'max'     => 1,
                'step'    => 0.1,
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_overlay'] => 'opacity: {{VALUE}};',
                ),
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'tab_background_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'items_content_hover_color',
            array(
                'label'     => esc_html__( 'Additional Elements Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-effect-layla:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-layla:hover ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-oscar:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-marley:hover ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-ruby:hover ' . $css_scheme['banner_text'] => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-roxy:hover ' . $css_scheme['banner_text'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-roxy:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-bubba:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-bubba:hover ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-romeo:hover ' . $css_scheme['banner_content'] . '::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-romeo:hover ' . $css_scheme['banner_content'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-sarah:hover ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-effect-chico:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'background_hover',
                'selector' => '{{WRAPPER}} ' . $css_scheme['banner'] . ':hover ' . $css_scheme['banner_overlay'],
            ),
            25
        );

        $this->_add_control(
            'hover_opacity',
            array(
                'label'   => esc_html__( 'Opacity', 'lastudio-kit' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => '0.4',
                'min'     => 0,
                'max'     => 1,
                'step'    => 0.1,
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner'] . ':hover ' . $css_scheme['banner_overlay'] => 'opacity: {{VALUE}};',
                ),
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_item_title_style',
            array(
                'label'      => esc_html__( 'Item Title', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_start_controls_tabs( 'tabs_title_style' );

        $this->_start_controls_tab(
            'tab_title_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'items_title_color',
            array(
                'label'     => esc_html__( 'Title Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_title'] => 'color: {{VALUE}}',
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'tab_title_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'items_title_color_hover',
            array(
                'label'     => esc_html__( 'Title Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-carousel__item:hover ' . $css_scheme['items_title'] => 'color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-carousel__item:hover ' . $css_scheme['banner_title'] => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'items_title_link_color_hover',
            array(
                'label'     => esc_html__( 'Link Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-carousel__item ' . $css_scheme['items_title'] . ' a:hover' => 'color: {{VALUE}}',
                ),
                'condition' => array(
                    'item_layout' => 'simple',
                    'link_title' => 'yes',
                ),
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'items_title_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['items_title'] . ', {{WRAPPER}}  ' . $css_scheme['items_title'] . ' a, {{WRAPPER}} ' . $css_scheme['banner_title'],
                'separator' => 'before',
            ),
            50
        );

        $this->_add_responsive_control(
            'items_title_margin',
            array(
                'label'      => esc_html__( 'Margin', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'separator'  => 'before',
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            50
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_item_text_style',
            array(
                'label'      => esc_html__( 'Item Content', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_start_controls_tabs( 'tabs_text_style' );

        $this->_start_controls_tab(
            'tab_text_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'items_text_color',
            array(
                'label'     => esc_html__( 'Content Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_text'] => 'color: {{VALUE}}',
                    '{{WRAPPER}} ' . $css_scheme['banner_text'] => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'tab_text_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'items_text_color_hover',
            array(
                'label'     => esc_html__( 'Content Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-carousel__item:hover ' . $css_scheme['items_text'] => 'color: {{VALUE}}',
                    '{{WRAPPER}} .lakit-carousel__item:hover ' . $css_scheme['banner_text'] => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'items_text_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['items_text'] . ', {{WRAPPER}} ' . $css_scheme['banner_text'],
                'separator' => 'before',
            ),
            50
        );

        $this->_add_responsive_control(
            'items_text_margin',
            array(
                'label'      => esc_html__( 'Margin', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'separator'  => 'before',
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_text'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['banner_text'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            50
        );

        $this->_end_controls_section();

        /**
         * Action Button Style Section
         */
        $this->_start_controls_section(
            'section_action_button_style',
            array(
                'label'      => esc_html__( 'Action Button', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition'  => array(
                    'item_layout' => 'simple',
                ),
            )
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}}  ' . $css_scheme['items_button'],
            ),
            50
        );

        $this->_add_responsive_control(
            'button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            50
        );

        $this->_add_responsive_control(
            'button_margin',
            array(
                'label'      => __( 'Margin', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            75
        );

        $this->_add_responsive_control(
            'button_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'after',
            ),
            75
        );

        $this->_start_controls_tabs( 'tabs_button_style' );

        $this->_start_controls_tab(
            'tab_button_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'button_color',
            array(
                'label'     => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'button_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => array(
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'button_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['items_button'],
            ),
            75
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['items_button'],
            ),
            100
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'tab_button_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'button_hover_color',
            array(
                'label'     => esc_html__( 'Text Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] . ':hover' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'primary_button_hover_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] . ':hover' => 'background-color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'button_hover_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['items_button'] . ':hover',
            ),
            75
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['items_button'] . ':hover',
            ),
            100
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_end_controls_section();

        $this->register_carousel_arrows_dots_style_section();

    }

    protected function render() {

        $this->_context = 'render';

        $this->_open_wrap();
        include $this->_get_global_template( 'index' );
        $this->_close_wrap();
    }

    public function get_advanced_carousel_options( $carousel_columns = false ) {
        return parent::get_advanced_carousel_options($carousel_columns);
    }

    public function get_advanced_carousel_img( $class = '' ) {

        $settings = $this->get_settings_for_display();
        $size     = isset( $settings['img_size'] ) ? $settings['img_size'] : 'full';
        $image    = isset( $this->_processed_item['item_image'] ) ? $this->_processed_item['item_image'] : '';

        if ( ! $image ) {
            return;
        }

        if ( 'full' !== $size && ! empty( $image['id'] ) ) {
            $image_data = wp_get_attachment_image_src( $image['id'], $size );
            $url = $image_data[0];
            $width = $image_data[1];
            $height = $image_data[2];
        }
        else {
            $url = $image['url'];
            $width = 100;
            $height = 50;
        }

        if ( empty( $url ) ) {
            return;
        }

        $alt = esc_attr( Control_Media::get_image_alt( $image ) );

        $extra = lastudio_kit_helper()->get_attr_string([
            'width' => $width,
            'height' => $height
        ]);

        return sprintf( '<img src="%1$s" class="%2$s" alt="%3$s" loading="lazy"%4$s>', $url, $class, $alt, $extra );

    }

    protected function _loop_button_item( $keys = array(), $format = '%s' ) {
        $item = $this->_processed_item;
        $params = [];

        foreach ( $keys as $key => $value ) {

            if ( ! array_key_exists( $value, $item ) ) {
                return false;
            }

            if ( empty( $item[$value] ) ) {
                return false;
            }

            $params[] = $item[ $value ];
        }

        return vsprintf( $format, $params );
    }

    /**
     * Get item template content.
     *
     * @return string|void
     */
    protected function _loop_item_template_content() {
        $template_id = $this->_processed_item['template_id'];

        if ( empty( $template_id ) ) {
            return;
        }

        // for multi-language plugins
        $template_id = apply_filters( 'lastudio-kit/widgets/template_id', $template_id, $this );
        $content     = lastudio_kit()->elementor()->frontend->get_builder_content_for_display( $template_id );

        if ( lastudio_kit()->elementor()->editor->is_edit_mode() ) {
            $edit_url = add_query_arg(
                array(
                    'elementor' => '',
                ),
                get_permalink( $template_id )
            );
            $edit_link = sprintf(
                '<a class="lastudio-kit-edit-template-link" href="%s" title="%s" target="_blank"><span class="dashicons dashicons-edit"></span></a>',
                esc_url( $edit_url ),
                esc_html__( 'Edit Template', 'lastudio-kit' )
            );
            $content .= $edit_link;
        }
        return $content;
    }
}