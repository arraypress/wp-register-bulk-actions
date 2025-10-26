<?php
/**
 * Post Bulk Actions Class
 *
 * @package     ArrayPress\WP\RegisterBulkActions
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\WP\RegisterBulkActions\Tables;

use ArrayPress\WP\RegisterBulkActions\Abstracts\BulkActions;

class Post extends BulkActions {

	/**
	 * Object type constant
	 */
	protected const OBJECT_TYPE = 'post';

	/**
	 * Load the necessary hooks for post bulk actions.
	 *
	 * @return void
	 */
	public function load_hooks(): void {
		$screen_id = 'edit-' . $this->object_subtype;

		add_filter( "bulk_actions-{$screen_id}", [ $this, 'register_bulk_actions' ] );
		add_filter( "handle_bulk_actions-{$screen_id}", [ $this, 'handle_bulk_action' ], 10, 3 );
		add_action( 'admin_notices', [ $this, 'display_admin_notice' ] );
	}

}