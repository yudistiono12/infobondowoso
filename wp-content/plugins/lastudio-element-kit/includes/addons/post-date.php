<?php

/**
 * Class: LaStudioKit_Post_Date
 * Name: Post Date
 * Slug: lakit-post-date
 */

namespace Elementor;

if (!defined('WPINC')) {
    die;
}


/**
 * Post Date Widget
 */
class LaStudioKit_Post_Date extends LaStudioKit_Base {

    protected function enqueue_addon_resources(){
        $this->add_style_depends( 'lastudio-kit-base' );
    }

    public function get_name() {
        return 'lakit-post-date';
    }

    protected function get_widget_title() {
        return esc_html__( 'Post Date', 'lastudio-kit' );
    }

    public function get_icon() {
        return 'far fa-clock';
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Post Date', 'lastudio-kit' ),
            ]
        );

        $this->add_control(
            'date_type',
            [
                'label' => __( 'Date Type', 'lastudio-kit' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'publish' => __( 'Publish Date', 'lastudio-kit' ),
                    'modified' => __( 'Last Modified Date', 'lastudio-kit' ),
                ],
                'default' => 'publish',
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
                    'home' => __( 'Home URL', 'lastudio-kit' ),
                    'post' => esc_html__( 'Post URL', 'lastudio-kit' ),
                    'custom' => __( 'Custom URL', 'lastudio-kit' ),
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'lastudio-kit' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'lastudio-kit' ),
                'condition' => [
                    'link_to' => 'custom',
                ],
                'default' => [
                    'url' => '',
                ],
                'show_label' => false,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Post Date', 'lastudio-kit' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => __( 'Text Color', 'lastudio-kit' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lakit-post-date' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .lakit-post-date a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .lakit-post-date',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .lakit-post-date',
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'lastudio-kit' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();

        // Backwards compitability check
        if ( $settings['date_type'] )
            $date_type = $settings['date_type'];
        else
            $date_type = 'publish';

        switch ( $date_type ) {
            case 'modified' :
                $date = get_the_modified_date();
                break;

            case 'publish' :
            default:
                $date = get_the_date();
                break;
        }

        if ( empty( $date ) )
            return;

        switch ( $settings['link_to'] ) {
            case 'custom' :
                if ( ! empty( $settings['link']['url'] ) ) {
                    $link = esc_url( $settings['link']['url'] );
                } else {
                    $link = false;
                }
                break;

            case 'post' :
                $link = esc_url( get_the_permalink() );
                break;

            case 'home' :
                $link = esc_url( get_home_url() );
                break;

            case 'none' :
            default:
                $link = false;
                break;
        }
        $target = $settings['link']['is_external'] ? 'target="_blank"' : '';

        $animation_class = ! empty( $settings['hover_animation'] ) ? 'elementor-animation-' . $settings['hover_animation'] : '';

        $html = sprintf( '<%1$s class="lakit-post-date %2$s">', $settings['html_tag'], $animation_class );
        if ( $link ) {
            $html .= sprintf( '<a href="%1$s" %2$s>%3$s</a>', $link, $target, $date );
        } else {
            $html .= $date;
        }
        $html .= sprintf( '</%s>', $settings['html_tag'] );

        echo $html;
    }

    protected function _content_template() {
        ?>
        <#
        // Backwards compitability check
        var datetype;
        if (settings.date_type) {
        datetype = settings.date_type;
        } else {
        datetype = "publish";
        }

        var data_fields = [];
        data_fields[ "modified" ] = "<?php echo get_the_modified_date(); ?>";
        data_fields[ "publish" ] = "<?php echo get_the_date(); ?>";

        var date = data_fields[ datetype ];

        var link_url;
        switch( settings.link_to ) {
        case 'custom':
        link_url = settings.link.url;
        break;
        case 'post':
        link_url = '<?php echo esc_url( get_the_permalink() ); ?>';
        break;
        case 'home':
        link_url = '<?php echo esc_url( get_home_url() ); ?>';
        break;
        case 'none':
        default:
        link_url = false;
        }
        var target = settings.link.is_external ? 'target="_blank"' : '';

        var animation_class = '';
        if ( '' !== settings.hover_animation ) {
        animation_class = 'elementor-animation-' + settings.hover_animation;
        }

        var html = '<' + settings.html_tag + ' class="lakit-post-date ' + animation_class + '">';
        if ( link_url ) {
        html += '<a href="' + link_url + '" ' + target + '>' + date + '</a>';
        } else {
        html += date;
        }
        html += '</' + settings.html_tag + '>';

        print( html );
        #>
        <?php
    }
    
}