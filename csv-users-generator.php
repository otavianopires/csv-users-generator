<?php
/**
 * Plugin Name:       CSV Users Generator
 * Plugin URI:        https://github.com/otavianopires/csv-users-generator
 * Description:       Import users from CSV
 * Version:           0.1
 * Author:            Otaviano Pires Amancio
 * Author URI:        https://github.com/otavianopires
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cug
 * Domain Path:       /lang
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CUG_VERSION', '0.1' );
define( 'CUG_PATH', plugin_dir_path(__FILE__) );
define( 'CUG_URL', plugin_dir_url(__FILE__) );
define( 'CUG_TEXT_DOMAIN', 'cug' );
 
require_once CUG_PATH . 'includes/core.php';