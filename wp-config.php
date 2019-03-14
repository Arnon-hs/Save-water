<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'Save_water' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost:3308' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ';DoZfYpC;L7<S%i#zk|Gi%9BLR0p<DcGUA8tg|uOu?M)=%/U99^TpZIfkb*vxuZj' );
define( 'SECURE_AUTH_KEY',  'BNuIfnf-qn{P65F~mhh-%h{8C.4pM6yE%*mcgYlk[ uN/*30Mvtz^7v9Cxh@I{.#' );
define( 'LOGGED_IN_KEY',    'v*I};=B/hpRq4bVR>%/5MOdyf?JrN@~=Dln9zawX/@*}t# HE.J2m10l6dGH3e19' );
define( 'NONCE_KEY',        '>pqpPgf%%2+!ZQ<fZShDLp;:}/Q{q42kqWr)i^~HsI}>ao^aN2D[%JZL=IQz6&1)' );
define( 'AUTH_SALT',        'l&V:]8+MYQ6}=BZe%0r/Oq7>2#s@X%qp2MhtcWyIa+S_hC54!}jYpWR3 7U%UZ)p' );
define( 'SECURE_AUTH_SALT', 'BORO_.HFu.5U(w)llag*fgkTRd?mjqnim[6~9(slUzp&9J3wf.S$VwFWtq:tDbCH' );
define( 'LOGGED_IN_SALT',   '?<`b2(v!!23Bh> yH=LdsK09IBbqw={in(,y2<xr7PryD41*x$nyx,5=D[+U[cdK' );
define( 'NONCE_SALT',       'oUU/k9:$:697gs^8mQ[dshl(Nv2ukT&LAsNLu#w|%#md]!:qBdI`:v}.O?mDL%N6' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
