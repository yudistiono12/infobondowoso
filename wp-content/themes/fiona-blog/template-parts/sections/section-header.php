<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="custom-header" rel="home">
		<img src="<?php esc_url(header_image()); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr(get_bloginfo( 'title' )); ?>">
	</a>
<?php endif;  ?>
<header id="header-section" class="header header-one">
        <!--===// Start: Header Above
        =================================-->
		<?php do_action('fiona_blog_above_header'); ?>	
        <!--===// End: Header Top
        =================================-->  
		<!-- Header Widget Info -->
	    <div class="header-widget-info d-none d-av-block">
	        <div class="av-container">
	            <div class="header-wrapper">                
	                <div class="flex-fill">
	                    <div class="header-info">
	                        <div class="header-item widget-left">
	                        	<div class="menu-right">
		                            <ul class="header-wrap-right">
	                                <?php $fiona_blog_hs_search = get_theme_mod( 'hide_show_search','1'); 
										 if($fiona_blog_hs_search == '1') { ?>
	                                    <li class="search-button">
	                                        <button id="view-search-btn" class="header-search-toggle"><i class="fa fa-search"></i></button>
											<!-- Quik search -->
											<div class="view-search-btn header-search-popup">
												<div class="search-overlay-layer"></div>
												<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Site Search', 'fiona-blog' ); ?>">
													<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'fiona-blog' ); ?></span>
													<input type="search" class="search-field header-search-field" placeholder="<?php esc_attr_e( 'Type To Search', 'fiona-blog' ); ?>" name="s" id="popfocus" value="" autofocus>
													<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
												</form>
												<button type="button" class="close-style header-search-close"></button>
											</div>
											<!-- / -->
										</li>  
										<?php } 
										 $fiona_blog_hs_nav_social  = get_theme_mod( 'hs_nav_social','1');
										 $fiona_blog_hdr_nav_social = get_theme_mod( 'hdr_nav_social_icons'); 
										 if($fiona_blog_hs_nav_social == '1' && !empty($fiona_blog_hdr_nav_social)) {?>
										<li class="share-toolkit-list">
											<aside class="share-toolkit widget widget_social_widget">
												<a href="#" class="toolkit-hover"><i class="fa fa-share-alt"></i></a>
												<ul>
													<?php
														$fiona_blog_hdr_nav_social = json_decode($fiona_blog_hdr_nav_social);
														if( $fiona_blog_hdr_nav_social!='' )
														{
														foreach($fiona_blog_hdr_nav_social as $fiona_blog_social_item){	
														$fiona_blog_social_icon = ! empty( $fiona_blog_social_item->icon_value ) ? apply_filters( 'fiona_blog_translate_single_string', $fiona_blog_social_item->icon_value, 'Navigation section' ) : '';	
														$fiona_blog_social_link = ! empty( $fiona_blog_social_item->link ) ? apply_filters( 'fiona_blog_translate_single_string', $fiona_blog_social_item->link, 'Navigation section' ) : '';
													?>
														<li><a href="<?php echo esc_url( $fiona_blog_social_link ); ?>"><i class="fa <?php echo esc_attr( $fiona_blog_social_icon ); ?>"></i><svg class="round-svg-circle"><circle cx="50%" cy="50%" r="49%"></circle><circle cx="50%" cy="50%" r="49%"></circle></svg></a></li>
													<?php }} ?>
												</ul>
											</aside>
										</li>
									<?php } ?>
									</ul>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="flex-fill">
	                    <div class="logo text-center">
			                <?php
								if(has_custom_logo())
								{	
									the_custom_logo();
								}
								else { 
								?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<h4 class="site-title">
										<?php 
											echo esc_html(get_bloginfo('name'));
										?>
									</h4>
								</a>	
							<?php 						
								}
							?>
							<?php
								$fiona_blog_description = get_bloginfo( 'description');
								if ($fiona_blog_description) : ?>
									<p class="site-description"><?php echo esc_html($fiona_blog_description); ?></p>
							<?php endif; ?>
			            </div>
	                </div>
	                <div class="flex-fill">
	                    <div class="header-info">
	                        <div class="header-item widget-right">
	                            <div class="menu-right">
	                                <ul class="header-wrap-right">
										<?php $fiona_blog_flash_hs = get_theme_mod( 'hide_show_flash','1'); 
										 if($fiona_blog_flash_hs == '1') { ?>
	                                	<li class="flash-toolkit-list">
											<aside class="flash-toolkit">
												<button type="button" class="flash-hover"><i class="fa fa-flash"></i></button>
											</aside>
										</li>
										<?php } 
										  $fiona_blog_bookmark_hs = get_theme_mod( 'hide_show_bookmark','1'); 
										 if($fiona_blog_bookmark_hs == '1') { ?>
	                                	<li class="bookmark-toolkit-list">
											<aside class="bookmark-toolkit">
												<a href="<?php echo esc_url( admin_url()); ?>" class="bookmark-hover"><i class="fa fa-bookmark-o"></i><span class="bookmark-total"><?php echo count_user_posts( get_the_author_meta('ID') ); ?></span></a>
												<ul>
													<li><a href="<?php echo esc_url( admin_url()); ?>"><?php esc_html_e('Login to add posts to your read later list','fiona-blog'); ?></a></li>
												</ul>
											</aside>
										</li>
										<?php } ?>
	                                </ul>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- / -->

        <div class="navigator-wrapper">
	        <!--===// Start: Mobile Toggle
	        =================================-->
	        <div class="theme-mobile-nav <?php echo esc_attr(fiona_blog_sticky_menu()); ?>"> 
	            <div class="av-container">
	                <div class="av-columns-area">
	                    <div class="av-column-12">
	                        <div class="theme-mobile-menu">
	                        	<div class="mobile-logo">
	                            	<div class="logo">
										<?php
											if(has_custom_logo())
											{	
												the_custom_logo();
											}
											else { 
											?>
											<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
												<h4 class="site-title">
													<?php 
														echo esc_html(get_bloginfo('name'));
													?>
												</h4>
											</a>	
										<?php 						
											}
										?>
										<?php
											$fiona_blog_description = get_bloginfo( 'description');
											if ($fiona_blog_description) : ?>
												<p class="site-description"><?php echo esc_html($fiona_blog_description); ?></p>
										 <?php endif; ?>
									</div>
	                            </div>
	                            <div class="menu-toggle-wrap">
	                            	<div class="mobile-menu-right"></div>
									<div class="hamburger-menu">
										<button type="button" class="menu-toggle">
											<div class="top-bun"></div>
											<div class="meat"></div>
											<div class="bottom-bun"></div>
										</button>
									</div>
								</div>
	                            <div id="mobile-m" class="mobile-menu">
	                                <button type="button" class="header-close-menu close-style"></button>
	                            </div>
	                            <div class="headtop-mobi">
	                                <div class="header-toggle"><button type="button" class="header-above-toggle"><span></span></button></div>
									<div id="mob-h-top" class="mobi-head-top"></div>
								</div>
	                        </div>
	                    </div>
	                </div>
	            </div>        
	        </div>
	        <!--===// End: Mobile Toggle
	        =================================-->

	        <!--===// Start: Navigation
	        =================================-->
	        <div class="nav-area d-none d-av-block">
	        	<div class="navbar-area <?php echo esc_attr(fiona_blog_sticky_menu()); ?>">
		            <div class="av-container">
		                <div class="av-columns-area">
		                	<div class="theme-menu-left my-auto">
		                		<div class="menu-right">
		                			<ul class="header-wrap-right">
		                                <?php 
											$fiona_blog_hs_nav_btn = get_theme_mod( 'hide_show_nav_btn','1'); 
											$fiona_blog_nav_btn_lbl  = get_theme_mod( 'nav_btn_lbl');
											$fiona_blog_nav_btn_link = get_theme_mod( 'nav_btn_link');
											$fiona_blog_nav_btn_icon = get_theme_mod( 'nav_btn_icon');
										?>
										<?php if($fiona_blog_hs_nav_btn == '1' && !empty($fiona_blog_nav_btn_lbl)) { ?>
											<li class="av-button-area">
												<a href="<?php echo esc_url($fiona_blog_nav_btn_link );?>" target="_blank" class="av-btn av-btn-primary av-btn-effect-0">
													<span><?php echo esc_html($fiona_blog_nav_btn_lbl);?></span>
													<span><i class="fa <?php echo esc_attr($fiona_blog_nav_btn_icon); ?>"></i></span>
												</a>
											</li> 
										<?php } ?>
									</ul>
	                            </div>
		                	</div>
		                    <div class="theme-menu-center my-auto px-0">
		                        <div class="theme-menu">
		                            <nav class="menubar">
		                               <?php 
											wp_nav_menu( 
												array(  
													'theme_location' => 'primary_menu',
													'container'  => '',
													'menu_class' => 'menu-wrap',
													'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
													'walker' => new WP_Bootstrap_Navwalker()
													 ) 
												);
										?>                   
		                            </nav>
		                        </div>
		                    </div>
		                    <div class="theme-menu-right my-auto">
								<?php $fiona_blog_hs_cart = get_theme_mod( 'hide_show_cart','1'); ?>
								<div class="menu-right">
	                                <ul class="header-wrap-right">
										<?php if($fiona_blog_hs_cart == '1') { ?>
										<?php if ( class_exists( 'WooCommerce' ) ) { ?>
											<li class="cart-wrapper">
												<a href="javascript:void(0)" class="cart-icon-wrap" id="cart" title="View your shopping cart">             
													<i class="fa cart-icon"></i>
													<?php 
													if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
														$fiona_blog_cart_count = WC()->cart->cart_contents_count;
														$fiona_blog_cart_url = wc_get_cart_url();
														
														if ( $fiona_blog_cart_count > 0 ) {
														?>
															 <span><?php echo esc_html( $fiona_blog_cart_count ); ?></span>
														<?php 
														}
														else {
															?>
															<span><?php esc_html_e('0','fiona-blog'); ?></span>
															<?php 
														}
													}
													?>
												</a>
												<!-- Shopping Cart Start -->
												<div class="shopping-cart">
													<?php get_template_part('woocommerce/cart/mini','cart');	 ?>
												</div>
												<!-- Shopping Cart End -->
											</li>
										<?php } }
										$fiona_blog_hs_nav_docker = get_theme_mod('hs_hdr_nav_docker','1');
										if($fiona_blog_hs_nav_docker == '1'): 
										?>
											<li class="about-toggle-list">
												<div class="hamburger-menu">
													<button type="button" class="about-toggle">
														<div class="top-bun"></div>
														<div class="meat"></div>
														<div class="bottom-bun"></div>
													</button>
												</div>
											</li>
										<?php endif; ?>
	                                </ul>
	                            </div>
	                        </div>
		                </div>
		            </div>
		        </div>
	        </div>
	        <!--===// End:  Navigation
	        =================================-->
	    </div>
	    
		<!-- Author Popup -->
		<div class="author-popup">
			<div class="author-overlay-layer"></div>
		    <div class="author-div">
				<div class="author-anim">
					<button type="button" class="close-style author-close"></button>
					<div class="author-content">
		       			<?php 
							$fiona_blog_docker_custom 	= get_theme_mod('hdr_nav_docker_custom');
								  if ( ! empty( $fiona_blog_docker_custom ) ){ 
										 echo wp_kses_post($fiona_blog_docker_custom); 
								 } 
						?>
					</div>
				</div>
		    </div>
		</div>
		<!-- / -->
    </header>
    <!-- End: Header
    =================================-->
<?php
if ( !is_page_template( 'templates/template-homepage.php' ) ) {
	fiona_blog_breadcrumbs_style();  
}
