<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'LaStudio_Kit_Integration' ) ) {

	/**
	 * Define LaStudio_Kit_Integration class
	 */
	class LaStudio_Kit_Integration {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Check if processing elementor widget
		 *
		 * @var boolean
		 */
		private $is_elementor_ajax = false;

		/**
		 * Initalize integration hooks
		 *
		 * @return void
		 */
		public function init() {

			add_action( 'elementor/init', array( $this, 'register_category' ) );

			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_addons' ), 10 );

			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_vendor_addons' ), 20 );

			add_action( 'elementor/controls/controls_registered', array( $this, 'rewrite_controls' ), 10 );

			add_action( 'elementor/controls/controls_registered', array( $this, 'add_controls' ), 10 );

			add_action( 'wp_ajax_elementor_render_widget', array( $this, 'set_elementor_ajax' ), 10, -1 );

            add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'editor_scripts' ) );

            add_action( 'elementor/editor/after_enqueue_styles',   array( $this, 'editor_styles' ) );

            // WPML compatibility
            if ( defined( 'WPML_ST_VERSION' ) ) {
                add_filter( 'lastudio-kit/themecore/get_location_templates/template_id', array( $this, 'set_wpml_translated_location_id' ) );
            }

            // Polylang compatibility
            if ( class_exists( 'Polylang' ) ) {
                add_filter( 'lastudio-kit/themecore/get_location_templates/template_id', array( $this, 'set_pll_translated_location_id' ) );
            }

            add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_link_fragments' ) );

            add_action( 'init', array( $this, 'register_handler' ) );
            add_action( 'init', array( $this, 'login_handler' ) );

            add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );

			// Init Elementor Extension module
			$ext_module_data = lastudio_kit()->module_loader->get_included_module_data( 'elementor-extension.php' );

            LaStudioKit_Extension\Module::get_instance(
				array(
					'path' => $ext_module_data['path'],
					'url'  => $ext_module_data['url'],
				)
			);
		}

		/**
		 * Set $this->is_elementor_ajax to true on Elementor AJAX processing
		 *
		 * @return  void
		 */
		public function set_elementor_ajax() {
			$this->is_elementor_ajax = true;
		}

		/**
		 * Check if we currently in Elementor mode
		 *
		 * @return void
		 */
		public function in_elementor() {

            $result = false;

            if ( wp_doing_ajax() ) {
                $result = ( isset( $_REQUEST['action'] ) && 'elementor_ajax' === $_REQUEST['action'] );
            } elseif ( Elementor\Plugin::instance()->editor->is_edit_mode()
                && 'wp_enqueue_scripts' === current_filter() ) {
                $result = true;
            } elseif ( Elementor\Plugin::instance()->preview->is_preview_mode() && 'wp_enqueue_scripts' === current_filter() ) {
                $result = true;
            }

			/**
			 * Allow to filter result before return
			 *
			 * @var bool $result
			 */
			return apply_filters( 'lastudio-kit/in-elementor', $result );
		}

		/**
		 * Register plugin addons
		 *
		 * @param  object $widgets_manager Elementor widgets manager instance.
		 * @return void
		 */
		public function register_addons( $widgets_manager ) {

			$avaliable_widgets = lastudio_kit_settings()->get( 'avaliable_widgets' );

			require lastudio_kit()->plugin_path( 'includes/base/class-widget-base.php' );

			foreach ( glob( lastudio_kit()->plugin_path( 'includes/addons/' ) . '*.php' ) as $file ) {
				$slug = basename( $file, '.php' );

				$enabled = isset( $avaliable_widgets[ $slug ] ) ? $avaliable_widgets[ $slug ] : false;

				if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $avaliable_widgets ) {
					$this->register_addon( $file, $widgets_manager );
				}
			}
		}

		/**
		 * Register vendor addons
		 *
		 * @param  object $widgets_manager Elementor widgets manager instance.
		 * @return void
		 */
		public function register_vendor_addons( $widgets_manager ) {

            $woo_conditional = array(
                'cb'  => 'class_exists',
                'arg' => 'WooCommerce',
            );

            $allowed_vendors = apply_filters(
                'lastudio-kit/allowed-vendor-widgets',
                array(
                    'woo_cart' => array(
                        'file' => lastudio_kit()->plugin_path(
                            'includes/addons/vendor/woo-cart.php'
                        ),
                        'conditional' => $woo_conditional,
                    ),
                )
            );

            foreach ( $allowed_vendors as $vendor ) {
                if ( is_callable( $vendor['conditional']['cb'] )
                    && true === call_user_func( $vendor['conditional']['cb'], $vendor['conditional']['arg'] ) ) {
                    $this->register_addon( $vendor['file'], $widgets_manager );
                }
            }

		}

		/**
		 * Rewrite core controls.
		 *
		 * @param  object $controls_manager Controls manager instance.
		 * @return void
		 */
		public function rewrite_controls( $controls_manager ) {

		}

		/**
		 * Add new controls.
		 *
		 * @param  object $controls_manager Controls manager instance.
		 * @return void
		 */
		public function add_controls( $controls_manager ) {

		}

		/**
		 * Include control file by class name.
		 *
		 * @param  [type] $class_name [description]
		 * @return [type]             [description]
		 */
		public function include_control( $class_name, $grouped = false ) {

			$filename = sprintf(
				'includes/controls/%2$sclass-%1$s.php',
				str_replace( '_', '-', strtolower( $class_name ) ),
				( true === $grouped ? 'groups/' : '' )
			);

			if ( ! file_exists( lastudio_kit()->plugin_path( $filename ) ) ) {
				return false;
			}

			require lastudio_kit()->plugin_path( $filename );

			return true;
		}

		/**
		 * Register addon by file name
		 *
		 * @param  string $file            File name.
		 * @param  object $widgets_manager Widgets manager instance.
		 * @return void
		 */
		public function register_addon( $file, $widgets_manager ) {

			$base  = basename( str_replace( '.php', '', $file ) );
			$class = ucwords( str_replace( '-', ' ', $base ) );
			$class = str_replace( ' ', '_', $class );
            $class = 'LaStudioKit_' . $class;
			$class = sprintf( 'Elementor\%s', $class );

			require $file;

			if ( class_exists( $class ) ) {

				$widgets_manager->register_widget_type( new $class );
			}
		}

		/**
		 * Register cherry category for elementor if not exists
		 *
		 * @return void
		 */
		public function register_category() {

            Elementor\Plugin::instance()->elements_manager->add_category(
				'lastudiokit',
				array(
					'title' => esc_html__( 'LaStudio Kit', 'lastudio-kit' ),
					'icon'  => 'font',
				)
			);
		}

        /**
         * Enqueue plugin scripts only with elementor scripts
         *
         * @return void
         */
        public function editor_scripts() {

            wp_enqueue_script(
                'lastudio-kit-editor',
                lastudio_kit()->plugin_url( 'assets/js/lastudio-kit-editor.js' ),
                array( 'jquery' ),
                lastudio_kit()->get_version(),
                true
            );
        }

        /**
         * Enqueue editor styles
         *
         * @return void
         */
        public function editor_styles() {

            wp_enqueue_style(
                'lastudio-kit-editor',
                lastudio_kit()->plugin_url( 'assets/css/lastudio-kit-editor.css' ),
                array(),
                lastudio_kit()->get_version()
            );

        }

        public function frontend_enqueue(){

            wp_register_style( 'lastudio-kit-base', lastudio_kit()->plugin_url('assets/css/lastudio-kit-base.css'), [], lastudio_kit()->get_version());
            wp_register_script(  'lastudio-kit-base' , lastudio_kit()->plugin_url('assets/js/lastudio-kit-base.js') , [ 'elementor-frontend' ],  lastudio_kit()->get_version() , true );

            $rest_api_url = apply_filters( 'lastudio-kit/rest/frontend/url', get_rest_url() );

            wp_localize_script('lastudio-kit-base', 'LaStudioKitSettings', [
                'templateApiUrl' => $rest_api_url . 'lastudio-kit-api/v1/elementor-template',
                'ajaxurl'        => esc_url( admin_url( 'admin-ajax.php' ) ),
                'isMobile'       => filter_var( wp_is_mobile(), FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
                'devMode'        => is_user_logged_in() ? 'true' : 'false',
                'i18n'           => [

                ]
            ]);
        }

        /**
         * Set WPML translated location.
         *
         * @param $post_id
         *
         * @return mixed|void
         */
        public function set_wpml_translated_location_id( $post_id ) {
            $location_type = get_post_type( $post_id );

            return apply_filters( 'wpml_object_id', $post_id, $location_type, true );
        }

        /**
         * set_pll_translated_location_id
         *
         * @param $post_id
         *
         * @return false|int|null
         */
        public function set_pll_translated_location_id( $post_id ) {

            if ( function_exists( 'pll_get_post' ) ) {

                $translation_post_id = pll_get_post( $post_id );

                if ( null === $translation_post_id ) {
                    // the current language is not defined yet
                    return $post_id;
                } elseif ( false === $translation_post_id ) {
                    //no translation yet
                    return $post_id;
                } elseif ( $translation_post_id > 0 ) {
                    // return translated post id
                    return $translation_post_id;
                }
            }

            return $post_id;
        }

        /**
         * Cart link fragments
         *
         * @return array
         */
        public function cart_link_fragments( $fragments ) {

            global $woocommerce;

            $lakit_fragments = apply_filters( 'lastudio-kit/handlers/cart-fragments', array(
                '.lakit-cart__total-val' => 'cart/global/cart-totals.php',
                '.lakit-cart__count-val' => 'cart/global/cart-count.php',
            ) );

            foreach ( $lakit_fragments as $selector => $template ) {
                ob_start();
                include lastudio_kit()->get_template( $template );
                $fragments[ $selector ] = ob_get_clean();
            }

            return $fragments;

        }


        /**
         * Login form handler.
         *
         * @return void
         */
        public function login_handler() {

            if ( ! isset( $_POST['lakit_login'] ) ) {
                return;
            }

            try {

                if ( empty( $_POST['log'] ) ) {

                    $error = sprintf(
                        '<strong>%1$s</strong>: %2$s',
                        __( 'ERROR', 'lastudio-kit' ),
                        __( 'The username field is empty.', 'lastudio-kit' )
                    );

                    throw new Exception( $error );

                }

                $signon = wp_signon();

                if ( is_wp_error( $signon ) ) {
                    throw new Exception( $signon->get_error_message() );
                }

                $redirect = isset( $_POST['redirect_to'] )
                    ? esc_url( $_POST['redirect_to'] )
                    : esc_url( home_url( '/' ) );

                wp_redirect( $redirect );
                exit;

            } catch ( Exception $e ) {
                wp_cache_set( 'lakit-login-messages', $e->getMessage() );
            }

        }

        /**
         * Registration handler
         *
         * @return void
         */
        public function register_handler() {

            if ( ! isset( $_POST['lakit-register-nonce'] ) ) {
                return;
            }

            if ( ! wp_verify_nonce( $_POST['lakit-register-nonce'], 'lakit-register' ) ) {
                return;
            }

            try {

                $username           = isset( $_POST['username'] ) ? $_POST['username'] : '';
                $password           = isset( $_POST['password'] ) ? $_POST['password'] : '';
                $email              = isset( $_POST['email'] ) ? $_POST['email'] : '';
                $confirm_password   = isset( $_POST['lakit_confirm_password'] ) ? $_POST['lakit_confirm_password'] : '';
                $confirmed_password = isset( $_POST['password-confirm'] ) ? $_POST['password-confirm'] : '';
                $confirm_password   = filter_var( $confirm_password, FILTER_VALIDATE_BOOLEAN );

                if ( $confirm_password && $password !== $confirmed_password ) {
                    throw new Exception( esc_html__( 'Entered passwords don\'t match', 'lastudio-kit' ) );
                }

                $validation_error = new WP_Error();

                $user = $this->create_user( $username, sanitize_email( $email ), $password );

                if ( is_wp_error( $user ) ) {
                    throw new Exception( $user->get_error_message() );
                }

                global $current_user;
                $current_user = get_user_by( 'id', $user );
                wp_set_auth_cookie( $user, true );

                if ( ! empty( $_POST['lakit_redirect'] ) ) {
                    $redirect = wp_sanitize_redirect( $_POST['lakit_redirect'] );
                } else {
                    $redirect = $_POST['_wp_http_referer'];
                }

                wp_redirect( $redirect );
                exit;

            } catch ( Exception $e ) {
                wp_cache_set( 'lakit-register-messages', $e->getMessage() );
            }

        }

        /**
         * Create new user function
         *
         * @param  [type] $username [description]
         * @param  [type] $email    [description]
         * @param  [type] $password [description]
         * @return [type]           [description]
         */
        public function create_user( $username, $email, $password ) {

            // Check username
            if ( empty( $username ) || ! validate_username( $username ) ) {
                return new WP_Error(
                    'registration-error-invalid-username',
                    __( 'Please enter a valid account username.', 'lastudio-kit' )
                );
            }

            if ( username_exists( $username ) ) {
                return new WP_Error(
                    'registration-error-username-exists',
                    __( 'An account is already registered with that username. Please choose another.', 'lastudio-kit' )
                );
            }

            // Check the email address.
            if ( empty( $email ) || ! is_email( $email ) ) {
                return new WP_Error(
                    'registration-error-invalid-email',
                    __( 'Please provide a valid email address.', 'lastudio-kit' )
                );
            }

            if ( email_exists( $email ) ) {
                return new WP_Error(
                    'registration-error-email-exists',
                    __( 'An account is already registered with your email address. Please log in.', 'lastudio-kit' )
                );
            }

            // Check password
            if ( empty( $password ) ) {
                return new WP_Error(
                    'registration-error-missing-password',
                    __( 'Please enter an account password.', 'lastudio-kit' )
                );
            }

            $custom_error = apply_filters( 'lakit_register_form_custom_error', null );

            if ( is_wp_error( $custom_error ) ){
                return $custom_error;
            }

            $new_user_data = array(
                'user_login' => $username,
                'user_pass'  => $password,
                'user_email' => $email,
            );

            $user_id = wp_insert_user( $new_user_data );

            if ( is_wp_error( $user_id ) ) {
                return new WP_Error(
                    'registration-error',
                    '<strong>' . __( 'Error:', 'lastudio-kit' ) . '</strong> ' . __( 'Couldn&#8217;t register you&hellip; please contact us if you continue to have problems.', 'lastudio-kit' )
                );
            }

            return $user_id;

        }

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of LaStudio_Kit_Integration
 *
 * @return object
 */
function lastudio_kit_integration() {
	return LaStudio_Kit_Integration::get_instance();
}
