 <!--===// Start: Section 2
    =================================--> 
<?php  
	$fiona_section2_hs 				= get_theme_mod('section2_hs','1');
	$fiona_blog_section2_cat_id 	= get_theme_mod('section2_category_id');
	$fiona_blog_section2_title		= get_theme_mod('section2_title'); 
	$fiona_blog_section2_num		= get_theme_mod('section2_display_num','6');
	if($fiona_section2_hs == '1'){
?>	

<!--===// Start: Section 2 
=================================-->
<div id="post-section" class="post-section post-shadow av-py-default home-blog home-feature-categories">
	<div class="av-columns-area wow fadeInUp">
		<?php if(!empty($fiona_blog_section2_title)):?>
			<div class="av-column-12">
				<div class="heading-default wow fadeInUp">
					<h3><?php echo esc_html($fiona_blog_section2_title); ?></h3>
				</div>
			</div>
		<?php endif; ?>	
		<div class="av-column-12">
			<div class="av-masonry av-masonry-2">
				<?php
					$fiona_blog_blog_args = array( 'post_type' => 'post', 'category_name' => $fiona_blog_section2_cat_id,'posts_per_page' => $fiona_blog_section2_num,'post__not_in'=>get_option("sticky_posts"));
						$fiona_blog_wp_query = new WP_Query($fiona_blog_blog_args);
						if($fiona_blog_wp_query)
						{	
						while($fiona_blog_wp_query->have_posts()):$fiona_blog_wp_query->the_post();
					
						get_template_part('template-parts/content/content','page'); 
					
					 endwhile; } 
					 wp_reset_postdata();
				 ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>			
	