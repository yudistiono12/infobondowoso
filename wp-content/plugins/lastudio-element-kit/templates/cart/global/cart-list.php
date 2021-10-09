<?php
/**
 * Cart list template
 */

$close_button_html = $this->_get_icon( 'cart_list_close_icon', '<div class="lakit-cart__close-button lakit-blocks-icon">%s</div>' );
?>
<div class="lakit-cart__list">
	<?php echo $close_button_html; ?>
	<?php $this->_html( 'cart_list_label', '<h4 class="lakit-cart__list-title">%s</h4>' ); ?>
	<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
</div>
