<?php
class Fiona_Blog_Category_Dropdown_Control extends WP_Customize_Control {

    /**
     * Control type.
     *
     * @access public
     * @var string
     */
    public $type = 'fiona-blog-dropdown-category';

    /**
     * Taxonomy.
     *
     * @access public
     * @var string
     */
    public $taxonomy = '';

    /**
     * Constructor.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {

        $fiona_blog_taxonomy = 'category';
        if ( isset( $args['taxonomy'] ) ) {
            $taxonomy_exist = taxonomy_exists( $args['taxonomy']  );
            if ( true === $taxonomy_exist ) {
                $fiona_blog_taxonomy =  $args['taxonomy'];
            }
        }
        $args['taxonomy'] = $fiona_blog_taxonomy;
        $this->taxonomy =  $fiona_blog_taxonomy;

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render content.
     *
     * @since 1.0.0
     */
    public function render_content() {

        $tax_args = array(
            'hierarchical' => 0,
            'taxonomy'     => $this->taxonomy,
        );
        $cats = get_categories( $tax_args );

        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
            <select <?php $this->link(); ?>>
                <?php
                printf( '<option value="%s" %s>%s</option>', 0, selected( $this->value(), '', false ), __( 'All', 'fiona-blog' )  );
                ?>
                <?php if ( ! empty( $cats ) ) :  ?>
                    <?php foreach ( $cats as $key => $cat ) :  ?>
                        <?php
                        printf( '<option value="%s" %s>%s</option>', esc_attr( $cat->name ), selected( $this->value(), $cat->name, false ), esc_html( $cat->name ) );
                        ?>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </label>
        <?php
    }
}