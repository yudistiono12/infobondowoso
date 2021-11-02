<?php
/**
Template Name: Homepage
**/

get_header();

//Section Slider
do_action('fiona_blog_slider');
?>
<section class="full-homepage">
	<div class="av-container">
		<div class="av-columns-area">
			<div id="av-primary-content" class="av-column-8">	
				<?php	
					get_template_part('template-parts/sections/section','feature-categories');	
					do_action('fiona_blog_sections');		
				 ?>
			</div>
			<?php get_sidebar(); ?>
		</div>	
	</div>		
</section>
<?php
get_footer(); ?>