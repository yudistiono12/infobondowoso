<?php
/**
 * Loop end template
 */
?></div><?php
if ( filter_var(  $this->get_settings_for_display( 'carousel_dots' ), FILTER_VALIDATE_BOOLEAN ) ) {
    echo '<div class="lakit-carousel__dots swiper-pagination"></div>';
}
if ( filter_var(  $this->get_settings_for_display( 'carousel_arrows' ), FILTER_VALIDATE_BOOLEAN ) ) {
    echo sprintf( '<div class="lakit-carousel__prev-arrow-%s lakit-arrow prev-arrow">%s</div>', $this->get_id(), $this->_render_icon( 'carousel_prev_arrow', '%s', '', false ) );
    echo sprintf( '<div class="lakit-carousel__next-arrow-%s lakit-arrow next-arrow">%s</div>', $this->get_id(), $this->_render_icon( 'carousel_next_arrow', '%s', '', false ) );
}
if ( filter_var(  $this->get_settings_for_display( 'carousel_scrollbar' ), FILTER_VALIDATE_BOOLEAN ) ) {
    echo '<div class="lakit-carousel__scrollbar swiper-scrollbar"></div>';
}
?></div></div>