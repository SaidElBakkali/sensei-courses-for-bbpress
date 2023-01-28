<?php
/**
 * Helper class for Sensei Courses for bbPress
 *
 * @package Sensei Courses for bbPress
 * @since 1.0.0
 */

namespace Sensei_Courses_For_BBPress;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sensei Courses for bbPress Helper Class
 *
 * @since 1.0.0
 */
class Helper {

		/**
		 * It returns the forum ID associated with a course
		 *
		 * @param int $forum_id The ID of the course you want to get the forum ID for.
		 *
		 * @return mixed The forum ID associated with the course ID. If no forum ID is associated with the course ID, it returns an empty string.
		 */
	public static function get_course_id( $forum_id ) {
		return get_post_meta( $forum_id, '_sensei_courses_for_bbpress_course_id', true );
	}

		/**
		 * `update_post_meta( , 'sensei_courses_for_bbpress_course_id',  );`
		 *
		 * The first parameter is the post ID of the course. The second parameter is the meta key. The third
		 * parameter is the meta value
		 *
		 * @param int $course_id The ID of the course you want to set the forum ID for.
		 * @param int $forum_id The ID of the forum you want to associate with the course.
		 *
		 * @return mixed Meta ID if the key didn't exist, true on successful update, false on failure.
		 */
	public static function set_course_id( $forum_id, $course_id ) {
		return update_post_meta( $forum_id, '_sensei_courses_for_bbpress_course_id', $course_id );
	}

		/**
		 * It deletes the forum ID from the course ID
		 *
		 * @param int $course_id The ID of the course you want to get the forum ID for.
		 *
		 * @return bool True on success, false on failure.
		 */
	public static function delete_course_id( $forum_id ) {
		return delete_post_meta( $forum_id, '_sensei_courses_for_bbpress_course_id' );
	}


	/**
	 * It creates a dropdown menu of all the courses in the system
	 *
	 * @param string $post_type The post type of the courses you want to get. Default is 'course'.
	 * @param int    $selected_course_id The ID of the course you want to be selected. Default is 0.
	 * @param string $id The ID of the dropdown menu. Default is 'dropdown_name'.
	 * @return void The HTML for the dropdown menu.
	 * @since 1.0.0
	 */
	public static function courses_drop_down_html( $post_type = 'course', $selected_course_id = 0, $id = 'dropdown_name', $echo = true ) {

		$html = '';

		$course_args = array(
			'post_type'        => $post_type,
			'posts_per_page'   => -1,
			'order'            => 'ASC',
			'post_status'      => 'publish',
			'suppress_filters' => 0,
			'fields'           => 'ids',
		);

		$courses = get_posts( apply_filters( 'sensei_grading_filter_courses', $course_args ) );

		$html = '';

		if ( count( $courses ) > 0 ) {
			foreach ( $courses as $course_id ) {
				$html .= sprintf( '<option value="%s" %s>%s</option>', esc_attr( absint( $course_id ) ), selected( $course_id, $selected_course_id, false ), esc_html( get_the_title( $course_id ) ) );
			}
		}

		$html = sprintf( '<option value="">%s</option>%s', __( 'Seleciona un curos', 'bbpress-for-sensei-courses' ), $html );

		$html = sprintf( '<select name="%s" id="%s">%s</select>', $id, $id, $html );

		if ( true !== $echo ) {
			return $html;
		}

		echo wp_kses(
			$html,
			array(
				'select' => array(
					'name' => array(),
					'id'   => array(),
				),
				'option' => array(
					'value'    => array(),
					'selected' => array(),
				),
			)
		);
	}

	/**
	 * Check if Sensei Courses is active.
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public static function is_sensei_courses_active() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		if ( is_plugin_active( 'sensei-lms/sensei-lms.php' ) ) {
			return true;
		}

		return false;
	}

}
