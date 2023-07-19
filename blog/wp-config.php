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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'blog_mysittivacation');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'mYsiTTi341Com');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('FS_METHOD', 'direct');
/* That's all, stop editing! Happy blogging. */
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ':Vd!=z|_/in0p<=[L2g2mnMv$-ps{lVI+?`=4UX[;F2RnT_Ka%i&.y]qqi{U_QWw');
define('SECURE_AUTH_KEY',  '-80F+WsPO0Q)@tc)yPh/(fws]U=JUcYd.+eXoP*[@Yg/jgIhP?s`p*W~.3] $x#C');
define('LOGGED_IN_KEY',    '(5DGAeH?l3Tidy=v1< ;zZG4hA!TvKQxs z{B!I{+|?@zXF)H ,3XjT^xLETo&o4');
define('NONCE_KEY',        '<Z#4(WLvy[_RyDAl{=I^`x>gS=2%frNr[2I=d_gjw6x$^f=XzMo:xodKrVkqtxNT');
define('AUTH_SALT',        'Dvu+%gC;%)n?N)D/#@Tw.)8hQN?k=`=$AG0i_SGp%T0Ac)sY?OSpS{[b4CF`[3:x');
define('SECURE_AUTH_SALT', 'e!?YN!CDhBO)1EU?(Oid|yPd|Z.qIyYz6{Aj?i>!4Ng9DXge#gwnI)LQT!%35UEw');
define('LOGGED_IN_SALT',   'VDD2s4e9xBrSUfxXQj++u4@v+Fz)Sn;C^r?91k :rtHCOKO9eKojn:`4z2$x9(@X');
define('NONCE_SALT',       '|x6S3t}VI9.vz;df$#^>wBN bwXMLT=zd);o3RlIO(q5_n^^CMW=;$ScVS4g@%^g');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

define( 'WP_MEMORY_LIMIT', '512M' );
@ini_set( 'upload_max_size' , '300M' );
@ini_set( 'post_max_size', '13M');
@ini_set( 'memory_limit', '15M' );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
