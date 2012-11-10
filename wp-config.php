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
define('DB_NAME', getenv('MYSQL_DB_NAME'));

/** MySQL database username */
define('DB_USER', getenv('MYSQL_USERNAME'));

/** MySQL database password */
define('DB_PASSWORD', getenv('MYSQL_PASSWORD'));

/** MySQL hostname */
define('DB_HOST', getenv('MYSQL_DB_HOST'));

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** --- PHP Fog --- Set WordPress to cache requests (for Varnish) */
define('WP_CACHE', true);

/** --- PHP Fog --- Patch a few issues with file saves, plugins, etc. */
define('FS_METHOD', 'direct');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '_x)vS4_CM9(!g5!5:Un^Bu<c$c`e|]ny*EG~5mg#dlCvlDME.|DU|$^xV(=3|Y*=');
define('SECURE_AUTH_KEY',  '-2I{+t+Gt@xW7r1i1!mW>(%0tgFG2s,d?$Y=PQ<JnG|?.._o8iJ/BkPn3)Rgev+[');
define('LOGGED_IN_KEY',    'f+0a?Go 1OBp*RPS#vX_O_m,|}.*=[jpw|jsX</;A#,Ai`FKsz@h=Q~h.Yp6n(ac');
define('NONCE_KEY',        'MO>X6P/cr[K6WC *%pS/eOy9[~j n$oT_>NVXyS7qbx)D#M(atcaxoIe~8eJ{-uv');
define('AUTH_SALT',        '*n|RWJ6H36HFm-arq`:*3l5Ya(A1m=l!%&x|~;vn!+YD3RQcEH#tW.*RF?q!h!Kv');
define('SECURE_AUTH_SALT', 'Pi[>V.n?}48sXqlo@pKXi@sUlC9+J*^E~XRdO[l+oTa|Tc9d/:A.Y/+NyNnNTIm0');
define('LOGGED_IN_SALT',   'Re|P??qI%QlBbJ. Ggrds}>lwM#K=!ni0#p4Wj[DLQ5_;yJ Au>m4b25<?!jp9l]');
define('NONCE_SALT',       'Cj|,{jLhf={khP|zUH]});>(He< p8YjO4--,Bch!fU<!Ba#-1dw`Gc(mfPD2S0j');

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
