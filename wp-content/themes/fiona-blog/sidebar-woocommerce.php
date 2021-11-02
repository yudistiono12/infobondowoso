<?php
/**
 * side bar template
 */
?>
<?php if ( ! is_active_sidebar( 'fiona-blog-woocommerce-sidebar' ) ) {	return; } ?>
<div id="av-secondary-content" class="av-column-4 av-pb-default av-pt-default wow fadeInUp">
	<section class="sidebar">
		<?php dynamic_sidebar('fiona-blog-woocommerce-sidebar'); ?>
	</section>
</div>