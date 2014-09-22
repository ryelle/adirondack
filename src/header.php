<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Adirondack
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'adirondack' ); ?></a>

<?php get_sidebar(); ?>

<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle"><?php _ex( 'Menu', 'primary menu label', 'adirondack' ); ?></button>
			<div class="small-widgets-toggle widgets-toggle"><button class="dashicons-before dashicons-menu"><span class="screen-reader-text"><?php _e( 'Show Widgets', 'adirondack' ); ?></span></button></div>
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li class="widgets-toggle"><button class="dashicons-before dashicons-menu"><span class="screen-reader-text">' . __( 'Show Widgets', 'adirondack' ) . '</span></button></li></ul>'
			) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
