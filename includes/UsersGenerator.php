<?php

/**
 * Receives a list of data and generate users
 */

class UsersGenerator {

    /**
     * Generate users from list
     */
    public static function generateUsers($users_list)
    {
        $total_users_created = 0;
        foreach ($users_list as $key => $userdata) {
            if ( self::validateUserData($userdata) ) {
                
                // Sanitize data before creating user
                $userdata = array_combine(
                    array_keys($userdata), 
                    array_map( array('UsersGenerator', 'sanitizeUserdata' ), $userdata, array_keys($userdata) )
                );
               
                // Insert user and increment total users created number
                $user_id = wp_insert_user($userdata);
                if ( ! is_wp_error( $user_id ) ) {
                    $total_users_created = $total_users_created + 1;
                }
            }
        }
        
        return $total_users_created;
    }

    /**
     * Validate User data keys
     */
    public static function validateUserData($userdata)
    {
        $userdata_keys = array(
            'ID',
            'user_pass',
            'user_login',
            'user_nicename',
            'user_url',
            'user_email',
            'display_name',
            'nickname',
            'first_name',
            'last_name',
            'description',
            'rich_editing',
            'syntax_highlighting',
            'comment_shortcuts',
            'admin_color',
            'use_ssl',
            'user_registered',
            'show_admin_bar_front',
            'role',
            'locale'
        );

        foreach ($userdata as $key => $value) {
            if (!in_array($key, $userdata_keys)) {
                return false;
            }
        }

        /** Needs validation to each value **/

        return true;
    }

    /**
     * Sanitize Userdata values
     */
    public static function sanitizeUserdata($value, $param)
    {
        switch ($param) {
            case 'user_login':
                return sanitize_user($value);
                break;
            
            case 'user_email':
                return sanitize_email($value);
                break;
            
            case 'role':
                return sanitize_title($value);
                break;
            
            case 'user_url':
                return esc_url($value);
                break;
            
            default:
                return sanitize_text_field($value);
                break;
        }
    }

}