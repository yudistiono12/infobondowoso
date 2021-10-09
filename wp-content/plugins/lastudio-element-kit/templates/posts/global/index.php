<?php
/**
 * Posts template
 */

$settings           = $this->get_settings_for_display();

$preset             = $this->get_settings_for_display('preset');
$layout             = $this->get_settings_for_display('layout_type');
$enable_carousel    = $this->get_settings_for_display('enable_carousel');
$enable_masonry     = $this->get_settings_for_display('enable_masonry');
$query_post_type    = $this->get_settings_for_display('query_post_type');

$floating_counter = $this->get_settings_for_display('floating_counter');
$floating_counter_as = $this->get_settings_for_display('floating_counter_as');

$this->add_render_attribute( 'main-container', 'id', 'lapost_' . $this->get_id() );

$this->add_render_attribute( 'main-container', 'class', array(
	'lakit-posts',
	'layout-type-' . $layout,
	'preset-' . $preset,
    'querycpt--' . (!empty($query_post_type) ? $query_post_type : 'default')
) );

if(filter_var($floating_counter, FILTER_VALIDATE_BOOLEAN)){
    $this->add_render_attribute( 'main-container', 'class', 'enable--counter' );
    if(filter_var($floating_counter_as, FILTER_VALIDATE_BOOLEAN)){
        $this->add_render_attribute( 'main-container', 'class', 'enable--counter-as-icon' );
    }
}

$this->add_render_attribute( 'main-container', 'data-item_selector', '.lakit-posts__item' );

if(false !== strpos($preset, 'grid')){
    $this->add_render_attribute( 'main-container', 'class', 'lakit-posts--grid' );
}
else{
    $this->add_render_attribute( 'main-container', 'class', 'lakit-posts--list' );
}

$this->add_render_attribute( 'list-container', 'class', 'lakit-posts__list' );

if('grid' == $layout && !filter_var($enable_carousel, FILTER_VALIDATE_BOOLEAN)){
    $this->add_render_attribute( 'list-container', 'class', 'col-row' );
}

$this->add_render_attribute( 'list-wrapper', 'class', 'lakit-posts__list_wrapper');


if(filter_var($enable_masonry, FILTER_VALIDATE_BOOLEAN)){
    $this->add_render_attribute( 'main-container', 'class', 'lakit-masonry-wrapper' );
    $this->add_render_attribute( 'main-container', 'data-masonrywrap', '.lakit-posts__list' );
}
else{
    if(filter_var($enable_carousel, FILTER_VALIDATE_BOOLEAN)){
        $slider_options = $this->get_advanced_carousel_options('columns');
        if(!empty($slider_options)){
            $this->add_render_attribute( 'list-wrapper', 'data-slider_options', json_encode($slider_options) );
            $this->add_render_attribute( 'list-wrapper', 'dir', is_rtl() ? 'rtl' : 'ltr' );
            $this->add_render_attribute( 'list-wrapper', 'class', 'swiper-container lakit-carousel');
            $this->add_render_attribute( 'list-container', 'class', 'swiper-wrapper' );
            $this->add_render_attribute( 'main-container', 'class', 'lakit-carousel-outer' );
        }
    }
}

$the_query = $this->the_query();

?>

<div <?php echo $this->get_render_attribute_string( 'main-container' ); ?>><?php

    if($the_query->have_posts()){
        ?>
        <div <?php echo $this->get_render_attribute_string( 'list-wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'list-container' ); ?>>
            <?php

            while ($the_query->have_posts()){

                $the_query->the_post();

                $this->_load_template( $this->_get_global_template( 'loop-item' ) );

                $this->item_counter++;
                $this->_processed_index++;
            }
            ?>
            </div>
            <?php

            if ( filter_var( $enable_carousel, FILTER_VALIDATE_BOOLEAN ) && !filter_var($enable_masonry, FILTER_VALIDATE_BOOLEAN) ) {
                if (filter_var($this->get_settings_for_display('carousel_dots'), FILTER_VALIDATE_BOOLEAN)) {
                    echo '<div class="lakit-carousel__dots swiper-pagination"></div>';
                }
                if (filter_var($this->get_settings_for_display('carousel_arrows'), FILTER_VALIDATE_BOOLEAN)) {
                    echo sprintf('<div class="lakit-carousel__prev-arrow-%s lakit-arrow prev-arrow">%s</div>', $this->get_id(), $this->_render_icon('carousel_prev_arrow', '%s', '', false));
                    echo sprintf('<div class="lakit-carousel__next-arrow-%s lakit-arrow next-arrow">%s</div>', $this->get_id(), $this->_render_icon('carousel_next_arrow', '%s', '', false));
                }
                if (filter_var($this->get_settings_for_display('carousel_scrollbar'), FILTER_VALIDATE_BOOLEAN)) {
                    echo '<div class="lakit-carousel__scrollbar swiper-scrollbar"></div>';
                }
            }
            ?>
        </div>
    <?php
        if( $this->get_settings_for_display('paginate') == 'yes' ){

            if( $this->get_settings_for_display('loadmore_text') ) {
                $load_more_text = $this->get_settings_for_display('loadmore_text');
            }
            else{
                $load_more_text = esc_html__('Load More', 'lastudio-kit');
            }

            $nav_classes = array('post-pagination', 'lakit-pagination', 'clearfix', 'lakit-ajax-pagination');

            if( $this->get_settings_for_display('paginate_as_loadmore') == 'yes') {
                $nav_classes[] = 'active-loadmore';
            }

            $paginated = ! $the_query->get( 'no_found_rows' );

            $p_total_pages = $paginated ? (int) $the_query->max_num_pages : 1;
            $p_current_page = $paginated ? (int) max( 1, $the_query->get( 'paged', 1 ) ) : 1;

            $paged_key = 'post-page' . esc_attr($this->get_id());

            if( $query_post_type == 'current_query'){
                $paged_key = 'paged';
            }

            $p_base = add_query_arg(null, null, false);
            $p_base = esc_url_raw( add_query_arg( $paged_key, '%#%', $p_base ) );
            $p_format = '?'.$paged_key.'=%#%';

            if( $p_total_pages == $p_current_page ) {
                $nav_classes[] = 'nothingtoshow';
            }

            $pagination_args = array(
                'total'        => $p_total_pages,
                'type'         => 'list',
                'prev_text'    => __( '&laquo;', 'lastudio-kit' ),
                'next_text'    => __( '&raquo;', 'lastudio-kit' ),
                'end_size'     => 3,
                'mid_size'     => 3
            );

            if($query_post_type != 'current_query'){
                $pagination_args['base']    = $p_base;
                $pagination_args['format']  = $p_format;
                $pagination_args['current'] = max( 1, $p_current_page );
            }

            ?>
            <nav class="<?php echo join(' ', $nav_classes) ?>" data-parent-container="#lapost_<?php echo $this->get_id() ?>" data-container="#lapost_<?php echo $this->get_id() ?> .lakit-posts__list" data-item-selector=".lakit-posts__item" data-ajax_request_id="<?php echo $paged_key ?>">
                <div class="lakit-ajax-loading-outer"><div class="la-loader spinner3"><div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div><div class="cube1"></div><div class="cube2"></div><div class="cube3"></div><div class="cube4"></div></div></div>
                <div class="lakit-post__loadmore_ajax lakit-pagination_ajax_loadmore">
                    <a href="javascript:;"><span><?php echo esc_html($load_more_text); ?></span></a>
                </div>
                <?php
                echo paginate_links( apply_filters( 'lastudio-kit/posts/pagination_args', $pagination_args, 'post' ) );
                ?>
            </nav>
            <?php
        }
    ?>

    <?php
        $this->item_counter = 0;
        $this->_processed_index = 0;
    }
    ?>
</div>
