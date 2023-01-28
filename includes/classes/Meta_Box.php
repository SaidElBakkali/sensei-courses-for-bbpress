<?php
/**
 * Meta Box class file
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
 * Sensei Courses for bbPress Meta Box Class
 *
 * @since 1.0.0
 */
class Meta_Box {

	/**
	 * It adds the meta box to the forum post type
	 */
	public function add_meta_box() {

		add_meta_box(
			'sensei_courses_for_bbpress_meta_box',
			__( 'Sensei Courses for bbPress', 'sensei-courses-for-bbpress' ),
			array( $this, 'render_meta_box' ),
			'forum',
			'side',
			'high'
		);
	}

	/**
	 * It renders the meta box
	 *
	 * @param object $post WP_Post The post object.
	 */
	public function render_meta_box( $post ) {

		$course_id = Helper::get_course_id( $post->ID );

		wp_nonce_field( 'sensei_courses_for_bbpress_meta_box', 'sensei_courses_for_bbpress_meta_box_nonce' );

		Helper::courses_drop_down_html( 'course', $course_id, 'sensei_courses_for_bbpress_course_id', true );
	}

	/**
	 * It saves the meta box
	 *
	 * @param int $post_id int The ID of the post being saved.
	 *
	 * @return mixed
	 */
	public function save_meta_box( $post_id ) {

		// Check if our nonce is set.
		if ( ! isset( $_POST['sensei_courses_for_bbpress_meta_box_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['sensei_courses_for_bbpress_meta_box_nonce']; // phpcs:ignore

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'sensei_courses_for_bbpress_meta_box' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$course_id = sanitize_text_field( $_POST['sensei_courses_for_bbpress_course_id'] ); // phpcs:ignore

		// Update the meta field.
		Helper::set_course_id( $post_id, $course_id );
	}
}
