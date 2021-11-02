<?php
/**
 * The template for displaying search form.
 *
 * @package     Fiona Blog
 * @since       1.0
 */
?>

<form class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" placeholder="<?php esc_attr_e( 'Search', 'fiona-blog' ); ?>" name="s" id="s" class="av-search-field">
	<button class="av-search-submit"><i class="fa fa-search"></i></button>
</form>