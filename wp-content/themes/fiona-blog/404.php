<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Fiona Blog
 */
get_header();
?>
<section id="section404" class="section404 av-py-default">
	<div class="av-container">
		<div class="av-columns-area wow fadeInUp">
			<div class="av-column-12">
				<div class="av-text-404">
					<div class="balloon">
						<div><span><?php esc_html_e('4','fiona-blog'); ?></span></div>
						
						<div><span>
							<img src=<?php echo esc_url(get_template_directory_uri()."/assets/images/bg/smile.svg"); ?> alt="" width="335">	
						</span></div>
						
						<div><span><?php esc_html_e('4','fiona-blog'); ?></span></div>
					</div>
					
					<h2><?php esc_html_e('OOPS!...','fiona-blog'); ?></h2>
					<p><?php esc_html_e('Something Went Wrong','fiona-blog'); ?></p>
					
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="av-btn av-btn-primary"><?php esc_html_e('Back To Home','fiona-blog'); ?></a>  
				</div>
			</div>
		</div>
	</div>
</section>
<?php 
get_footer(); ?>
