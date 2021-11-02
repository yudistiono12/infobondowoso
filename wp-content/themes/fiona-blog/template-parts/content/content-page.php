<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fiona Blog
 */
$fiona_blog_post_format = get_post_format() ? : 'standard';
$post_format_icon_hs = get_theme_mod('post_format_icon_hs','1');
$post_date_box_hs 	 = get_theme_mod('post_date_box_hs','1');
$post_cats_hs 		 = get_theme_mod('post_cats_hs','1');
$post_tags_hs 		 = get_theme_mod('post_tags_hs','1');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-items post-filter mb-6'); ?>>
	<?php if($post_format_icon_hs =='1'): ?>
		<span class="post-format">
			<div class="post-shape">
				<div class="postIconFill"></div>
				<?php echo fiona_blog_post_format_icons(); ?>
			</div>
		</span>
	<?php endif; ?>	
	<?php if ( has_post_thumbnail() || $fiona_blog_post_format == 'video' || $fiona_blog_post_format == 'audio' || $fiona_blog_post_format == 'gallery' ) : ?>
	<figure class="post-image-figure">
		<div class="post-image">
			<?php do_action( 'fiona_blog_post_format_img_video' ); ?>
		</div>
	</figure>
	<?php endif;
	if ( is_sticky() ) : ?>
		<span class="bg-sticky rounded-circle"><i class="fa fa-thumb-tack"></i></span>
	<?php endif; ?>
	<div class="post-content post-padding">
		<?php if($post_cats_hs =='1' || $post_tags_hs =='1' || $post_date_box_hs =='1'): ?>
		<div class="post-meta">								
			<span class="post-list">
				<ul class="post-categories">
					<?php if($post_cats_hs =='1'): ?>
						<li><a href="<?php esc_url(the_permalink()); ?>"><i class="fa 	fa-folder-open"></i><?php the_category(', '); ?></a></li>
					<?php endif; ?>	
					<?php if(has_tag() && $post_tags_hs =='1') { ?>
						<li><a href="<?php esc_url(the_permalink()); ?>"><i class="fa fa-tag"></i><?php the_tags(''); ?></a></li>
					<?php } ?>
				</ul>
			</span>
			<?php if($post_date_box_hs =='1'): ?>
				<span class="posted-on post-date">
					<a href="<?php echo esc_url(get_month_link(get_post_time('Y'),get_post_time('m'))); ?>"><span><?php echo esc_html(get_the_date('j')); ?></span><?php echo esc_html(get_the_date('M')); ?></a>
				</span>
			<?php endif; ?>		
		</div>
		<?php
			endif;
			//title
			if ( is_single() ) :

			the_title('<h5 class="post-title">', '</h5>' );
			
			else:
			
			the_title( sprintf( '<h5 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
			
			endif;

			//content
			do_action( 'fiona_blog_post_format_img_video_content' );
		?>
	</div>
</article>