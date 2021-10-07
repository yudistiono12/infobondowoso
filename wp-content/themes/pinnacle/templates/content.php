<?php
/**
 * Post loop content
 *
 * @package Pinnacle Theme
 */

global $post, $pinnacle;
$slide_sidebar = 848;
$portraittext  = 'col-md-7';
$portraitimg   = 'col-md-5';

if ( isset( $pinnacle['postexcerpt_hard_crop'] ) && '1' === $pinnacle['postexcerpt_hard_crop'] ) {
	$hardcrop = true;
} else {
	$hardcrop = false;
}
// Get summary setting.
if ( has_post_format( 'video' ) ) {
	$postsummery = get_post_meta( $post->ID, '_kad_video_post_summery', true );
	if ( empty( $postsummery ) || 'default' === $postsummery ) {
		if ( ! empty( $pinnacle['video_post_summery_default'] ) ) {
			$postsummery = $pinnacle['video_post_summery_default'];
		} else {
			$postsummery = 'video';
		}
	}
	$swidth = get_post_meta( $post->ID, '_kad_video_posthead_width', true );
	if ( ! empty( $swidth ) ) {
		$slidewidth = $swidth;
	} else {
		$slidewidth = $slide_sidebar;
	}
					$slideheight = 400;
} else if ( has_post_format( 'gallery' ) ) {
	$postsummery = get_post_meta( $post->ID, '_kad_gallery_post_summery', true );
	if ( empty( $postsummery ) || 'default' === $postsummery ) {
		if ( ! empty( $pinnacle['gallery_post_summery_default'] ) ) {
			$postsummery = $pinnacle['gallery_post_summery_default'];
		} else {
			$postsummery = 'slider_landscape';
		}
	}
	$height = get_post_meta( $post->ID, '_kad_gallery_posthead_height', true );
	$swidth = get_post_meta( $post->ID, '_kad_gallery_posthead_width', true );
	if ( ! empty( $height ) ) {
		$slideheight = $height;
	} else {
		$slideheight = 400;
	}
	if ( ! empty( $swidth ) ) {
		$slidewidth = $swidth;
	} else {
		$slidewidth = $slide_sidebar;
	}
} elseif ( has_post_format( 'image' ) ) {
	$postsummery = get_post_meta( $post->ID, '_kad_image_post_summery', true );
	if ( empty( $postsummery ) || 'default' === $postsummery ) {
		if ( ! empty( $pinnacle['image_post_summery_default'] ) ) {
			$postsummery = $pinnacle['image_post_summery_default'];
		} else {
			$postsummery = 'img_portrait';
		}
	}
	$swidth = get_post_meta( $post->ID, '_kad_image_posthead_width', true );
	if ( ! empty( $swidth ) ) {
		$slidewidth = $swidth;
	} else {
		$slidewidth = $slide_sidebar;
	}
	$slideheight = 400;
} else {
	if ( ! empty( $pinnacle['post_summery_default'] ) ) {
		$postsummery = $pinnacle['post_summery_default'];
	} else {
		$postsummery = 'img_landscape';
	}
	$slidewidth  = $slide_sidebar;
	$slideheight = 400;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'kad_blog_item postclass kad-animation' ); ?> data-animation="fade-in" data-delay="0">
	<div class="row">
		<?php
		if ( 'img_landscape' === $postsummery ) {
			$textsize = 'col-md-12';
			if ( has_post_thumbnail( $post->ID ) ) {
				if ( $hardcrop ) {
					$img = pinnacle_get_image_array( $slidewidth, $slideheight, true, null, get_the_title(), get_post_thumbnail_id( $post->ID ), false );
				} else {
					$img = pinnacle_get_image_array( $slidewidth, false, false, null, get_the_title(), get_post_thumbnail_id( $post->ID ), false );
				}
				?>
				<div class="col-md-12">
					<div class="imghoverclass img-margin-center" >
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<img src="<?php echo esc_url( $img['src'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" class="iconhover" width="<?php echo esc_attr( $img['width'] ); ?>" height="<?php echo esc_attr( $img[2] ); ?>" <?php echo wp_kses_post( $img['srcset'] ); ?>>
						</a> 
					</div>
				</div>
				<?php
			}
		} elseif ( 'img_portrait' === $postsummery ) {
						$textsize = $portraittext;
					if ( has_post_thumbnail( $post->ID ) ) {
						$img = pinnacle_get_image_array( 360, 360, true, null, get_the_title(), get_post_thumbnail_id( $post->ID ), false );
						?>
								<div class="<?php echo esc_attr( $portraitimg ); ?>">
									<div class="imghoverclass img-margin-center" >
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<img src="<?php echo esc_url( $img['src'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" class="iconhover" width="<?php echo esc_attr( $img['width'] ); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" <?php echo wp_kses_post( $img['srcset'] ); ?>>
										</a> 
									 </div>
								 </div>
							  <?php
								$image = null;
								$thumbnail_url = null;
					} else {
						$textsize = 'col-md-12';
					}
				} elseif ( $postsummery == 'slider_landscape' ) {
						$textsize = 'col-md-12';
					?>
							<div class="col-md-12">
								<div class="flexslider kt-flexslider loading" style="max-width:<?php echo esc_attr( $slidewidth ); ?>px;" data-flex-speed="7000" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
									<ul class="slides">
									  <?php
										$image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
										if ( ! empty( $image_gallery ) ) {
											$attachments = array_filter( explode( ',', $image_gallery ) );
											if ( $attachments ) {
												foreach ( $attachments as $attachment ) {
													$img = pinnacle_get_image_array( $slidewidth, $slideheight, true, null, null, $attachment, false );
													?>
													<li>
														  <a href="<?php the_permalink(); ?>">
															  <div>
																<img src="<?php echo esc_url( $img['src'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" class="iconhover" width="<?php echo esc_attr( $img['width'] ); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" <?php echo wp_kses_post( $img['srcset'] ); ?>>
															</div>
														  </a>
													</li>
													<?php
												}
											}
										}
										?>
																			   
									</ul>
								</div> <!--Flex Slides-->
							</div>
				<?php } elseif ( $postsummery == 'slider_portrait' ) { ?>
							 <?php $textsize = 'col-md-7'; ?>
							  <div class="col-md-5">
								  <div class="flexslider kt-flexslider loading" data-flex-speed="7000" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
									  <ul class="slides">
										 <?php
											$image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
											if ( ! empty( $image_gallery ) ) {
												$attachments = array_filter( explode( ',', $image_gallery ) );
												if ( $attachments ) {
													foreach ( $attachments as $attachment ) {
														$img = pinnacle_get_image_array( 360, 360, true, null, null, $attachment, false );
														?>
													<li>
													  <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">
														  <div>
															<img src="<?php echo esc_url( $img['src'] ); ?>" alt="<?php echo esc_attr( $img['alt'] ); ?>" class="iconhover" width="<?php echo esc_attr( $img['width'] ); ?>" height="<?php echo esc_attr( $img['height'] ); ?>" <?php echo wp_kses_post( $img['srcset'] ); ?>>
														</div>
													  </a>
													</li>
														<?php
													}
												}
											}
											?>
													   
									  </ul>
								</div> <!--Flex Slides-->
							</div>
					<?php
				} elseif ( $postsummery == 'video' ) {
					   $textsize = 'col-md-12';
					?>
							<div class="col-md-12">
								<div class="videofit">
								<?php echo get_post_meta( $post->ID, '_kad_post_video', true ); ?>
								</div>
							</div>
					<?php
				} else {
						$textsize = 'col-md-12';
				}
				?>
					  <div class="<?php echo esc_attr( $textsize ); ?> postcontent">
							<?php
							if ( isset( $pinnacle['hide_author_img'] ) && $pinnacle['hide_author_img'] == '1' ) {
								get_template_part( 'templates/entry', 'meta-author' ); }
							?>
							<header>
								<a href="<?php the_permalink(); ?>"><h3 class="entry-title"><?php the_title(); ?></h3></a>
									<?php get_template_part( 'templates/entry', 'meta-subhead' ); ?>
							</header>
							<div class="entry-content">
								<?php the_excerpt(); ?>
							</div>
					  </div><!-- Text size -->
					  <div class="col-md-12 postfooterarea">
						  <footer class="clearfix">
							<?php get_template_part( 'templates/entry', 'meta-footer' ); ?>
						  </footer>
					  </div>
			</div><!-- row-->
	</article> <!-- Article -->
