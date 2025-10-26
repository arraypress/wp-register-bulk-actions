<?php
/**
 * Bulk Actions Helper Functions
 *
 * Global helper functions for registering bulk actions.
 *
 * @package     ArrayPress\WP\RegisterBulkActions
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

use ArrayPress\WP\RegisterBulkActions\Tables\Post;
use ArrayPress\WP\RegisterBulkActions\Tables\User;
use ArrayPress\WP\RegisterBulkActions\Tables\Taxonomy;
use ArrayPress\WP\RegisterBulkActions\Tables\Comment;
use ArrayPress\WP\RegisterBulkActions\Tables\Media;

if ( ! function_exists( 'register_post_bulk_actions' ) ):
	/**
	 * Register bulk actions for posts or custom post types
	 *
	 * @param string|array $post_types Post type(s) to register actions for
	 * @param array        $actions    Bulk actions configuration
	 *
	 * @return void
	 */
	function register_post_bulk_actions( $post_types, array $actions ): void {
		$post_types = (array) $post_types;

		foreach ( $post_types as $post_type ) {
			new Post( $actions, $post_type );
		}
	}
endif;

if ( ! function_exists( 'register_user_bulk_actions' ) ):
	/**
	 * Register bulk actions for users
	 *
	 * @param array $actions Bulk actions configuration
	 *
	 * @return void
	 */
	function register_user_bulk_actions( array $actions ): void {
		new User( $actions, 'user' );
	}
endif;

if ( ! function_exists( 'register_taxonomy_bulk_actions' ) ):
	/**
	 * Register bulk actions for taxonomies
	 *
	 * @param string|array $taxonomies Taxonomy/taxonomies to register actions for
	 * @param array        $actions    Bulk actions configuration
	 *
	 * @return void
	 */
	function register_taxonomy_bulk_actions( $taxonomies, array $actions ): void {
		$taxonomies = (array) $taxonomies;

		foreach ( $taxonomies as $taxonomy ) {
			new Taxonomy( $actions, $taxonomy );
		}
	}
endif;

if ( ! function_exists( 'register_comment_bulk_actions' ) ):
	/**
	 * Register bulk actions for comments
	 *
	 * @param array $actions Bulk actions configuration
	 *
	 * @return void
	 */
	function register_comment_bulk_actions( array $actions ): void {
		new Comment( $actions, 'comment' );
	}
endif;

if ( ! function_exists( 'register_media_bulk_actions' ) ):
	/**
	 * Register bulk actions for media
	 *
	 * @param array $actions Bulk actions configuration
	 *
	 * @return void
	 */
	function register_media_bulk_actions( array $actions ): void {
		new Media( $actions, 'attachment' );
	}
endif;