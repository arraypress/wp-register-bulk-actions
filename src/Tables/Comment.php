<?php
/**
 * Comment Bulk Actions Class
 *
 * @package     ArrayPress\WP\RegisterBulkActions
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\RegisterBulkActions\Tables;

use ArrayPress\RegisterBulkActions\Abstracts\BulkActions;

class Comment extends BulkActions {

	/**
	 * Object type constant
	 */
	protected const OBJECT_TYPE = 'comment';

	/**
	 * Load the necessary hooks for comment bulk actions.
	 *
	 * @return void
	 */
	public function load_hooks(): void {
		add_filter( 'bulk_actions-edit-comments', [ $this, 'register_bulk_actions' ] );
		add_filter( 'handle_bulk_actions-edit-comments', [ $this, 'handle_bulk_action' ], 10, 3 );
		add_action( 'admin_notices', [ $this, 'display_admin_notice' ] );
	}

}