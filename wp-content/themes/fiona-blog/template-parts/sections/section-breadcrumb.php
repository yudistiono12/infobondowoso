<?php 
$fiona_blog_hs_breadcrumb	= get_theme_mod('hs_breadcrumb','1');	
if($fiona_blog_hs_breadcrumb == '1') {	
?>
<section id="breadcrumb-section" class="breadcrumb-area breadcrumb-center">
	<div class="av-container">
		<div class="av-columns-area">
			<div class="av-column-12">
				<div class="breadcrumb-content">
					<div class="breadcrumb-heading">
						<h2>
							<?php 
								if ( is_home() || is_front_page()):
	
									single_post_title();
						
								elseif ( is_day() ) : 
								
									printf( __( 'Daily Archives: %s', 'fiona-blog' ), get_the_date() );
								
								elseif ( is_month() ) :
								
									printf( __( 'Monthly Archives: %s', 'fiona-blog' ), (get_the_date( 'F Y' ) ));
									
								elseif ( is_year() ) :
								
									printf( __( 'Yearly Archives: %s', 'fiona-blog' ), (get_the_date( 'Y' ) ) );
									
								elseif ( is_category() ) :
								
									printf( __( 'Category Archives: %s', 'fiona-blog' ), (single_cat_title( '', false ) ));

								elseif ( is_tag() ) :
								
									printf( __( 'Tag Archives: %s', 'fiona-blog' ), (single_tag_title( '', false ) ));
									
								elseif ( is_404() ) :

									printf( __( 'Error 404', 'fiona-blog' ));
									
								elseif ( is_author() ) :
								
									printf( __( 'Author: %s', 'fiona-blog' ), (get_the_author( '', false ) ));		
									
								elseif ( class_exists( 'woocommerce' ) ) : 
									
									if ( is_shop() ) {
										woocommerce_page_title();
									}
									
									elseif ( is_cart() ) {
										the_title();
									}
									
									elseif ( is_checkout() ) {
										the_title();
									}
									
									else {
										the_title();
									}
								else :
										the_title();
										
								endif;
								
							?>
						</h2>
					</div>
					<ol class="breadcrumb-list">
						<?php if (function_exists('fiona_blog_breadcrumbs')) fiona_blog_breadcrumbs();?>
					</ol>	
				</div>                    
			</div>
		</div>
	</div> <!-- container -->
</section>
<?php } ?>