<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'saJqa9AP4HyAonNHu6CkFSU4kCV7UmCnOnSHk5GOUomJT/Jaon7IvumvdV7WwjpANz1V3tJxUevYJACvT5Q/Gw==');
define('SECURE_AUTH_KEY',  '0PTIZq9aVjOoaoLeMYdBOg72aAL5j3FatTYVoRQZO9hZ6kKkscAl5qc2NVwKmgeFTtdMrWkHcp/XuFzdo7+nLQ==');
define('LOGGED_IN_KEY',    'l2AzWI9sNoeyc6G+5IQxyLg7zi0pdXbUKn7aNEQl7dlpXm2GJkb0LuetK57IZab2KDyCU0inXAkxRFbanG8BWg==');
define('NONCE_KEY',        'YKja4OND8rnfRx8NyuAuUH/oNDexPLGbJF94vS9SWhwsY8X3DuDTLyIIppDx0eRPixNKSE/wrdhNa5dkg/ujsQ==');
define('AUTH_SALT',        'Cu8uAcyH6YfobebuHuOdEPJMWEX5qc+nyV4zjfx/dXZD1dxBj+aA+cIDcywRqJC/gtzAZif/hIGBf68EMobjJA==');
define('SECURE_AUTH_SALT', 'ssnvX4kcwFamuz8TQpX8Yqi7yq6j7FzCZ3/04KMZm2ejm16KydSnk0cK65Phgxjd0XJCb3s+8hCGn8Vn1ZXPlQ==');
define('LOGGED_IN_SALT',   'AUL3zeeobTsCnBRsDI/QClFrjyMpaLib4UrobqJlD3tzG+oi6IsuCp9aFVmnSRz42DU1SEI3AxoyPXBvfeodwQ==');
define('NONCE_SALT',       'prfhwFRwQ1uhSS4tfJJMk6LlmiZ94oRTitS92VzKTDolAINxRFO7dGO8hi4xfeqpzaZbrnMgW8P9kgpGgingug==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
