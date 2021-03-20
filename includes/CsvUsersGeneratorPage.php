<?php
/**
 * Creates page for the import csv form
 */

class CsvUsersGeneratorPage {

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'addCsvUsersGenerator' ) );
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
}