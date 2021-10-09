<?php
	/**
	 * Loop item template
	 */
	
	$target = $this->_loop_item( array( 'item_link_target' ), ' target="%s"' );
	$rel = $this->_loop_item( array( 'item_link_rel' ), ' rel="%s"' );
	
	$item_settings = $this->_processed_item;
	
	$content_type = ! empty( $item_settings['item_content_type'] ) ? $item_settings['item_content_type'] : 'default';

	$img = $this->get_advanced_carousel_img( 'lakit-banner__img' );
	$lightbox = 'data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="' . $this->get_id() . '"';
	$settings = $this->get_settings_for_display();

?>
<div class="lakit-carousel__item swiper-slide">
	<div class="lakit-carousel__item-inner">
        <?php if(empty($img) && $content_type == 'template') :?>
        <div class="lakit-template-wrapper"><?php echo $this->_loop_item_template_content();?></div>
        <?php else: ?>
        <figure class="lakit-banner lakit-effect-<?php echo esc_attr( $this->get_settings_for_display( 'animation_effect' ) ); ?>"><?php

                if ( $item_settings['item_content_type'] === 'default' ) {
                    if ( $settings['item_link_type'] === 'lightbox' && $img ) {
                        printf( '<a href="%1$s" class="lakit-banner__link" %2$s>', $item_settings['item_image']['url'], $lightbox );
                    } else {
                        echo $this->_loop_item( array( 'item_link' ), '<a href="%s" class="lakit-banner__link"' . $target . $rel . '>' );
                    }
                }

                echo '<div class="lakit-banner__overlay"></div>';
                echo $img;
                echo '<figcaption class="lakit-banner__content">';
                    echo '<div class="lakit-banner__content-wrap">';
                        switch ( $content_type ) {
                            case 'default':
                                echo $this->_loop_item( array( 'item_title' ), '<' . $title_tag . ' class="lakit-banner__title">%s</' . $title_tag . '>' );
                                echo $this->_loop_item( array( 'item_text' ), '<div class="lakit-banner__text">%s</div>' );
                                break;
                            case 'template':
                                echo $this->_loop_item_template_content();
                                break;
                        }
                    echo '</div>';
                echo '</figcaption>';

            if ( $item_settings['item_content_type'] === 'default' ) {
                if ( $settings['item_link_type'] === 'lightbox' && $img ) {
                    printf( '</a>' );
                } else {
                    echo $this->_loop_item( array( 'item_link' ), '</a>' );
                }
            }
	?></figure>
    <?php endif; ?>
	</div>
</div>
