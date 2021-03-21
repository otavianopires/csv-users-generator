<?php

/**
 * Parse CSV data and validates a csv file
 */
class CsvParser {

    /**
     * Convert CSV data to associative array
     */
    public static function csvToArray($filename)
    {        
        $data_list = array();

        if ( !file_exists($filename) ) {
            return false;
        }

        if ( ( $csv_file = fopen($filename, "r" ) ) !== FALSE ) {

            $csv_headers = fgetcsv($csv_file, 1000, ",");
            
            while ( ( $csv_row = fgetcsv( $csv_file, 1000, "," ) ) !== FALSE ) {

                if ( isset( $csv_row ) && !empty( $csv_row[0] ) ) {
                    $csv_row = array_combine( $csv_headers, $csv_row );
                    array_push( $data_list, $csv_row );
                }
            }

            fclose($csv_file);

        }

        if ( empty( $data_list ) ) {
            return false;
        }

        return $data_list;
    }

    /**
     * Validate CSV file 
     */
    public static function validateFile($file)
    {
        if ( !file_exists($file["tmp_name"]) ) {
            return 'file_exists';
        }

        $file_type = pathinfo( basename($file["name"]),PATHINFO_EXTENSION );
        if ( $file_type != "csv" ) {
            return 'extension';
        }
        
        if ( $file["size"] > 6553600 ) {
            return 'size';
        }

        return false;
    }

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