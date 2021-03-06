<?php
/**
 * Features list item template
 */

$classes  = 'pricing-feature-' . $this->_loop_item( array( '_id' ) );
$classes .= ' ' . $this->_loop_item( array( 'item_included' ) );

?>
<div class="pricing-feature <?php echo $classes; ?>">
	<div class="pricing-feature__inner"><?php
		echo $this->__pricing_feature_icon();
		printf( '<span class="pricing-feature__text">%s</span>', $this->_loop_item( array( 'item_text' ) ) );
	?></div>
</div>