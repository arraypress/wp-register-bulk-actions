<?php
/**
 * Row Actions Examples
 *
 * Practical examples of using the WP Register Row Actions library.
 * Note: No need to wrap in admin_init - the library handles hook timing automatically!
 *
 * @package ArrayPress\WP\RegisterRowActions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// POST - Mark as Featured
register_post_bulk_actions( 'post', [
	'mark_featured'   => [
		'label'      => 'Mark as Featured',
		'capability' => 'edit_posts',
		'callback'   => function ( $post_ids ) {
			$count = 0;
			foreach ( $post_ids as $post_id ) {
				if ( get_post_status( $post_id ) === 'publish' ) {
					update_post_meta( $post_id, '_featured', true );
					$count ++;
				}
			}

			return [
				'message' => sprintf( '%d post(s) marked as featured', $count )
			];
		}
	],
	'unmark_featured' => [
		'label'      => 'Unmark Featured',
		'capability' => 'edit_posts',
		'callback'   => function ( $post_ids ) {
			foreach ( $post_ids as $post_id ) {
				delete_post_meta( $post_id, '_featured' );
			}

			return [
				'message' => sprintf( '%d post(s) unmarked', count( $post_ids ) )
			];
		}
	]
] );

// USER - Send Welcome Email
register_user_bulk_actions( [
	'send_welcome' => [
		'label'      => 'Send Welcome Email',
		'capability' => 'edit_users',
		'callback'   => function ( $user_ids ) {
			$sent = 0;
			foreach ( $user_ids as $user_id ) {
				$user = get_userdata( $user_id );
				if ( $user && wp_mail( $user->user_email, 'Welcome!', 'Welcome message' ) ) {
					$sent ++;
				}
			}

			return [
				'message' => sprintf( 'Welcome email sent to %d user(s)', $sent )
			];
		}
	]
] );

// COMMENT - Mark as Helpful
register_comment_bulk_actions( [
	'mark_helpful' => [
		'label'      => 'Mark as Helpful',
		'capability' => 'moderate_comments',
		'callback'   => function ( $comment_ids ) {
			foreach ( $comment_ids as $comment_id ) {
				update_comment_meta( $comment_id, '_helpful', true );
			}

			return [
				'message' => sprintf( '%d comment(s) marked as helpful', count( $comment_ids ) )
			];
		}
	]
] );

// TAXONOMY - Feature Categories
register_taxonomy_bulk_actions( [ 'category', 'post_tag' ], [
	'feature_terms' => [
		'label'      => 'Mark as Featured',
		'capability' => 'manage_categories',
		'callback'   => function ( $term_ids ) {
			foreach ( $term_ids as $term_id ) {
				update_term_meta( $term_id, '_featured', true );
			}

			return [
				'message' => sprintf( '%d term(s) marked as featured', count( $term_ids ) )
			];
		}
	]
] );

// MEDIA - Regenerate Thumbnails
register_media_bulk_actions( [
	'regenerate_thumbs' => [
		'label'      => 'Regenerate Thumbnails',
		'capability' => 'upload_files',
		'callback'   => function ( $attachment_ids ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';

			$count = 0;
			foreach ( $attachment_ids as $attachment_id ) {
				if ( wp_attachment_is_image( $attachment_id ) ) {
					$file = get_attached_file( $attachment_id );
					$meta = wp_generate_attachment_metadata( $attachment_id, $file );
					wp_update_attachment_metadata( $attachment_id, $meta );
					$count ++;
				}
			}

			return [
				'message' => sprintf( 'Regenerated thumbnails for %d image(s)', $count )
			];
		}
	]
] );