# WordPress Register Bulk Actions

Simple library for adding custom bulk actions to WordPress admin tables.

## Installation

```bash
composer require arraypress/wp-register-bulk-actions
```

## Usage

### Posts

```php
register_post_bulk_actions( 'post', [
    'mark_featured' => [
        'label'      => 'Mark as Featured',
        'capability' => 'edit_posts',
        'callback'   => function( $post_ids ) {
            foreach ( $post_ids as $post_id ) {
                update_post_meta( $post_id, '_featured', true );
            }
            return [ 'message' => count($post_ids) . ' posts marked as featured' ];
        }
    ]
] );
```

### Users

```php
register_user_bulk_actions( [
    'send_welcome' => [
        'label'      => 'Send Welcome Email',
        'capability' => 'edit_users',
        'callback'   => function( $user_ids ) {
            // Send emails...
            return [ 'message' => 'Emails sent!' ];
        }
    ]
] );
```

### Taxonomies

```php
register_taxonomy_bulk_actions( 'category', [
    'feature_terms' => [
        'label'    => 'Mark as Featured',
        'callback' => function( $term_ids ) {
            foreach ( $term_ids as $term_id ) {
                update_term_meta( $term_id, '_featured', true );
            }
            return [ 'message' => 'Done!' ];
        }
    ]
] );
```

### Comments

```php
register_comment_bulk_actions( [
    'mark_helpful' => [
        'label'    => 'Mark as Helpful',
        'callback' => function( $comment_ids ) {
            foreach ( $comment_ids as $comment_id ) {
                update_comment_meta( $comment_id, '_helpful', true );
            }
            return [ 'message' => 'Marked as helpful' ];
        }
    ]
] );
```

### Media

```php
register_media_bulk_actions( [
    'regenerate' => [
        'label'    => 'Regenerate Thumbnails',
        'callback' => function( $attachment_ids ) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            
            foreach ( $attachment_ids as $attachment_id ) {
                $file = get_attached_file( $attachment_id );
                $meta = wp_generate_attachment_metadata( $attachment_id, $file );
                wp_update_attachment_metadata( $attachment_id, $meta );
            }
            
            return [ 'message' => 'Thumbnails regenerated' ];
        }
    ]
] );
```

## Options

```php
[
    'label'      => 'Action Label',    // Required - shown in dropdown
    'capability' => 'manage_options',  // Optional - default: manage_options
    'callback'   => function( $ids ) { // Required - receives array of IDs
        // Do something with $ids
        
        // Return success message
        return [ 'message' => 'Done!' ];
        
        // Or return error
        return [ 
            'success' => false,
            'message' => 'Error occurred'
        ];
    }
]
```

## Multiple Post Types/Taxonomies

```php
register_post_bulk_actions( ['post', 'page', 'product'], [
    'my_action' => [ /* ... */ ]
] );

register_taxonomy_bulk_actions( ['category', 'post_tag'], [
    'my_action' => [ /* ... */ ]
] );
```

## Features

- ✅ Automatic admin notices
- ✅ Capability checking
- ✅ Success/error handling
- ✅ Works on all admin tables
- ✅ No hooks needed - just call the function

## Requirements

- PHP 7.4+
- WordPress 5.0+

## License

GPL-2.0-or-later