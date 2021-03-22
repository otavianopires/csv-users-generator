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

            $first_line = fgetcsv($csv_file, 1000, ",");

            $csv_headers = array();
            for ($i = 0, $j = count($first_line); $i < $j; $i++) {
                array_push($csv_headers, preg_replace('/[^(\x20-\x7F)]*/', '', $first_line[$i]) );
            }
            
            while ( ( $csv_row = fgetcsv( $csv_file, 1000, "," ) ) !== FALSE ) {
                $csv_row = array_map("utf8_encode", $csv_row);
                $csv_row = array_combine( $csv_headers, $csv_row );

                if ( $csv_row['user_login'] != '' ) {
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
}