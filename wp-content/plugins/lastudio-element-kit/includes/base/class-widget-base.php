<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use LaStudioKit_Extension\Controls\Group_Control_Box_Style;

abstract class LaStudioKit_Base extends Widget_Base {

    public $_context          = 'render';
    public $_processed_item   = false;
    public $_processed_index  = 0;
    public $_load_level       = 100;
    public $_include_controls = [];
    public $_exclude_controls = [];
    public $_new_icon_prefix  = 'selected_';

    /**
     * [__construct description]
     * @param array  $data [description]
     * @param [type] $args [description]
     */
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );

        $this->_load_level = (int)lastudio_kit_settings()->get( 'widgets_load_level', 100 );

        $widget_name = $this->get_name();

        $this->_include_controls = apply_filters( "lastudio-kit/editor/{$widget_name}/include-controls", [], $widget_name, $this );

        $this->_exclude_controls = apply_filters( "lastudio-kit/editor/{$widget_name}/exclude-controls", [], $widget_name, $this );

        $this->enqueue_addon_resources();
    }

    protected function enqueue_addon_resources(){

    }

    protected function get_html_wrapper_class() {
        return 'lastudio-kit elementor-' . $this->get_name();
    }

    protected function get_widget_title(){
        return '';
    }

    public function get_title(){
        return 'LaStudioKit ' . $this->get_widget_title();
    }

    public function get_categories() {
        return [ 'lastudiokit' ];
    }

    /**
     * [get_kit_help_url description]
     * @return [type] [description]
     */
    public function get_kit_help_url() {
        return false;
    }

    /**
     * [get_help_url description]
     * @return [type] [description]
     */
    public function get_help_url() {

        $url = $this->get_kit_help_url();

        $style_parent_theme = wp_get_theme( get_template() );

        $author_slug = strtolower( preg_replace('/\s+/', '', $style_parent_theme->get('Author') ) );

        if ( ! empty( $url ) ) {
            return add_query_arg(
                array(
                    'utm_source'   => $author_slug,
                    'utm_medium'   => 'lastudiokit' . '_' . $this->get_name(),
                    'utm_campaign' => 'need-help',
                ),
                esc_url( $url )
            );
        }

        return false;
    }
    
    /**
     * Get globaly affected template
     *
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function _get_global_template( $name = null ) {

        $widget_name = str_replace(['lakit-', 'lastudio-kit-'], '', $this->get_name());

        $template = call_user_func( array( $this, sprintf( '_get_%s_template', $this->_context ) ), $name );

        if ( ! $template ) {
            $template = lastudio_kit()->get_template( $widget_name . '/global/' . $name . '.php' );
        }

        return $template;
    }

    /**
     * Get front-end template
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function _get_render_template( $name = null ) {
        return lastudio_kit()->get_template( $this->get_name() . '/render/' . $name . '.php' );
    }

    /**
     * Get editor template
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function _get_edit_template( $name = null ) {
        return lastudio_kit()->get_template( $this->get_name() . '/edit/' . $name . '.php' );
    }

    /**
     * Load template directly
     * @param $template
     * @access protected
     */
    protected function _load_template( $template ){
        include $template;
    }

    /**
     * Get global looped template for settings
     * Required only to process repeater settings.
     *
     * @param  string $name     Base template name.
     * @param  string $setting  Repeater setting that provide data for template.
     * @param  string $callback Callback for preparing a loop array
     * @return void
     */
    public function _get_global_looped_template( $name = null, $setting = null, $callback = null ) {

        $templates = array(
            'start' => $this->_get_global_template( $name . '-loop-start' ),
            'loop'  => $this->_get_global_template( $name . '-loop-item' ),
            'end'   => $this->_get_global_template( $name . '-loop-end' ),
        );

        call_user_func(
            array( $this, sprintf( '_get_%s_looped_template', $this->_context ) ), $templates, $setting, $callback
        );

    }

    /**
     * Get render mode looped template
     *
     * @param  array  $templates [description]
     * @param  string $setting   [description]
     * @param  string $callback  Callback for preparing a loop array
     * @return void
     */
    public function _get_render_looped_template( $templates = array(), $setting = null, $callback = null ) {

        $loop = $this->get_settings_for_display( $setting );
        $loop = apply_filters( 'lastudio-kit/widget/loop-items', $loop, $setting, $this );

        if ( empty( $loop ) ) {
            return;
        }

        if ( $callback && is_callable( $callback ) ) {
            $loop = call_user_func( $callback, $loop );
        }

        if ( ! empty( $templates['start'] ) ) {
            include $templates['start'];
        }

        foreach ( $loop as $item ) {

            $this->_processed_item = $item;

            if ( ! empty( $templates['loop'] ) ) {
                include $templates['loop'];
            }
            $this->_processed_index++;
        }

        $this->_processed_item = false;
        $this->_processed_index = 0;

        if ( ! empty( $templates['end'] ) ) {
            include $templates['end'];
        }

    }

    /**
     * Get edit mode looped template
     *
     * @param  array  $templates [description]
     * @param  [type] $setting   [description]
     * @return [type]            [description]
     */
    public function _get_edit_looped_template( $templates = array(), $setting = null ) {
        ?>
        <# if ( settings.<?php echo $setting; ?> ) { #>
        <?php
        if ( ! empty( $templates['start'] ) ) {
            include $templates['start'];
        }
        ?>
        <# _.each( settings.<?php echo $setting; ?>, function( item ) { #>
        <?php
        if ( ! empty( $templates['loop'] ) ) {
            include $templates['loop'];
        }
        ?>
        <# } ); #>
        <?php
        if ( ! empty( $templates['end'] ) ) {
            include $templates['end'];
        }
        ?>
        <# } #>
        <?php
    }

    /**
     * Get current looped item dependends from context.
     *
     * @param  string $key Key to get from processed item
     * @return mixed
     */
    public function _loop_item( $keys = array(), $format = '%s' ) {

        return call_user_func( array( $this, sprintf( '_%s_loop_item', $this->_context ) ), $keys, $format );

    }

    /**
     * Loop edit item
     *
     * @param  [type]  $keys       [description]
     * @param  string  $format     [description]
     * @param  boolean $nested_key [description]
     * @return [type]              [description]
     */
    public function _edit_loop_item( $keys = array(), $format = '%s' ) {

        $settings = $keys[0];

        if ( isset( $keys[1] ) ) {
            $settings .= '.' . $keys[1];
        }

        ob_start();

        echo '<# if ( item.' . $settings . ' ) { #>';
        printf( $format, '{{{ item.' . $settings . ' }}}' );
        echo '<# } #>';

        return ob_get_clean();
    }

    /**
     * Loop render item
     *
     * @param  string  $format     [description]
     * @param  [type]  $key        [description]
     * @param  boolean $nested_key [description]
     * @return [type]              [description]
     */
    public function _render_loop_item( $keys = array(), $format = '%s' ) {

        $item = $this->_processed_item;

        $key        = $keys[0];
        $nested_key = isset( $keys[1] ) ? $keys[1] : false;

        if ( empty( $item ) || ! isset( $item[ $key ] ) ) {
            return false;
        }

        if ( false === $nested_key || ! is_array( $item[ $key ] ) ) {
            $value = $item[ $key ];
        } else {
            $value = isset( $item[ $key ][ $nested_key ] ) ? $item[ $key ][ $nested_key ] : false;
        }

        if ( ! empty( $value ) ) {
            return sprintf( $format, $value );
        }

    }

    /**
     * Include global template if any of passed settings is defined
     *
     * @param  [type] $name     [description]
     * @param  [type] $settings [description]
     * @return [type]           [description]
     */
    public function _glob_inc_if( $name = null, $settings = array() ) {

        $template = $this->_get_global_template( $name );

        call_user_func( array( $this, sprintf( '_%s_inc_if', $this->_context ) ), $template, $settings );

    }

    /**
     * Include render template if any of passed setting is not empty
     *
     * @param  [type] $file     [description]
     * @param  [type] $settings [description]
     * @return [type]           [description]
     */
    public function _render_inc_if( $file = null, $settings = array() ) {

        foreach ( $settings as $setting ) {
            $val = $this->get_settings_for_display( $setting );

            if ( ! empty( $val ) ) {
                include $file;
                return;
            }

        }

    }

    /**
     * Include render template if any of passed setting is not empty
     *
     * @param  [type] $file     [description]
     * @param  [type] $settings [description]
     * @return [type]           [description]
     */
    public function _edit_inc_if( $file = null, $settings = array() ) {

        $condition = null;
        $sep       = null;

        foreach ( $settings as $setting ) {
            $condition .= $sep . 'settings.' . $setting;
            $sep = ' || ';
        }

        ?>

        <# if ( <?php echo $condition; ?> ) { #>

        <?php include $file; ?>

        <# } #>

        <?php
    }

    /**
     * Open standard wrapper
     *
     * @return void
     */
    public function _open_wrap() {

    }

    /**
     * Close standard wrapper
     *
     * @return void
     */
    public function _close_wrap() {

    }

    /**
     * Print HTML markup if passed setting not empty.
     *
     * @param  string $setting Passed setting.
     * @param  string $format  Required markup.
     * @param  array  $args    Additional variables to pass into format string.
     * @param  bool   $echo    Echo or return.
     * @return string|void
     */
    public function _html( $setting = null, $format = '%s' ) {

        call_user_func( array( $this, sprintf( '_%s_html', $this->_context ) ), $setting, $format );

    }

    /**
     * Returns HTML markup if passed setting not empty.
     *
     * @param  string $setting Passed setting.
     * @param  string $format  Required markup.
     * @param  array  $args    Additional variables to pass into format string.
     * @param  bool   $echo    Echo or return.
     * @return string|void
     */
    public function _get_html( $setting = null, $format = '%s' ) {

        ob_start();
        $this->_html( $setting, $format );
        return ob_get_clean();

    }

    /**
     * Print HTML template
     *
     * @param  [type] $setting [description]
     * @param  [type] $format  [description]
     * @return [type]          [description]
     */
    public function _render_html( $setting = null, $format = '%s' ) {

        if ( is_array( $setting ) ) {
            $key     = $setting[1];
            $setting = $setting[0];
        }

        $val = $this->get_settings_for_display( $setting );

        if ( ! is_array( $val ) && '0' === $val ) {
            printf( $format, $val );
        }

        if ( is_array( $val ) && empty( $val[ $key ] ) ) {
            return '';
        }

        if ( ! is_array( $val ) && empty( $val ) ) {
            return '';
        }

        if ( is_array( $val ) ) {
            printf( $format, $val[ $key ] );
        } else {
            printf( $format, $val );
        }

    }

    /**
     * Print underscore template
     *
     * @param  [type] $setting [description]
     * @param  [type] $format  [description]
     * @return [type]          [description]
     */
    public function _edit_html( $setting = null, $format = '%s' ) {

        if ( is_array( $setting ) ) {
            $setting = $setting[0] . '.' . $setting[1];
        }

        echo '<# if ( settings.' . $setting . ' ) { #>';
        printf( $format, '{{{ settings.' . $setting . ' }}}' );
        echo '<# } #>';
    }

    /**
     * Add icon control
     *
     * @param string $id
     * @param array  $args
     * @param object $instance
     */
    public function _add_advanced_icon_control( $id, array $args = array(), $instance = null ) {

        if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {

            $_id = $id; // old control id
            $id  = $this->_new_icon_prefix . $id;

            $args['type'] = Controls_Manager::ICONS;
            $args['fa4compatibility'] = $_id;

            unset( $args['file'] );
            unset( $args['default'] );

            if ( isset( $args['fa5_default'] ) ) {
                $args['default'] = $args['fa5_default'];

                unset( $args['fa5_default'] );
            }
        } else {
            $args['type'] = Controls_Manager::ICON;
            unset( $args['fa5_default'] );
        }

        if ( null !== $instance ) {
            $instance->add_control( $id, $args );
        } else {
            $this->add_control( $id, $args );
        }
    }

    /**
     * Prepare icon control ID for condition.
     *
     * @param  string $id Old icon control ID.
     * @return string
     */
    public function _prepare_icon_id_for_condition( $id ) {

        if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {
            return $this->_new_icon_prefix . $id . '[value]';
        }

        return $id;
    }

    /**
     * Print HTML icon markup
     *
     * @param  array $setting
     * @param  string $format
     * @param  string $icon_class
     * @return void
     */
    public function _icon( $setting = null, $format = '%s', $icon_class = '' ) {
        call_user_func( array( $this, sprintf( '_%s_icon', $this->_context ) ), $setting, $format, $icon_class );
    }

    /**
     * Returns HTML icon markup
     *
     * @param  array $setting
     * @param  string $format
     * @param  string $icon_class
     * @return string
     */
    public function _get_icon( $setting = null, $format = '%s', $icon_class = '' ) {
        return $this->_render_icon( $setting, $format, $icon_class, false );
    }

    /**
     * Print HTML icon template
     *
     * @param  array  $setting
     * @param  string $format
     * @param  string $icon_class
     * @param  bool   $echo
     *
     * @return void|string
     */
    public function _render_icon( $setting = null, $format = '%s', $icon_class = '', $echo = true ) {

        if ( false === $this->_processed_item ) {
            $settings = $this->get_settings_for_display();
        } else {
            $settings = $this->_processed_item;
        }

        $new_setting = $this->_new_icon_prefix . $setting;

        $migrated = isset( $settings['__fa4_migrated'][ $new_setting ] );
        $is_new   = empty( $settings[ $setting ] ) && class_exists( 'Elementor\Icons_Manager' ) && Icons_Manager::is_migration_allowed();

        $icon_html = '';

        if ( $is_new || $migrated ) {

            $attr = array( 'aria-hidden' => 'true' );

            if ( ! empty( $icon_class ) ) {
                $attr['class'] = $icon_class;
            }

            if ( isset( $settings[ $new_setting ] ) ) {
                ob_start();
                Icons_Manager::render_icon( $settings[ $new_setting ], $attr );

                $icon_html = ob_get_clean();
            }

        } else if ( ! empty( $settings[ $setting ] ) ) {

            if ( empty( $icon_class ) ) {
                $icon_class = $settings[ $setting ];
            } else {
                $icon_class .= ' ' . $settings[ $setting ];
            }

            $icon_html = sprintf( '<i class="%s" aria-hidden="true"></i>', $icon_class );
        }

        if ( empty( $icon_html ) ) {
            return;
        }

        if ( ! $echo ) {
            return sprintf( $format, $icon_html );
        }

        printf( $format, $icon_html );
    }

    /**
     * [__add_control description]
     * @param  boolean $control_id   [description]
     * @param  array   $control_args [description]
     * @param  integer $load_level   [description]
     * @return [type]                [description]
     */
    public function _add_control( $control_id = false, $control_args = [], $load_level = 100 ) {

        if (
            ( $this->_load_level < $load_level
                || 0 === $this->_load_level
                || in_array( $control_id, $this->_exclude_controls )
            ) && !in_array( $control_id, $this->_include_controls )
        ) {
            return false;
        }

        $this->add_control( $control_id, $control_args );
    }

    /**
     * [__add_responsive_control description]
     * @param  boolean $control_id   [description]
     * @param  array   $control_args [description]
     * @param  integer $load_level   [description]
     * @return [type]                [description]
     */
    public function _add_responsive_control( $control_id = false, $control_args = [], $load_level = 100 ) {

        if (
            ( $this->_load_level < $load_level
                || 0 === $this->_load_level
                || in_array( $control_id, $this->_exclude_controls )
            ) && !in_array( $control_id, $this->_include_controls )
        ) {
            return false;
        }

        $this->add_responsive_control( $control_id, $control_args );
    }

    /**
     * [__add_group_control description]
     * @param  boolean $group_control_type [description]
     * @param  array   $group_control_args [description]
     * @param  integer $load_level         [description]
     * @return [type]                      [description]
     */
    public function _add_group_control( $group_control_type = false, $group_control_args = [], $load_level = 100 ) {

        if (
            ( $this->_load_level < $load_level
                || 0 === $this->_load_level
                || in_array( $group_control_args['name'], $this->_exclude_controls )
            ) && !in_array( $group_control_args['name'], $this->_include_controls )
        ) {
            return false;
        }

        $this->add_group_control( $group_control_type, $group_control_args );
    }

    /**
     * [__add_icon_control description]
     * @param  [type] $id   [description]
     * @param  array  $args [description]
     * @return [type]       [description]
     */
    public function _add_icon_control( $id, array $args = array(), $load_level = 100 ) {

        if (
            ( $this->_load_level < $load_level
                || 0 === $this->_load_level
                || in_array( $id, $this->_exclude_controls )
            ) && !in_array( $id, $this->_include_controls )
        ) {
            return false;
        }

        $this->_add_advanced_icon_control( $id, $args );
    }

    /**
     * [__start_controls_section description]
     * @param  boolean $controls_section_id   [description]
     * @param  array   $controls_section_args [description]
     * @param  integer $load_level            [description]
     * @return [type]                         [description]
     */
    public function _start_controls_section( $controls_section_id = false, $controls_section_args = [], $load_level = 25 ) {

        if ( ! $controls_section_id || $this->_load_level < $load_level || 0 === $this->_load_level ) {
            return false;
        }

        $this->start_controls_section( $controls_section_id, $controls_section_args );
    }

    /**
     * [__end_controls_section description]
     * @param  integer $load_level [description]
     * @return [type]              [description]
     */
    public function _end_controls_section( $load_level = 25 ) {

        if ( $this->_load_level < $load_level || 0 === $this->_load_level ) {
            return false;
        }

        $this->end_controls_section();
    }

    /**
     * [__start_controls_tabs description]
     * @param  boolean $tabs_id    [description]
     * @param  integer $load_level [description]
     * @return [type]              [description]
     */
    public function _start_controls_tabs( $tabs_id = false, $tab_args = [], $load_level = 25 ) {

        if ( ! $tabs_id || $this->_load_level < $load_level || 0 === $this->_load_level ) {
            return false;
        }

        $this->start_controls_tabs( $tabs_id, $tab_args );
    }

    /**
     * [__end_controls_tabs description]
     * @param  integer $load_level [description]
     * @return [type]              [description]
     */
    public function _end_controls_tabs( $load_level = 25 ) {

        if ( $this->_load_level < $load_level || 0 === $this->_load_level ) {
            return false;
        }

        $this->end_controls_tabs();
    }

    /**
     * [__start_controls_tab description]
     * @param  boolean $tab_id     [description]
     * @param  array   $tab_args   [description]
     * @param  integer $load_level [description]
     * @return [type]              [description]
     */
    public function _start_controls_tab( $tab_id = false, $tab_args = [], $load_level = 25 ) {

        if ( ! $tab_id || $this->_load_level < $load_level || 0 === $this->_load_level ) {
            return false;
        }

        $this->start_controls_tab( $tab_id, $tab_args );
    }

    /**
     * [__end_controls_tab description]
     * @param  integer $load_level [description]
     * @return [type]              [description]
     */
    public function _end_controls_tab( $load_level = 25 ) {

        if ( $this->_load_level < $load_level || 0 === $this->_load_level ) {
            return false;
        }

        $this->end_controls_tab();
    }

    /**
     * Start popover
     *
     * @param int $load_level
     * @return void|bool
     */
    public function _start_popover( $load_level = 25 ) {

        if ( $this->_load_level < $load_level || 0 === $this->_load_level ) {
            return false;
        }

        $this->start_popover();
    }

    /**
     * End popover
     *
     * @param int $load_level
     * @return void|bool
     */
    public function _end_popover( $load_level = 25 ) {

        if ( $this->_load_level < $load_level || 0 === $this->_load_level ) {
            return false;
        }

        $this->end_popover();
    }

    public function _get_icon_setting( $setting = null, $format = '%s', $icon_class = '', $echo = false ){
        $icon_html = '';

        $attr = array( 'aria-hidden' => 'true' );

        if ( ! empty( $icon_class ) ) {
            $attr['class'] = $icon_class;
        }

        if(!empty($setting)){
            ob_start();
            Icons_Manager::render_icon( $setting, $attr );
            $icon_html = ob_get_clean();
        }

        if ( empty( $icon_html ) ) {
            return;
        }

        if ( ! $echo ) {
            return sprintf( $format, $icon_html );
        }

        printf( $format, $icon_html );

    }

    public function _add_link_attributes( $element, array $url_control, $overwrite = false ) {
        if ( method_exists( $this, 'add_link_attributes' ) ) {
            return $this->add_link_attributes( $element, $url_control, $overwrite );
        }

        $attributes = array();

        if ( ! empty( $url_control['url'] ) ) {
            $attributes['href'] = esc_url( $url_control['url'] );
        }

        if ( ! empty( $url_control['is_external'] ) ) {
            $attributes['target'] = '_blank';
        }

        if ( ! empty( $url_control['nofollow'] ) ) {
            $attributes['rel'] = 'nofollow';
        }

        if ( $attributes ) {
            $this->add_render_attribute( $element, $attributes, $overwrite );
        }

        return $this;
    }
    
    protected function register_carousel_section( $carousel_condition = [], $carousel_columns = false, $enable_carousel = true ){
        $this->_start_controls_section(
            'carousel_section',
            array(
                'label' => esc_html__( 'Carousel Settings', 'lastudio-kit' ),
                'condition' => $carousel_condition
            )
        );

        if($enable_carousel){
            $this->_add_control(
                'enable_carousel',
                array(
                    'label'        => esc_html__( 'Enable Carousel', 'lastudio-kit' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                    'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                    'return_value' => 'yes',
                    'default'      => '',
                )
            );
        }

        if($carousel_columns === false){
            $column_dependency = 'carousel_columns!';
            $this->_add_responsive_control(
                'carousel_columns',
                array(
                    'label'     => esc_html__( 'Slides to Show', 'lastudio-kit' ),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => '1',
                    'options'   => lastudio_kit_helper()->get_select_range(10),
                )
            );
        }
        else{
            $column_dependency = "{$carousel_columns}!";
        }

        $this->_add_responsive_control(
            'carousel_to_scroll',
            array(
                'label'     => esc_html__( 'Slides to Scroll', 'lastudio-kit' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => lastudio_kit_helper()->get_select_range(6),
                'condition' => array(
                    $column_dependency => '1',
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_rows',
            array(
                'label'     => esc_html__( 'Rows', 'lastudio-kit' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => lastudio_kit_helper()->get_select_range(6)
            )
        );

        $this->_add_control(
            'carousel_fluid_width',
            array(
                'label'        => esc_html__( 'Fluid Items Width', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $this->_add_control(
            'carousel_arrows',
            array(
                'label'        => esc_html__( 'Show Arrows Navigation', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'true',
                'default'      => 'true',
            )
        );

        $this->_add_icon_control(
            'carousel_prev_arrow',
            array(
                'label'       => esc_html__( 'Prev Arrow Icon', 'lastudio-kit' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'file'        => '',
                'default'     => 'fa fa-angle-left',
                'fa5_default' => array(
                    'value'   => 'fas fa-angle-left',
                    'library' => 'fa-solid',
                ),
                'condition' => array(
                    'carousel_arrows' => 'true',
                ),
            )
        );

        $this->_add_icon_control(
            'carousel_next_arrow',
            array(
                'label'       => esc_html__( 'Next Arrow Icon', 'lastudio-kit' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'file'        => '',
                'default'     => 'fa fa-angle-right',
                'fa5_default' => array(
                    'value'   => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ),
                'condition' => array(
                    'carousel_arrows' => 'true',
                ),
            )
        );

        $this->_add_control(
            'carousel_dots',
            array(
                'label'        => esc_html__( 'Show Dots Pagination', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'true',
                'default'      => '',
            )
        );

        $this->_add_control(
            'carousel_dot_type',
            array(
                'label'     => esc_html__( 'Dots Pagination Type', 'lastudio-kit' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'bullets',
                'options'   => [
                    'bullets'       => esc_html__('Bullets', 'lastudio-kit'),
                    'fraction'      => esc_html__('Fraction', 'lastudio-kit'),
                    'progressbar'   => esc_html__('Progressbar', 'lastudio-kit'),
                    'custom'        => esc_html__('Custom', 'lastudio-kit'),
                ],
                'condition' => array(
                    'carousel_dots' => 'true',
                ),
            )
        );

        $this->_add_control(
            'carousel_autoplay',
            array(
                'label'        => esc_html__( 'Autoplay', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'true',
                'default'      => 'true',
            )
        );

        $this->_add_control(
            'carousel_pause_on_hover',
            array(
                'label'        => esc_html__( 'Pause on Hover', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'true',
                'default'      => '',
                'condition' => array(
                    'carousel_autoplay' => 'true',
                ),
            )
        );

        $this->_add_control(
            'carousel_pause_on_interaction',
            array(
                'label'        => esc_html__( 'Pause on Interaction', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'true',
                'default'      => '',
                'condition' => array(
                    'carousel_autoplay' => 'true',
                ),
            )
        );

        $this->_add_control(
            'carousel_autoplay_speed',
            array(
                'label'     => esc_html__( 'Autoplay Speed', 'lastudio-kit' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => array(
                    'carousel_autoplay' => 'true',
                ),
            )
        );

        $this->_add_control(
            'carousel_loop',
            array(
                'label'        => esc_html__( 'Infinite Loop', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'true',
                'default'      => 'true',
            )
        );

        $this->_add_control(
            'carousel_effect',
            array(
                'label'   => esc_html__( 'Effect', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'description'=> esc_html__( 'The `Fade` option does not work if `slides to show` option is `1`', 'lastudio-kit' ),
                'default' => 'slide',
                'options' => array(
                    'slide' => esc_html__( 'Slide', 'lastudio-kit' ),
                    'fade'  => esc_html__( 'Fade', 'lastudio-kit' ),
                    'cube'  => esc_html__( 'Cube', 'lastudio-kit' ),
                    'coverflow'  => esc_html__( 'Coverflow', 'lastudio-kit' ),
                    'flip'  => esc_html__( 'Flip', 'lastudio-kit' ),
                )
            )
        );

        $this->_add_responsive_control(
            'carousel_item_width',
            array(
                'label' => esc_html__( 'Custom Item Width', 'lastudio-kit' ),
                'type' => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 300,
                    'unit' => 'px',
                ),
                'size_units' => ['px', 'em', 'vw', 'vh', '%'],
                'selectors' => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-carousel__item' => 'width: {{SIZE}}{{UNIT}};',
                ),
                'separator' => 'before',
                'condition' => array(
                    'carousel_effect' => ['flip', 'cube', 'coverflow'],
                ),
            )
        );

        $this->_add_control(
            'carousel_speed',
            array(
                'label'   => esc_html__( 'Animation Speed', 'lastudio-kit' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 500,
            )
        );

        $this->_add_control(
            'carousel_center_mode',
            array(
                'label'        => esc_html__( 'Center Mode', 'lastudio-kit' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'lastudio-kit' ),
                'label_off'    => esc_html__( 'No', 'lastudio-kit' ),
                'return_value' => 'yes',
                'default'      => ''
            )
        );

        $this->_add_responsive_control(
            'carousel_padding_left',
            array(
                'label'      => esc_html__( 'Padding Left', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( '%', 'px', 'em', 'vw', 'vh' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 500,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}}' => '--lakit-carousel-padding-left: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_padding_right',
            array(
                'label'      => esc_html__( 'Padding Right', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( '%', 'px', 'em', 'vw', 'vh' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 500,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}}' => '--lakit-carousel-padding-right: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->_end_controls_section();

    }

    protected function register_carousel_arrows_dots_style_section( $carousel_condition = []  ){

        /**
         * Arrow Sections
         */
        $this->_start_controls_section(
            'carousel_arrow_style_section',
            array(
                'label'      => esc_html__( 'Carousel Arrows', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition' => $carousel_condition
            )
        );

        $this->_start_controls_tabs( 'carousel_arrow_tabs' );

        $this->_start_controls_tab(
            'carousel_tab_arrow_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'carousel_arrow_normal_style',
                'label'          => esc_html__( 'Arrows Style', 'lastudio-kit' ),
                'selector'       => '{{WRAPPER}} .lakit-carousel .lakit-arrow'
            )
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'carousel_tab_arrow_hover',
            array(
                'label' => esc_html__( 'Hover', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'carousel_arrow_hover_style',
                'label'          => esc_html__( 'Arrows Style', 'lastudio-kit' ),
                'selector'       => '{{WRAPPER}} .lakit-carousel .lakit-arrow:hover'
            )
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_control(
            'carousel_prev_arrow_position',
            array(
                'label'     => esc_html__( 'Prev Arrow Position', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'carousel_prev_arrow_v_position_by',
            array(
                'label'   => esc_html__( 'Vertical Position by', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => array(
                    'top'    => esc_html__( 'Top', 'lastudio-kit' ),
                    'bottom' => esc_html__( 'Bottom', 'lastudio-kit' ),
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_prev_arrow_top_position',
            array(
                'label'      => esc_html__( 'Top Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'carousel_prev_arrow_v_position_by' => 'top',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-arrow.prev-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_prev_arrow_bottom_position',
            array(
                'label'      => esc_html__( 'Bottom Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'carousel_prev_arrow_v_position_by' => 'bottom',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-arrow.prev-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
                ),
            )
        );

        $this->_add_control(
            'carousel_prev_arrow_h_position_by',
            array(
                'label'   => esc_html__( 'Horizontal Position by', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => array(
                    'left'  => esc_html__( 'Left', 'lastudio-kit' ),
                    'right' => esc_html__( 'Right', 'lastudio-kit' ),
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_prev_arrow_left_position',
            array(
                'label'      => esc_html__( 'Left Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'carousel_prev_arrow_h_position_by' => 'left',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-arrow.prev-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_prev_arrow_right_position',
            array(
                'label'      => esc_html__( 'Right Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'carousel_prev_arrow_h_position_by' => 'right',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-arrow.prev-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ),
            )
        );

        $this->_add_control(
            'carousel_next_arrow_position',
            array(
                'label'     => esc_html__( 'Next Arrow Position', 'lastudio-kit' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->_add_control(
            'carousel_next_arrow_v_position_by',
            array(
                'label'   => esc_html__( 'Vertical Position by', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => array(
                    'top'    => esc_html__( 'Top', 'lastudio-kit' ),
                    'bottom' => esc_html__( 'Bottom', 'lastudio-kit' ),
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_next_arrow_top_position',
            array(
                'label'      => esc_html__( 'Top Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'carousel_next_arrow_v_position_by' => 'top',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-arrow.next-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_next_arrow_bottom_position',
            array(
                'label'      => esc_html__( 'Bottom Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'carousel_next_arrow_v_position_by' => 'bottom',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-arrow.next-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
                ),
            )
        );

        $this->_add_control(
            'carousel_next_arrow_h_position_by',
            array(
                'label'   => esc_html__( 'Horizontal Position by', 'lastudio-kit' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => array(
                    'left'  => esc_html__( 'Left', 'lastudio-kit' ),
                    'right' => esc_html__( 'Right', 'lastudio-kit' ),
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_next_arrow_left_position',
            array(
                'label'      => esc_html__( 'Left Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'carousel_next_arrow_h_position_by' => 'left',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-arrow.next-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_next_arrow_right_position',
            array(
                'label'      => esc_html__( 'Right Indent', 'lastudio-kit' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'carousel_next_arrow_h_position_by' => 'right',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-arrow.next-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ),
            )
        );

        $this->_end_controls_section();

        $this->_start_controls_section(
            'carousel_dot_style_section',
            array(
                'label'      => esc_html__( 'Carousel Dots', 'lastudio-kit' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition' => $carousel_condition
            )
        );

        $this->_start_controls_tabs( 'carousel_dot_tabs' );

        $this->_start_controls_tab(
            'carousel_tab_dot_normal',
            array(
                'label' => esc_html__( 'Normal', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'carousel_dot_normal_style',
                'label'          => esc_html__( 'Dots Style', 'lastudio-kit' ),
                'selector'       => '{{WRAPPER}} .lakit-carousel .swiper-pagination-bullet',
                'exclude' => array(
                    'box_font_color',
                    'box_font_size',
                ),
            )
        );

        $this->_end_controls_tab();

        $this->_start_controls_tab(
            'carousel_tab_dot_hover',
            array(
                'label' => esc_html__( 'Active', 'lastudio-kit' ),
            )
        );

        $this->_add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'carousel_dot_hover_style',
                'label'          => esc_html__( 'Dots Style', 'lastudio-kit' ),
                'selector'       => '{{WRAPPER}} .lakit-carousel .swiper-pagination-bullet-active,{{WRAPPER}} .lakit-carousel .swiper-pagination-bullet:hover',
                'exclude' => array(
                    'box_font_color',
                    'box_font_size',
                ),
            )
        );

        $this->_end_controls_tab();

        $this->_end_controls_tabs();

        $this->_add_responsive_control(
            'carousel_dots_gap',
            array(
                'label' => esc_html__( 'Gap', 'lastudio-kit' ),
                'type' => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 5,
                    'unit' => 'px',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .lakit-carousel .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
                ),
                'separator' => 'before',
            )
        );

        $this->_add_responsive_control(
            'carousel_dots_margin',
            array(
                'label'      => esc_html__( 'Dots Box Margin', 'lastudio-kit' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .lakit-carousel .lakit-carousel__dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->_add_responsive_control(
            'carousel_dots_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'lastudio-kit' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left' => array(
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
                    )
                ),
                'prefix_class' => 'lakit-dots-pos-',
            )
        );

        $this->_end_controls_section();
    }

    public function get_advanced_carousel_options( $carousel_columns = false ) {

        $settings = $this->get_settings();
        $widget_id = $this->get_id();

        $options  = array(
            'slidesToScroll' => lastudio_kit_helper()->get_attribute_with_all_breakpoints('carousel_to_scroll', $settings),
            'rows'           => lastudio_kit_helper()->get_attribute_with_all_breakpoints('carousel_rows', $settings),
            'autoplaySpeed'  => absint( $settings['carousel_autoplay_speed'] ),
            'autoplay'       => filter_var( $settings['carousel_autoplay'], FILTER_VALIDATE_BOOLEAN ),
            'infinite'       => filter_var( $settings['carousel_loop'], FILTER_VALIDATE_BOOLEAN ),
            'centerMode'     => filter_var( $settings['carousel_center_mode'], FILTER_VALIDATE_BOOLEAN ),
            'pauseOnHover'   => filter_var( $settings['carousel_pause_on_hover'], FILTER_VALIDATE_BOOLEAN ),
            'pauseOnInteraction'   => filter_var( $settings['carousel_pause_on_interaction'], FILTER_VALIDATE_BOOLEAN ),
            'speed'          => absint( $settings['carousel_speed'] ),
            'arrows'         => filter_var( $settings['carousel_arrows'], FILTER_VALIDATE_BOOLEAN ),
            'dots'           => filter_var( $settings['carousel_dots'], FILTER_VALIDATE_BOOLEAN ),
            'variableWidth'  => filter_var( $settings['carousel_fluid_width'], FILTER_VALIDATE_BOOLEAN ),
            'prevArrow'      => '.lakit-carousel__prev-arrow-' . $widget_id,
            'nextArrow'      => '.lakit-carousel__next-arrow-' . $widget_id,
            'rtl'            => is_rtl(),
            'effect'         => $settings['carousel_effect'],
            'dotType'       => $settings['carousel_dot_type'],
        );
        if($carousel_columns === false){
            $options['slidesToShow'] = lastudio_kit_helper()->get_attribute_with_all_breakpoints('carousel_columns', $settings);
        }
        else{
            $options['slidesToShow'] = lastudio_kit_helper()->get_attribute_with_all_breakpoints($carousel_columns, $settings);
        }
        return $options;
    }
}
