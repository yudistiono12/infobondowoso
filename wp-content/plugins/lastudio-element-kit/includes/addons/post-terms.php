<?php

/**
 * Class: LaStudioKit_Post_Terms
 * Name: Post Terms
 * Slug: lakit-post-terms
 */

namespace Elementor;

if (!defined('WPINC')) {
    die;
}


/**
 * Post Terms Widget
 */
class LaStudioKit_Post_Terms extends LaStudioKit_Base {

    protected function enqueue_addon_resources(){
        $this->add_style_depends( 'lastudio-kit-base' );
    }

    public function get_name() {
        return 'lakit-post-terms';
    }

    protected function get_widget_title() {
        return esc_html__( 'Post Terms', 'lastudio-kit' );
    }

    public function get_icon() {
        return 'eicon-sitemap';
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Post Terms', 'lastudio-kit' ),
            ]
        );

        $this->add_control(
            'taxonomy',
            [
                'label' => __( 'Taxonomy', 'lastudio-kit' ),
                'type' => Controls_Manager::SELECT,
                'options' => get_taxonomies( array( 'public' => true ) ),
                'default' => 'category',
            ]
        );

        $this->add_control(
            'separator',
            [
                'label' => __( 'Separator', 'lastudio-kit' ),
                'type' => Controls_Manager::TEXT,
                'default' => ', ',
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label' => __( 'HTML Tag', 'lastudio-kit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'p' => 'p',
                    'div' => 'div',
                    'span' => 'span',
                ],
                'default' => 'p',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'lastudio-kit' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'lastudio-kit' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'lastudio-kit' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'lastudio-kit' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justified', 'lastudio-kit' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_to',
            [
                'label' => __( 'Link to', 'lastudio-kit' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __( 'None', 'lastudio-kit' ),
                    'term' => __( 'Term', 'lastudio-kit' ),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Post Terms', 'lastudio-kit' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .lakit-post-terms',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .lakit-post-terms',
            ]
        );

        $this->_add_responsive_control(
            'term_margin',
            [
                'label' => __( 'Item Margin', 'lastudio-kit' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lakit-post-terms .term-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->_add_responsive_control(
            'term_padding',
            [
                'label' => __( 'Item Padding', 'lastudio-kit' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lakit-post-terms .term-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->_start_controls_tabs( 'term_item_style' );

        $this->_start_controls_tab(
            'term_item_normal',
            [
                'label' => __( 'Normal', 'lastudio-kit' ),
            ]
        );

        $this->_add_control(
            'term_color',
            [
                'label' => __( 'Text Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lakit-post-terms .term-item,{{WRAPPER}} .lakit-post-terms' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->_add_control(
            'term_bgcolor',
            [
                'label' => __( 'Background Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lakit-post-terms .term-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'term_item_hover',
            [
                'label' => __( 'Hover', 'lastudio-kit' ),
            ]
        );

        $this->_add_control(
            'term_hover_color',
            [
                'label' => __( 'Text Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lakit-post-terms .term-item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->_add_control(
            'term_hover_bgcolor',
            [
                'label' => __( 'Background Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .lakit-post-terms .term-item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->_add_control(
            'term_hover_border',
            [
                'label' => __( 'Border Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'term_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .lakit-post-terms .term-item:hover',
                ],
            ]
        );

        $this->_add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'lastudio-kit' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'term_border',
                'selector' => '{{WRAPPER}} .lakit-post-terms .term-item',
                'separator' => 'before',
            ]
        );

        $this->_add_responsive_control(
            'term_border_radius',
            [
                'label' => __( 'Border Radius', 'lastudio-kit' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .lakit-post-terms .term-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        global $post;
        $settings = $this->get_settings();

        $taxonomy = $settings['taxonomy'];
        if ( empty( $taxonomy ) )
            return;

        $term_list = get_the_terms( $post->ID, $taxonomy );
        if ( empty( $term_list ) || is_wp_error( $term_list ) )
            return;

        $animation_class = ! empty( $settings['hover_animation'] ) ? 'elementor-animation-' . $settings['hover_animation'] : '';

        $html = sprintf( '<%1$s class="lakit-post-terms %2$s">', $settings['html_tag'], $animation_class );
        switch ( $settings['link_to'] ) {
            case 'term' :
                foreach ( $term_list as $term ) {
                    $html .= sprintf( '<a class="term-item" href="%1$s">%2$s</a>%3$s', esc_url( get_term_link( $term ) ), $term->name, $settings['separator'] );
                }
                break;

            case 'none' :
            default:
                foreach ( $term_list as $term ) {
                    $html .= sprintf('<span class="term-item">%1$s</span>', $term->name) . $settings['separator'];
                }
                break;
        }
        $html .= sprintf( '</%1$s>', $settings['html_tag'] );

        echo $html;
    }

    protected function _content_template() {
        global $post;
        ?>
        <#
        var taxonomy = settings.taxonomy;

        var all_terms = [];
        <?php
        $taxonomies = get_taxonomies( array( 'public' => true ) );
        foreach ( $taxonomies as $taxonomy ) {
            printf( 'all_terms["%1$s"] = [];', $taxonomy );
            $terms = get_the_terms( $post->ID, $taxonomy );
            if ( $terms ) {
                $i = 0;
                foreach ( $terms as $term ) {
                    printf( 'all_terms["%1$s"][%2$s] = [];', $taxonomy, $i );
                    printf( 'all_terms["%1$s"][%2$s] = { slug: "%3$s", name: "%4$s", url: "%5$s" };', $taxonomy, $i, $term->slug, $term->name, esc_url( get_term_link( $term ) ) );
                    $i++;
                }
            }
        }
        ?>
        var post_terms = all_terms[ settings.taxonomy ];

        var terms = '';
        var i = 0;

        switch( settings.link_to ) {
        case 'term':
        while ( all_terms[ settings.taxonomy ][i] ) {
        terms += "<a href='" + all_terms[ settings.taxonomy ][i].url + "'>" + all_terms[ settings.taxonomy ][i].name + "</a>" + settings.separator;
        i++;
        }
        break;
        case 'none':
        default:
        while ( all_terms[ settings.taxonomy ][i] ) {
        terms += all_terms[ settings.taxonomy ][i].name + settings.separator;
        i++;
        }
        break;
        }
        terms = terms.slice(0, terms.length-2);

        var animation_class = '';
        if ( '' !== settings.hover_animation ) {
        animation_class = 'elementor-animation-' + settings.hover_animation;
        }

        var html = '<' + settings.html_tag + ' class="lakit-post-terms ' + animation_class + '">';
        html += terms;
        html += '</' + settings.html_tag + '>';

        print( html );
        #>
        <?php
    }
    
}