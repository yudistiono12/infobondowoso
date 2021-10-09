<?php
/**
 * helper class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'LaStudio_Kit_Helper' ) ) {

	/**
	 * Define LaStudio_Kit_Helper class
	 */
	class LaStudio_Kit_Helper {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   LaStudio_Kit_Helper
		 */
		private static $instance = null;

        /**
         * Returns columns classes string
         *
         * @param  array $columns Columns classes array
         * @return string
         */
		public function render_grid_classes( $columns = [] ){

            $columns = wp_parse_args( $columns, array(
                'desktop'  => '1',
                'laptop'   => '',
                'tablet'   => '',
                'mobile'  => '',
                'xmobile'   => ''
            ) );

            $replaces = array(
                'xmobile' => 'xmobile-block-grid',
                'mobile' => 'mobile-block-grid',
                'tablet' => 'tablet-block-grid',
                'laptop' => 'laptop-block-grid',
                'desktop' => 'block-grid'
            );

            $classes = array();

            foreach ( $columns as $device => $cols ) {
                if ( ! empty( $cols ) ) {
                    $classes[] = sprintf( '%1$s-%2$s', $replaces[$device], $cols );
                }
            }

            return implode( ' ' , $classes );

        }

		/**
		 * Returns columns classes string
		 *
		 * @param  array $columns Columns classes array
		 * @return string
		 */
		public function col_classes( $columns = array() ) {

			$columns = wp_parse_args( $columns, array(
				'desk' => 1,
				'tab'  => 1,
				'mob'  => 1,
			) );

			$classes = array();

			foreach ( $columns as $device => $cols ) {
				if ( ! empty( $cols ) ) {
					$classes[] = sprintf( 'col-%1$s-%2$s', $device, $cols );
				}
			}

			return implode( ' ' , $classes );
		}

		/**
		 * Returns disable columns gap nad rows gap classes string
		 *
		 * @param  string $use_cols_gap [description]
		 * @param  string $use_rows_gap [description]
		 * @return string
		 */
		public function gap_classes( $use_cols_gap = 'yes', $use_rows_gap = 'yes' ) {

			$result = array();

			foreach ( array( 'cols' => $use_cols_gap, 'rows' => $use_rows_gap ) as $element => $value ) {
				if ( 'yes' !== $value ) {
					$result[] = sprintf( 'disable-%s-gap', $element );
				}
			}

			return implode( ' ', $result );

		}

		/**
		 * Returns image size array in slug => name format
		 *
		 * @return  array
		 */
		public function get_image_sizes() {

			global $_wp_additional_image_sizes;

			$sizes  = get_intermediate_image_sizes();
			$result = array();

			foreach ( $sizes as $size ) {
				if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
					$result[ $size ] = ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) );
				} else {
					$result[ $size ] = sprintf(
						'%1$s (%2$sx%3$s)',
						ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
						$_wp_additional_image_sizes[ $size ]['width'],
						$_wp_additional_image_sizes[ $size ]['height']
					);
				}
			}

			return array_merge( array( 'full' => esc_html__( 'Full', 'lastudio-kit' ), ), $result );
		}

		/**
		 * Get categories list.
		 *
		 * @return array
		 */
		public function get_categories() {

			$categories = get_categories();

			if ( empty( $categories ) || ! is_array( $categories ) ) {
				return array();
			}

			return wp_list_pluck( $categories, 'name', 'term_id' );

		}

		/**
		 * Returns allowed order by fields for options
		 *
		 * @return array
		 */
		public function orderby_arr() {
			return array(
				'none'          => esc_html__( 'None', 'lastudio-kit' ),
				'ID'            => esc_html__( 'ID', 'lastudio-kit' ),
				'author'        => esc_html__( 'Author', 'lastudio-kit' ),
				'title'         => esc_html__( 'Title', 'lastudio-kit' ),
				'name'          => esc_html__( 'Name (slug)', 'lastudio-kit' ),
				'date'          => esc_html__( 'Date', 'lastudio-kit' ),
				'modified'      => esc_html__( 'Modified', 'lastudio-kit' ),
				'rand'          => esc_html__( 'Rand', 'lastudio-kit' ),
				'comment_count' => esc_html__( 'Comment Count', 'lastudio-kit' ),
				'menu_order'    => esc_html__( 'Menu Order', 'lastudio-kit' ),
			);
		}

		/**
		 * Returns allowed order fields for options
		 *
		 * @return array
		 */
		public function order_arr() {

			return array(
				'desc' => esc_html__( 'Descending', 'lastudio-kit' ),
				'asc'  => esc_html__( 'Ascending', 'lastudio-kit' ),
			);

		}

		/**
		 * Returns allowed order by fields for options
		 *
		 * @return array
		 */
		public function verrtical_align_attr() {
			return array(
				'baseline'    => esc_html__( 'Baseline', 'lastudio-kit' ),
				'top'         => esc_html__( 'Top', 'lastudio-kit' ),
				'middle'      => esc_html__( 'Middle', 'lastudio-kit' ),
				'bottom'      => esc_html__( 'Bottom', 'lastudio-kit' ),
				'sub'         => esc_html__( 'Sub', 'lastudio-kit' ),
				'super'       => esc_html__( 'Super', 'lastudio-kit' ),
				'text-top'    => esc_html__( 'Text Top', 'lastudio-kit' ),
				'text-bottom' => esc_html__( 'Text Bottom', 'lastudio-kit' ),
			);
		}

		/**
		 * Returns array with numbers in $index => $name format for numeric selects
		 *
		 * @param  integer $to Max numbers
		 * @return array
		 */
		public function get_select_range( $to = 10 ) {
			$range = range( 1, $to );
			return array_combine( $range, $range );
		}

		/**
		 * Returns badge placeholder URL
		 *
		 * @return void
		 */
		public function get_badge_placeholder() {
			return lastudio_kit()->plugin_url( 'assets/images/placeholder-badge.svg' );
		}

		/**
		 * Rturns image tag or raw SVG
		 *
		 * @param  string $url  image URL.
		 * @param  array  $attr [description]
		 * @return string
		 */
		public function get_image_by_url( $url = null, $attr = array() ) {

			$url = esc_url( $url );

			if ( empty( $url ) ) {
				return;
			}

			$ext  = pathinfo( $url, PATHINFO_EXTENSION );
			$attr = array_merge( array( 'alt' => '' ), $attr );

			if ( 'svg' !== $ext ) {
				return sprintf( '<img src="%1$s"%2$s>', $url, $this->get_attr_string( $attr ) );
			}

			$base_url = site_url( '/' );
			$svg_path = str_replace( $base_url, ABSPATH, $url );
			$key      = md5( $svg_path );
			$svg      = get_transient( $key );

			if ( ! $svg ) {
				$svg = file_get_contents( $svg_path );
			}

			if ( ! $svg ) {
				return sprintf( '<img src="%1$s"%2$s>', $url, $this->get_attr_string( $attr ) );
			}

			set_transient( $key, $svg, DAY_IN_SECONDS );

			unset( $attr['alt'] );

			return sprintf( '<div%2$s>%1$s</div>', $svg, $this->get_attr_string( $attr ) );
		}

		/**
		 * Return attributes string from attributes array.
		 *
		 * @param  array  $attr Attributes string.
		 * @return string
		 */
		public function get_attr_string( $attr = array() ) {

			if ( empty( $attr ) || ! is_array( $attr ) ) {
				return;
			}

			$result = '';

			foreach ( $attr as $key => $value ) {
				$result .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
			}

			return $result;
		}

		/**
		 * Returns carousel arrow
		 *
		 * @param  array $classes Arrow additional classes list.
		 * @return string
		 */
		public function get_carousel_arrow( $classes ) {

			$format = apply_filters( 'lastudio_kit/carousel/arrows_format', '<i class="%s lakit-arrow"></i>', $classes );

			return sprintf( $format, implode( ' ', $classes ) );
		}

		/**
		 * Get post types options list
		 *
		 * @return array
		 */
		public static function get_post_types( $args = [] ) {

            $post_type_args = [
                'show_in_nav_menus' => true,
                'public' => true,
            ];

            if ( ! empty( $args['post_type'] ) ) {
                $post_type_args['name'] = $args['post_type'];
            }

            $post_type_args = apply_filters('lastudio-kit/post-types-list/args', $post_type_args, $args);

			$post_types = get_post_types( $post_type_args, 'objects' );

			$deprecated = apply_filters(
				'lastudio-kit/post-types-list/deprecated',
				array( 'attachment', 'elementor_library' )
			);

			$result = array();

			if ( empty( $post_types ) ) {
				return $result;
			}

			foreach ( $post_types as $slug => $post_type ) {

				if ( in_array( $slug, $deprecated ) ) {
					continue;
				}

				$result[ $slug ] = $post_type->label;

			}

			return $result;

		}

        /**
         * Returns all custom taxonomies
         *
         * @return [type] [description]
         */
        public static function get_taxonomies( $args = [], $output = 'names', $operator = 'and' ) {

            global $wp_taxonomies;

            $field = ( 'names' === $output ) ? 'name' : false;

            // Handle 'object_type' separately.
            if ( isset( $args['object_type'] ) ) {
                $object_type = (array) $args['object_type'];
                unset( $args['object_type'] );
            }

            $taxonomies = wp_filter_object_list( $wp_taxonomies, $args, $operator );

            if ( isset( $object_type ) ) {
                foreach ( $taxonomies as $tax => $tax_data ) {
                    if ( ! array_intersect( $object_type, $tax_data->object_type ) ) {
                        unset( $taxonomies[ $tax ] );
                    }
                }
            }

            if ( $field ) {
                $taxonomies = wp_list_pluck( $taxonomies, $field );
            }

            return $taxonomies;

        }

        /**
         * [search_posts_by_type description]
         * @param  [type] $type  [description]
         * @param  [type] $query [description]
         * @param  array  $ids   [description]
         * @return [type]        [description]
         */
        public static function search_posts_by_type( $type, $query, $ids = array() ) {

            add_filter( 'posts_where', array( __CLASS__, 'force_search_by_title' ), 10, 2 );

            $posts = get_posts( array(
                'post_type'           => $type,
                'ignore_sticky_posts' => true,
                'posts_per_page'      => -1,
                'suppress_filters'    => false,
                's_title'             => $query,
                'include'             => $ids,
            ) );

            remove_filter( 'posts_where', array( __CLASS__, 'force_search_by_title' ), 10 );

            $result = array();

            if ( ! empty( $posts ) ) {
                foreach ( $posts as $post ) {
                    $result[] = array(
                        'id'   => $post->ID,
                        'text' => $post->post_title,
                    );
                }
            }

            return $result;
        }

        /**
         * Force query to look in post title while searching
         * @return [type] [description]
         */
        public static function force_search_by_title( $where, $query ) {

            $args = $query->query;

            if ( ! isset( $args['s_title'] ) ) {
                return $where;
            } else {
                global $wpdb;

                $searh = esc_sql( $wpdb->esc_like( $args['s_title'] ) );
                $where .= " AND {$wpdb->posts}.post_title LIKE '%$searh%'";

            }

            return $where;
        }

        /**
         * [search_terms_by_tax description]
         * @param  [type] $tax   [description]
         * @param  [type] $query [description]
         * @param  array  $ids   [description]
         * @return [type]        [description]
         */
        public static function search_terms_by_tax( $tax, $query, $ids = array() ) {

            $terms = get_terms( array(
                'taxonomy'   => $tax,
                'hide_empty' => false,
                'name__like' => $query,
                'include'    => $ids,
            ) );

            $result = array();


            if ( ! empty( $terms ) && !is_wp_error($terms) ) {
                foreach ( $terms as $term ) {
                    $result[] = array(
                        'id'   => $term->term_id,
                        'text' => $term->name,
                    );
                }
            }

            return $result;

        }

		/**
		 * Return available arrows list
		 * @return array
		 */
		public function get_available_prev_arrows_list() {

			return apply_filters(
				'lastudio_kit/carousel/available_arrows/prev',
				array(
					'fa fa-angle-left'          => __( 'Angle', 'lastudio-kit' ),
					'fa fa-chevron-left'        => __( 'Chevron', 'lastudio-kit' ),
					'fa fa-angle-double-left'   => __( 'Angle Double', 'lastudio-kit' ),
					'fa fa-arrow-left'          => __( 'Arrow', 'lastudio-kit' ),
					'fa fa-caret-left'          => __( 'Caret', 'lastudio-kit' ),
					'fa fa-long-arrow-alt-left' => __( 'Long Arrow', 'lastudio-kit' ),
					'fa fa-arrow-circle-left'   => __( 'Arrow Circle', 'lastudio-kit' ),
					'fa fa-chevron-circle-left' => __( 'Chevron Circle', 'lastudio-kit' ),
					'fa fa-caret-square-left'   => __( 'Caret Square', 'lastudio-kit' ),
				)
			);

		}

		/**
		 * Return available arrows list
		 * @return array
		 */
		public function get_available_next_arrows_list() {

			return apply_filters(
				'lastudio_kit/carousel/available_arrows/next',
				array(
					'fa fa-angle-right'          => __( 'Angle', 'lastudio-kit' ),
					'fa fa-chevron-right'        => __( 'Chevron', 'lastudio-kit' ),
					'fa fa-angle-double-right'   => __( 'Angle Double', 'lastudio-kit' ),
					'fa fa-arrow-right'          => __( 'Arrow', 'lastudio-kit' ),
					'fa fa-caret-right'          => __( 'Caret', 'lastudio-kit' ),
					'fa fa-long-arrow-alt-right'     => __( 'Long Arrow', 'lastudio-kit' ),
					'fa fa-arrow-circle-right'   => __( 'Arrow Circle', 'lastudio-kit' ),
					'fa fa-chevron-circle-right' => __( 'Chevron Circle', 'lastudio-kit' ),
					'fa fa-caret-square-right'   => __( 'Caret Square', 'lastudio-kit' ),
				)
			);

		}

		/**
		 * Return available arrows list
		 * @return array
		 */
		public function get_available_title_html_tags() {

			return array(
				'h1'   => esc_html__( 'H1', 'lastudio-kit' ),
				'h2'   => esc_html__( 'H2', 'lastudio-kit' ),
				'h3'   => esc_html__( 'H3', 'lastudio-kit' ),
				'h4'   => esc_html__( 'H4', 'lastudio-kit' ),
				'h5'   => esc_html__( 'H5', 'lastudio-kit' ),
				'h6'   => esc_html__( 'H6', 'lastudio-kit' ),
				'div'  => esc_html__( 'div', 'lastudio-kit' ),
				'span' => esc_html__( 'span', 'lastudio-kit' ),
				'p'    => esc_html__( 'p', 'lastudio-kit' ),
			);

		}

		/**
		 * Get post taxonomies for options.
		 *
		 * @return array
		 */
		public function get_taxonomies_for_options() {

			$args = array(
				'public' => true,
			);

			$taxonomies = get_taxonomies( $args, 'objects', 'and' );

			return wp_list_pluck( $taxonomies, 'label', 'name' );
		}

		/**
		 * Get elementor templates list for options.
		 *
		 * @return array
		 */
		public function get_elementor_templates_options() {
			$templates = lastudio_kit()->elementor()->templates_manager->get_source( 'local' )->get_items();

			$options = array(
				'0' => '— ' . esc_html__( 'Select', 'lastudio-kit' ) . ' —',
			);

			foreach ( $templates as $template ) {
				$options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
			}

			return $options;
		}

		/**
		 * Is script debug.
		 *
		 * @return bool
		 */
		public function is_script_debug() {
			return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
		}

		/**
		 * Is FA5 migration.
		 *
		 * @return bool
		 */
		public function is_fa5_migration() {

			if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) && Elementor\Icons_Manager::is_migration_allowed() ) {
				return true;
			}

			return false;
		}

		/**
		 * Check if is valid timestamp
		 *
		 * @param  int|string $timestamp
		 * @return boolean
		 */
		public function is_valid_timestamp( $timestamp ) {
			return ( ( string ) ( int ) $timestamp === $timestamp ) && ( $timestamp <= PHP_INT_MAX ) && ( $timestamp >= ~PHP_INT_MAX );
		}

		public function validate_html_tag( $tag ) {
			$allowed_tags = array(
				'article',
				'aside',
				'div',
				'footer',
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
				'header',
				'main',
				'nav',
				'p',
				'section',
				'span',
			);

			return in_array( strtolower( $tag ), $allowed_tags ) ? $tag : 'div';
		}

		public function get_attribute_with_all_breakpoints( $atts = '', $settings = [], $only_device = '' ) {

		    $data = [];

		    if(property_exists( lastudio_kit()->elementor(), 'breakpoints')){
                $breakpoints = lastudio_kit()->elementor()->breakpoints->get_breakpoints();
                foreach ( $breakpoints as $breakpoint_name => $breakpoint ) {
                    $config[ $breakpoint_name ] = $breakpoint_name;
                }
            }
		    else{
                $config = [
                    'tablet' => '',
                    'mobile' => ''
                ];
            }

		    if(!empty($atts) && !empty($settings)){
		        if(isset($settings[$atts])){
                    $data['desktop'] = $settings[$atts];
                }
		        if(!empty($config)){
		            foreach ($config as $k => $v){
		                if(isset($settings[$atts.'_' . $k])){
                            $data[$k] = $settings[$atts.'_' . $k];
                        }
                    }
                }
            }

		    if(isset($data['laptop']) && empty($data['laptop']) && !empty($data['desktop'])){
                $data['laptop'] = $data['desktop'];
            }
		    if(isset($data['tabletportrait']) && empty($data['tabletportrait']) && !empty($data['tablet'])){
                $data['tabletportrait'] = $data['tablet'];
            }

		    if(!empty($only_device)){
		        if(isset($data[$only_device])){
		            return $data[$only_device];
                }
		        else{
		            return '';
                }
            }

            return $data;
        }


		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return LaStudio_Kit_Helper
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

        /**
         * Get breadcrumbs post taxonomy settings.
         *
         * @return array
         */
        public function get_breadcrumbs_post_taxonomy_settings() {
            static $results = array();

            if ( empty( $results ) ) {
                $post_types = get_post_types( array( 'public' => true ), 'objects' );

                if ( is_array( $post_types ) && ! empty( $post_types ) ) {

                    foreach ( $post_types as $post_type ) {
                        $value = lastudio_kit_settings()->get( 'breadcrumbs_taxonomy_' . $post_type->name, ( 'post' === $post_type->name ) ? 'category' : '' );

                        if ( ! empty( $value ) ) {
                            $results[ $post_type->name ] = $value;
                        }
                    }
                }
            }

            return $results;
        }

        public static function set_global_authordata() {
            global $authordata;
            if ( ! isset( $authordata->ID ) ) {
                $post = get_post();
                $authordata = get_userdata( $post->post_author ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            }
        }
	}

}

/**
 * Returns instance of LaStudio_Kit_Helper
 *
 * @return LaStudio_Kit_Helper
 */
function lastudio_kit_helper() {
	return LaStudio_Kit_Helper::get_instance();
}
