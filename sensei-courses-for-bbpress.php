<?php
/**
 * Plugin Name: Sensei Courses for bbPress
 * Plugin URI: https://github.com/SaidElBakkali/
 * Description: Assing Sensei Courses to bbPress Forums
 * Version: 1.0.0
 * Author: Said El Bakkali
 * Author URI: http://www.saidelbakkali.com
 * Requires at least: 5.8
 * Tested up to: 6.1
 * Text Domain: sensei-courses-for-bbpress
 * Domain Path: /locales/
 *
 * @package Sensei Courses for bbPress
 * @category Core
 * @since 1.0.0
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

use Sensei_Courses_For_BBPress\Sensei_Courses_For_BBPress;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include the composer autoloader.
if ( file_exists( __DIR__ . '/includes/packages/autoload.php' ) ) {
	require_once __DIR__ . '/includes/packages/autoload.php';
}

/**
 * Main instance of SC4BBP.
 *
 * Returns the main instance of SC4BBP to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return Sensei_Courses_For_bbPress
 */
function sensei_courses_for_bbpress() {
	return Sensei_Courses_For_BBPress::instance();
}

sensei_courses_for_bbpress();
