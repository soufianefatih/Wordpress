<?php
/**
 * Appearance Settings
 *
 * @package jobscout
 */

if ( ! function_exists( 'jobscout_customize_register_appearance' ) ) :

function jobscout_customize_register_appearance( $wp_customize ) {
    
    $wp_customize->add_panel( 
        'appearance_settings', 
        array(
            'title'       => __( 'Appearance Settings', 'jobscout' ),
            'priority'    => 25,
            'capability'  => 'edit_theme_options',
            'description' => __( 'Change color and body background.', 'jobscout' ),
        ) 
    );
    
    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'colors' )->panel                          = 'appearance_settings';
    $wp_customize->get_section( 'colors' )->priority                       = 30;
    $wp_customize->get_section( 'background_image' )->panel                = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority             = 35;
    $wp_customize->get_section( 'background_image' )->title                = __( 'Background', 'jobscout' );
    $wp_customize->get_control( 'background_color' )->description          = __( 'Background color of the theme.', 'jobscout' );  
}
endif;
add_action( 'customize_register', 'jobscout_customize_register_appearance' );