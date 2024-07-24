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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wpdb' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '|uYv9 _YMBMq4$WSX{<EKL>*<=y/>& 64V[.#2F&l7UeG2To+vs96?;}#Q{^+Hia' );
define( 'SECURE_AUTH_KEY',   ' `ejylt*8G|pQt;DV4&5_$wKR6|r&S0fk(U,-$fzn7|Fl7=e!0Iz-4|S!`{3LjjC' );
define( 'LOGGED_IN_KEY',     '*X.Tb6{FsKE(:>cNXG:5=R3Xwg55M{w?ud!G.mpqX=|:Tfcx.|k)K$ZyWI{)2oFZ' );
define( 'NONCE_KEY',         'u2C#svCaHv!Vv*K##;T_N&{W~Lgc3oK8t<^$y#yz[Ib-]*0<v&f1`@.n9p^51j/n' );
define( 'AUTH_SALT',         'alu2%(0,Ix[ivSl:y%4~d+3K6!o2Q~.D=,szJvk>$FnSvJ3aG985N7lONK~uFBjh' );
define( 'SECURE_AUTH_SALT',  'B#]QVyPV<ohRw?N}H#i^TNURmXZg:Z-Us~Rj]PGg7;!vCV)2He-~utO)f4P?T*p;' );
define( 'LOGGED_IN_SALT',    'iR&P-N--f_C$,d!B`}bCP=q2ljG+t/9rFL#9056Nhuo)E)H|zQd%FN6&O%Vm9J0/' );
define( 'NONCE_SALT',        '$FR6)bV/l!$;XTCe{qmU%SRZ+A(7Cu&Y~(.)G!SK W(pi[|av*/90$gqFr&;Z_=4' );
define( 'WP_CACHE_KEY_SALT', 'Rq?BAuko-wD j:*,W(=u+aYy>WR</N8(lzpudv/mGYt83Y~zaCJgiq|ez/pQ1.^+' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
