<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
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
define( 'DB_NAME', 'infobondowoso' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '.[MVkr-; mf+<gA.Rt)>yyD9QU#4s*Po@_3-]3&b0oJE_gbNYp)Pq/26)3WVmP.s' );
define( 'SECURE_AUTH_KEY',  'tU663$>%{;mhi6hLLLp9b$Lj|+W)!~>VFx=B:`TS!YC}iit^%_*]>p3NAwO|-E2N' );
define( 'LOGGED_IN_KEY',    '%kIZ[69}MsaPZ<Fpl0x=;^wUw+|I5p/ SMKm*X&jaS;fJc}ui.g~jAq-hrRqs$Gi' );
define( 'NONCE_KEY',        '+ZsqTVO/W= >T]1SH9$Xi*_`L/QCa$b(^wH@QH}jzJE7HyuFJ@i!Gue{0}P;4EB9' );
define( 'AUTH_SALT',        'zVYZE.~G0z:bW7TPWfM8ZYJq)p},;f4qB&~Vjgvh;,;n&p|=|M%Kp^?E.wo3XH3d' );
define( 'SECURE_AUTH_SALT', 'Kx;DY,!jY`@]?b-s@[=Ia15x)Peb]wpW.SXKRFrUM#w6:Hv;{TW/:1rE)cc^%P]s' );
define( 'LOGGED_IN_SALT',   'bcjT&Bf4,jenwAeP-$?c|B(8Zah6jk1|915$xU(hcAr>l13hjg,B%AbS#:kY Afl' );
define( 'NONCE_SALT',       ',ildY4r[o(VtZw!go}eJ_`39-#g%-nywt7s80-b_f0-1K]tE,.^Wt5wap~(<khFf' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
