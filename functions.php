<?php

// Theme Assets
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {
	wp_enqueue_style( 'coostr-bootstrap-css', get_stylesheet_directory_uri() . '/inc/css/bootstrap.min.css', false, '3.3.1' );
	wp_enqueue_style( 'coostr-font-awesome', get_stylesheet_directory_uri() . '/inc/css/font-awesome.min.css', false, '4.2.0' );
	wp_enqueue_style( 'coostr-lightbox', get_stylesheet_directory_uri() . '/inc/css/lightbox.css', false, '4.2.0' );
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'coostr-bootstrap-js', get_stylesheet_directory_uri() . '/inc/js/bootstrap.min.js', false, '3.3.1' );
	wp_enqueue_script( 'lightbox-js', get_stylesheet_directory_uri() . '/inc/js/lightbox.min.js', false, '3.3.1' );
	wp_enqueue_script( 'coostr-global-js', get_stylesheet_directory_uri() . '/inc/js/coostr.global.js', false, '3.3.1' );
}

// Add logo support
add_action( 'customize_register', 'coostr_customize_register' );

function coostr_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	$wp_customize->add_section( 'kickstarter' , array(
        'title'      => __( 'Kickstarter', 'coostr' ),
        'priority'   => 100,
    ) );
	
	$wp_customize->add_setting( 'coostr_logo' ); // Add setting for logo uploader

	// Add control for logo uploader (actual uploader)
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'coostr_logo', array(
		'label'    => __( 'Upload Header Logo', 'esc' ),
		'section'  => 'title_tagline',
		'settings' => 'coostr_logo',
	) ) );

}

function storefront_site_branding() {

	echo '<div class="site-branding">';

	if ( get_theme_mod( 'coostr_logo' ) ) { ?>
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php echo esc_url( get_theme_mod( 'coostr_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
			</a>
		</h1>
	<?php } else { ?>
		<div class="site-branding">
			<h1 class="site-title"><?php bloginfo( 'name' ); ?></a></h1>
			<?php if ( '' != get_bloginfo( 'description' ) ) { ?>
				<p class="site-description"><?php echo bloginfo( 'description' ); ?></p>
			<?php } ?>
		</div>
	<?php }
	
	echo '</div>';
	
}

function storefront_page_header() {
	?>
	<header class="entry-header">
		<?php
		if(is_single('product') || is_page('cart') || is_shop()) {
			the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' );
		}
		?>
	</header><!-- .entry-header -->
	<?php
}

function storefront_page_content() {
	?>
	<div class="entry-content" itemprop="mainContentOfPage">

		<?php if(is_page('home')) {
			get_template_part('content', 'home');
		} else if(is_page('about')) {
			get_template_part('content', 'about');
		} else if(is_page('gallery')) {
			get_template_part('content', 'gallery');
		} else if(is_page('contact')) {
			get_template_part('content', 'contact');
		} else {
			the_content();
		} ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php
}

// Remove Breadcrumbs

add_action( 'init', 'coostr_remove_breadcrumbs' );

function coostr_remove_breadcrumbs() {
	remove_action( 'storefront_content_top', 'woocommerce_breadcrumb', 	10 );
}

?>