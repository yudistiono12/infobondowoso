<?php
/**
 * Class: LaStudioKit_Hamburger_Panel
 * Name: Hamburger Panel
 * Slug: lakit-hamburger-panel
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LaStudioKit_Hamburger_Panel extends LaStudioKit_Base {

    protected function enqueue_addon_resources(){
        wp_register_style( $this->get_name(), lastudio_kit()->plugin_url('assets/css/addons/hamburger-panel.css'), ['lastudio-kit-base'], lastudio_kit()->get_version());

        $this->add_style_depends( $this->get_name() );
        $this->add_script_depends( 'lastudio-kit-base' );
    }

	public function get_name() {
		return 'lakit-hamburger-panel';
	}

	public function get_widget_title() {
		return esc_html__( 'Hamburger Panel', 'lastudio-kit' );
	}

	public function get_icon() {
		return 'lastudio-kit-icon-hamburger-panel';
	}


	protected function register_controls() {

        $css_scheme = apply_filters(
            'lastudio-kit/hamburger-panel/css-scheme',
            array(
                'panel'    => '.lakit-hamburger-panel',
                'instance' => '.lakit-hamburger-panel__instance',
                'cover'    => '.lakit-hamburger-panel__cover',
                'inner'    => '.lakit-hamburger-panel__inner',
                'content'  => '.lakit-hamburger-panel__content',
                'close'    => '.lakit-hamburger-panel__close-button',
                'toggle'   => '.lakit-hamburger-panel__toggle',
                'icon'     => '.lakit-hamburger-panel__icon',
                'label'    => '.lakit-hamburger-panel__toggle-label',
            )
        );

        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Content', 'lastudio-kit' ),
            )
        );

        $this->_add_advanced_icon_control(
            'panel_toggle_icon',
            array(
                'label'       => esc_html__( 'Icon', 'lastudio-kit' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => false,
                'skin'        => 'inline',
                'file'        => '',
                'default'     => 'fa fa-align-justify',
                'fa5_default' => array(
                    'value'   => 'fas fa-align-justify',
                    'library' => 'fa-solid',
                ),
            )
        );

        $this->_add_advanced_icon_control(
            'panel_toggle_active_icon',
            array(
                'label'       => esc_html__( 'Active Icon', 'lastudio-kit' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => false,
                'skin'        => 'inline',
                'file'        => '',
                'default'     => 'fa fa-close',
                'fa5_default' => array(
                    'value'   => 'fas fa-times',
                    'library' => 'fa-solid',
                ),
            )
        );

        $this->_add_advanced_icon_control(
            'panel_close_icon',
            array(
                'label'       => esc_html__( 'Close Icon', 'lastudio-kit' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => false,
                'skin'        => 'inline',
                'file'        => '',
                'default'     => 'fa fa-close',
                'fa5_default' => array(
                    'value'   => 'fas fa-times',
                    'library' => 'fa-solid',
                ),
            )
        );

        $this->add_control(
            'panel_toggle_label',
            array(
                'label'   => esc_html__( 'Label', 'lastudio-kit' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'More', 'lastudio-kit' ),
            )
        );

        $this->add_responsive_control(
            'panel_toggle_label_alignment',
            array(
                'label'   => esc_html__( 'Toggle Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => array(
                    'flex-start' => array(
                        'title' => esc_html__( 'Start', 'lastudio-kit' ),
                        'icon'  => ! is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-kit' ),
                        'icon'  => 'eicon-h-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'End', 'lastudio-kit' ),
                        'icon'  => ! is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['panel'] => 'justify-content: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'panel_template_id',
            array(
                'label'       => esc_html__( 'Choose Template', 'lastudio-kit' ),
                'label_block' => 'true',
                'type'        => 'lastudiokit-query',
                'object_type' => \Elementor\TemplateLibrary\Source_Local::CPT,
                'filter_type' => 'by_id',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            array(
                'label' => esc_html__( 'Settings', 'lastudio-kit' ),
            )
        );

        $this->add_control(
            'position',
            array(
                'label'       => esc_html__( 'Position', 'lastudio-kit' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'right',
                'options' => array(
                    'right' => esc_html__( 'Right', 'lastudio-kit' ),
                    'left'  => esc_html__( 'Left', 'lastudio-kit' ),
                ),
            )
        );

        $this->add_control(
            'animation_effect',
            array(
                'label'       => esc_html__( 'Effect', 'lastudio-kit' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'slide',
                'options' => array(
                    'slide' => esc_html__( 'Slide', 'lastudio-kit' ),
                    'fade'  => esc_html__( 'Fade', 'lastudio-kit' ),
                    'zoom'  => esc_html__( 'Zoom', 'lastudio-kit' ),
                ),
            )
        );

        $this->add_control(
            'z_index',
            array(
                'label'   => esc_html__( 'Z-Index', 'lastudio-kit' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 1,
                'max'     => 100000,
                'step'    => 1,
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['instance'] => 'z-index: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'ajax_template',
            array(
                'label'        => esc_html__( 'Use Ajax Loading for Template', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'Off', 'lastudio-kit' ),
                'return_value' => 'yes',
                'default'      => 'false',
            )
        );

        $this->end_controls_section();

        $this->_start_controls_section(
            'section_panel_style',
            array(
                'label'      => esc_html__( 'Panel', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_responsive_control(
            'panel_width',
            array(
                'label'      => esc_html__( 'Panel Width', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 250,
                        'max' => 800,
                    ),
                    '%' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['instance'] => 'width: {{SIZE}}{{UNIT}};',
                ),
            ),
            25
        );

        $this->_add_responsive_control(
            'panel_padding',
            array(
                'label'      => __( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['content'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'panel_background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['inner'],
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'panel_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['inner'],
            ),
            75
        );

        $this->_add_control(
            'panel_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            75
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'panel_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['inner'],
            ),
            75
        );

        $this->_add_control(
            'cover_style_heading',
            array(
                'label'     => esc_html__( 'Cover', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ),
            25
        );

        $this->_add_control(
            'cover_bg_color',
            array(
                'label' => esc_html__( 'Background color', 'lastudio-kit' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['cover'] => 'background-color: {{VALUE}};',
                ),
            ),
            25
        );

        $this->_add_control(
            'close_button_style_heading',
            array(
                'label'     => esc_html__( 'Close Button', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ),
            25
        );

        $this->_start_controls_tabs( 'close_button_styles' );

        $this->_start_controls_tab(
            'close_button_control',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            \LaStudioKit_Extension\Controls\Group_Control_Box_Style::get_type(),
            array(
                'label'    => esc_html__( 'Close Icon', 'lastudio-kit' ),
                'name'     => 'close_icon_box',
                'selector' => '{{WRAPPER}} ' . $css_scheme['close'],
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'close_button_control_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            \LaStudioKit_Extension\Controls\Group_Control_Box_Style::get_type(),
            array(
                'label'    => esc_html__( 'Close Icon', 'lastudio-kit' ),
                'name'     => 'close_icon_box_hover',
                'selector' => '{{WRAPPER}} ' . $css_scheme['close'] . ':hover',
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_control(
            'content_loader_style_heading',
            array(
                'label'     => esc_html__( 'Loader Styles', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'ajax_template' => 'yes',
                )
            ),
            25
        );

        $this->_add_control(
            'content_loader_color',
            array(
                'label' => esc_html__( 'Loader color', 'lastudio-kit' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['content'] . ' .lakit-hamburger-panel-loader' => 'border-color: {{VALUE}}; border-top-color: white;',
                ),
                'condition' => array(
                    'ajax_template' => 'yes',
                )
            ),
            25
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'section_panel_toggle_style',
            array(
                'label'      => esc_html__( 'Toggle', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_start_controls_tabs( 'toggle_styles' );

        $this->_start_controls_tab(
            'toggle_tab_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'toggle_background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'],
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'toggle_tab_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'toggle_background_hover',
                'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'] . ':hover',
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_responsive_control(
            'toggle_padding',
            array(
                'label'      => esc_html__( 'Padding', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['toggle'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator'  => 'before',
            ),
            25
        );

        $this->_add_responsive_control(
            'toggle_margin',
            array(
                'label'      => esc_html__( 'Margin', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['toggle'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'toggle_border',
                'label'       => esc_html__( 'Border', 'lastudio-kit' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['toggle'],
            ),
            75
        );

        $this->_add_control(
            'toggle_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['toggle'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            ),
            75
        );

        $this->_add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'toggle_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'],
            ),
            100
        );

        $this->_add_control(
            'toggle_icon_style_heading',
            array(
                'label'     => esc_html__( 'Icon Styles', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ),
            25
        );

        $this->_start_controls_tabs( 'toggle_icon_styles' );

        $this->_start_controls_tab(
            'toggle_icon_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            \LaStudioKit_Extension\Controls\Group_Control_Box_Style::get_type(),
            array(
                'label'    => esc_html__( 'Toggle Icon', 'lastudio-kit' ),
                'name'     => 'toggle_icon_box',
                'selector' => '{{WRAPPER}} ' . $css_scheme['icon'],
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'toggle_icon_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            \LaStudioKit_Extension\Controls\Group_Control_Box_Style::get_type(),
            array(
                'label'    => esc_html__( 'Toggle Icon', 'lastudio-kit' ),
                'name'     => 'toggle_icon_box_hover',
                'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'] . ':hover ' . $css_scheme['icon'],
            ),
            25
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_control(
            'toggle_label_style_heading',
            array(
                'label'     => esc_html__( 'Label Styles', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ),
            25
        );

        $this->_start_controls_tabs( 'toggle_label_styles' );

        $this->_start_controls_tab(
            'toggle_label_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'toggle_control_label_color',
            array(
                'label'     => esc_html__( 'Label Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['label'] => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'toggle_label_typography',
                'selector' => '{{WRAPPER}} '. $css_scheme['label'],
            ),
            50
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'toggle_label_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'toggle_control_label_color_hover',
            array(
                'label'     => esc_html__( 'Label Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['toggle'] . ':hover ' . $css_scheme['label'] => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'toggle_label_typography_hover',
                'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'] . ':hover ' . $css_scheme['label'],
            ),
            50
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_end_controls_section();

	}

    protected function render() {

        $this->_context = 'render';

        $panel_settings = $this->get_settings();

        $template_id      = isset( $panel_settings['panel_template_id'] ) ? $panel_settings['panel_template_id'] : '0';
        $position         = isset( $panel_settings['position'] ) ? $panel_settings['position'] : 'right';
        $animation_effect = isset( $panel_settings['animation_effect'] ) ? $panel_settings['animation_effect'] : 'slide';
        $ajax_template    = isset( $panel_settings['ajax_template'] ) ? filter_var( $panel_settings['ajax_template'], FILTER_VALIDATE_BOOLEAN ) : false;

        $settings = array(
            'position'     => $position,
            'ajaxTemplate' => $ajax_template,
        );

        $this->add_render_attribute( 'instance', array(
            'class' => array(
                'lakit-hamburger-panel',
                'lakit-hamburger-panel-' . $position . '-position',
                'lakit-hamburger-panel-' . $animation_effect . '-effect',
            ),
            'data-settings' => json_encode( $settings ),
        ) );

        $close_button_html = $this->_get_icon( 'panel_close_icon', '<div class="lakit-hamburger-panel__close-button lakit-blocks-icon">%s</div>' );

        $toggle_control_html = '';

        $toggle_icon        = $this->_get_icon( 'panel_toggle_icon', '<span class="lakit-hamburger-panel__icon icon-normal lakit-blocks-icon">%s</span>' );
        $toggle_active_icon = $this->_get_icon( 'panel_toggle_active_icon', '<span class="lakit-hamburger-panel__icon icon-active lakit-blocks-icon">%s</span>' );

        if ( ! empty( $toggle_icon ) && ! empty( $toggle_active_icon ) ) {
            $toggle_control_html .= sprintf( '<div class="lakit-hamburger-panel__toggle-icon">%1$s%2$s</div>', $toggle_icon, $toggle_active_icon );
        }

        $toggle_label_html = '';

        if ( ! empty( $panel_settings['panel_toggle_label'] ) ) {
            $toggle_label_html .= sprintf( '<div class="lakit-hamburger-panel__toggle-label"><span>%1$s</span></div>', $panel_settings['panel_toggle_label'] );
        }

        $toggle_html = sprintf( '<div class="lakit-hamburger-panel__toggle">%1$s%2$s</div>', $toggle_control_html, $toggle_label_html );

        ?>
        <div <?php echo $this->get_render_attribute_string( 'instance' ); ?>>
            <?php echo $toggle_html; ?>
            <div class="lakit-hamburger-panel__instance">
                <div class="lakit-hamburger-panel__cover"></div>
                <div class="lakit-hamburger-panel__inner">
                    <?php
                    echo $close_button_html;

                    if ( ! empty( $template_id ) ) {
                        $link = add_query_arg(
                            array(
                                'elementor' => '',
                            ),
                            get_permalink( $template_id )
                        );

                        if ( lastudio_kit_integration()->in_elementor() ) {
                            echo sprintf( '<div class="lakit-tabs__edit-cover" data-template-edit-link="%s"><i class="eicon-edit"></i><span>%s</span></div>', $link, esc_html__( 'Edit Template', 'lastudio-kit' ) );
                        }
                    }

                    $this->add_render_attribute( 'lakit-hamburger-panel__content', array(
                        'class'            => 'lakit-hamburger-panel__content',
                        'data-template-id' => ! empty( $template_id ) ? $template_id : 'false',
                    ) );

                    $content_html = '';

                    if ( ! empty( $template_id ) && ! $ajax_template ) {
                        $content_html .= lastudio_kit()->elementor()->frontend->get_builder_content_for_display( $template_id );
                    } else if ( ! $ajax_template ) {
                        $content_html = $this->no_templates_message();
                    } else {
                        $content_html .= '<div class="lakit-hamburger-panel-loader"></div>';
                    }

                    echo sprintf( '<div %1$s>%2$s</div>', $this->get_render_attribute_string( 'lakit-hamburger-panel__content' ), $content_html );
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Empty templates message description
     *
     * @return string
     */
    public function empty_templates_message() {
        return '<div id="elementor-widget-template-empty-templates">
				<div class="elementor-widget-template-empty-templates-icon"><i class="eicon-nerd"></i></div>
				<div class="elementor-widget-template-empty-templates-title">' . esc_html__( 'You Haven’t Saved Templates Yet.', 'lastudio-kit' ) . '</div>
				<div class="elementor-widget-template-empty-templates-footer">' . esc_html__( 'What is Library?', 'lastudio-kit' ) . ' <a class="elementor-widget-template-empty-templates-footer-url" href="https://go.elementor.com/docs-library/" target="_blank">' . esc_html__( 'Read our tutorial on using Library templates.', 'lastudio-kit' ) . '</a></div>
				</div>';
    }

    /**
     * No templates message
     *
     * @return string
     */
    public function no_templates_message() {
        $message = '<span>' . esc_html__( 'Template is not defined. ', 'lastudio-kit' ) . '</span>';

        $url = add_query_arg(
            array(
                'post_type'     => 'elementor_library',
                'action'        => 'elementor_new_post',
                '_wpnonce'      => wp_create_nonce( 'elementor_action_new_post' ),
                'template_type' => 'section',
            ),
            esc_url( admin_url( '/edit.php' ) )
        );

        $new_link = '<span>' . esc_html__( 'Select an existing template or create a ', 'lastudio-kit' ) . '</span><a class="lakit-tabs-new-template-link elementor-clickable" href="' . $url . '" target="_blank">' . esc_html__( 'new one', 'lastudio-kit' ) . '</a>' ;

        return sprintf(
            '<div class="lakit-tabs-no-template-message">%1$s%2$s</div>',
            $message,
            lastudio_kit_integration()->in_elementor() ? $new_link : ''
        );
    }

}
