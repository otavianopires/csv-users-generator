<?php

/**
 * Return custom errors
 */
class CugError {

    /**
     * Return custom WP_Error according to the error type
     */
    public static function getError($type)
    {
        $error = new WP_Error();
        switch ($type) {
            case 'file_exists':
                $error->add( 'file_exists', __('CSV file does not exist.', CUG_TEXT_DOMAIN ) );
                break;
            
            case 'size':
                $error->add( 'size', __('CSV file must have maximun of 50MB', CUG_TEXT_DOMAIN ) );
                break;
        
            case 'extension':
                $error->add( 'extension', __('Only CSV files are allowed.', CUG_TEXT_DOMAIN ) );
                break;
        
            case 'empty':
                $error->add( 'empty', __('The CSV file is empty.', CUG_TEXT_DOMAIN ) );
                break;
                        
            default:
                break;
        }

        return $error;
    }
}