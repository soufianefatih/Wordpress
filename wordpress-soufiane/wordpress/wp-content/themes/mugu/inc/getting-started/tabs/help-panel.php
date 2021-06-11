<?php
/**
 * Help Panel.
 *
 * @package Mugu
 */
?>
<!-- Help file panel -->
<div id="help-panel" class="panel-left">

    <div class="panel-aside">
        <h4><?php esc_html_e( 'View Our Documentation Link', 'mugu' ); ?></h4>
        <p><?php esc_html_e( 'Are you new to the WordPress world? Our step by step easy documentation guide will help you create an attractive and engaging website without any prior coding knowledge or experience.', 'mugu' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://docs.rarathemes.com/docs/mugu/' ); ?>" title="<?php esc_attr_e( 'Visit the Documentation', 'mugu' ); ?>" target="_blank">
            <?php esc_html_e( 'View Documentation', 'mugu' ); ?>
        </a>
    </div><!-- .panel-aside -->
    
    <div class="panel-aside">
        <h4><?php esc_html_e( 'Support Ticket', 'mugu' ); ?></h4>
        <p><?php printf( __( 'It\'s always better to visit our %1$sDocumentation Guide%2$s before you send us a support query.', 'mugu' ), '<a href="'. esc_url( 'https://docs.rarathemes.com/docs/mugu/' ) .'" target="_blank">', '</a>' ); ?></p>
        <p><?php printf( __( 'If the Documentation Guide didn\'t help you, contact us via our %1$sSupport Ticket%2$s. We reply to all the support queries within one business day, except on the weekends.', 'mugu' ), '<a href="'. esc_url( 'https://rarathemes.com/support-ticket/' ) .'" target="_blank">', '</a>' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://rarathemes.com/support-ticket/' ); ?>" title="<?php esc_attr_e( 'Visit the Support', 'mugu' ); ?>" target="_blank">
            <?php esc_html_e( 'Contact Support', 'mugu' ); ?>
        </a>
    </div><!-- .panel-aside -->

    <div class="panel-aside">
        <h4><?php esc_html_e( 'View Our Mugu Demo', 'mugu' ); ?></h4>
        <p><?php esc_html_e( 'Visit the demo to get more idea about our theme design and its features.', 'mugu' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://rarathemes.com/previews/?theme=mugu' ); ?>" title="<?php esc_attr_e( 'Visit the Demo', 'mugu' ); ?>" target="_blank">
            <?php esc_html_e( 'View Demo', 'mugu' ); ?>
        </a>
    </div><!-- .panel-aside -->
</div>