<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mugu
 */
$first_cat                 = get_theme_mod( 'mugu_category_section_one_cat' ); //from customizer
$second_cat                = get_theme_mod( 'mugu_category_section_two_cat' ); //from customizer    
$third_cat                 = get_theme_mod( 'mugu_category_section_three_cat' ); //from customizer
$fourth_cat                = get_theme_mod( 'mugu_category_section_four_cat' ); //from customizer
$ed_feature_section        = get_theme_mod( 'mugu_ed_featured_section' ); //from customizer
$ed_rcnt_and_pplr_post_sec = get_theme_mod( 'mugu_ed_blog_section' ); //from customizer

if ( 'posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() );
}elseif( $ed_feature_section || $ed_rcnt_and_pplr_post_sec || $first_cat || $second_cat || $third_cat || $fourth_cat ){ 
    get_header();
    /**
     * @hooked mugu_top_news_section - 10 
     * @hooked mugu_three_col_cat_content - 20
     * @hooked mugu_three_row_cat_content - 30
     * @hooked mugu_three_video_cat_content - 40
     * @hooked mugu_big_img_single_cat_content - 50
     * @hooked mugu_more_news_content          - 60  
    */
    do_action( 'mugu_home_page' );
    get_footer();   
}else{
    include( get_page_template() );
}