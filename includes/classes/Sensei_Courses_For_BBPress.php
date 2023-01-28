<?php
/**
 * Sensei Courses for bbPress Class File
 *
 * @package Sensei Courses for bbPress
 * @since 1.0.0
 */

namespace Sensei_Courses_For_BBPress;

use Sensei_Courses_For_BBPress\Meta_Box;
use Sensei_Courses_For_BBPress\Helper;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sensei Courses for bbPress Class
 *
 * @since 1.0.0
 */
class Sensei_Courses_For_BBPress {

	/**
	 * Sensei Courses for bbPress version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * The single instance of the class.
	 *
	 * @var Sensei_Courses_For_BBPress
	 * @since 1.0.0
	 */
	protected static $instance = null;

	/**
	 * Main Sensei Courses for bbPress Instance.
	 *
	 * Ensures only one instance of Sensei Courses for bbPress is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Sensei_Courses_For_BBPress()
	 * @return Sensei Courses for bbPress - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Sensei Courses for bbPress Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->init_hooks();

		do_action( 'sensei_courses_for_bbpress_loaded' );
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 1.0.0
	 */
	private function init_hooks() {

		$metabox = new Meta_Box();
		add_filter( 'bbp_user_can_view_forum', array( $this, 'user_can_view_forum' ), 10, 3 );
		add_action( 'add_meta_boxes', array( $metabox, 'add_meta_box' ) );
		add_action( 'save_post', array( $metabox, 'save_meta_box' ) );
	}

	/**
	 * If the user is not enrolled in the course, then they can't view the forum
	 *
	 * @param bool $retval The return value. If you want to override the default, return true or false.
	 * @param int  $forum_id The ID of the forum being viewed.
	 * @param int  $user_id The ID of the user who is trying to view the forum.
	 *
	 * @return bool
	 */
	public function user_can_view_forum( $retval, $forum_id, $user_id ) {
		$course_id = Helper::get_course_id( $forum_id );

		// Check if the current user is not an admin.
		if ( ! current_user_can( 'manage_options' ) && Helper::is_sensei_courses_active() ) {
			// Check if the user is enrolled in the course.
			if ( ! Sensei()->course->can_access_course_content( $course_id, $user_id ) ) {
				$retval = false;
			}
		}

		return $retval;
	}
}
