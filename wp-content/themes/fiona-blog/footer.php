<!--===// Start: Footer
    =================================-->
    <footer id="footer-section" class="footer-section footer">
		<?php if ( is_active_sidebar( 'fiona-blog-footer-widget-area' ) ) { ?>
			<div class="footer-main">
				<div class="av-container">
					<div class="av-columns-area wow fadeInDown">
						<?php  dynamic_sidebar( 'fiona-blog-footer-widget-area' ); ?>
					</div>
				</div>
			</div>
		<?php } ?>	
		 <div class="footer-copyright">
            <div class="av-container">
                <div class="av-columns-area">
					<div class="av-column-12 av-md-column-12">
						<div class="footer-copy widget-center">
							<?php 
							dynamic_sidebar( 'fiona-blog-footer-layout-first' );
							$footer_first_custom  = get_theme_mod('footer_first_custom','Copyright &copy; [current_year] [site_title] | Powered by [theme_author]');	
							 if(!empty($footer_first_custom)){
							?>
								<div class="widget-center text-av-center text-center">            
									<div class="copyright-text">
										<?php
											$fiona_blog_copyright_allowed_tags = array(
												'[current_year]' => date_i18n('Y'),
												'[site_title]'   => get_bloginfo('name'),
												'[theme_author]' => sprintf(__('<span><a href="#">Fiona WordPress Theme</a></span>', 'fiona-blog')),
											);
											echo apply_filters('fiona_blog_footer_copyright', wp_kses_post(fiona_blog_str_replace_assoc($fiona_blog_copyright_allowed_tags, $footer_first_custom)));
										?>
									</div>
								</div>
							 <?php } ?>
						</div>
					</div>					
                </div>
            </div>
        </div>
    </footer>
    <!-- End: Footer
    =================================-->
<!-- ScrollUp -->
<?php 
	$hs_scroller 	= get_theme_mod('hs_scroller','1');	
	if($hs_scroller == '1') :
?>
	<button type=button class="scrollup"><i class="fa fa-arrow-up"></i></button>
<?php endif; ?>	
<!-- / -->  
</div>
</div>
<?php 
wp_footer(); ?>
</body>
</html>
