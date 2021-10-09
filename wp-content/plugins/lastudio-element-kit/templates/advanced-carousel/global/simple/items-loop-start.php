<?php
/**
 * Loop start template
 */
$options = $this->get_advanced_carousel_options();
$dir = is_rtl() ? 'rtl' : 'ltr';

$title_tag  = $this->get_settings_for_display( 'title_html_tag' );
$title_tag  = lastudio_kit_helper()->validate_html_tag( $title_tag );
$link_title = $this->get_settings_for_display( 'link_title' );

$equal_cols = $this->get_settings_for_display( 'equal_height_cols' );
$cols_class = ( 'true' === $equal_cols ) ? ' lakit-equal-cols' : '';

?><div class="lakit-carousel lakit-carousel--simple<?php echo esc_attr($cols_class) ?>" data-slider_options="<?php echo htmlspecialchars( json_encode( $options ) ); ?>" dir="<?php echo $dir; ?>">
    <div class="swiper-container"><div class="swiper-wrapper">
