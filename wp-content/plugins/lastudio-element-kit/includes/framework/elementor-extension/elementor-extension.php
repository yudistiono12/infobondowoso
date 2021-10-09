<?php
/**
 * LaStudioKit Elementor Extension Module.
 *
 * Version: 1.0.0
 */

namespace LaStudioKit_Extension;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use Elementor\Core\Common\Modules\Ajax\Module as Ajax;

if ( ! class_exists( 'LaStudioKit_Extension\Module' ) ) {

    /**
     * Class LaStudioKit_Extension\Module.
     *
     * @since 1.0.0
     */
    class Module {

        /**
         * A reference to an instance of this class.
         *
         * @since  1.0.0
         * @access private
         * @var    object
         */
        private static $instance = null;

        /**
         * Module version.
         *
         * @var string
         */
        protected $version = '1.0.0';

        /**
         * Module directory path.
         *
         * @since 1.0.0
         * @access protected
         * @var srting.
         */
        protected $path;

        /**
         * Module directory URL.
         *
         * @since 1.0.0
         * @access protected
         * @var srting.
         */
        protected $url;

        /**
         * Constructor.
         *
         * @since  1.0.0
         * @param  array $args
         * @access public
         * @return void
         */
        public function __construct( array $args = array() ) {

            $this->path = $args['path'];
            $this->url  = $args['url'];

            $this->load_files();

            add_action( 'elementor/controls/controls_registered',  array( $this, 'register_controls' ) );
            add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_editor_scripts' ) );
            add_action( 'elementor/ajax/register_actions', [ $this, 'register_ajax_actions' ] );
            add_action( 'elementor/icons_manager/additional_tabs', [ $this, 'enqueue_custom_icon_fonts' ] );


            // Register private actions
            $priv_actions = array(
                'lakit_theme_search_posts' => array( $this, 'search_posts' ),
                'lakit_theme_search_pages' => array( $this, 'search_pages' ),
                'lakit_theme_search_cats'  => array( $this, 'search_cats' ),
                'lakit_theme_search_tags'  => array( $this, 'search_tags' ),
                'lakit_theme_search_terms' => array( $this, 'search_terms' ),
            );

            foreach ( $priv_actions as $tag => $callback ) {
                add_action( 'wp_ajax_' . $tag, $callback );
            }
        }

        /**
         * Load required files.
         */
        public function load_files() {

            require trailingslashit( $this->path ) . 'inc/controls/control-query.php';
            require trailingslashit( $this->path ) . 'inc/controls/group-control-query.php';
            require trailingslashit( $this->path ) . 'inc/controls/group-control-related.php';
            require trailingslashit( $this->path ) . 'inc/controls/group-control-box-style.php';
            require trailingslashit( $this->path ) . 'inc/controls/search.php';

            require trailingslashit( $this->path ) . 'inc/classes/post-query.php';
            require trailingslashit( $this->path ) . 'inc/classes/related-query.php';

            if(class_exists('\WC_Shortcode_Products')){
                require trailingslashit( $this->path ) . 'inc/classes/products-renderer.php';
            }

            require trailingslashit( $this->path ) . 'inc/classes/query-control.php';

            $avaliable_extension = lastudio_kit_settings()->get('avaliable_extensions', [
                'motion_effects'    => true,
                'floating_effects'  => true,
                'css_transform'     => true,
                'wrapper_link'      => true
            ]);

            if( !empty($avaliable_extension['floating_effects']) && filter_var( $avaliable_extension['floating_effects'], FILTER_VALIDATE_BOOLEAN ) ){
                require trailingslashit( $this->path ) . 'inc/floating-effects.php';
            }

            if( !empty($avaliable_extension['css_transform']) && filter_var( $avaliable_extension['css_transform'], FILTER_VALIDATE_BOOLEAN ) ){
                require trailingslashit( $this->path ) . 'inc/css-transform.php';
            }

            if( !empty($avaliable_extension['wrapper_link']) && filter_var( $avaliable_extension['wrapper_link'], FILTER_VALIDATE_BOOLEAN ) ){
                require trailingslashit( $this->path ) . 'inc/wrapper-link.php';
            }

            if( !empty($avaliable_extension['motion_effects']) && filter_var( $avaliable_extension['motion_effects'], FILTER_VALIDATE_BOOLEAN ) ){
                require trailingslashit( $this->path ) . 'inc/controls/group-control-motion-fx.php';
                require trailingslashit( $this->path ) . 'inc/motion-effects.php';
            }

        }

        /**
         * Register new controls.
         *
         * @param  object $controls_manager Controls manager instance.
         * @return void
         */
        public function register_controls( $controls_manager ) {

            $controls_manager->add_group_control( \LaStudioKit_Extension\Controls\Group_Control_Query::get_type(),      new \LaStudioKit_Extension\Controls\Group_Control_Query() );
            $controls_manager->add_group_control( \LaStudioKit_Extension\Controls\Group_Control_Related::get_type(),    new \LaStudioKit_Extension\Controls\Group_Control_Related() );
            $controls_manager->add_group_control( \LaStudioKit_Extension\Controls\Group_Control_Box_Style::get_type(),  new \LaStudioKit_Extension\Controls\Group_Control_Box_Style() );
            $controls_manager->register_control( \LaStudioKit_Extension\Controls\Control_Query::get_control_type(),     new \LaStudioKit_Extension\Controls\Control_Query() );
            $controls_manager->register_control( \LaStudioKit_Extension\Controls\Control_Search::get_control_type(),    new \LaStudioKit_Extension\Controls\Control_Search() );

        }

        /**
         * @param Ajax $ajax_manager
         */
        public function register_ajax_actions( $ajax_manager ){
            $class_query = \LaStudioKit_Extension\Classes\Query_Control::get_instance();
            $ajax_manager->register_ajax_action( 'lastudiokit_query_control_value_titles', [ $class_query, 'ajax_posts_control_value_titles' ] );
            $ajax_manager->register_ajax_action( 'lastudiokit_query_control_filter_autocomplete', [ $class_query, 'ajax_posts_filter_autocomplete' ] );
        }

        /**
         * Enqueue editor scripts.
         */
        public function enqueue_editor_scripts() {
            wp_enqueue_script(
                'lastudio-kit-ext-editor',
                $this->url . 'assets/js/editor.js',
                array( 'jquery' ),
                $this->version,
                true
            );
        }

        /**
         * Enqueue custom icon fonts
         *
         * @param $tabs
         */
        public function enqueue_custom_icon_fonts( $tabs ){

            $tabs['dlicon'] = [
                'name' => 'dlicon',
                'label' => __( 'DL Icons', 'lastudio-kit' ),
                'url' =>  $this->url . 'assets/css/dlicon.css',
                'prefix' => '',
                'displayPrefix' => 'dlicon',
                'labelIcon' => 'fas fa-star',
                'ver' => '1.0.0',
                'fetchJson' => $this->url . 'assets/fonts/dlicon.json',
                'native' => false
            ];

            $tabs['splicon'] = [
                'name' => 'splicon',
                'label' => __( 'Simple Line Icon', 'lastudio-kit' ),
                'url' =>  $this->url . 'assets/css/simple-line-icons.css',
                'prefix' => 'icon-',
                'displayPrefix' => 'splicon',
                'labelIcon' => 'fas fa-star',
                'ver' => '1.0.0',
                'fetchJson' => $this->url . 'assets/fonts/simple-line-icons.json',
                'native' => false
            ];

            $tabs['icofont'] = [
                'name' => 'icofont',
                'label' => __( 'IcoFont', 'lastudio-kit' ),
                'url' =>  $this->url . 'assets/css/icofont.css',
                'prefix' => 'icofont-',
                'displayPrefix' => 'icofont',
                'labelIcon' => 'fas fa-star',
                'ver' => '1.0.0',
                'fetchJson' => $this->url . 'assets/fonts/icofont.json',
                'native' => false
            ];

            return $tabs;
        }

        /**
         * Serch page
         *
         * @return [type] [description]
         */
        public function search_pages() {

            if ( ! current_user_can( 'edit_posts' ) ) {
                wp_send_json( array() );
            }

            $query = isset( $_GET['q'] ) ? esc_attr( $_GET['q'] ) : '';
            $ids   = isset( $_GET['ids'] ) ? esc_attr( $_GET['ids'] ) : array();

            wp_send_json( array(
                'results' => lastudio_kit_helper()->search_posts_by_type( 'page', $query, $ids ),
            ) );

        }

        /**
         * Serch post
         *
         * @return [type] [description]
         */
        public function search_posts() {

            if ( ! current_user_can( 'edit_posts' ) ) {
                wp_send_json( array() );
            }

            $query     = isset( $_GET['q'] ) ? esc_attr( $_GET['q'] ) : '';
            $post_type = isset( $_GET['preview_post_type'] ) ? esc_attr( $_GET['preview_post_type'] ) : 'post';
            $ids       = isset( $_GET['ids'] ) ? esc_attr( $_GET['ids'] ) : array();

            wp_send_json( array(
                'results' => lastudio_kit_helper()->search_posts_by_type( $post_type, $query, $ids ),
            ) );

        }

        /**
         * Serch category
         *
         * @return [type] [description]
         */
        public function search_cats() {

            if ( ! current_user_can( 'edit_posts' ) ) {
                wp_send_json( array() );
            }

            $query = isset( $_GET['q'] ) ? esc_attr( $_GET['q'] ) : '';
            $ids   = isset( $_GET['ids'] ) ? esc_attr( $_GET['ids'] ) : array();

            wp_send_json( array(
                'results' => lastudio_kit_helper()->search_terms_by_tax( 'category', $query, $ids ),
            ) );

        }

        /**
         * Serch tag
         *
         * @return [type] [description]
         */
        public function search_tags() {

            if ( ! current_user_can( 'edit_posts' ) ) {
                wp_send_json( array() );
            }

            $query = isset( $_GET['q'] ) ? esc_attr( $_GET['q'] ) : '';
            $ids   = isset( $_GET['ids'] ) ? esc_attr( $_GET['ids'] ) : array();

            wp_send_json( array(
                'results' => lastudio_kit_helper()->search_terms_by_tax( 'post_tag', $query, $ids ),
            ) );

        }

        /**
         * Serach terms from passed taxonomies
         * @return [type] [description]
         */
        public function search_terms() {

            if ( ! current_user_can( 'edit_posts' ) ) {
                wp_send_json( array() );
            }

            $query = isset( $_GET['q'] ) ? esc_attr( $_GET['q'] ) : '';

            $tax = '';

            if ( isset( $_GET['conditions_archive-tax_tax'] ) ) {
                $tax = $_GET['conditions_archive-tax_tax'];
            }

            if ( isset( $_GET['conditions_singular-post-from-tax_tax'] ) ) {
                $tax = $_GET['conditions_singular-post-from-tax_tax'];
            }

            $tax = explode( ',', $tax );

            $ids = isset( $_GET['ids'] ) ? esc_attr( $_GET['ids'] ) : array();

            wp_send_json( array(
                'results' => lastudio_kit_helper()->search_terms_by_tax( $tax, $query, $ids ),
            ) );

        }

        /**
         * Returns the instance.
         *
         * @since  1.0.0
         * @param  array $args
         * @access public
         * @return object
         */
        public static function get_instance( array $args = array() ) {
            // If the single instance hasn't been set, set it now.
            if ( null == self::$instance ) {
                self::$instance = new self( $args );
            }

            return self::$instance;
        }
    }

}
