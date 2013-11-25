<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'l;T[j9q4GUs5F+d_0{@MwaN&+Tm<:28)z84_R:P{dh,|x.[fzo+aKwWqryCysf3f');
define('SECURE_AUTH_KEY',  '%c7uoOf255O],zNOfY@gNSsb~By|x|jRG84rc)eV]b]kGSV^ZEz)C3aZd)Vo}b3s');
define('LOGGED_IN_KEY',    'qupo2]zxzUa!yR_ma;L$l:5~F<5WR|?m<Xe+OSS3p~3B9H0Bo{%&fkhmPNdub-A ');
define('NONCE_KEY',        'aPY*bb4!cbI~tHvcNk_ep6!|zqeJrM3*>-,q;p0|cC|JBOZ=mb+B5hibJKH+s;0;');
define('AUTH_SALT',        'RBzb%+H{gRN1NGy_m/Fz3+)5qD>8Nm(*v{4|fBZVpvEXIh%OT@-X7`mJ8;n7HrFY');
define('SECURE_AUTH_SALT', 'vWxLKr!C~$46QvQ.* &vD$PUpo-4@ax^)tC~u~UwJ RVz:o5P`+;*f^LF[GUf~q-');
define('LOGGED_IN_SALT',   '3tuPi*oDYXWk|%Fw6(PPpGAjmg$vKu4a5+n=B4G_,=eac:o/<6TH[ uctr|0ab=Y');
define('NONCE_SALT',       'GTMq7SGZe@yPE_g..OYme|I*nb(flLI@eC5bq&0*/>#1VX,)=v-]X_(S$?7G-?[o');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

//* FTP Settings **/
/** wp-content path */
if(is_admin()) {
add_filter('filesystem_method', create_function('$a', 'return "direct";' ));
define( 'FS_CHMOD_DIR', 0777 );
}
