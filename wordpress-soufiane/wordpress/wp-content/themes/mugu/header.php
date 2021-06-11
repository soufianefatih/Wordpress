<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mugu
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head itemscope itemtype="http://schema.org/WebSite">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content (Press Enter)', 'mugu' ); ?></a>
	<?php
	/**
	 * Mugu Header
	 *
	 * @see mugu_dynamic_header
	 */
	do_action( 'mugu_header' );

	/**
     * Header AD
     * 
    */
    do_action( 'mugu_header_ad' );
    $ed_featured_section = get_theme_mod( 'mugu_ed_featured_section' );
	if( ( is_front_page() || is_page_template('template-home.php') ) && $ed_featured_section  ){
		/**
		 * Home page featured layout two
		 *
		 * @see mugu_featured_before_content
		 */
		do_action( 'mugu_home_page_before_content' );
	}
	?>
    
    <div class="container">	
		<?php
			
			if( is_home() || is_archive() || is_category() ) echo '<div class = "post-section">';
		           
            if ( ! ( is_front_page() || is_page_template( 'template-home.php') ) ){ 
				do_action('mugu_header_layout');
			} 
			if ( ! ( is_front_page() || is_page_template( 'template-home.php') ) ) echo '<div class = "row">'; 
        ?>	
	   <div id="content" class="site-content">    
