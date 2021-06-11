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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'SbFEUJ*pSe/(S:C[hcDKN[rVV8)8f`H)AQX!8a=r2zn7!KTpN;bTw7()i`#jpH7.' );
define( 'SECURE_AUTH_KEY',  '1I)mgiun0X{1FLgxX|A&M@_/Ste/)7hm1[78cuj)W|Pg) &8TCjV`cKf7}@bJ5B?' );
define( 'LOGGED_IN_KEY',    '%I<4 ?@T*knKp9=xIYl6`FJ6VXha/G*D8_$ToPT^@EO,Pa@#cKp/Jt$%UB,#Sd=K' );
define( 'NONCE_KEY',        '8=WO]0xGL0Ntebusvv`7HUGYf%0:l;Q>`Gj/&/GYm[mR)Dea(^X7Jd)T34C%WO?g' );
define( 'AUTH_SALT',        'VcT&1S=]!/5_&N)Ra%tY8ol=6R9O4>#nmFNr$=Z*NYbB>Z#7Wz&grtI,_s1v`7MN' );
define( 'SECURE_AUTH_SALT', 'XT%emualk({kGh i#PWsWvCrk!CUK2p6mmKwwK0nMxbR:fos2e=2NdS]Q5uLfk!b' );
define( 'LOGGED_IN_SALT',   '5WtD[S4xYPI_Fl4$BY{~Q`&PYy)4prkuG[I7m`LQ20AkdJ7;SISC4YQ~]k|8r)|K' );
define( 'NONCE_SALT',       'a1}%E|RjFKT`]yc?-rc#K&%(M i:AjkJl/Rujhj- mMSQ4czLuJzY1{3a!:Kg_*K' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
