<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Fiona
 */

if ( ! function_exists( 'fiona_blog_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function fiona_blog_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'fiona-blog' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'fiona-blog' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
}
endif;

if ( ! function_exists( 'fiona_blog_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function fiona_blog_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'fiona-blog' ) );
		if ( $categories_list && fiona_blog_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'fiona-blog' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'fiona-blog' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'fiona-blog' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'fiona-blog' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'fiona-blog' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function fiona_blog_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'fiona_blog_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'fiona_blog_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so fiona_blog_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so fiona_blog_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in fiona_blog_categorized_blog.
 */
function fiona_blog_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'fiona_blog_categories' );
}
add_action( 'edit_category', 'fiona_blog_category_transient_flusher' );
add_action( 'save_post',     'fiona_blog_category_transient_flusher' );

/**
 * Function that returns if the menu is sticky
 */
if (!function_exists('fiona_blog_sticky_menu')):
    function fiona_blog_sticky_menu()
    {
        $is_sticky = get_theme_mod('hide_show_sticky','1');

        if ($is_sticky == '1'):
            return 'sticky-nav ';
        else:
            return 'not-sticky';
        endif;
    }
endif;


/**
 * Register Google fonts for fiona.
 */
function fiona_blog_google_font() {
	
    $get_fonts_url = '';
		
    $font_families = array();
 
	$font_families = array('Poppins:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $get_fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

    return $get_fonts_url;
}

function fiona_blog_scripts_styles() {
    wp_enqueue_style( 'fiona-blog-fonts', fiona_blog_google_font(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'fiona_blog_scripts_styles' );


/**
 * Register Breadcrumb for Multiple Variation
 */
function fiona_blog_breadcrumbs_style() {
	get_template_part('./template-parts/sections/section','breadcrumb');			
}

/**
 * Fiona post-format select type of icons
 */
if (!function_exists('fiona_blog_post_format_icons')):
    function fiona_blog_post_format_icons()
    {
        $fiona_blog_post_format = get_post_format() ? : 'standard';

        if ( $fiona_blog_post_format == 'aside' ) : ?>
		
			<div class="post-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"><path d="M24.411 0H5.589A5.6 5.6 0 000 5.59v18.82A5.609 5.609 0 005.589 30h18.822A5.609 5.609 0 0030 24.41V5.59A5.6 5.6 0 0024.411 0zm0 27.18H5.589a2.775 2.775 0 01-2.777-2.77V5.59a2.784 2.784 0 012.777-2.78h18.822a2.783 2.783 0 012.776 2.78v18.82a2.774 2.774 0 01-2.776 2.77zm-4.183-13.47h-3.942V9.77a1.286 1.286 0 10-2.572 0v3.94H9.771a1.285 1.285 0 100 2.57h3.943v3.94a1.286 1.286 0 102.572 0v-3.94h3.942a1.285 1.285 0 100-2.57z" fill="var(--sp-primary)" fill-rule="evenodd"/></svg>
		   	</div>
			
		<?php elseif ( $fiona_blog_post_format == 'gallery' ) : ?>
		
			<div class="post-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="28"><path d="M16.219 9.88a3.255 3.255 0 103.266 3.26 3.264 3.264 0 00-3.266-3.26zm0 4.96a1.705 1.705 0 110-3.41 1.705 1.705 0 110 3.41zM29.246 2.43L8.013.02A3.086 3.086 0 004.591 2.7l-.389 3.18H3A3.119 3.119 0 000 9.1v15.87a2.944 2.944 0 002.877 3.02h21.467a3.189 3.189 0 003.267-3.02v-.62a3.967 3.967 0 001.478-.62 3.221 3.221 0 001.127-2.1l1.789-15.75a3.14 3.14 0 00-2.759-3.45zm-3.189 22.54a1.635 1.635 0 01-1.711 1.47H3a1.4 1.4 0 01-1.441-1.35V22.1l6.027-4.43a1.878 1.878 0 012.411.12l4.24 3.73a3.692 3.692 0 002.294.85 3.516 3.516 0 001.867-.51l7.66-4.42v7.53zm0-9.35l-8.477 4.92a1.966 1.966 0 01-2.3-.19l-4.277-3.76a3.47 3.47 0 00-4.317-.16l-5.133 3.73V9.1a1.571 1.571 0 011.439-1.67h21.349a1.79 1.79 0 011.711 1.67v6.52zm4.4-9.95v.02l-1.828 15.75a1.3 1.3 0 01-.506 1.04c-.155.16-.5.24-.5.32V9.1a3.34 3.34 0 00-3.267-3.22H5.758l.35-3.02a1.756 1.756 0 01.583-1.01 1.735 1.735 0 011.167-.31l21.194 2.44a1.552 1.552 0 011.401 1.69z" fill="var(--sp-primary)" fill-rule="evenodd"/></svg>
			</div>
			
		<?php elseif ( $fiona_blog_post_format == 'link' ) : ?>
		
			<div class="post-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="28.969" height="29"><path d="M7.99 20.97a1.178 1.178 0 001.676 0L20.944 9.7a1.187 1.187 0 00-1.676-1.68L7.99 19.3a1.178 1.178 0 000 1.67zM26.582 2.38a8.16 8.16 0 00-11.52 0l-3.894 3.9a1.178 1.178 0 000 1.67 1.19 1.19 0 001.676 0l3.894-3.89a5.776 5.776 0 018.168 8.17l-3.894 3.89a1.187 1.187 0 001.676 1.68l3.894-3.9a8.143 8.143 0 000-11.52zM16.09 21.04l-3.894 3.89a5.756 5.756 0 01-8.168 0 5.772 5.772 0 010-8.16l3.894-3.9a1.178 1.178 0 000-1.67 1.19 1.19 0 00-1.676 0l-3.894 3.89a8.146 8.146 0 1011.52 11.52l3.9-3.89a1.189 1.189 0 00-1.682-1.68z" fill="var(--sp-primary)" fill-rule="evenodd"/></svg>
		   	</div>
			
		<?php elseif ( $fiona_blog_post_format == 'image' ) : ?>
		
			<div class="post-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"><path d="M23.625 0H3.374A3.374 3.374 0 000 3.37v20.25A3.383 3.383 0 003.374 27h20.251A3.384 3.384 0 0027 23.62V3.37A3.375 3.375 0 0023.625 0zM3.191 2.04h20.617a1.152 1.152 0 011.146 1.15v8.12l-3.772-3.78a1.159 1.159 0 00-1.62 0l-8.066 8.07-2.913-2.91a1.141 1.141 0 00-1.62 0L2.046 17.6V3.19a1.151 1.151 0 011.145-1.15zm20.617 22.91H3.191a1.142 1.142 0 01-1.145-1.14v-2.97l5.727-5.72 6.635 6.63a1.135 1.135 0 001.62 0 1.146 1.146 0 000-1.62l-2.913-2.91 7.257-7.26 4.582 4.58v9.27a1.143 1.143 0 01-1.146 1.14zM9 6.75A2.251 2.251 0 116.75 4.5 2.252 2.252 0 019 6.75z" fill="var(--sp-primary)" fill-rule="evenodd"/></svg>
		   	</div>
			
		<?php elseif ( $fiona_blog_post_format == 'quote' ) : ?>
		
			<div class="post-icon">
		   		<svg xmlns="http://www.w3.org/2000/svg" width="36" height="26"><path d="M35.731 8.27A8.05 8.05 0 0027.655.26c-4.339 0-7.735 3.35-8.074 7.96a21.524 21.524 0 007.018 17.38.562.562 0 00.756-.01c.321-.28.54-.51 1.021-.99.366-.37.887-.9 1.729-1.73a.562.562 0 00.066-.72c-2.065-2.97-2.121-5.11-2.048-5.89a8.05 8.05 0 007.608-7.99zm-1.138 0a6.911 6.911 0 01-6.938 6.87.6.6 0 00-.511.31c-.208.39-.681 3.12 1.826 6.95-.656.65-1.089 1.09-1.406 1.41-.263.26-.441.44-.6.6a20.523 20.523 0 01-6.251-16.1c.295-4.01 3.212-6.92 6.939-6.92a6.92 6.92 0 016.941 6.88zm1.407 0a8.307 8.307 0 01-7.623 8.24A9.294 9.294 0 0030.392 22a.827.827 0 01-.1 1.06c-.78.77-1.285 1.28-1.646 1.64l-.081.09c-.467.47-.7.71-1.034 1a.865.865 0 01-1.112.01A21.784 21.784 0 0119.31 8.21c.349-4.76 3.857-8.22 8.342-8.22A8.326 8.326 0 0136 8.27zM27.174 25.4c.318-.29.535-.51 1.01-.99l.081-.08c.362-.37.867-.87 1.649-1.65a.3.3 0 00.035-.38c-2.117-3.04-2.17-5.26-2.094-6.07l.022-.23.231-.01A7.735 7.735 0 0027.655.53c-4.194 0-7.477 3.24-7.805 7.71a21.236 21.236 0 006.926 17.16.282.282 0 00.2.07.293.293 0 00.198-.07zm7.688-17.13a7.186 7.186 0 01-7.207 7.14.323.323 0 00-.273.17c-.178.33-.6 2.99 1.814 6.67l.118.18-.153.16c-.655.65-1.088 1.09-1.4 1.41-.265.26-.444.44-.6.6l-.187.18-.189-.18a20.8 20.8 0 01-6.333-16.31c.306-4.15 3.337-7.17 7.208-7.17a7.188 7.188 0 017.202 7.15zm-7.49 15.35c.292-.29.682-.69 1.255-1.26-2.441-3.83-1.974-6.56-1.722-7.03a.847.847 0 01.75-.45 6.61 6.61 0 100-13.22c-3.581 0-6.386 2.8-6.671 6.67a20.233 20.233 0 005.981 15.7c.113-.11.243-.24.407-.41zm-10.9-15.35A8.05 8.05 0 008.396.26C4.057.26.66 3.61.32 8.22A21.514 21.514 0 007.34 25.6a.562.562 0 00.756-.01c.321-.28.541-.51 1.023-.99.365-.37.886-.9 1.726-1.73a.562.562 0 00.066-.72c-2.067-2.97-2.121-5.11-2.047-5.89a8.05 8.05 0 007.607-7.99zm-1.138 0a6.911 6.911 0 01-6.938 6.87.6.6 0 00-.512.31c-.207.39-.68 3.12 1.827 6.95-.655.65-1.088 1.09-1.4 1.41-.264.26-.443.44-.6.6a20.533 20.533 0 01-6.253-16.1c.3-4.01 3.215-6.92 6.941-6.92a6.92 6.92 0 016.934 6.88zm1.407 0a8.308 8.308 0 01-7.624 8.24A9.275 9.275 0 0011.133 22a.828.828 0 01-.1 1.06c-.793.78-1.3 1.3-1.662 1.66l-.062.06c-.469.48-.7.72-1.035 1.01a.866.866 0 01-1.113.01A21.788 21.788 0 01.05 8.21C.4 3.45 3.909-.01 8.394-.01a8.326 8.326 0 018.346 8.28zM7.914 25.4c.319-.29.536-.51 1.013-.99l.062-.06c.362-.37.871-.88 1.666-1.67a.3.3 0 00.034-.38c-2.118-3.05-2.17-5.26-2.094-6.07l.022-.23.231-.01A7.735 7.735 0 008.396.53C4.202.53.918 3.77.589 8.24A21.243 21.243 0 007.517 25.4a.282.282 0 00.2.07.289.289 0 00.196-.07zm7.689-17.13a7.186 7.186 0 01-7.207 7.14.324.324 0 00-.274.17c-.178.33-.6 2.99 1.814 6.67l.119.18-.154.16c-.654.65-1.086 1.08-1.4 1.4l-.027.03c-.25.25-.423.43-.575.58l-.187.18-.188-.18A20.8 20.8 0 011.188 8.29c.307-4.15 3.338-7.17 7.21-7.17A7.188 7.188 0 0115.6 8.27zm-13.88.06a20.24 20.24 0 005.983 15.7c.107-.11.23-.23.382-.38l.027-.03c.291-.29.681-.69 1.252-1.26-2.441-3.83-1.974-6.56-1.722-7.03a.849.849 0 01.751-.45 6.61 6.61 0 100-13.22c-3.581 0-6.387 2.8-6.673 6.67z" fill="var(--sp-primary)" fill-rule="evenodd"/></svg>
		   	</div>
			
		<?php elseif ( $fiona_blog_post_format == 'video' ) : ?>
		
			<div class="post-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="37" height="21"><path d="M19.787 21H4.663A4.61 4.61 0 010 16.46V4.54A4.6 4.6 0 014.663 0h15.124a4.6 4.6 0 014.664 4.54v11.92A4.61 4.61 0 0119.787 21zM4.663 2.02a2.558 2.558 0 00-2.59 2.52v11.92a2.558 2.558 0 002.59 2.52h15.124a2.558 2.558 0 002.59-2.52V4.54a2.558 2.558 0 00-2.59-2.52H4.663zm29.134 17.07a3.3 3.3 0 01-1.622-.43l-6.207-3.47V5.82l6.176-3.47a2.959 2.959 0 01.93-.37 3.317 3.317 0 012.711.61A3.078 3.078 0 0137 5.02v10.93a3.1 3.1 0 01-.421 1.55 3.233 3.233 0 01-2.779 1.59zm-5.755-5.07l5.173 2.89a1.136 1.136 0 001.563-.41 1.123 1.123 0 00.148-.55V5.02a1.069 1.069 0 00-.433-.85 1.166 1.166 0 00-.981-.21l-.062.01a.734.734 0 00-.254.12l-5.154 2.9v7.03z" fill="var(--sp-primary)" fill-rule="evenodd"/></svg>
		   	</div>
			
		<?php elseif ( $fiona_blog_post_format == 'audio' ) : ?>
		
			<div class="post-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="31" height="25"><path d="M16.018.22L5.525 6.69h-2.2a3.364 3.364 0 00-3.33 3.39v4.84a3.362 3.362 0 003.33 3.38h1.78l10.932 6.48a1.51 1.51 0 002.277-1.32V1.54A1.517 1.517 0 0016.018.22zm-14.2 14.7v-4.84a1.528 1.528 0 011.513-1.54h1.33v7.91h-1.33a1.526 1.526 0 01-1.515-1.53zm14.685 8L6.477 16.98V8.27l10.026-6.19v20.84zm4.661-6.62a.925.925 0 000 1.85 5.656 5.656 0 000-11.31.925.925 0 000 1.85 3.805 3.805 0 01-.002 7.61zm0-13.79a.92.92 0 000 1.84 8.146 8.146 0 010 16.29.92.92 0 000 1.84 9.986 9.986 0 000-19.97z" fill="var(--sp-primary)" fill-rule="evenodd"/></svg>
		   	</div>
			
		<?php elseif ( $fiona_blog_post_format == 'status' ) : ?>
		
			<div class="post-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"><path d="M19.351 0l-.621.62a4.4 4.4 0 00-.648 5.39l-6.287 4.24-.109-.1a6.157 6.157 0 00-8.7 0l-.621.62 7.81 7.81L0 28.75 1.243 30l10.175-10.18 7.81 7.81.622-.62a6.16 6.16 0 000-8.7l-.109-.11 4.248-6.29a4.4 4.4 0 005.39-.64l.622-.63zm-.187 25.08L4.912 10.83a4.4 4.4 0 015.531.56l8.163 8.16a4.4 4.4 0 01.558 5.53zm-.69-8.15l-5.413-5.41 6.182-4.18 3.407 3.41zm5.932-6.91l-4.433-4.43a2.64 2.64 0 01-.515-3l7.949 7.95a2.655 2.655 0 01-3.001-.52z" fill="var(--sp-primary)" fill-rule="evenodd"/></svg>
			</div>
			
		<?php elseif ( $fiona_blog_post_format == 'chat' ) : ?>
		
			<div class="post-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"><path d="M26.569 1.42a4.863 4.863 0 00-6.889 0L2.921 18.19a1.317 1.317 0 00-.307.49L.069 26.32a1.271 1.271 0 00.806 1.61 1.362 1.362 0 00.4.07 1.38 1.38 0 00.4-.07l7.634-2.54a1.365 1.365 0 00.5-.31l16.76-16.77a4.873 4.873 0 000-6.89zm-1.8 5.09L8.228 23.06l-4.942 1.65 1.646-4.94L21.478 3.23a2.324 2.324 0 113.292 3.28z" fill="var(--sp-primary)" fill-rule="evenodd"/></svg>
		   	</div>
			
		<?php elseif ( $fiona_blog_post_format == 'standard' ) : ?>
		
			<div class="post-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="29" height="27"><path d="M8.847 11.66h-3.02a.92.92 0 010-1.84h3.02a.92.92 0 010 1.84zm14.5 0h-9.062a.92.92 0 010-1.84h9.062a.92.92 0 01.001 1.84zm-14.5 4.91h-3.02a.925.925 0 010-1.85h3.02a.925.925 0 010 1.85zm14.5 0h-9.062a.925.925 0 010-1.85h9.062a.925.925 0 01.001 1.85zm-14.5 4.9h-3.02a.92.92 0 010-1.84h3.02a.92.92 0 010 1.84zm14.5 0h-9.062a.92.92 0 010-1.84h9.062a.92.92 0 01.001 1.84zM25.676 27H3.321a3.357 3.357 0 01-3.322-3.38V3.37A3.348 3.348 0 013.321 0h22.356A3.349 3.349 0 0129 3.37v20.25A3.358 3.358 0 0125.677 27zM3.32 1.84a1.525 1.525 0 00-1.51 1.53v20.25a1.527 1.527 0 001.51 1.54h22.356a1.527 1.527 0 001.51-1.54V3.37a1.525 1.525 0 00-1.51-1.53H3.321zm24.772 4.29H.905a.92.92 0 010-1.84h27.188a.92.92 0 010 1.84z" fill="var(--sp-primary)" fill-rule="evenodd"/></svg>
		   	</div>
			
		<?php endif;
    }
endif;


/**
 * Fiona post-format Image Video
 */
if (!function_exists('fiona_blog_post_format_img_video')):
    function fiona_blog_post_format_img_video()
    {
        $fiona_blog_post_format = get_post_format() ? : 'standard';

        if ( $fiona_blog_post_format == 'video' || $fiona_blog_post_format == 'audio' ) : 
			$media = get_media_embedded_in_content( 
						apply_filters( 'the_content', get_the_content() )
					);
			//echo print_r($media);
			if(!empty($media)):
				echo $media['0'];
			endif;	

		elseif ( $fiona_blog_post_format == 'gallery' ) :
			
			global $post;
			//echo $posts->images = get_post_gallery( );
		 	if (has_block('gallery', $post->post_content)) {
			  //echo 'yes, there is a gallery';
			  $post_blocks = parse_blocks($post->post_content);
			  foreach ($post_blocks as $post_block){
				if ($post_block['blockName'] == 'core/gallery'){
				  echo do_shortcode( $post_block['innerHTML'] );
				}
			  }
			}
			// if there is not a gallery block do this
			else {
				echo 'no gallery';
			}
	
				
		 else : 
				the_post_thumbnail();
		 endif;
    }
endif;
add_action( 'fiona_blog_post_format_img_video', 'fiona_blog_post_format_img_video' );



/**
 * Fiona post-format Image Video content
 */
if (!function_exists('fiona_blog_post_format_img_video_content')):
    function fiona_blog_post_format_img_video_content()
    {
        $fiona_blog_post_format = get_post_format() ? : 'standard';

        if ( $fiona_blog_post_format == 'video' || $fiona_blog_post_format == 'audio' || $fiona_blog_post_format == 'gallery' ) :
			the_excerpt();
			//echo"video";
		elseif ( $fiona_blog_post_format == 'quote' ) :
			?>
			<blockquote>
			<?php
			the_excerpt();
			?>
			</blockquote>
			<?php

		elseif ( $fiona_blog_post_format == 'link' ) :
			?>
			<div class="post-linking">
			<?php
				the_excerpt();
			?>
			</div>
			<?php

		else : 
		 
			the_content(
				sprintf( 
					__( 'Read More', 'fiona-blog' ), 
					'<span class="screen-reader-text">  '.esc_html(get_the_title()).'</span>' 
				)
			);
			
		 endif;
    }
endif;
add_action( 'fiona_blog_post_format_img_video_content', 'fiona_blog_post_format_img_video_content' );



/**
 * Fiona Dynamic Style
 */
 
 if( ! function_exists( 'fiona_blog_dynamic_style' ) ):
    function fiona_blog_dynamic_style() {

		$output_css = '';
		
		 /**
		 *  Breadcrumb Style
		 */
		 
		$breadcrumb_min_height			= get_theme_mod('breadcrumb_min_height','236');	
		
		if($breadcrumb_min_height !== '') { 
				$output_css .=".breadcrumb-content {
					min-height: " .esc_attr($breadcrumb_min_height). "px;
				}\n";
			}
		
		$breadcrumb_bg_img			= get_theme_mod('breadcrumb_bg_img',esc_url(get_template_directory_uri() .'/assets/images/bg/breadcrumbg.jpg')); 
		$breadcrumb_back_attach		= get_theme_mod('breadcrumb_back_attach','scroll'); 

		if($breadcrumb_bg_img !== '') { 
			$output_css .=".breadcrumb-area {
					background-image: url(" .esc_url($breadcrumb_bg_img). ");
					background-attachment: " .esc_attr($breadcrumb_back_attach). ";
				}\n";
		}
		
        wp_add_inline_style( 'fiona-blog-style', $output_css );
    }
endif;
add_action( 'wp_enqueue_scripts', 'fiona_blog_dynamic_style' );



/**
 * This Function Check whether Sidebar active or Not
 */
if(!function_exists( 'fiona_blog_post_layout' )) :
function fiona_blog_post_layout(){
	if(is_active_sidebar('fiona-blog-sidebar-primary'))
		{ echo 'av-column-8'; } 
	else 
		{ echo 'av-column-12'; }  
} endif;