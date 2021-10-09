<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    LaStudio Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'LaStudio_Kit_Settings' ) ) {

	/**
	 * Define LaStudio_Kit_Settings class
	 */
	class LaStudio_Kit_Settings {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * [$key description]
		 * @var string
		 */
		public $key = 'lastudio-kit-settings';

		/**
		 * Access Token transient option key
		 *
		 * @var string
		 */
		private $insta_updated_access_token_key = 'lastudio_kit_instagram_updated_access_token';

		/**
		 * [$builder description]
		 * @var null
		 */
		public $builder  = null;

		/**
		 * [$settings description]
		 * @var null
		 */
		public $settings = null;

		/**
		 * Available Widgets array
		 *
		 * @var array
		 */
		public $avaliable_widgets = [];

		/**
		 * [$default_avaliable_extensions description]
		 * @var [type]
		 */
		public $default_avaliable_extensions = [
			'motion_effects'    => 'true',
			'floating_effects'  => 'true',
			'css_transform'     => 'true',
			'wrapper_link'      => 'true',
		];

		/**
		 * [$settings_page_config description]
		 * @var [type]
		 */
		public $settings_page_config = [];

		/**
		 * Available Widgets Slugs
		 *
		 * @var array
		 */
		public $avaliable_widgets_slugs = [];

		/**
		 * Init page
		 */
		public function init() {

			foreach ( glob( lastudio_kit()->plugin_path( 'includes/addons/' ) . '*.php' ) as $file ) {
				$data = get_file_data( $file, array( 'class' => 'Class', 'name' => 'Name', 'slug' => 'Slug' ) );

				$slug = basename( $file, '.php' );
				$this->avaliable_widgets[ $slug ] = $data['name'];
				$this->avaliable_widgets_slugs[]  = $data['slug'];
			}

			// Refresh Instagram Access Token
			add_action( 'admin_init', array( $this, 'refresh_instagram_access_token' ) );
		}

		/**
		 * [generate_frontend_config_data description]
		 * @return [type] [description]
		 */
		public function generate_frontend_config_data() {

			$default_active_widgets = [];
            $avaliable_widgets = [];

			foreach ( $this->avaliable_widgets as $slug => $name ) {

				$avaliable_widgets[] = [
					'label' => $name,
					'value' => $slug,
				];

				$default_active_widgets[ $slug ] = 'true';
			}

			$active_widgets = $this->get( 'avaliable_widgets', $default_active_widgets );

			$avaliable_extensions = [
				[
					'label' => esc_html__( 'Motion Effects Extension', 'lastudio-kit' ),
					'value' => 'motion_effects',
				],
                [
					'label' => esc_html__( 'Floating Effects Extension', 'lastudio-kit' ),
					'value' => 'floating_effects',
				],
                [
					'label' => esc_html__( 'CSS Transform Extension', 'lastudio-kit' ),
					'value' => 'css_transform',
				],
                [
					'label' => esc_html__( 'Wrapper Links', 'lastudio-kit' ),
					'value' => 'wrapper_link',
				],
			];

			$active_extensions = $this->get( 'avaliable_extensions', $this->default_avaliable_extensions );

			$rest_api_url = apply_filters( 'lastudio-kit/rest/frontend/url', get_rest_url() );

            $breadcrumbs_taxonomy_options = [];

            $post_types = get_post_types( array( 'public' => true ), 'objects' );

            if ( is_array( $post_types ) && ! empty( $post_types ) ) {

                foreach ( $post_types as $post_type ) {
                    $taxonomies = get_object_taxonomies( $post_type->name, 'objects' );

                    if ( is_array( $taxonomies ) && ! empty( $taxonomies ) ) {

                        $options = [
                            [
                                'label' => esc_html__( 'None', 'lastudio-kit' ),
                                'value' => '',
                            ]
                        ];

                        foreach ( $taxonomies as $tax ) {

                            if ( ! $tax->public ) {
                                continue;
                            }

                            $options[] = [
                                'label' => $tax->labels->singular_name,
                                'value' => $tax->name,
                            ];
                        }

                        $breadcrumbs_taxonomy_options[ 'breadcrumbs_taxonomy_' . $post_type->name ] = array(
                            'value'   => $this->get( 'breadcrumbs_taxonomy_' . $post_type->name, ( 'post' === $post_type->name ) ? 'category' : '' ),
                            'options' => $options,
                        );
                    }
                }
            }

            $settingsData = [
                'svg_uploads'             => [
                    'value' => $this->get( 'svg_uploads', 'enabled' ),
                ],
                'lastudio_kit_templates'           => [
                    'value' => $this->get( 'lastudio_kit_templates', 'enabled' ),
                ],
                'api_key'                 => [
                    'value' => $this->get( 'api_key', '' ),
                ],
                'disable_api_js'          => [
                    'value' => $this->get( 'disable_api_js', [ 'disable' => 'false' ] ),
                ],
                'mailchimp-api-key'       => [
                    'value' => $this->get( 'mailchimp-api-key', '' ),
                ],
                'mailchimp-list-id'       => [
                    'value' => $this->get( 'mailchimp-list-id', '' ),
                ],
                'mailchimp-double-opt-in' => [
                    'value' => $this->get( 'mailchimp-double-opt-in', false ),
                ],
                'insta_access_token'      => [
                    'value' => $this->get( 'insta_access_token', '' ),
                ],
                'insta_business_access_token' => [
                    'value' => $this->get( 'insta_business_access_token', '' ),
                ],
                'insta_business_user_id' => [
                    'value' => $this->get( 'insta_business_user_id', '' ),
                ],
                'weather_api_key'         => [
                    'value' => $this->get( 'weather_api_key', '' ),
                ],
                'avaliable_widgets'       => [
                    'value'   => $active_widgets,
                    'options' => $avaliable_widgets,
                ],
                'avaliable_extensions'    => [
                    'value'   => $active_extensions,
                    'options' => $avaliable_extensions,
                ],
                'pro_relations' => [
                    'value'   => $this->get( 'pro_relations', 'show_both' ),
                    'options' => array(
                        array(
                            'label' => esc_html__( 'LaStudioKit Overrides', 'lastudio-kit' ),
                            'value' => 'lakit_override',
                        ),
                        array(
                            'label' => esc_html__( 'Pro Overrides', 'lastudio-kit' ),
                            'value' => 'pro_override',
                        ),
                        array(
                            'label' => esc_html__( 'Show Both, LaStudioKit Before Pro', 'lastudio-kit' ),
                            'value' => 'show_both',
                        ),
                        array(
                            'label' => esc_html__( 'Show Both, Pro Before LaStudioKit', 'lastudio-kit' ),
                            'value' => 'show_both_reverse',
                        ),
                    ),
                ],
                'prevent_pro_locations' => array(
                    'value' => $this->get( 'prevent_pro_locations', 'false' ),
                ),
            ];

            $settingsData = array_merge($settingsData, $breadcrumbs_taxonomy_options);

			$this->settings_page_config = [
				'messages' => [
					'saveSuccess' => esc_html__( 'Saved', 'lastudio-kit' ),
					'saveError'   => esc_html__( 'Error', 'lastudio-kit' ),
				],
				'settingsApiUrl' => $rest_api_url . 'lastudio-kit-api/v1/plugin-settings',
				'settingsData' => $settingsData
			];

			return $this->settings_page_config;
		}

		/**
		 * Return settings page URL
		 *
		 * @param  string $subpage
		 * @return string
		 */
		public function get_settings_page_link( $subpage = 'general' ) {

			return add_query_arg(
				array(
					'page'    => 'lastudio-kit-dashboard-settings-page',
					'subpage' => 'lastudio-kit-' . $subpage . '-settings',
				),
				esc_url( admin_url( 'admin.php' ) )
			);

		}

		/**
		 * [get description]
		 * @param  [type]  $setting [description]
		 * @param  boolean $default [description]
		 * @return [type]           [description]
		 */
		public function get( $setting, $default = false ) {

			if ( null === $this->settings ) {
				$this->settings = get_option( $this->key, array() );
			}

			return isset( $this->settings[ $setting ] ) ? $this->settings[ $setting ] : $default;

		}

		/**
		 * Refresh Instagram Access Token
		 *
		 * @return void
		 */
		public function refresh_instagram_access_token() {
			$access_token = $this->get( 'insta_access_token' );
			$access_token = trim( $access_token );

			if ( empty( $access_token ) ) {
				return;
			}

			$updated = get_transient( $this->insta_updated_access_token_key );

			if ( ! empty( $updated ) ) {
				return;
			}

			$url = add_query_arg(
				array(
					'grant_type'   => 'ig_refresh_token',
					'access_token' => $access_token,
				),
				'https://graph.instagram.com/refresh_access_token'
			);

			$response = wp_remote_get( $url );

			if ( ! $response || is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				set_transient( $this->insta_updated_access_token_key, 'error', DAY_IN_SECONDS );
				return;
			}

			$body = wp_remote_retrieve_body( $response );

			if ( ! $body ) {
				set_transient( $this->insta_updated_access_token_key, 'error', DAY_IN_SECONDS );
				return;
			}

			$body = json_decode( $body, true );

			if ( empty( $body['access_token'] ) || empty( $body['expires_in'] ) ) {
				set_transient( $this->insta_updated_access_token_key, 'error', DAY_IN_SECONDS );
				return;
			}

			set_transient( $this->insta_updated_access_token_key, 'updated', 30 * DAY_IN_SECONDS );
		}


		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}
}

/**
 * Returns instance of LaStudio_Kit_Settings
 *
 * @return object
 */
function lastudio_kit_settings() {
	return LaStudio_Kit_Settings::get_instance();
}

lastudio_kit_settings()->init();
