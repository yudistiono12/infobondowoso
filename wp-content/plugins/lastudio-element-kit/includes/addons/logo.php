<?php
/**
 * Class: LaStudioKit_Logo
 * Name: Logo
 * Slug: lakit-logo
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LaStudioKit_Logo extends LaStudioKit_Base {

    protected function enqueue_addon_resources(){
        $this->add_style_depends( 'lastudio-kit-base' );
    }

	public function get_name() {
		return 'lakit-logo';
	}

	public function get_widget_title() {
		return esc_html__( 'Logo', 'lastudio-kit' );
	}

	public function get_icon() {
		return 'lastudio-kit-icon-logo';
	}


	protected function register_controls() {

        $this->_start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Content', 'lastudio-kit' ),
            )
        );

        $this->_add_control(
            'logo_type',
            array(
                'type'    => 'select',
                'label'   => esc_html__( 'Logo Type', 'lastudio-kit' ),
                'default' => 'text',
                'options' => array(
                    'text'  => esc_html__( 'Text', 'lastudio-kit' ),
                    'image' => esc_html__( 'Image', 'lastudio-kit' ),
                    'both'  => esc_html__( 'Both Text and Image', 'lastudio-kit' ),
                ),
            )
        );

        $this->_add_control(
            'logo_image',
            array(
                'label'     => esc_html__( 'Logo Image', 'lastudio-kit' ),
                'type'      => Controls_Manager::MEDIA,
                'condition' => array(
                    'logo_type!' => 'text',
                ),
            )
        );

        $this->_add_control(
            'logo_image_2x',
            array(
                'label'     => esc_html__( 'Retina Logo Image', 'lastudio-kit' ),
                'type'      => Controls_Manager::MEDIA,
                'condition' => array(
                    'logo_type!' => 'text',
                ),
            )
        );

        $this->_add_control(
            'logo_text_from',
            array(
                'type'       => 'select',
                'label'      => esc_html__( 'Logo Text From', 'lastudio-kit' ),
                'default'    => 'site_name',
                'options'    => array(
                    'site_name' => esc_html__( 'Site Name', 'lastudio-kit' ),
                    'custom'    => esc_html__( 'Custom', 'lastudio-kit' ),
                ),
                'condition' => array(
                    'logo_type!' => 'image',
                ),
            )
        );

        $this->_add_control(
            'logo_text',
            array(
                'label'     => esc_html__( 'Custom Logo Text', 'lastudio-kit' ),
                'type'      => Controls_Manager::TEXT,
                'condition' => array(
                    'logo_text_from' => 'custom',
                    'logo_type!'     => 'image',
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
            'linked_logo',
            array(
                'label'        => esc_html__( 'Linked Logo', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'true',
                'default'      => 'true',
            )
        );

        $this->_add_control(
            'remove_link_on_front',
            array(
                'label'        => esc_html__( 'Remove Link on Front Page', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'true',
                'default'      => '',
            )
        );

        $this->_add_control(
            'logo_display',
            array(
                'type'        => 'select',
                'label'       => esc_html__( 'Display Logo Image and Text', 'lastudio-kit' ),
                'label_block' => true,
                'default'     => 'block',
                'options'     => array(
                    'inline' => esc_html__( 'Inline', 'lastudio-kit' ),
                    'block'  => esc_html__( 'Text Below Image', 'lastudio-kit' ),
                ),
                'condition' => array(
                    'logo_type' => 'both',
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'logo_style',
            array(
                'label'      => esc_html__( 'Logo', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_responsive_control(
            'logo_alignment',
            array(
                'label'   => esc_html__( 'Logo Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'flex-start',
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
                    '{{WRAPPER}} .lakit-logo' => 'justify-content: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_control(
            'vertical_logo_alignment',
            array(
                'label'       => esc_html__( 'Image and Text Vertical Alignment', 'lastudio-kit' ),
                'type'        => Controls_Manager::CHOOSE,
                'default'     => 'center',
                'label_block' => true,
                'options' => array(
                    'flex-start' => array(
                        'title' => esc_html__( 'Top', 'lastudio-kit' ),
                        'icon' => 'eicon-v-align-top',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Middle', 'lastudio-kit' ),
                        'icon' => 'eicon-v-align-middle',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Bottom', 'lastudio-kit' ),
                        'icon' => 'eicon-v-align-bottom',
                    ),
                    'baseline' => array(
                        'title' => esc_html__( 'Baseline', 'lastudio-kit' ),
                        'icon' => 'eicon-v-align-bottom',
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .lakit-logo__link' => 'align-items: {{VALUE}}',
                ),
                'condition' => array(
                    'logo_type'    => 'both',
                    'logo_display' => 'inline',
                ),
            ),
            25
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'text_logo_style',
            array(
                'label'      => esc_html__( 'Text', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->_add_control(
            'text_logo_color',
            array(
                'label'     => esc_html__( 'Color', 'lastudio-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .lakit-logo__text' => 'color: {{VALUE}}',
                ),
            ),
            25
        );

        $this->_add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'text_logo_typography',
                'selector' => '{{WRAPPER}} .lakit-logo__text',
            ),
            50
        );

        $this->_add_control(
            'text_logo_gap',
            array(
                'label'      => esc_html__( 'Gap', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'default'    => array(
                    'size' => 5,
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-logo-display-block .lakit-logo__img'  => 'margin-bottom: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .lakit-logo-display-inline .lakit-logo__img' => 'margin-right: {{SIZE}}{{UNIT}}',
                ),
                'condition'  => array(
                    'logo_type' => 'both',
                ),
            ),
            25
        );

        $this->_add_responsive_control(
            'text_logo_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array(
                        'title' => esc_html__( 'Left', 'lastudio-kit' ),
                        'icon'  => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'lastudio-kit' ),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'lastudio-kit' ),
                        'icon'  => 'fa fa-align-right',
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .lakit-logo__text' => 'text-align: {{VALUE}}',
                ),
                'condition' => array(
                    'logo_type'    => 'both',
                    'logo_display' => 'block',
                ),
            ),
            50
        );

        $this->_end_controls_section();

	}

	protected function render() {

		$this->_context = 'render';

		$this->_open_wrap();
		include $this->_get_global_template( 'index' );
		$this->_close_wrap();
	}

    /**
     * Check if logo is linked
     * @return [type] [description]
     */
    public function _is_linked() {

        $settings = $this->get_settings();

        if ( empty( $settings['linked_logo'] ) ) {
            return false;
        }

        if ( 'true' === $settings['remove_link_on_front'] && is_front_page() ) {
            return false;
        }

        return true;

    }

    /**
     * Returns logo text
     *
     * @return string Text logo HTML markup.
     */
    public function _get_logo_text() {

        $settings    = $this->get_settings();
        $type        = isset( $settings['logo_type'] ) ? esc_attr( $settings['logo_type'] ) : 'text';
        $text_from   = isset( $settings['logo_text_from'] ) ? esc_attr( $settings['logo_text_from'] ) : 'site_name';
        $custom_text = isset( $settings['logo_text'] ) ? wp_kses_post( $settings['logo_text'] ) : '';

        if ( 'image' === $type ) {
            return;
        }

        if ( 'site_name' === $text_from ) {
            $text = get_bloginfo( 'name' );
        } else {
            $text = $custom_text;
        }

        $format = apply_filters(
            'lastudio-kit/logo/text-foramt',
            '<div class="lakit-logo__text">%s</div>'
        );

        return sprintf( $format, $text );
    }

    /**
     * Returns logo classes string
     *
     * @return string
     */
    public function _get_logo_classes() {

        $settings = $this->get_settings();

        $classes = array(
            'lakit-logo',
            'lakit-logo-type-' . $settings['logo_type'],
            'lakit-logo-display-' . $settings['logo_display'],
        );

        return implode( ' ', $classes );
    }

    /**
     * Returns logo image
     *
     * @return string Image logo HTML markup.
     */
    public function _get_logo_image() {

        $settings = $this->get_settings();
        $type     = isset( $settings['logo_type'] ) ? esc_attr( $settings['logo_type'] ) : 'text';
        $image    = isset( $settings['logo_image'] ) ? $settings['logo_image'] : false;
        $image_2x = isset( $settings['logo_image_2x'] ) ? $settings['logo_image_2x'] : false;

        if ( 'text' === $type || ! $image ) {
            return;
        }

        $image_src    = $this->_get_logo_image_src( $image );
        $image_2x_src = $this->_get_logo_image_src( $image_2x );

        if ( empty( $image_src ) && empty( $image_2x_src ) ) {
            return;
        }

        $format = apply_filters(
            'lastudio-kit/logo/image-format',
            '<img src="%1$s" class="lakit-logo__img" alt="%2$s"%3$s>'
        );

        $image_data = ! empty( $image['id'] ) ? wp_get_attachment_image_src( $image['id'], 'full' ) : array();
        $width      = isset( $image_data[1] ) ? $image_data[1] : false;
        $height     = isset( $image_data[2] ) ? $image_data[2] : false;

        $attrs = sprintf(
            '%1$s%2$s%3$s',
            $width ? ' width="' . $width . '"' : '',
            $height ? ' height="' . $height . '"' : '',
            ( ! empty( $image_2x_src ) ? ' srcset="' . esc_url( $image_2x_src ) . ' 2x"' : '' )
        );

        return sprintf( $format, esc_url( $image_src ), get_bloginfo( 'name' ), $attrs );
    }

    public function _get_logo_image_src( $args = array() ) {

        if ( ! empty( $args['id'] ) ) {
            $img_data = wp_get_attachment_image_src( $args['id'], 'full' );

            return ! empty( $img_data[0] ) ? $img_data[0] : false;
        }

        if ( ! empty( $args['url'] ) ) {
            return $args['url'];
        }

        return false;
    }

}
