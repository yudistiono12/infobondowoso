<?php
/**
 * Page Header.
 *
 * @package Pinnacle Theme
 */

if ( ! pinnacle_hide_pagetitle() ) {
} else {
	global $post, $pinnacle;
	if ( is_page() ) {
		$bsub = get_post_meta( $post->ID, '_kad_subtitle', true );
	} elseif ( is_category() ) {
		$bsub = strip_tags( category_description() );
	} elseif ( is_tag() ) {
		$bsub = strip_tags( tag_description() );
	} else {
		$bsub = '';
	}
	$bsub = apply_filters( 'kadence_page_subtitle', $bsub, $post, $pinnacle );
	?>
	<div id="pageheader" class="titleclass">
		<div class="header-color-overlay"></div>
		<div class="container">
			<div class="page-header">
				<div class="row">
					<div class="col-md-12">
						<h1 class="kad-page-title entry-title" itemprop="name headline"><?php echo apply_filters( 'kadence_page_title', pinnacle_title() ); ?></h1>
						<?php
						if ( ! empty( $bsub ) ) {
							echo '<div class="subtitle"> ' . do_shortcode( $bsub ) . ' </div>';
						}
						?>
					</div>
				</div>
			</div>
		</div><!--container-->
	</div><!--titleclass-->
<?php } ?>
