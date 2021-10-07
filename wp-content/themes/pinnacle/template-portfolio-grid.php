<?php
/*
Template Name: Portfolio Grid
*/
get_header(); 
get_template_part('templates/page', 'header'); 

 global $post, $pinnacle;
			$portfolio_category    = get_post_meta( $post->ID, '_kad_portfolio_type', true );
			$portfolio_style       = get_post_meta( $post->ID, '_kad_portfolio_style', true );
			$portfolio_items       = get_post_meta( $post->ID, '_kad_portfolio_items', true );
			$portfolio_column      = get_post_meta( $post->ID, '_kad_portfolio_columns', true );
			$portfolio_ratio       = get_post_meta( $post->ID, '_kad_portfolio_img_ratio', true );
			$pie                   = get_post_meta( $post->ID, '_kad_portfolio_item_excerpt', true );
			$portfolio_hover_style = get_post_meta( $post->ID, '_kad_portfolio_hover_style', true );
			$portfolio_item_types  = get_post_meta( $post->ID, '_kad_portfolio_item_types', true );
			$portfolio_lightbox    = get_post_meta( $post->ID, '_kad_portfolio_lightbox', true );
			$portfolio_order       = get_post_meta( $post->ID, '_kad_portfolio_order', true );

			if(empty($portfolio_style) || $portfolio_style == 'default') {
				if(isset($pinnacle['portfolio_style_default'])) {
					$pstyleclass = $pinnacle['portfolio_style_default'];
				} else {
					$pstyleclass = 'padded_style';
				}
			} else {
				$pstyleclass = $portfolio_style;
			}

			if(empty($portfolio_hover_style) || $portfolio_hover_style == 'default') {
				if(isset($pinnacle['portfolio_hover_style_default'])) {
					$phoverstyleclass = $pinnacle['portfolio_hover_style_default'];
				} else {
					$phoverstyleclass = 'p_lightstyle';
				}
			} else {
				$phoverstyleclass = $portfolio_hover_style;
			}

			if(!empty($pie) && $pie == "on") {
				$showexcerpt = 'true';
			} else {
				$showexcerpt = 'false';
			}


			if (!empty($portfolio_lightbox) && $portfolio_lightbox == 'on'){
				$plb = 'true';
			} else {
				$plb = 'false';
			}

			if(isset($portfolio_order)) {
				$p_orderby = $portfolio_order;
			} else {
				$p_orderby = 'menu_order';
			}

			if($p_orderby == 'menu_order' || $p_orderby == 'title') {
				$p_order = 'ASC';
			} else {
				$p_order = 'DESC';
			}

			if($portfolio_category == '-1' || empty($portfolio_category)) {
				$portfolio_cat_slug = ''; $portfolio_cat_ID = '';
			} else {
				$portfolio_cat = get_term_by ('id',$portfolio_category,'portfolio-type' );
				$portfolio_cat_slug = $portfolio_cat -> slug;
				$portfolio_cat_ID = $portfolio_cat -> term_id;
			}
			$portfolio_category = $portfolio_cat_slug;

			if($portfolio_items == 'all') {
				$portfolio_items = '-1';
			}

			if(empty($portfolio_ratio) || $portfolio_ratio == 'default') {
				if(isset($pinnacle['portfolio_ratio_default'])) {
					$pimgratio = $pinnacle['portfolio_ratio_default'];
				} else {
					$pimgratio = "square";
				}
			} else {
				$pimgratio = $portfolio_ratio;
			}

			if ($portfolio_column == '2') {
				$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12';
				$slidewidth = 600;
			} else if ($portfolio_column == '3'){
				$itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12';
				$slidewidth = 400;
			} else if ($portfolio_column == '6'){
				$itemsize = 'tcol-md-2 tcol-sm-3 tcol-xs-4 tcol-ss-6';
				$slidewidth = 300;
			} else if ($portfolio_column == '5'){
				$itemsize = 'tcol-md-25 tcol-sm-3 tcol-xs-4 tcol-ss-6';
				$slidewidth = 300;
			} else {
				$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12';
				$slidewidth = 300;
			}

			if($pimgratio == 'portrait') {
				$temppimgheight = $slidewidth * 1.35;
				$slideheight = floor($temppimgheight);
			} else if($pimgratio == 'landscape') {
				$temppimgheight = $slidewidth / 1.35;
				$slideheight = floor($temppimgheight);
			} else if($pimgratio == 'widelandscape') {
				$temppimgheight = $slidewidth / 2;
				$slideheight = floor($temppimgheight);
			} else {
				$slideheight = $slidewidth;
			}
			// Set global loop var
        		global $kt_portfolio_loop;
                  $kt_portfolio_loop = array(
                 	'lightbox' => $plb,
                 	'showexcerpt' => $showexcerpt,
                 	'showtypes' => $portfolio_item_types,
                 	'pstyleclass' => $pstyleclass,
                 	'slidewidth' => $slidewidth,
                 	'slideheight' => $slideheight,
                 	);
		?>
	<div id="content" class="container">
   		<div class="row">
      		<div class="main <?php echo esc_attr( pinnacle_main_class() ); ?>" role="main">
				<div class="container entry-content" itemprop="mainContentOfPage"><?php get_template_part('templates/content', 'page'); ?></div>              
            		<div id="portfoliowrapper" class="rowtight <?php echo esc_attr($pstyleclass);?> <?php echo esc_attr($phoverstyleclass);?>"> 

		           	<?php if ( post_type_exists( 'portfolio' ) ) {
							$temp 		= $wp_query; 
						  	$wp_query 	= null; 
						  	$wp_query 	= new WP_Query();
							$wp_query->query(array(
									'paged' 			=> $paged,
									'orderby' 			=> $p_orderby,
									'order' 			=> $p_order,
									'post_type' 		=> 'portfolio',
									'portfolio-type'	=> $portfolio_cat_slug,
									'posts_per_page' 	=> $portfolio_items
									));
					
								if ( $wp_query ) : 
									while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
										<div class="<?php echo esc_attr($itemsize);?> p-item">
					                	<?php do_action('kadence_portfolio_loop_start');
												get_template_part('templates/content', 'loop-portfolio'); 
											  do_action('kadence_portfolio_loop_end');
										?>
                    				</div>
								<?php endwhile; else: ?>
									<li class="error-not-found"><?php _e('Sorry, no portfolio entries found.', 'pinnacle');?></li>
								<?php endif; ?>
                	</div> <!--portfoliowrapper-->
             
		                <?php if ($wp_query->max_num_pages > 1) :
		                        if(function_exists('pinnacle_wp_pagination')) {
		                            pinnacle_wp_pagination();   
		                        } else { ?>      
		                            <nav id="post-nav" class="pager">
		                                <div class="previous"><?php next_posts_link(__('&larr; Older posts', 'pinnacle')); ?></div>
		                                <div class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'pinnacle')); ?></div>
		                             </nav>
		                        <?php }
		                endif;
		               	$wp_query = null; 
		                $wp_query = $temp;
		                wp_reset_query(); 
		            }?>
		            <?php do_action('kt_after_pagecontent'); ?>
			</div><!-- /.main -->
			<?php get_sidebar(); ?>
      	</div><!-- /.row-->
    </div><!-- /.content -->
</div><!-- /.wrap -->
<?php get_footer(); ?>