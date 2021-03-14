<?php
define('WP_CACHE', true);
define('WP_MEMORY_LIMIT', '128M');

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
define( 'DB_USER', 'azureuser@oud-database' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Oud@123456789' );

/** MySQL hostname */
define( 'DB_HOST', 'oud-database.mysql.database.azure.com' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secey/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('AUTH_KEY',         'cm}-FrI-TL}#pu1uFtO:R[[xTN|&<xe|HfsD/5g8r)P9M*v;wv+/>s^[QLgWVf{I');
define('SECURE_AUTH_KEY',  'hnlJyRPEy|+_Q86?W>@1S[`G|=kV=fk*BX@a7;3_XEg^3-GX-uz@SZD@px,Dk.x)');
define('LOGGED_IN_KEY',    'c{*JLYO{j#|`4E+j~UXrsz3YK,h&+czT/+XJo6qD,|B+K:pQHHg#W40oI]QCaIlN');
define('NONCE_KEY',        ')k#-Y-GpS,0T S8pNk&2A]C$;@60|{>cFzw/4+uRAAFRVO+@vn>PC6Y-@>5cdB~n');
define('AUTH_SALT',        'Gc/*FD)$}vlda1t(@4rg6~h+Vvs<+O[?92^m.1c!)+H]oZ]}/ dH4<<t&5&J%.7m');
define('SECURE_AUTH_SALT', ';M r};MkY9EK1VVvO$H>PsZWM6>bjO#^Fl*PrLq&XYGAIQ(NzW/$0h_|vs,FCMQz');
define('LOGGED_IN_SALT',   '-amKV*M#E|K;Nx/>@PuW7%hi~>zY0/k9g ^<E^0R@V9Is{b@k&OSQjT!4Et[Q=q$');
define('NONCE_SALT',       'xY-(A{qnF0>2=!Uts9 `8iE{4mxiG+-h[qLu1sq gW0_zn<brmTMgWM`J$+[n4w+');

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
