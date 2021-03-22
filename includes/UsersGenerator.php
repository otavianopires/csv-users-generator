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

}