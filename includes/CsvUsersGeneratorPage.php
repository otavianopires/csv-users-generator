<?php

/**
 * Creates page for the import csv form
 */
class CsvUsersGeneratorPage {

    public function __construct()
    {
        $this->loadDependencies();

        add_action( 'admin_menu', array( $this, 'addCsvUsersGenerator' ) );

        add_action( 'admin_post_csv_users_generator', array( $this, 'importCsv' ) );

        add_action('admin_notices', array( $this, 'CsvUsersGeneratorAdminNotices') );
    }

    private function loadDependencies()
    {
        require_once CUG_PATH . 'includes/CsvParser.php';
    }

    /**
     * Add page to menu
     */
    public function addCsvUsersGenerator()
    {
        add_menu_page( 
            __( 'CSV Users Generator', CUG_TEXT_DOMAIN ), 
            __( 'CSV Users Generator', CUG_TEXT_DOMAIN ),
            'manage_options',
            'csv-users-generator',
            array( $this, 'csvUsersGeneratorTemplate' ),
            'dashicons-groups',
            80
        );
    }

    /**
     * Add template to page
     */
    public function csvUsersGeneratorTemplate()
    {
        require_once CUG_PATH . 'templates/csv-users-generator.php';
    }

    public function importCsv()
    {
        if ( !isset($_POST['cug_nonce']) || ! wp_verify_nonce( $_POST['cug_nonce'], 'csv_users_nonce' ) ) {
            wp_safe_redirect( home_url($_POST['_wp_http_referer']) );
            exit;
        }

        // Validate CSV file before trying to import
        $validate_file = CsvParser::validateFile($_FILES['csv_users']);

        if ( $validate_file ) {
            $query_args = array( 'csvError' => $validate_file );
            $redirect_to = add_query_arg( $query_args, admin_url( 'admin.php?page=csv-users-generator' ) );

            wp_safe_redirect( $redirect_to );
            exit;
        }
        
        // At this point we can try to convert the CSV data to associative array
        $users_list = CsvParser::csvToArray($_FILES['csv_users']['tmp_name']);

        if ( !$users_list ) {
            $query_args = array( 'csvWarning' => 'empty' );
            $redirect_to = add_query_arg( $query_args, admin_url( 'admin.php?page=csv-users-generator' ) );

            wp_safe_redirect( $redirect_to );
            exit;
        }

        // All good! We can generate new users

        // Code to generate users

        // Redirect after users generated
        $query_args = array( 'csvSuccess' => 'generated' );
        $redirect_to = add_query_arg( $query_args, admin_url( 'admin.php?page=csv-users-generator' ) );

        wp_safe_redirect( $redirect_to );
        exit;

    }
    
    /**
     * Added custom admin notices
     */
    public function CsvUsersGeneratorAdminNotices(){
        global $pagenow;
        if ( $pagenow == 'admin.php' && isset($_GET['page']) && sanitize_title($_GET['page']) == 'csv-users-generator' ) {

            if ( isset($_GET['csvSuccess']) && sanitize_title($_GET['csvSuccess']) == 'generated' ) : ?>
                <div class="notice notice-success is-dismissible">
                    <p><b><?php _e('Success! Users generated.', CUG_TEXT_DOMAIN ) ?></b></p>
                </div>
            <?php endif;

            if ( isset($_GET['csvWarning']) ) :
                $file_error = CsvParser::getError(sanitize_title(sanitize_title($_GET['csvWarning'])));
                ?>
                <div class="notice notice-warning is-dismissible">
                    <p><b><?php echo $file_error->get_error_message(); ?></b></p>
                </div>
            <?php endif;

            if ( isset($_GET['csvError']) ) :
                $file_error = CsvParser::getError(sanitize_title($_GET['fileError']));
                ?>
                <div class="notice notice-error is-dismissible">
                    <p><b><?php echo $file_error->get_error_message(); ?></b></p>
                </div>
            <?php endif;
        }
    }
}