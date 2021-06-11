<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package mugu
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mugu_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }
    
    if( !( is_active_sidebar( 'right-sidebar' ) ) ) {
        $classes[] = 'full-width'; 
    }
    
    if( is_page() ){
        $sidebar_layout = mugu_sidebar_layout();
        if( $sidebar_layout == 'no-sidebar' )
        $classes[] = 'full-width';
    }

    // return the $classes array
	return $classes;
}
add_filter( 'body_class', 'mugu_body_classes' );

if( ! function_exists( 'mugu_fonts_url' ) ) :
/**
 * Register custom fonts.
 */
function mugu_fonts_url() {
    $fonts_url = '';

    /*
    * translators: If there are characters in your language that are not supported
    * by Oxygen, translate this to 'off'. Do not translate into your own language.
    */
    $oxygen = _x( 'on', 'Oxygen font: on or off', 'mugu' );
    
    /*
    * translators: If there are characters in your language that are not supported
    * by PT Serif, translate this to 'off'. Do not translate into your own language.
    */
    $pt_serif = _x( 'on', 'PT Serif font: on or off', 'mugu' );

    if ( 'off' !== $oxygen || 'off' !== $pt_serif ) {
        $font_families = array();

        if( 'off' !== $oxygen ){
            $font_families[] = 'Oxygen:300,400,700';
        }

        if( 'off' !== $pt_serif ){
            $font_families[] = 'PT Serif';
        }

        $query_args = array(
            'family'  => urlencode( implode( '|', $font_families ) ),
            'display' => urlencode( 'fallback' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url( $fonts_url );
}
endif;

if( ! function_exists( 'mugu_header_site_brand' ) ) :
/**
 * Site Brand
*/
function mugu_header_site_brand(){ ?>
    <div class="site-branding" itemscope itemtype="http://schema.org/Organization">
            <?php
                if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                    the_custom_logo();
                } 
            ?>
            <div class="text-logo">  
                <?php if ( is_front_page() ) : ?>
                    <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                    <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                <?php endif;
                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) : ?>
                        <p class="site-description" itemprop="description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
                <?php
                    endif; 
                ?>
            </div> 
        </div><!-- .site-branding -->
        <?php
}
endif;
add_action('mugu_header_logo','mugu_header_site_brand');

if( ! function_exists( 'mugu_dynamic_header' ) ) :
/**
 * Dynamic Header 
*/
function mugu_dynamic_header(){    
    $header_array = array( 'one', 'two' );
    $header = get_theme_mod( 'mugu_header_layout', 'one' );
    if( in_array( $header, $header_array ) ){            
        get_template_part( 'header/' . $header );
    }
}
endif;
add_action( 'mugu_header', 'mugu_dynamic_header' );

/**
 * Mugu Header Layout 
**/
function mugu_header_layout_cb(){ ?>
    <div class="top-bar">
        <div class="page-header">
            <?php 
                if( is_page() ){ 
                    the_title( '<h1 class="page-title">', '</h1>' ); 
                }elseif( is_search() ){ ?>
                    <h1 class="page-title"><?php esc_html_e( 'Search Results', 'mugu' ); ?></h1>
          <?php }elseif( is_home() ) {?>
                <h1 class="page-title"><?php esc_html_e( 'Blogs', 'mugu' ); ?></h1>
          <?php }elseif( is_404() ) {?>
                <h1 class="page-title"><?php esc_html_e( 'Page Not Found', 'mugu' ); ?></h1>
          <?php }elseif( is_archive() ){ ?>
                <header class="page-header">
                <?php
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
                ?>
                </header><!-- .page-header -->
          <?php } ?>
        </div>

       <?php
        /**
        * Header Beadcrumb
        */
          do_action('mugu_breadcrumbs');
        ?>
      </div>
<?php }
add_action('mugu_header_layout','mugu_header_layout_cb');

if( ! function_exists( 'mugu_social_cb' ) ) :
/**
 * Mugu Header Layout 
**/
function mugu_social_cb(){ 
$social    = get_theme_mod( 'mugu_ed_social' );
$facebook  = get_theme_mod( 'mugu_facebook' );
$twitter   = get_theme_mod( 'mugu_twitter' );
$pinterest = get_theme_mod( 'mugu_pinterest' );
$linkedin  = get_theme_mod( 'mugu_linkedin' );
$instagram = get_theme_mod( 'mugu_instagram' );
$youtube   = get_theme_mod( 'mugu_youtube' );


if( $social && ( $facebook || $twitter || $pinterest || $linkedin || $instagram || $youtube ) ) {
    echo '<ul class="social-networks">'; 
        if( $facebook ) echo'<li><a href  ="' . esc_url( $facebook ) . '" title="facebook"><i class="fa fa-facebook"></i></a></li>';
        if( $twitter ) echo'<li><a href   ="' . esc_url( $twitter ) . '" title="twitter"><i class="fa fa-twitter"></i></a></li>';
        if( $pinterest ) echo'<li><a href ="' . esc_url( $pinterest ) . '" title="pinterest"><i class="fa fa-pinterest-p"></i></a></li>';
        if( $linkedin ) echo'<li><a href  ="' . esc_url( $linkedin ) . '"  title="linkedin"><i class="fa fa-linkedin"></i></a></li>';
        if( $instagram ) echo'<li><a href ="' . esc_url( $instagram ) . '" title="instagram"><i class="fa fa-instagram"></i></a></li>';
        if( $youtube ) echo'<li><a href   ="' . esc_url( $youtube ) . '" title="youtube"><i class="fa fa-youtube"></i></a></li>';
    echo '</ul>';
    }
}
endif;
add_action( 'mugu_social_link','mugu_social_cb' );
  
/**
 * Custom Bread Crumb
 *
 * @link http://www.qualitytuts.com/wordpress-custom-breadcrumbs-without-plugin/
 */ 
function mugu_breadcrumbs_cb() {    
    global $post;
    
    $post_page   = get_option( 'page_for_posts' ); //The ID of the page that displays posts.
    $show_front  = get_option( 'show_on_front' ); //What to show on the front page
    $showCurrent = get_theme_mod( 'mugu_ed_current', '1' ); // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $delimiter   = get_theme_mod( 'mugu_breadcrumb_separator', __( '>', 'mugu' ) ); // delimiter between crumbs
    $home        = get_theme_mod( 'mugu_breadcrumb_home_text', __( 'Home', 'mugu' ) ); // text for the 'Home' link
    $before      = '<span class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'; // tag before the current crumb
    $after       = '</span>'; // tag after the current crumb
    $mugu_ed_breadcrumb = get_theme_mod('mugu_ed_breadcrumb');
    $depth = 1;    

    if( $mugu_ed_breadcrumb ){
      echo '<div id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( home_url() ) . '" class="home_crumb"><span itemprop="name">' . esc_html( $home ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
          if( is_home() && ! is_front_page() ){            
              $depth = 2;
              if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( single_post_title( '', false ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;          
          }elseif( is_category() ){            
              $depth = 2;
              $thisCat = get_category( get_query_var( 'cat' ), false );
              if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                  $p = get_post( $post_page );
                  echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( $post_page ) ) . '"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                  $depth ++;  
              }

              if ( $thisCat->parent != 0 ) {
                  $parent_categories = get_category_parents( $thisCat->parent, false, ',' );
                  $parent_categories = explode( ',', $parent_categories );

                  foreach ( $parent_categories as $parent_term ) {
                      $parent_obj = get_term_by( 'name', $parent_term, 'category' );
                      if( is_object( $parent_obj ) ){
                          $term_url    = get_term_link( $parent_obj->term_id );
                          $term_name   = $parent_obj->name;
                          echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                          $depth ++;
                      }
                  }
              }

              if( $showCurrent ) echo $before . '<span itemprop="name">' .  esc_html( single_cat_title( '', false ) ) . '</span><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;

          }elseif( is_tag() ){            
              $queried_object = get_queried_object();
              $depth = 2;

              if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( single_tag_title( '', false ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;    
          }elseif( is_author() ){            
              $depth = 2;
              global $author;
              $userdata = get_userdata( $author );
              if( $showCurrent ) echo $before . '<span itemprop="name">' . esc_html( $userdata->display_name ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;  
          }elseif( is_day() ){            
              $depth = 2;
              echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'mugu' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'mugu' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
              $depth ++;
              echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'mugu' ) ), get_the_time( __( 'm', 'mugu' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'mugu' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
              $depth ++;
              if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_time( __( 'd', 'mugu' ) ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
               
          }elseif( is_month() ){            
              $depth = 2;
              echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'mugu' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'mugu' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
              $depth++;
              if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_time( __( 'F', 'mugu' ) ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;      
          }elseif( is_year() ){            
              $depth = 2;
              if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_time( __( 'Y', 'mugu' ) ) ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after; 
          }elseif( is_single() && !is_attachment() ) {
            //For Post                
            $cat_object       = get_the_category();
            $potential_parent = 0;
            $depth            = 2;
            
            if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                $p = get_post( $post_page );
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';  
                $depth++;
            }
            
            if( is_array( $cat_object ) ){ //Getting category hierarchy if any
    
                //Now try to find the deepest term of those that we know of
                $use_term = key( $cat_object );
                foreach( $cat_object as $key => $object ){
                    //Can't use the next($cat_object) trick since order is unknown
                    if( $object->parent > 0  && ( $potential_parent === 0 || $object->parent === $potential_parent ) ){
                        $use_term = $key;
                        $potential_parent = $object->term_id;
                    }
                }
                
                $cat = $cat_object[$use_term];
          
                $cats = get_category_parents( $cat, false, ',' );
                $cats = explode( ',', $cats );

                foreach ( $cats as $cat ) {
                    $cat_obj = get_term_by( 'name', $cat, 'category' );
                    if( is_object( $cat_obj ) ){
                        $term_url    = get_term_link( $cat_obj->term_id );
                        $term_name   = $cat_obj->name;
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                        $depth ++;
                    }
                }
            }

            if ( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;      
          }elseif( is_page() ){            
              $depth = 2;
              if( $post->post_parent ){            
                  global $post;
                  $depth = 2;
                  $parent_id  = $post->post_parent;
                  $breadcrumbs = array();
                  
                  while( $parent_id ){
                      $current_page  = get_post( $parent_id );
                      $breadcrumbs[] = $current_page->ID;
                      $parent_id     = $current_page->post_parent;
                  }
                  $breadcrumbs = array_reverse( $breadcrumbs );
                  for ( $i = 0; $i < count( $breadcrumbs); $i++ ){
                      echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $breadcrumbs[$i] ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $breadcrumbs[$i] ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /></span>';
                      if ( $i != count( $breadcrumbs ) - 1 ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ';
                      $depth++;
                  }

                  if ( $showCurrent ) echo ' <span class="separator">' . esc_html( $delimiter ) . '</span> ' . $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" /></span>'. $after;      
              }else{
                  if ( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html( get_the_title() ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after; 
              }
          }elseif( is_search() ){            
              $depth = 2;
              if( $showCurrent ) echo $before .'<span itemprop="name">'. esc_html__( 'Search Results for "', 'mugu' ) . esc_html( get_search_query() ) . esc_html__( '"', 'mugu' ) .'</span><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;      
          }elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {            
              $depth = 2;
              $post_type = get_post_type_object(get_post_type());
              if( get_query_var('paged') ){
                  echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />';
                  echo ' <span class="separator">' . $delimiter . '</span></span> ' . $before . sprintf( __('Page %s', 'mugu'), get_query_var('paged') ) . $after;
              }elseif( is_archive() ){
                  echo $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( $post_type->label ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
              }else{
                  echo $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( $post_type->label ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
              }              
          }elseif( is_attachment() ){            
              $depth  = 2;
              $parent = get_post( $post->post_parent );
              $cat    = get_the_category( $parent->ID );
              if( $cat ){
                  $cat = $cat[0];
                  echo get_category_parents( $cat, TRUE, ' <span class="separator">' . $delimiter . '</span> ');
                  echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $parent ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $parent->post_title ) . '<span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . ' <span class="separator">' . $delimiter . '</span></span>';
              }
              if( $showCurrent ) echo $before .'<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;   
          }elseif ( is_404() ){
              if( $showCurrent ) echo $before . esc_html__( '404 Error - Page not Found', 'mugu' ) . $after;
          }
          if( get_query_var('paged') ) echo __( ' (Page', 'mugu' ) . ' ' . get_query_var('paged') . __( ')', 'mugu' );        
          echo '</div>';
    }
}  // end mugu_breadcrumbs()
add_action( 'mugu_breadcrumbs', 'mugu_breadcrumbs_cb' );

if( ! function_exists( 'mugu_header_ad' ) ) :
/**
 * Header AD
*/
function mugu_header_ad(){
    $ed_header_ad = get_theme_mod( 'mugu_ed_header_ad' ); //from customizer
    $ad_img       = get_theme_mod( 'mugu_header_ad' ); //from customizer
    $ad_link      = get_theme_mod( 'mugu_header_ad_link' ); //from customizer
    $ad_image     = wp_get_attachment_image_src( $ad_img, 'full' );
    $target       = get_theme_mod( 'mugu_open_link_diff_tab', '1' ) ? 'target="_blank"' : '';
    
    if( $ed_header_ad && $ad_img ){ ?>
    <div class="advertise">
        <?php if( $ad_link ) echo '<a href="' . esc_url( $ad_link ) . '" ' . $target . '>'; ?>
            <img src="<?php echo esc_url( $ad_image[0] ); ?>"  />
        <?php if( $ad_link ) echo '</a>'; ?>        
    </div>
    <?php
    }
}
endif;
add_action( 'mugu_header_ad', 'mugu_header_ad' );

if( ! function_exists( 'mugu_featured_before_content' ) ) :
/**
 * Featured Content  
*/
function mugu_featured_before_content(){    
    $ed_featured_section = get_theme_mod( 'mugu_ed_featured_section' );
    $featured_section_layout = get_theme_mod( 'mugu_featured_post_layout', 'one' );
    $featured_post_one   = get_theme_mod( 'mugu_featured_post_one' );
    $featured_post_two   = get_theme_mod( 'mugu_featured_post_two' );
    $featured_post_three = get_theme_mod( 'mugu_featured_post_three' );
    $featured_post_four  = get_theme_mod( 'mugu_featured_post_four' );
    $featured_post_five  = get_theme_mod( 'mugu_featured_post_five' );
    $featured_post_six   = get_theme_mod( 'mugu_featured_post_six' );
    $featured_post_seven = get_theme_mod( 'mugu_featured_post_seven' );
    
    if( ( $featured_section_layout == 'two' ) && $ed_featured_section ){
        echo '<div class="featured-post layout-2">';
        echo '<div class="col">';
            mugu_featured_post_query( $featured_post_one, 'mugu-featured-second-one' );
            mugu_featured_post_query( $featured_post_two, 'mugu-featured-second-one' );
        echo '</div>';
        echo '<div class="col large">';
            mugu_featured_post_query( $featured_post_three, 'mugu-featured-second-two' );
        echo '</div>'; 
        echo '<div class="col">';
            mugu_featured_post_query( $featured_post_four, 'mugu-featured-second-one' );
            mugu_featured_post_query( $featured_post_five, 'mugu-featured-second-one' );
        echo '</div>'; 
        echo '<div class="col">';
            mugu_featured_post_query( $featured_post_six, 'mugu-featured-second-one' );
            mugu_featured_post_query( $featured_post_seven, 'mugu-featured-second-one' );
        echo '</div>';  
        echo '</div>'; 
    }
}
endif;
add_action( 'mugu_home_page_before_content', 'mugu_featured_before_content', 10 );

function mugu_featured_post_query( $featured_post, $img_size){

    $featured_qry = new WP_Query( array( 
            'p' => $featured_post,
        ) );
        
    if( $featured_qry->have_posts() ){ 
    
        while( $featured_qry->have_posts() ){
            $featured_qry->the_post();
        
            if( $featured_post == true ){ ?>
                <div class="post">
                    <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                        <?php 
                        if ( has_post_thumbnail() ) {
                        the_post_thumbnail( esc_attr( $img_size ), array( 'itemprop' => 'image' ) );
                        }else{
                        mugu_get_fallback_svg( $img_size );
                        } ?>
                    </a>
                    <div class="text-holder">                
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
                        <span class="byline"><a href="<?php the_permalink(); ?>"><?php the_author(); ?></a></span>
                    </div>
                </div>             
                <?php                
            }        
        }
        wp_reset_postdata(); 
    }  
}

if( ! function_exists( 'mugu_featured_content' ) ) :
/**
 * Featured Content  
*/
function mugu_featured_content(){    
    $ed_featured_section     = get_theme_mod( 'mugu_ed_featured_section' );
    $featured_section_layout = get_theme_mod( 'mugu_featured_post_layout', 'one' );
    $featured_post_one       = get_theme_mod( 'mugu_featured_post_one' );
    $featured_post_two       = get_theme_mod( 'mugu_featured_post_two' );
    $featured_post_three     = get_theme_mod( 'mugu_featured_post_three' );
    $featured_post_four      = get_theme_mod( 'mugu_featured_post_four' );
  
    $featured_posts = array( $featured_post_one, $featured_post_two, $featured_post_three, $featured_post_four );
    $featured_posts = array_diff( array_unique( $featured_posts ), array('') );
    
    $x        = 0; 
    $class    = '';
    $img_size = '';
    
    if( ( $featured_section_layout == 'one' ) && $ed_featured_section && $featured_posts ){
     
        $featured_qry = new WP_Query( array( 
            'post_type'             => 'post',
            'posts_per_page'        => -1,
            'post__in'              => $featured_posts,
            'orderby'               => 'post__in',
            'ignore_sticky_posts'   => true 
        ) );
        
        if( $featured_qry->have_posts() ){ ?>
        
        <div class="featured-post layout-1">
       
        <?php
        while( $featured_qry->have_posts() ){
            $featured_qry->the_post();
            
            if( has_post_thumbnail() ){
                if($x == 0){
                    $class = '';
                    $img_size = 'mugu-featured-one';
                }elseif($x == 1){
                    $class = ' medium';
                    $img_size = 'mugu-featured-two';                  
                }else{
                    $class = ' small';
                    $img_size = 'mugu-featured-three';                    
                }
                ?>
                <div class="post<?php echo esc_attr( $class ); ?>">
                    <a href="<?php the_permalink(); ?>" class="post-thumbnail"><?php the_post_thumbnail( $img_size, array( 'itemprop' => 'image' ) ); ?></a>
                    <div class="text-holder">                
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
                        <span class="byline"><a href="<?php the_permalink(); ?>"><?php the_author(); ?></a></span>
                    </div>
                </div>             
                <?php
                $x++;
            }
        }
        wp_reset_postdata(); 
        ?>
        </div>
        <?php
        }     
    }
}
endif;
add_action( 'mugu_home_page', 'mugu_featured_content', 10 );

if( ! function_exists( 'mugu_post_wrapper_start' ) ) :
/**
 * Popular and Category post start
*/
function mugu_post_wrapper_start(){
    echo '<div class="post-section">';
} 
endif;
add_action( 'mugu_home_page', 'mugu_post_wrapper_start', 20 );

if( ! function_exists( 'mugu_latest_popular_posts' ) ) :
/**
 * Latest & Popular Posts
*/
function mugu_latest_popular_posts(){
    
    $ed_latest_popular       = get_theme_mod( 'mugu_ed_blog_section' );
    $mugu_button_one_label   = get_theme_mod( 'mugu_button_one_label', __('Latest', 'mugu') ); 
    $mugu_button_two_label   = get_theme_mod( 'mugu_button_two_label', __('Popular', 'mugu') );
    
    if( $ed_latest_popular ){
        
        if( $mugu_button_one_label && $mugu_button_two_label ){ ?>
            <ul class="tabs-menu">
                <li class="current">
                    <button class="tab-btn" id="latest-post"><?php echo esc_html( $mugu_button_one_label); ?></button>
                </li>
                <li>
                    <button class="tab-btn" id="most-popular"><?php echo esc_html( $mugu_button_two_label); ?></button>
                </li>
            </ul>
    	<?php 
        } 
        
        $mugu_qry = new WP_Query( array( 
            'post_type'           => 'post', 
            'post_status'         => 'publish',
            'posts_per_page'      => 6,             
            'ignore_sticky_posts' => true,            
        ) );

        if( $mugu_qry->have_posts() ){ ?>

            <div class="article-holder row">

            <?php while( $mugu_qry->have_posts() ){ 
                $mugu_qry->the_post(); ?>
                
                <article class="post">
			
                    <a href="<?php the_permalink();?>" class="post-thumbnail">
                      <?php 
                      if( has_post_thumbnail() ){ 
                        the_post_thumbnail( 'mugu-blog-post', array( 'itemprop' => 'image' ) );
                      }else{
                        mugu_get_fallback_svg( 'mugu-blog-post' );
                      } ?>
                    </a>
    					
                    <div class="text-holder">    				
                        <?php 
                             mugu_category_list(); 
                             the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
                             echo '<div class="entry-meta">';
                             mugu_posted_on(); 
                             echo '</div>';
                             the_excerpt();
                             echo '<a href="'. esc_url( get_the_permalink() ) . '" class="readmore">'.  esc_html__( 'Read More', 'mugu' ) . '</a>' ; 
                        ?>
                        
    		            </div>
                    
		            </article>
		        <?php }
                wp_reset_postdata();
                ?>
            </div>
            <div id="loader"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>    
        <?php
        }
    }    
}
endif; 
add_action( 'mugu_home_page', 'mugu_latest_popular_posts', 30 ); 

if( ! function_exists( 'mugu_category_content' ) ) :
/**
 * Category Contents
*/
function mugu_category_content(){
    
    $one_cat   = get_theme_mod( 'mugu_category_section_one_cat' );
    $two_cat   = get_theme_mod( 'mugu_category_section_two_cat' );    
    $three_cat = get_theme_mod( 'mugu_category_section_three_cat' );
    $four_cat  = get_theme_mod( 'mugu_category_section_four_cat' );
    
    if( $one_cat ) mugu_get_category_content( $one_cat, 'small' );
    if( $two_cat ) mugu_get_category_content( $two_cat, 'big' );
    if( $three_cat ) mugu_get_category_content( $three_cat, 'small' );
    if( $four_cat ) mugu_get_category_content( $four_cat, 'big' );
    
}
endif;
add_action( 'mugu_home_page', 'mugu_category_content', 40 );

if( ! function_exists( 'mugu_post_wrapper_end' ) ) :
/**
 * Popular and Category post end
*/
function mugu_post_wrapper_end(){
    echo '</div>';
} 
endif;
add_action( 'mugu_home_page', 'mugu_post_wrapper_end', 50 );

function mugu_get_category_content( $cat_id, $style ){
    $img_size = '';
    $img_size = ( $style === 'small' ) ? 'mugu-popular-post' : 'mugu-blog-post' ;
    $cat = get_category( $cat_id );
    
    $args = array( 
		'post_type'             => 'post',
		'cat'           		=> $cat_id,
		'post_status'           => 'publish',
		'posts_per_page'   		=> 6,
		'ignore_sticky_posts'   => true 
    );
    
    $mugu_qry = new WP_Query( $args );

    if( $mugu_qry->have_posts() ){ ?>
    <?php if( $style === 'small' ){ ?>
      	<div class="holder">
    		<div class="popular-posts"> 
        <?php } ?>
      			<h2 class="main-title"><?php echo esc_html( $cat->name ); ?></h2>
      			<div class="row">
    
          		<?php
            		while ($mugu_qry->have_posts()){ 
                        $mugu_qry->the_post(); ?>
                	
                	<div class="post">
                      <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                        <?php 
                        if( has_post_thumbnail() ){
                          the_post_thumbnail( esc_attr( $img_size ), array( 'itemprop' => 'image' ) ); 
                        }else{
                          mugu_get_fallback_svg( $img_size );
                        } ?>
                      </a>                       
                        <div class="text-holder">
                            <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php if( $style === 'big' ){ ?>
                                <div class="entry-meta">
                                    <?php mugu_posted_on(); ?> 
                                </div>
                                <?php the_excerpt(); ?>
                                <a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e( 'Read More','mugu' ); ?></a>
                            <?php } ?>
                        </div>
                  	</div>
          		    <?php 
                    }
                wp_reset_postdata();
          		?>
      			</div>
    		<?php 
            if( $style === 'small' ){ ?>
            </div>
    	</div>
    <?php }
    }
}

/**
 * Callback function for Comment List *
 * 
 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
 */
 
function mugu_comment($comment, $args, $depth) {
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body" itemscope itemtype="http://schema.org/UserComments">
	<?php endif; ?>
	
    <footer class="comment-meta">
    
        <div class="comment-author vcard">
    	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        <?php printf( __( '<b class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</b>', 'mugu' ), get_comment_author_link() ); ?>
    	</div>
    	<?php if ( $comment->comment_approved == '0' ) : ?>
    		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'mugu' ); ?></em>
    		<br />
    	<?php endif; ?>
    
    	<div class="comment-metadata commentmetadata">
            <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                <time datetime="<?php comment_date(); ?>"><?php echo get_comment_date(); ?></time>
            </a>
            <?php edit_comment_link( __( '(Edit)', 'mugu' ), '  ', '' ); ?>
    	</div>
    </footer>
    
    <div class="comment-content"><?php comment_text(); ?></div>

	<div class="reply">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

/**
 * Return sidebar layouts for pages
*/
function mugu_sidebar_layout(){
    global $post;
    
    if( get_post_meta( $post->ID, 'mugu_sidebar_layout', true ) ){
        return get_post_meta( $post->ID, 'mugu_sidebar_layout', true );    
    }else{
        return 'right-sidebar';
    }
}

/**
 * Footer Credits 
*/
function mugu_footer_credit(){
    $copyright_text = get_theme_mod( 'mugu_footer_copyright_text' );
    $text  = '<div class="site-info"><div class="container"><p>';
    if( $copyright_text ){
      $text .= wp_kses_post( $copyright_text ) . '&nbsp';
    }else{
      $text .= esc_html__( 'Copyright &copy; ', 'mugu' ) . date_i18n( esc_html__( 'Y', 'mugu' ) ); 
      $text .= ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a> &verbar; ';
    }
    $text .= esc_html__( 'Mugu developed by: ', 'mugu' );
    $text .= '<a href="' . esc_url( 'https://rarathemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Rara Theme', 'mugu' ) . '</a> &verbar; ';
    $text .= sprintf( esc_html__( 'Powered by: %s', 'mugu' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'mugu' ) ) .'" target="_blank">WordPress</a>.' );

    if ( function_exists( 'the_privacy_policy_link' ) ) {
      $text .= get_the_privacy_policy_link();
    }

    $text .= '</p></div></div>';
    echo apply_filters( 'mugu_footer_text', $text );    
}
add_action( 'mugu_footer', 'mugu_footer_credit' );

/**
 * Custom CSS
*/
if ( function_exists( 'wp_update_custom_css_post' ) ) {
    // Migrate any existing theme CSS to the core option added in WordPress 4.7.
    $css = get_theme_mod( 'mugu_custom_css' );
    if ( $css ) {
        $core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
        $return = wp_update_custom_css_post( $core_css . $css );
        if ( ! is_wp_error( $return ) ) {
            // Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
            remove_theme_mod( 'mugu_custom_css' );
        }
    }
} else {
    function mugu_custom_css(){
        $custom_css = get_theme_mod( 'mugu_custom_css' );
        if( ! empty( $custom_css ) ){
    		echo '<style type="text/css">';
    		echo wp_strip_all_tags( $custom_css );
    		echo '</style>';
    	}
    }
    add_action( 'wp_head', 'mugu_custom_css', 100 );
}

/**
 * Ajax Callback for Featured Category
*/
function mugu_category_ajax(){
    $id = $_POST['id'];
    
    $args = array( 
        'post_type'           => 'post', 
        'post_status'         => 'publish',
        'posts_per_page'      => 6,             
        'ignore_sticky_posts' => true,
    );
    
    if( $id === 'most-popular'){
        $args['orderby'] = 'comment_count';
    }
    
    $mugu_qry = new WP_Query( $args );

    if( $mugu_qry->have_posts() ){
        while( $mugu_qry->have_posts() ){ 
          $mugu_qry->the_post(); 
            
          $response .= '<article class="post">'; 
            
            $response .= '<a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
            $response .= has_post_thumbnail() ? get_the_post_thumbnail( get_the_ID(), 'mugu-blog-post' ) : mugu_get_fallback_svg( 'mugu-blog-post', false ); 
            $response .= '</a>';

            $response .= '<div class="text-holder">';
        
            if ( 'post' === get_post_type() ) {
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( esc_html__( ', ', 'mugu' ) );
                if ( $categories_list && mugu_categorized_blog() ) {
                    $response .= '<span class="cat-links">' . $categories_list . '</span>'; // WPCS: XSS OK.
                }
            } 
            
            $response .= '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_html( get_the_title() ) . '</a></h2>';
             
            $response .= '<div class="entry-meta">';
            
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
            
                $posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
                
            $response .= '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
              
            if (  ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                $response .= '/ <span class="comments">';
                
                $num_comments = get_comments_number(); // get_comments_number returns only a numeric value
                    if ( $num_comments == 0 ) {
                    $comments = __( 'Leave a Comment', 'mugu' );
                  } elseif ( $num_comments > 1 ) {
                    $comments = $num_comments . __(' Comments', 'mugu' );
                  } else {
                    $comments = __( '1 Comment', 'mugu' );
                  }
                  $response .= '<a href="' . esc_url( get_comments_link() ) .'">'. esc_html( $comments ) .'</a>';
                    
                    $response .= '</span>';
            }
            
            $response .= '</div>';
            
            $response .= wpautop( esc_html( get_the_excerpt() ) );
            
            $response .= '<a href="'. esc_url( get_the_permalink() ) . '" class="readmore">'. esc_html__( 'Read More', 'mugu' ) . '</a>' ; 
                         
        $response .= '</div></article>';
            
        }
        wp_reset_postdata(); 
    }
    
    echo $response;
    
    wp_die();
}
add_action( 'wp_ajax_mugu_cat_ajax', 'mugu_category_ajax' );
add_action( 'wp_ajax_nopriv_mugu_cat_ajax', 'mugu_category_ajax' );

if ( ! function_exists( 'mugu_excerpt_more' ) ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function mugu_excerpt_more($more) {
  return is_admin() ? $more : ' &hellip; ';
}
add_filter( 'excerpt_more', 'mugu_excerpt_more' );
endif;

if ( ! function_exists( 'mugu_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function mugu_excerpt_length( $length ) {
  return is_admin() ? $length : 20;
}
add_filter( 'excerpt_length', 'mugu_excerpt_length', 999 );
endif;

if( ! function_exists( 'mugu_post_author' ) ) :
/**
 * Post Author
 */
function mugu_post_author(){
  global $post;
  // Detect if it is a single post with a post author
  if( isset( $post->post_author ) ){
    // Get author's display name 
    $display_name = get_the_author_meta( 'display_name', $post->post_author );
    $display_bio = get_the_author_meta( 'description', $post->post_author );

    // Pass all this info to post content  
    if( ! empty( $display_bio ) ) {
      echo '<section class="author"> <div class="img-holder">';
      echo get_avatar( get_the_author_meta('ID') , 114);
      echo '</div> <div class="text-holder"><h2 class="title">';
      echo esc_html( $display_name ) . '</h2>';
      echo wpautop( esc_html( $display_bio ) ); 
      echo '</section>';
    }
  }
}
endif;
add_action( 'mugu_after_post_content', 'mugu_post_author', 10 );

if( ! function_exists( 'mugu_single_post_schema' ) ) :
/**
 * Single Post Schema
 *
 * @return string
 */
function mugu_single_post_schema() {
    if ( is_singular( 'post' ) ) {
        global $post;
        $custom_logo_id = get_theme_mod( 'custom_logo' );

        $site_logo   = wp_get_attachment_image_src( $custom_logo_id , 'mugu-schema' );
        $images      = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
        $excerpt     = mugu_escape_text_tags( $post->post_excerpt );
        $content     = $excerpt === "" ? mb_substr( mugu_escape_text_tags( $post->post_content ), 0, 110 ) : $excerpt;
        $schema_type = ! empty( $custom_logo_id ) && has_post_thumbnail( $post->ID ) ? "BlogPosting" : "Blog";

        $args = array(
            "@context"  => "http://schema.org",
            "@type"     => $schema_type,
            "mainEntityOfPage" => array(
                "@type" => "WebPage",
                "@id"   => esc_url( get_permalink( $post->ID ) )
            ),
            "headline"      => esc_html( get_the_title( $post->ID ) ),
            "datePublished" => esc_html( get_the_time( DATE_ISO8601, $post->ID ) ),
            "dateModified"  => esc_html( get_post_modified_time(  DATE_ISO8601, __return_false(), $post->ID ) ),
            "author"        => array(
                "@type"     => "Person",
                "name"      => mugu_escape_text_tags( get_the_author_meta( 'display_name', $post->post_author ) )
            ),
            "description" => ( class_exists('WPSEO_Meta') ? WPSEO_Meta::get_value( 'metadesc' ) : $content )
        );

        if ( has_post_thumbnail( $post->ID ) ) :
            $args['image'] = array(
                "@type"  => "ImageObject",
                "url"    => $images[0],
                "width"  => $images[1],
                "height" => $images[2]
            );
        endif;

        if ( ! empty( $custom_logo_id ) ) :
            $args['publisher'] = array(
                "@type"       => "Organization",
                "name"        => esc_html( get_bloginfo( 'name' ) ),
                "description" => wp_kses_post( get_bloginfo( 'description' ) ),
                "logo"        => array(
                    "@type"   => "ImageObject",
                    "url"     => $site_logo[0],
                    "width"   => $site_logo[1],
                    "height"  => $site_logo[2]
                )
            );
        endif;

        echo '<script type="application/ld+json">' , PHP_EOL;
        if ( version_compare( PHP_VERSION, '5.4.0' , '>=' ) ) {
            echo wp_json_encode( $args, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) , PHP_EOL;
        } else {
            echo wp_json_encode( $args ) , PHP_EOL;
        }
        echo '</script>' , PHP_EOL;
    }
}
endif;
add_action( 'wp_head', 'mugu_single_post_schema' );

if( ! function_exists( 'mugu_escape_text_tags' ) ) :
/**
 * Remove new line tags from string
 *
 * @param $text
 * @return string
 */
function mugu_escape_text_tags( $text ) {
    return (string) str_replace( array( "\r", "\n" ), '', strip_tags( $text ) );
}
endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
	/**
	 * Triggered after the opening <body> tag.
    */
	do_action( 'wp_body_open' );
}
endif;

if( ! function_exists( 'mugu_admin_notice' ) ) :
/**
 * Addmin notice for getting started page
*/
function mugu_admin_notice(){
    global $pagenow;
    $theme_args      = wp_get_theme();
    $meta            = get_option( 'mugu_admin_notice' );
    $name            = $theme_args->__get( 'Name' );
    $current_screen  = get_current_screen();
    
    if( 'themes.php' == $pagenow && !$meta ){
        
        if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
            return;
        }

        if( is_network_admin() ){
            return;
        }

        if( ! current_user_can( 'manage_options' ) ){
            return;
        } ?>

        <div class="welcome-message notice notice-info">
            <div class="notice-wrapper">
                <div class="notice-text">
                    <h3><?php esc_html_e( 'Congratulations!', 'mugu' ); ?></h3>
                    <p><?php printf( __( '%1$s is now installed and ready to use. Click below to see theme documentation, plugins to install and other details to get started.', 'mugu' ), esc_html( $name ) ) ; ?></p>
                    <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=mugu-getting-started' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to the getting started.', 'mugu' ); ?></a></p>
                    <p class="dismiss-link"><strong><a href="?mugu_admin_notice=1"><?php esc_html_e( 'Dismiss', 'mugu' ); ?></a></strong></p>
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'admin_notices', 'mugu_admin_notice' );

if( ! function_exists( 'mugu_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function mugu_update_admin_notice(){
    if ( isset( $_GET['mugu_admin_notice'] ) && $_GET['mugu_admin_notice'] = '1' ) {
        update_option( 'mugu_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'mugu_update_admin_notice' );

if( ! function_exists( 'mugu_get_image_sizes' ) ) :
/**
 * Get information about available image sizes
 */
function mugu_get_image_sizes( $size = '' ) {
 
    global $_wp_additional_image_sizes;
 
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
 
    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array( 
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    } 
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}
endif;

if ( ! function_exists( 'mugu_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function mugu_get_fallback_svg( $post_thumbnail, $echo = true ) {
    if( ! $post_thumbnail ){
        return;
    }
    
    $image_size = mugu_get_image_sizes( $post_thumbnail );
     
    if( $image_size && $echo ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:#dedede;"></rect>
            </svg>
        </div>
        <?php
    }else{
        $image_size_return = '<div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 ' . esc_attr( $image_size['width'] ) .' '. esc_attr( $image_size['height'] ) .'" preserveAspectRatio="none">
             <rect width="'. esc_attr( $image_size['width'] ) .' " height=" '.esc_attr( $image_size['height'] ). ' " style="fill:#dedede;"></rect>
            </svg>
        </div>';

        return $image_size_return;
    }
}
endif;