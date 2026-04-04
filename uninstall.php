<?php
/**
 * Plugin uninstall handler.
 *
 * Removes all plugin data: database tables, options, and scheduled actions.
 *
 * @package Plugin_Name
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Drop plugin tables and delete options for a single site.
 *
 * @param int $blog_id Blog ID (used for multisite table prefix).
 */
function plugin_name_uninstall_site( $blog_id = 0 ) {
	global $wpdb;

	if ( $blog_id ) {
		switch_to_blog( $blog_id );
	}

	// Drop custom tables. Add plugin-specific table names here.
	$tables = array();

	foreach ( $tables as $table ) {
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$wpdb->query( "DROP TABLE IF EXISTS {$table}" );
	}

	// Delete plugin options.
	delete_option( 'plugin_name_settings' );

	if ( $blog_id ) {
		restore_current_blog();
	}
}

if ( is_multisite() ) {
	$blog_ids = get_sites(
		array(
			'fields' => 'ids',
			'number' => 0,
		)
	);
	foreach ( $blog_ids as $current_blog_id ) {
		plugin_name_uninstall_site( (int) $current_blog_id );
	}
} else {
	plugin_name_uninstall_site();
}
