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
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'adirondack_load_svg' ); ?>

<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'adirondack' ); ?></a>

<?php get_sidebar(); ?>

<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		</div>

		<div class="nav-container">
		<?php $button = '';
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$button = '<button><svg class="ellipsis"><use xlink:href="#icon-ellipsis" /></svg><svg class="x"><use xlink:href="#icon-x" /></svg></button>';
		}
		?>
		<nav id="site-navigation" class="main-navigation <?php echo $button? 'has-widgets': 'no-widgets'; ?>" role="navigation">
			<button class="menu-toggle"><?php _ex( 'Menu', 'primary menu label', 'adirondack' ); ?></button>
			<div class="small-widgets-toggle widgets-toggle"><?php echo $button; ?></div>
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li class="widgets-toggle">' . $button . '</li></ul>'
			) ); ?>
		</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
