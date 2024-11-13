<?php $current_user = wp_get_current_user(); ?>

<div class="welcome-panel-content">

    <h1><?php echo get_bloginfo('name'); ?> CMS </h1>
    <p class="about-description"><?php echo sprintf( __( 'Hi %1$s, welcome to your admin dashboard.', 'rodesk-admin-core' ), $current_user->display_name ); ?></p>

    <p><?php echo sprintf( __( 'This is the place where the magic happes, here you can manage the content of your website. You can browse through the administration area by using the buttons on the main menu at the top left of this page. If you need help managing your website, please dont hesitate to ask and contact us by sending an email to %1$s.', 'rodesk-admin-core' ), $support_link ); ?></p>
    <p><?php _e( 'Have fun managing your website content. We love happy people!' , 'rodesk-admin-core' ); ?></p>

    <div class="welcome-panel-column-container">

        <div class="welcome-panel-column">
            <h3><?php _e( 'In need of support?', 'rodesk-admin-core' ); ?></h3>
            <a class="button button-primary button-hero" href="https://www.rodesk.com/people/" target="_blank"><?php _e( 'Contact the Rodesk tribe!', 'rodesk-admin-core' ); ?></a>
            <p><?php _e( 'Or send us an ', 'rodesk-admin-core' ); ?> <a href="mailto:interactie@rodesk.nl"><?php _e( 'E-mail', 'rodesk-admin-core' ); ?></a></p>
        </div>

        <div class="welcome-panel-column">
            <h3><?php _e( 'Userfull links', 'rodesk-admin-core' ); ?></h3>
            <ul>
                <li><a href="<?php echo get_bloginfo('url'); ?>" class="welcome-icon  welcome-view-site"><?php _e( 'View the live website', 'rodesk-admin-core' ); ?></a></li>
                <li><a href="http://rodesk.com" class="welcome-icon  welcome-learn-more" target="_blank"><?php _e( 'View the Rodesk website', 'rodesk-admin-core' ); ?></a></li>
            </ul>
        </div>

        <div class="welcome-panel-column welcome-panel-last">
            <h3><?php _e( 'Other actions', 'rodesk-admin-core' ); ?></h3>
            <ul>
                <li><a href="<?php echo get_admin_url(); ?>options-general.php" class="welcome-icon welcome-edit-page"><?php _e( 'Change preferences', 'rodesk-admin-core' ); ?></a></li>
                <li><a href="<?php echo get_admin_url(); ?>profile.php" class="welcome-icon welcome-comments"><?php _e( 'Edit account details', 'rodesk-admin-core' ); ?></a></li>
            </ul>
        </div>

    </div>
</div>
