<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'basic' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         'kBA9sPX4q}CSAo&,pCqTC9GR,D!wVDt?-7rWPk|y34%$uw|RU*qrtFLAy[D@GVbf' );
define( 'SECURE_AUTH_KEY',  '1P-!^Kr@VZlHo71aR/!7!`OVr*F1Rjbu[tbCur`D%io4!/:=aBk~^Mm+j|#1F{)4' );
define( 'LOGGED_IN_KEY',    'AJe0%0~rulI,Zl!v{|f()J&hiIKE-Nc+>0Bq}! O}j;SQF>])C1teurwcNH_mKnC' );
define( 'NONCE_KEY',        'S2~c^XHfXxu7SJ&qcxKXUbqDMob9COQKS-y9Ww!H,9!:BQT 6S6h<_Knwe6;!gF]' );
define( 'AUTH_SALT',        '5Fjc8ira6oIf K7]NZEVvZ]d`Aq^?mdlQZ4)=mQm/1&?h+xHifj=vTair)a)(;hY' );
define( 'SECURE_AUTH_SALT', ')J|l-f@NO3WEoo{aHfDE j% ~OnDhmFk8(6}zepcj8*u wnE{&U/7nr{:BuwZe|?' );
define( 'LOGGED_IN_SALT',   '7^,C=h(;ta>le4^JC~ZJ#)2l)-dwi[}g4RkS8(JC6>:0NzS%D`kW*M V?.l}eCpl' );
define( 'NONCE_SALT',       'rH_F<w1lDUQsyq>Wzl1SGwP/-@o06+JYLeGVGTz7uO}Jcr2Yh+zNxOgcDxMhqX7(' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
