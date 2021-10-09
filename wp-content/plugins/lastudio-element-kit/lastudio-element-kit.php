<?php
/**
 * Plugin Name:       LA-Studio Element Kit for Elementor
 * Description:       This plugin helps you to add custom size units into padding/setting of common widgets for Elementor
 * Version:           1.0.3.2
 * Author:            LA-Studio
 * Author URI:        https://la-studioweb.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lastudio-kit
 * Domain Path:       /languages
 *
 * Elementor tested up to: 3.2.4
 * Elementor Pro tested up to: 3.2
 *
 * @package lastudio-kit
 * @author  LA-Studio
 * @license GPL-2.0+
 * @copyright  2021, LA-Studio
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

if(!function_exists('LaStudio_Kit')){
    class LaStudio_Kit{
        /**
         * A reference to an instance of this class.
         *
         * @since  1.0.0
         * @access private
         * @var    object
         */
        private static $instance = null;

        /**
         * Holder for base plugin URL
         *
         * @since  1.0.0
         * @access private
         * @var    string
         */
        private $plugin_url = null;

        /**
         * Holder for base plugin path
         *
         * @since  1.0.0
         * @access private
         * @var    string
         */
        private $plugin_path = null;

        /**
         * Plugin version
         *
         * @var string
         */
        private $version = '1.0.3';

        /**
         * Framework component
         *
         * @since  1.0.0
         * @access public
         * @var    object
         */
        public $module_loader = null;

        public $modules_manager;


        /**
         * Sets up needed actions/filters for the plugin to initialize.
         *
         * @since 1.0.0
         * @access public
         * @return void
         */
        public function __construct() {

            spl_autoload_register( [ $this, 'autoload' ] );

            // Load the CX Loader.
            add_action( 'after_setup_theme', array( $this, 'module_loader' ), -20 );

            // Internationalize the text strings used.
            add_action( 'init', array( $this, 'lang' ), -999 );

            // Load files.
            add_action( 'init', array( $this, 'init' ), -999 );

            // Dashboard Init
            add_action( 'init', array( $this, 'dashboard_init' ), -999 );

            // Add body class
            add_filter('body_class', array( $this, 'body_class' ), 0);

            // Register activation and deactivation hook.
            register_activation_hook( __FILE__, array( $this, 'activation' ) );
            register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );

            add_action( 'elementor/init', [ $this, 'on_elementor_init' ] );

            add_action('admin_enqueue_scripts', [ $this, 'admin_enqueue'] );

            add_action('elementor/element/after_section_end', array( $this, 'add_size_units' ), 10, 2);
        }

        /**
         * Load the theme modules.
         *
         * @since  1.0.0
         */
        public function module_loader() {
            require $this->plugin_path( 'includes/framework/loader.php' );

            $this->module_loader = new LaStudio_Kit_CX_Loader(
                array(
                    $this->plugin_path( 'includes/framework/vue-ui/cherry-x-vue-ui.php' ),
                    $this->plugin_path( 'includes/framework/db-updater/cx-db-updater.php' ),
                    $this->plugin_path( 'includes/framework/dashboard/dashboard.php' ),
                    $this->plugin_path( 'includes/framework/elementor-extension/elementor-extension.php' ),
                    $this->plugin_path( 'includes/class-breadcrumbs.php' ),
                )
            );

            // Enable support for Post Formats
            add_theme_support( 'post-formats', array( 'standard', 'video', 'gallery', 'audio', 'quote', 'link' ) );
        }

        /**
         * Returns plugin version
         *
         * @return string
         */
        public function get_version() {
            return $this->version;
        }

        /**
         * Manually init required modules.
         *
         * @return void
         */
        public function init() {
            if ( ! $this->has_elementor() ) {
                add_action( 'admin_notices', array( $this, 'required_plugins_notice' ) );
                return;
            }

            $this->load_files();

            lastudio_kit_integration()->init();

            //Init Rest Api
            new \LaStudioKit\Rest_Api();

            if ( is_admin() ) {

                //Init Settings Manager
                new \LaStudioKit\Settings();
                // include DB upgrader
                require $this->plugin_path( 'includes/class-db-upgrader.php' );
                // Init DB upgrader
                new LaStudio_Kit_DB_Upgrader();
            }

            do_action( 'lastudio-kit/init', $this );
        }

        /**
         * [dashboard_init description]
         * @return [type] [description]
         */
        public function dashboard_init() {

            if ( is_admin() ) {

                $lastudio_kit_dashboard_module_data = $this->module_loader->get_included_module_data( 'dashboard.php' );

                $lastudio_kit_dashboard = \LaStudioKit_Dashboard\Dashboard::get_instance();

                $lastudio_kit_dashboard->init( array(
                    'path'           => $lastudio_kit_dashboard_module_data['path'],
                    'url'            => $lastudio_kit_dashboard_module_data['url'],
                    'cx_ui_instance' => array( $this, 'dashboard_ui_instance_init' ),
                    'plugin_data'    => array(
                        'slug'    => 'lastudio-kit',
                        'file'    => 'lastudio-element-kit/lastudio-element-kit.php',
                        'version' => $this->get_version(),
                        'plugin_links' => array(
                            array(
                                'label'  => esc_html__( 'Go to settings', 'lastudio-kit' ),
                                'url'    => add_query_arg( array( 'page' => 'lastudio-kit-dashboard-settings-page', 'subpage' => 'lastudio-kit-general-settings' ), admin_url( 'admin.php' ) ),
                                'target' => '_self',
                            ),
                        ),
                    ),
                ) );
            }
        }

        /**
         * [dashboard_ui_instance_init description]
         * @return [type] [description]
         */
        public function dashboard_ui_instance_init() {
            $cx_ui_module_data = $this->module_loader->get_included_module_data( 'cherry-x-vue-ui.php' );

            return new CX_Vue_UI( $cx_ui_module_data );
        }

        /**
         * Show recommended plugins notice.
         *
         * @return void
         */
        public function required_plugins_notice() {
            $screen = get_current_screen();

            if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
                return;
            }

            $plugin = 'elementor/elementor.php';

            $installed_plugins      = get_plugins();
            $is_elementor_installed = isset( $installed_plugins[ $plugin ] );

            if ( $is_elementor_installed ) {
                if ( ! current_user_can( 'activate_plugins' ) ) {
                    return;
                }

                $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );

                $message = sprintf( '<p>%s</p>', esc_html__( 'LA-Studio Kit requires Elementor to be activated.', 'lastudio-kit' ) );
                $message .= sprintf( '<p><a href="%s" class="button-primary">%s</a></p>', $activation_url, esc_html__( 'Activate Elementor Now', 'lastudio-kit' ) );
            }
            else {
                if ( ! current_user_can( 'install_plugins' ) ) {
                    return;
                }

                $install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

                $message = sprintf( '<p>%s</p>', esc_html__( 'LA-Studio Kit requires Elementor to be installed.', 'lastudio-kit' ) );
                $message .= sprintf( '<p><a href="%s" class="button-primary">%s</a></p>', $install_url, esc_html__( 'Install Elementor Now', 'lastudio-kit' ) );
            }

            printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
        }

        /**
         * Check if theme has elementor
         *
         * @return boolean
         */
        public function has_elementor() {
            return defined( 'ELEMENTOR_VERSION' );
        }

        /**
         * Check if theme has elementor
         *
         * @return boolean
         */
        public function has_elementor_pro() {
            return defined( 'ELEMENTOR_PRO_VERSION' );
        }

        /**
         * Returns Elementor instance
         *
         * @return object
         */
        public function elementor() {
            return \Elementor\Plugin::$instance;
        }

        /**
         * Load required files.
         *
         * @return void
         */
        public function load_files() {

            require $this->plugin_path( 'includes/class-helper.php' );
            require $this->plugin_path( 'includes/class-integration.php' );
            require $this->plugin_path( 'includes/class-settings.php' );
            require $this->plugin_path( 'includes/settings/manager.php' );

            require $this->plugin_path( 'includes/rest-api/template-helper.php' );
            require $this->plugin_path( 'includes/rest-api/rest-api.php' );
            require $this->plugin_path( 'includes/rest-api/endpoints/base.php' );
            require $this->plugin_path( 'includes/rest-api/endpoints/elementor-template.php' );
            require $this->plugin_path( 'includes/rest-api/endpoints/plugin-settings.php' );
            require $this->plugin_path( 'includes/rest-api/endpoints/get-menu-items.php' );

        }

        /**
         * Returns path to file or dir inside plugin folder
         *
         * @param  string $path Path inside plugin dir.
         * @return string
         */
        public function plugin_path( $path = null ) {

            if ( ! $this->plugin_path ) {
                $this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
            }

            return $this->plugin_path . $path;
        }
        /**
         * Returns url to file or dir inside plugin folder
         *
         * @param  string $path Path inside plugin dir.
         * @return string
         */
        public function plugin_url( $path = null ) {

            if ( ! $this->plugin_url ) {
                $this->plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );
            }

            return $this->plugin_url . $path;
        }

        /**
         * Loads the translation files.
         *
         * @since 1.0.0
         * @access public
         * @return void
         */
        public function lang() {
            load_plugin_textdomain( 'lastudio-kit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        /**
         * Get the template path.
         *
         * @return string
         */
        public function template_path() {
            return apply_filters( 'lastudio-kit/template-path', 'lastudio-kit/' );
        }

        /**
         * Returns path to template file.
         *
         * @return string|bool
         */
        public function get_template( $name = null ) {

            $template = locate_template( $this->template_path() . $name );

            if ( ! $template ) {
                $template = $this->plugin_path( 'templates/' . $name );
            }

            if ( file_exists( $template ) ) {
                return $template;
            } else {
                return false;
            }
        }

        /**
         * Do some stuff on plugin activation
         *
         * @since  1.0.0
         * @return void
         */
        public function activation() {
        }

        /**
         * Do some stuff on plugin activation
         *
         * @since  1.0.0
         * @return void
         */
        public function deactivation() {
        }

        /**
         *
         * Add custom css class into body tag
         *
         * @param $classes
         * @return array
         */
        public function body_class( $classes ){
            if(is_rtl()){
                $classes[] = 'rtl';
            }
            else{
                $classes[] = 'ltr';
            }
            return $classes;
        }

        public function on_elementor_init(){
            if( ! $this->has_elementor_pro() ){
                $this->modules_manager = new \LaStudioKitThemeBuilder\Modules\Modules_Manager();
            }
        }

        public function admin_enqueue(){
            wp_enqueue_script(
                'lastudio-kit-admin',
                $this->plugin_url('assets/js/lastudio-kit-admin.js'),
                array( 'jquery' ),
                $this->get_version()
            );
        }

        public static function get_instance() {
            // If the single instance hasn't been set, set it now.
            if ( null == self::$instance ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function autoload( $class ) {
            if ( 0 !== strpos( $class, 'LaStudioKitThemeBuilder' ) ) {
                return;
            }

            if ( ! class_exists( $class ) ) {

                $filename = strtolower(
                    preg_replace(
                        [ '/^' . 'LaStudioKitThemeBuilder' . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
                        [ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
                        $class
                    )
                );

                $filename = $this->plugin_path('includes/' . $filename . '.php');

                if ( is_readable( $filename ) ) {
                    include( $filename );
                }
            }

        }

        public function add_size_units( $controls_stack, $section_id ){
            if($section_id === 'section_advanced'){
                $controls_stack->update_responsive_control(
                    'margin',
                    [
                        'size_units' => [ 'px', 'em', '%', 'rem', 'vw', 'vh' ]
                    ]
                );
                $controls_stack->update_responsive_control(
                    'padding',
                    [
                        'size_units' => [ 'px', 'em', '%', 'rem', 'vw', 'vh' ]
                    ]
                );
            }

            if($section_id === '_section_style'){
                $controls_stack->update_responsive_control(
                    '_margin',
                    [
                        'size_units' => [ 'px', 'em', '%', 'rem', 'vw', 'vh' ]
                    ]
                );
                $controls_stack->update_responsive_control(
                    '_padding',
                    [
                        'size_units' => [ 'px', 'em', '%', 'rem', 'vw', 'vh' ]
                    ]
                );
            }
        }

        public function get_theme_support( $prop = '', $default = null ) {
            $theme_support = get_theme_support( 'lastudio' );
            $theme_support = is_array( $theme_support ) ? $theme_support[0] : false;

            if ( ! $theme_support ) {
                return $default;
            }

            if ( $prop ) {
                $prop_stack = explode( '::', $prop );
                $prop_key   = array_shift( $prop_stack );

                if ( isset( $theme_support[ $prop_key ] ) ) {
                    $value = $theme_support[ $prop_key ];

                    if ( count( $prop_stack ) ) {
                        foreach ( $prop_stack as $prop_key ) {
                            if ( is_array( $value ) && isset( $value[ $prop_key ] ) ) {
                                $value = $value[ $prop_key ];
                            } else {
                                $value = $default;
                                break;
                            }
                        }
                    }
                } else {
                    $value = $default;
                }

                return $value;
            }

            return $theme_support;
        }

    }
}

if(!function_exists('lastudio_kit')){
    /**
     * Returns instance of the plugin class.
     *
     * @since  1.0.0
     * @return object
     */
    function lastudio_kit(){
        return LaStudio_Kit::get_instance();
    }
}

lastudio_kit();