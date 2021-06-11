<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mugu
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
        echo '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail">';
    		if( has_post_thumbnail() ){
              	the_post_thumbnail( 'mugu-blog-post', array( 'itemprop' => 'image' ) );
            }else{
                mugu_get_fallback_svg( 'mugu-blog-post' );
            }  
        echo '</a>' ; 
	?>
	<div class="text-holder">
    	<?php 
    		mugu_category_list(); 
    		the_title( sprintf( '<h2 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
    	?>

		<?php 
            if ( 'post' === get_post_type() ) { ?>
                <div class="entry-meta">
                    <?php mugu_posted_on(); ?>
                </div><!-- .entry-meta -->
        <?php } ?>
        
	</div><!-- .entry-header -->
</article><!-- #post-## -->

