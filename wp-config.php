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
define('DB_NAME', 'globalsa_demowp');

/** MySQL database username */
define('DB_USER', 'globalsa_demo');

/** MySQL database password */
define('DB_PASSWORD', '9KLT4nsMBiy@');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'CpP$t;N8Cq![-HH]/K@^y<ijjX? E`S6VR`qLhsjkV2=Q{KBd,0xj:`?o93O,]5+');
define('SECURE_AUTH_KEY',  'M:2]Y;(aTNDVpQmwzjmc~5=MdPvrVMR,}at}x9%>eK8@#KE.LmOZ=`n|/]^=,<Gk');
define('LOGGED_IN_KEY',    'M5oa/>}U@>I%IqeYFO-qKo[oentC.MT`hLcy*Ls%hTXlPq:*|fT;nC=wTw?x(L02');
define('NONCE_KEY',        '}yM[<W ^mwHFr{u;rO)FgUFp.T7_!Ldy2r+~e k@jEj,(F~.nt^V)9G}yCCN2b~|');
define('AUTH_SALT',        'Z#^3z1fP$M&:BS4E;|hOf*?2RDq!e}qcesosfS~+Wk,sF[Q4/PZ!1JUZ<I29A7EW');
define('SECURE_AUTH_SALT', ':Tepu82vc@9/3P%X}6Tg#ZG+M/cN h61b~!NCAm<[Cc=mW6zzGAjP3fmH;UpXziN');
define('LOGGED_IN_SALT',   'Zw~@DuyR|&Ey%}M4%FX{lD`Q#2*LVg_@r2K1anWWv;]|JR@(I,we<2:t[()WUqKH');
define('NONCE_SALT',       'XPRaLA>eX 7_-hI@0SB~eq!6W`Rwue,TOB#GXg{aZ>f5jUXbriL<{Md@-*+icd?<');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wd_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
