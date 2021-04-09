-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.11-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla megappolis.apps
DROP TABLE IF EXISTS `apps`;
CREATE TABLE IF NOT EXISTS `apps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_at` date DEFAULT NULL,
  `blocked_at` date DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.apps: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `apps` DISABLE KEYS */;
REPLACE INTO `apps` (`id`, `name`, `icon`, `type`, `approved_at`, `blocked_at`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'core', 'fa fa-cog', 'MAIN', '2021-04-05', NULL, 1, NULL, '2021-04-05 14:11:35'),
	(2, 'yeipi', 'fa fa-truck', 'delivery', '2021-04-05', NULL, 1, '2021-04-05 14:43:12', '2021-04-05 14:47:25');
/*!40000 ALTER TABLE `apps` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.failed_jobs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.historical
DROP TABLE IF EXISTS `historical`;
CREATE TABLE IF NOT EXISTS `historical` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lot_id` bigint(20) unsigned NOT NULL,
  `table` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifier` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.historical: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `historical` DISABLE KEYS */;
/*!40000 ALTER TABLE `historical` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.lots
DROP TABLE IF EXISTS `lots`;
CREATE TABLE IF NOT EXISTS `lots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `state` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.lots: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `lots` DISABLE KEYS */;
/*!40000 ALTER TABLE `lots` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.migrations: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2021_03_19_161233_create_peoples_table', 1),
	(5, '2021_03_19_182514_add_people_id_to_users', 1),
	(6, '2021_03_22_131220_create_pages_table', 1),
	(7, '2021_03_22_132901_create_apps_table', 1),
	(8, '2021_03_22_153051_create_lots_table', 1),
	(9, '2021_03_22_153313_create_historical_table', 1),
	(10, '2021_03_22_182656_create_roles_table', 1),
	(11, '2021_03_22_183225_create_roles_users_table', 1),
	(12, '2021_03_22_183503_create_permissions_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.pages
DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` bigint(20) unsigned NOT NULL,
  `controller` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.pages: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
REPLACE INTO `pages` (`id`, `app_id`, `controller`, `action`, `name`, `type`, `icon`, `page_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 'page', 'register', 'Registro de Paginas', 'page', NULL, 0, NULL, NULL),
	(2, 1, 'permission', 'register', 'Registro de Permisos', 'page', NULL, 0, NULL, NULL),
	(3, 1, 'page', 'index', 'Lista de páginas', 'submenu', 'fa fa-file', 0, '2021-04-05 12:04:15', '2021-04-05 12:04:15'),
	(4, 1, 'permission', 'index', 'Lista de permisos', 'submenu', 'fa fa-user-shield', 0, '2021-04-05 12:05:33', '2021-04-05 12:05:33'),
	(5, 1, 'app', 'index', 'Lista de apps', 'submenu', 'fa fa-city', 0, '2021-04-05 12:05:59', '2021-04-05 12:05:59'),
	(6, 1, 'app', 'register', 'Registro de Roles', 'page', NULL, 0, '2021-04-05 12:06:26', '2021-04-05 12:06:26'),
	(7, 1, 'role', 'index', 'Lista de roles', 'submenu', 'fa fa-user-tag', 0, '2021-04-05 12:06:58', '2021-04-05 12:06:58'),
	(8, 1, 'role', 'register', 'Registro de rol', 'page', NULL, 0, '2021-04-05 12:07:38', '2021-04-05 12:07:38'),
	(9, 1, 'user', 'index', 'Lista de usuarios', 'submenu', 'fa fa-user-friends', 0, '2021-04-05 12:16:57', '2021-04-05 12:16:57'),
	(10, 1, 'user', 'register', 'Registro de usuario', 'page', NULL, 0, '2021-04-05 12:17:38', '2021-04-05 12:17:38'),
	(11, 1, 'home', 'index', 'Core', 'menu', NULL, 0, '2021-04-05 15:37:35', '2021-04-05 15:37:35'),
	(12, 2, 'home', 'index', 'Yeipi', 'menu', NULL, 0, '2021-04-05 16:10:50', '2021-04-05 16:10:50');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.peoples
DROP TABLE IF EXISTS `peoples`;
CREATE TABLE IF NOT EXISTS `peoples` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otherName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otherLastName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateBirth` date NOT NULL,
  `country` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.peoples: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `peoples` DISABLE KEYS */;
/*!40000 ALTER TABLE `peoples` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.permissions
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `page_id` bigint(20) unsigned NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.permissions: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
REPLACE INTO `permissions` (`id`, `role_id`, `page_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'view', NULL, NULL),
	(2, 1, 2, 'view', NULL, NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.roles: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
REPLACE INTO `roles` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
	(1, 'CORE-MEGAPPOLIS', 'MAIN', NULL, NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.roles_users
DROP TABLE IF EXISTS `roles_users`;
CREATE TABLE IF NOT EXISTS `roles_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.roles_users: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `roles_users` DISABLE KEYS */;
REPLACE INTO `roles_users` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, NULL);
/*!40000 ALTER TABLE `roles_users` ENABLE KEYS */;

-- Volcando estructura para tabla megappolis.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `people_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_people_id_foreign` (`people_id`),
  CONSTRAINT `users_people_id_foreign` FOREIGN KEY (`people_id`) REFERENCES `peoples` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.users: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `people_id`) VALUES
	(1, 'alex', 'raaz11chip@gmail.com', NULL, '$2y$10$MPBQpOLVc2yXvZwHAoEdu.//8aOXPvFEpoK.qynSm4QuOMLiTFhJq', NULL, '2021-04-05 13:41:32', '2021-04-05 13:41:32', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
