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
define('DB_USER', 'nixsin');

/** MySQL database password */
define('DB_PASSWORD', 'nixsin');

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
define('AUTH_KEY',         'N:{zXy0~4QE;<r*]sq&GQ$A}NpV]BitTHC%Y3W-WJkcA+/|of}*h 8Z/Bjo6K~70');
define('SECURE_AUTH_KEY',  '_$(xBWZx>6PpX?.`b0%ZfAliSk91mF7-^~V,1+mw`XvOIIbk}5Ox(7TZmXf*F(u9');
define('LOGGED_IN_KEY',    'GTbq:p2ADq#,C{9Oi>Txq(5>@f9)ijN?$9 OVi{OtPpo<#KIJpp#<0b10k/@n39E');
define('NONCE_KEY',        '-+UL,FA}T?S$APb,9w<|*>_%tc,mY8LqLM>Xpi6G:C{lL95-!W-_D.!bJcMQ%qjO');
define('AUTH_SALT',        '&3^5uU#FneT*PF&$JFC=Eit-1q7|mJH>_ra=>R$ V4cIJ~CMq{sE5WASb!zffC91');
define('SECURE_AUTH_SALT', ' `Yek{X0F#,qi2{<7Fl$|~k+IQc/s*(LF:6|A8!ql!C||iV78!{^}2dEwnlLdlk0');
define('LOGGED_IN_SALT',   '!$z^(1|? U:-BE-yCW7&-[MUVy<v&[%zhf[[_o1s0-D@n!_5vvI&ASuaSYORxT}3');
define('NONCE_SALT',       'Fux`]@c?=e^D=uZ^If?W_mizTnv MA5uxG(_=?7i}5_w,=0A7a fExb-1&7fhxjB');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
