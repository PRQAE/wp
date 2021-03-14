<?php
define( 'WP_CACHE', true );
define( 'WP_CACHE', false ); // Added by WP Rocket

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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'DqKri4Lfrmh1uW' );

/** MySQL database username */
define( 'DB_USER', 'DqKri4Lfrmh1uW' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Gyvbdc1LJ9R7wE' );

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
define( 'AUTH_KEY',          'Itwl6OsnmK%ka]GHp29DQ{8xsu,,(L!r{ ;f=tHFl,QB>pHF+9A*WVgm;t%$|{00' );
define( 'SECURE_AUTH_KEY',   'M-j*P0 whLTui#+k/<SF9<d6G7E;^6:AswAVk3$J6hG*SV0vG5fal9mzm^~+0;_X' );
define( 'LOGGED_IN_KEY',     'yTw=8&.^7J~V|UX(PsU|MSgFG*|i7mxjg;TNBt^xD8L=Ip^m4D7=^:d%-;U):},1' );
define( 'NONCE_KEY',         '[^])4iWizsrj8WB|Ai=M0s9W-XfzCM#awD1Ao-3ybQ[hwUH!JrZHN_ETUj,Uj.Zs' );
define( 'AUTH_SALT',         'ay^6i$`nx3V<$_i+#gD~Ex[vWBrSW-[c6Y7^~*fa|Ej$$Rha .bP(JYrd:bs*wI>' );
define( 'SECURE_AUTH_SALT',  't>?9^HeLC5kdF]!g%=qH/i6?eiRyrJ$e:D{MjCgNFIV]]60YkJ[UtkuDg=cJb]z,' );
define( 'LOGGED_IN_SALT',    'JDzYAjgq*q8%x:!^~@e<X74V)AU9gdO8F3:+xSWU9~G^`~/KT0l]T+cdW]xc&hk}' );
define( 'NONCE_SALT',        '=Z2Y(}/h/Jq3wy:$yw(SB&n+5[vy`DGI8)l}I`n.8i7{t;jG9sNbH{x@mfi>sH=3' );
define( 'WP_CACHE_KEY_SALT', '}9O%1{bh4c5@_{DEC]f75!}{)nn,ssYQ,!06t7#B(zyS3m,Dnh2;*Lh~c!KVZq(s' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'moud_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
//Disable File Edits
define('DISALLOW_FILE_EDIT', false);