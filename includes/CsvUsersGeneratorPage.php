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
}