<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mugu
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
    
    <?php    
        echo '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail">';
        if( has_post_thumbnail() ){
            the_post_thumbnail( 'mugu-blog-post', array( 'itemprop' => 'image' ) );
        }else{
            mugu_get_fallback_svg( 'mugu-blog-post' );
        }       
        echo '</a>' ; 
    ?>
	<header class="entry-header" itemprop="headline">
		<?php
        	mugu_category_list(); // Category list
			
            if ( is_single() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
            
            if ( 'post' === get_post_type() ) : ?>
                <div class="entry-meta">
                    <?php mugu_posted_on(); ?>
                </div><!-- .entry-meta -->
		<?php
            endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content" itemprop="text">
		<?php
			if( is_single() ){ 
                the_content( sprintf(
    				/* translators: %s: Name of current post. */
    				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'mugu' ), array( 'span' => array( 'class' => array() ) ) ),
    				the_title( '<span class="screen-reader-text">"', '"</span>', false )
    			) );
                
            }else{
                the_excerpt();
            }
            
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mugu' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php mugu_entry_footer(); ?>
	</footer><!-- .entry-footer -->
    
</article><!-- #post-## -->