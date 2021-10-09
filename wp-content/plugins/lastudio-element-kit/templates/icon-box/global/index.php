<?php
/**
 * Icon Box template
 */
$settings = $this->get_settings_for_display();
$icons_hover_animation = $this->get_settings_for_display('icons_hover_animation');
$icon_position = $this->get_settings_for_display('icon_position');
$show_global_link = $this->get_settings_for_display('show_global_link');
$global_link = $this->get_settings_for_display('global_link');
$enable_btn = $this->get_settings_for_display('enable_btn');
$btn_link = $this->get_settings_for_display('btn_url');
$enable_hover_btn = $this->get_settings_for_display('enable_hover_btn');
$icon_align = $this->get_settings_for_display('icon_align');
$show_overlay = $this->get_settings_for_display('show_overlay');
$show_image_overlay = $this->get_settings_for_display('show_image_overlay');
$info_box_hover_animation = $this->get_settings_for_display('info_box_hover_animation');
$section_bg_hover_color_direction = $this->get_settings_for_display('section_bg_hover_color_direction');
$icon_image_post = $this->get_settings_for_display('icon_position');

$box_classes = ['lakit-iconbox'];
$box_classes[] = 'lakit-iconbox__icon-align-' . $icon_image_post;
$box_classes[] = 'elementor-animation-' . $info_box_hover_animation;
if ($show_overlay == 'yes') {
    $box_classes[] = 'gradient-active';
}
if ($show_image_overlay == 'yes') {
    $box_classes[] = 'image-active';
}
$box_classes[] = $section_bg_hover_color_direction;
// info box style

$this->add_render_attribute('infobox_wrapper', 'class', $box_classes);

$title_tag = lastudio_kit_helper()->validate_html_tag( $this->get_settings_for_display('title_size') );

if(filter_var($show_global_link, FILTER_VALIDATE_BOOLEAN) && !filter_var($enable_btn, FILTER_VALIDATE_BOOLEAN) && !empty($global_link['url'])){
    $this->add_render_attribute( 'infobox_wrapper', [
        'data-lakit-element-link' => json_encode($global_link),
        'style' => 'cursor: pointer'
    ] );
}

echo sprintf('<div %1$s>', $this->get_render_attribute_string('infobox_wrapper') );
    echo $this->get_main_icon( sprintf('<div class="lakit-iconbox__box_header elementor-animation-%1$s"><div class="lakit-iconbox__box_icon icon_pos_%2$s">', esc_attr($icons_hover_animation), esc_attr($icon_position) )  . '%s</div></div>' );
    echo $this->get_main_image( sprintf('<div class="lakit-iconbox__box_header"><div class="lakit-iconbox__box_icon icon_pos_%1$s">', esc_attr($icon_position))  . '%s</div></div>' );

    echo '<div class="lakit-iconbox__box_body">';
    $this->_html( 'title_text', '<' . $title_tag  . ' class="lakit-iconbox__title">%s</' . $title_tag  . '>' );
    $this->_html( 'description_text', '<div class="lakit-iconbox__desc">%s</div>' );

    if(filter_var($enable_btn, FILTER_VALIDATE_BOOLEAN)){
        echo '<div class="lakit-iconbox__button_wrapper '. (filter_var($enable_hover_btn, FILTER_VALIDATE_BOOLEAN) ? 'enable_hover_btn' : 'disable_hover_button') .'">';
        $this->add_link_attributes('button', $btn_link );
        $this->add_render_attribute('button', 'class', 'elementor-button-link elementor-button');

        if ( !empty($settings['button_hover_animation']) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
        }

        $btn_text = $this->get_button_icon('<span class="elementor-button-icon elementor-align-icon-'. $icon_align .'">%s</span>');
        $btn_text .= sprintf('<span class="elementor-button-text">%s</span>', $this->get_settings_for_display('btn_text'));
        echo sprintf('<a %1$s><span class="elementor-button-content-wrapper">%2$s</span></a>', $this->get_render_attribute_string('button'), $btn_text);
        echo '</div>';
    }
    echo '</div>';
    echo $this->get_water_icon('<div class="lakit-iconbox__icon-hover">%s</div>');
    echo $this->get_overlay_image('<figure class="lakit-iconbox__image-hover">%s</figure>');
    echo $this->get_badge();
echo '</div>';