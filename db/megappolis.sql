-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.21-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.3.0.6363
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para megappolis
CREATE DATABASE IF NOT EXISTS `megappolis` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `megappolis`;

-- Volcando estructura para tabla megappolis.apps
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
REPLACE INTO `apps` (`id`, `name`, `icon`, `type`, `approved_at`, `blocked_at`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'core', 'fa fa-cog', 'MAIN', '2021-04-05', NULL, 1, NULL, '2021-04-05 18:11:35'),
	(2, 'yeipi', 'fa fa-truck', 'delivery', '2021-04-05', NULL, 1, '2021-04-05 18:43:12', '2021-04-05 18:47:25');

-- Volcando estructura para tabla megappolis.failed_jobs
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

-- Volcando estructura para tabla megappolis.historical
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

-- Volcando estructura para tabla megappolis.lots
CREATE TABLE IF NOT EXISTS `lots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `state` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.lots: ~0 rows (aproximadamente)

-- Volcando estructura para tabla megappolis.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.migrations: ~29 rows (aproximadamente)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2021_03_19_161233_create_peoples_table', 2),
	(5, '2021_03_19_182514_add_people_id_to_users', 2),
	(6, '2021_03_22_131220_create_pages_table', 2),
	(7, '2021_03_22_132901_create_apps_table', 2),
	(8, '2021_03_22_153051_create_lots_table', 2),
	(9, '2021_03_22_153313_create_historical_table', 2),
	(10, '2021_03_22_182656_create_roles_table', 2),
	(11, '2021_03_22_183225_create_roles_users_table', 2),
	(12, '2021_03_22_183503_create_permissions_table', 2),
	(13, '2021_04_12_140850_alter_role_table', 2),
	(14, '2021_05_05_190926_alter_peoples_table', 2),
	(15, '2021_04_08_184532_create_customers_table', 3),
	(16, '2021_04_08_194541_create_deliveries_table', 4),
	(17, '2021_04_08_201429_create_shops_table', 5),
	(18, '2021_04_08_201459_create_contracts_table', 6),
	(19, '2021_04_08_201520_create_orders_table', 7),
	(20, '2021_04_08_201612_create_details_table', 8),
	(21, '2021_04_16_163418_alter_order_table', 9),
	(22, '2021_04_19_001534_alter_deliveries_table', 10),
	(23, '2021_04_19_002755_alter_details_table', 11),
	(24, '2021_04_19_125502_create_products_table', 12),
	(25, '2021_04_19_133054_create_stocks_table', 13),
	(26, '2021_04_19_140412_alter_details_table', 14),
	(27, '2021_04_20_224502_create_provider_table', 15),
	(28, '2021_04_20_225016_alter_shop_table', 16),
	(29, '2021_04_20_234035_alter_customer_table', 17);

-- Volcando estructura para tabla megappolis.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` bigint(20) unsigned NOT NULL,
  `controller` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.pages: ~38 rows (aproximadamente)
REPLACE INTO `pages` (`id`, `app_id`, `controller`, `action`, `name`, `type`, `icon`, `page_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 'page', 'register', 'Registro de Paginas', 'page', NULL, 0, NULL, NULL),
	(2, 1, 'permission', 'register', 'Registro de Permisos', 'page', NULL, 0, NULL, NULL),
	(3, 1, 'page', 'index', 'Páginas', 'menu', 'fa fa-file', 0, '2021-04-05 16:04:15', '2021-11-10 04:57:22'),
	(4, 1, 'permission', 'index', 'Permisos', 'menu', 'fa fa-user-shield', 0, '2021-04-05 16:05:33', '2021-11-10 04:56:14'),
	(5, 1, 'app', 'index', 'Apps', 'menu', 'fa fa-city', 0, '2021-04-05 16:05:59', '2021-11-10 04:56:58'),
	(6, 1, 'app', 'register', 'Registro de Roles', 'page', NULL, 0, '2021-04-05 16:06:26', '2021-04-05 16:06:26'),
	(7, 1, 'role', 'index', 'Roles', 'menu', 'fa fa-user-tag', 0, '2021-04-05 16:06:58', '2021-11-10 04:56:44'),
	(8, 1, 'role', 'register', 'Registro de rol', 'page', NULL, 0, '2021-04-05 16:07:38', '2021-04-05 16:07:38'),
	(9, 1, 'user', 'index', 'Usuarios', 'menu', 'fa fa-user-friends', 0, '2021-04-05 16:16:57', '2021-11-10 04:56:32'),
	(10, 1, 'user', 'register', 'Registro de usuario', 'page', NULL, 0, '2021-04-05 16:17:38', '2021-04-05 16:17:38'),
	(11, 1, 'home', 'index', 'Core', 'app', NULL, 0, '2021-04-05 19:37:35', '2021-11-10 04:54:44'),
	(12, 2, 'home', 'index', 'Yeipi', 'app', NULL, 0, '2021-04-05 20:10:50', '2021-11-10 04:55:01'),
	(13, 1, 'people', 'index', 'Personas', 'menu', 'fa fa-users', 0, '2021-04-12 16:09:09', '2021-11-10 04:55:58'),
	(14, 1, 'people', 'register', 'Registro de Personas', 'page', NULL, 0, '2021-04-12 16:10:50', '2021-04-12 16:10:50'),
	(15, 2, 'comprar', 'index', 'Inicio', 'submenu', 'fa fa-home', 34, '2021-04-12 16:22:30', '2021-11-10 05:31:31'),
	(16, 2, 'entregar', 'index', 'Inicio', 'submenu', 'fa fa-home', 36, '2021-04-12 16:26:45', '2021-11-10 06:14:52'),
	(17, 2, 'proveer', 'index', 'Inicio', 'submenu', 'fa fa-home', 37, '2021-04-12 16:28:21', '2021-11-10 06:16:48'),
	(19, 2, 'detail', 'register', 'Detalles', 'submenu', NULL, 33, '2021-04-15 22:57:15', '2021-11-10 06:11:56'),
	(20, 2, 'entregar', 'register', 'Registro de Pedido', 'page', NULL, 36, '2021-04-16 19:32:31', '2021-11-10 06:24:37'),
	(21, 2, 'shop', 'index', 'Proveedores', 'submenu', 'fa fa-star', 33, '2021-04-16 21:55:21', '2021-11-10 06:26:41'),
	(22, 2, 'shop', 'register', 'Registro de Proveedor', 'page', NULL, 33, '2021-04-16 21:56:08', '2021-11-10 06:27:11'),
	(23, 2, 'delivery', 'index', 'Deliveries', 'submenu', 'fa fa-user-circle', 33, '2021-04-17 00:32:30', '2021-11-10 05:22:42'),
	(24, 2, 'contract', 'index', 'Contratos', 'submenu', NULL, 33, '2021-04-17 00:52:41', '2021-11-10 05:21:54'),
	(25, 2, 'contract', 'register', 'Registro de contrato', 'page', NULL, 33, '2021-04-17 00:53:51', '2021-11-10 06:23:58'),
	(26, 2, 'home', 'register', 'Registro de Información básica', 'page', NULL, 0, '2021-10-27 22:33:01', '2021-11-10 06:23:21'),
	(27, 2, 'comprar', 'location', 'Mi Ubicación', 'submenu', 'fa fa-map-marker-alt', 34, '2021-10-28 01:27:47', '2021-11-23 00:55:52'),
	(28, 2, 'comprar', 'history', 'Histórico de Pedidos', 'submenu', 'fa fa-history', 34, '2021-10-28 01:33:36', '2021-11-10 05:32:22'),
	(29, 2, 'proveer', 'iniciar', 'Inicio de ubicación de provisión', 'page', NULL, 37, '2021-10-28 01:48:19', '2021-11-10 06:25:38'),
	(30, 2, 'proveer', 'register', 'Registro de Productos', 'page', NULL, 37, '2021-10-28 01:50:26', '2021-11-10 06:25:50'),
	(31, 2, 'product', 'index', 'Productos', 'submenu', NULL, 33, '2021-11-04 01:41:02', '2021-11-10 06:17:41'),
	(32, 2, 'comprar', 'current', 'Pedido Actual', 'page', NULL, 15, '2021-11-07 05:19:32', '2021-11-10 06:25:23'),
	(33, 2, NULL, NULL, 'Administración', 'menu', 'fa fa-table', 12, '2021-11-10 05:09:40', '2021-11-10 05:09:40'),
	(34, 2, NULL, NULL, 'Pedir', 'menu', 'fa fa-cart-plus', 12, '2021-11-10 05:27:58', '2021-11-10 06:21:23'),
	(35, 1, NULL, NULL, 'Iniciar', 'page', NULL, 0, '2021-11-10 06:10:03', '2021-11-10 06:10:03'),
	(36, 2, NULL, NULL, 'Entregar', 'menu', 'fa fa-truck', 12, '2021-11-10 06:13:11', '2021-11-10 06:14:30'),
	(37, 2, NULL, NULL, 'Proveer', 'menu', 'fa fa-project-diagram', 12, '2021-11-10 06:15:40', '2021-11-10 06:16:57'),
	(38, 2, 'proveer', 'stock', 'Stock', 'submenu', 'fa fa-store', 37, '2021-11-11 21:47:04', '2021-11-11 21:47:45'),
	(39, 2, 'proveer', 'customer', 'Consumidores', 'submenu', 'fa fa-walking', 37, '2021-11-16 22:12:09', '2021-11-16 23:40:53');

-- Volcando estructura para tabla megappolis.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.password_resets: ~0 rows (aproximadamente)

-- Volcando estructura para tabla megappolis.peoples
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
  `documentNumber` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.peoples: ~0 rows (aproximadamente)
REPLACE INTO `peoples` (`id`, `tipo`, `name`, `otherName`, `lastName`, `otherLastName`, `dateBirth`, `country`, `city`, `phone`, `sex`, `created_at`, `updated_at`, `documentNumber`) VALUES
	(1, 'HUM', 'Roger', 'Alexandro', 'Arce', 'Zeballos', '1994-04-11', 'Bolivia', 'La Paz', '60125591', 'M', '2021-04-12 16:11:36', '2021-10-28 01:27:46', '9126497');

-- Volcando estructura para tabla megappolis.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `page_id` bigint(20) unsigned NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.permissions: ~17 rows (aproximadamente)
REPLACE INTO `permissions` (`id`, `role_id`, `page_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 1, 11, 'view', NULL, NULL),
	(2, 1, 3, 'view', NULL, NULL),
	(3, 1, 4, 'view', NULL, NULL),
	(4, 1, 2, 'view', NULL, NULL),
	(5, 1, 1, 'view', '2021-10-27 22:07:45', '2021-10-27 22:07:45'),
	(6, 1, 5, 'view', '2021-10-27 22:16:44', '2021-10-27 22:16:44'),
	(7, 1, 7, 'view', '2021-10-27 22:17:27', '2021-10-27 22:17:27'),
	(8, 1, 9, 'view', '2021-10-27 22:18:08', '2021-10-27 22:18:08'),
	(9, 1, 13, 'view', '2021-10-27 22:32:44', '2021-10-27 22:32:44'),
	(10, 2, 26, 'view', '2021-10-28 01:19:09', '2021-10-28 01:19:09'),
	(11, 2, 27, 'view', '2021-10-28 01:28:41', '2021-10-28 01:28:41'),
	(12, 2, 15, 'view', '2021-10-28 01:33:22', '2021-10-28 01:33:22'),
	(13, 4, 29, 'view', '2021-10-28 01:49:32', '2021-10-28 01:49:32'),
	(14, 4, 30, 'view', '2021-10-28 01:50:49', '2021-10-28 01:50:49'),
	(15, 2, 28, 'view', '2021-11-04 01:11:29', '2021-11-04 01:11:29'),
	(16, 2, 18, 'view', '2021-11-04 01:37:05', '2021-11-04 01:37:05'),
	(17, 1, 31, 'view', '2021-11-04 01:41:20', '2021-11-04 01:41:20'),
	(18, 1, 17, 'view', '2021-11-05 02:14:58', '2021-11-05 02:14:58'),
	(19, 2, 32, 'view', '2021-11-08 19:03:58', '2021-11-08 19:03:58'),
	(20, 4, 38, 'view', '2021-11-11 22:16:33', '2021-11-11 22:16:33'),
	(21, 4, 39, 'view', '2021-11-16 22:15:10', '2021-11-16 22:15:10');

-- Volcando estructura para tabla megappolis.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `app_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.roles: ~4 rows (aproximadamente)
REPLACE INTO `roles` (`id`, `name`, `type`, `created_at`, `updated_at`, `app_id`) VALUES
	(1, 'CORE-MEGAPPOLIS', 'MAIN', NULL, '2021-04-12 18:20:41', 1),
	(2, 'YEIPI-CUSTOMER', 'USER', '2021-04-12 18:43:16', '2021-04-12 18:43:16', 2),
	(3, 'YEIPI-DELIVERY', 'USER', '2021-04-12 18:44:03', '2021-04-12 18:44:59', 2),
	(4, 'YEIPI-PROVIDER', 'USER', '2021-04-12 18:44:36', '2021-04-12 18:44:36', 2);

-- Volcando estructura para tabla megappolis.roles_users
CREATE TABLE IF NOT EXISTS `roles_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.roles_users: ~4 rows (aproximadamente)
REPLACE INTO `roles_users` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(2, 1, 1, NULL, NULL),
	(5, 2, 1, '2021-04-12 19:07:22', '2021-04-12 19:07:22'),
	(6, 3, 1, '2021-04-16 18:55:54', '2021-04-16 18:55:54'),
	(8, 4, 1, '2021-11-04 01:52:13', '2021-11-04 01:52:13');

-- Volcando estructura para tabla megappolis.users
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

-- Volcando datos para la tabla megappolis.users: ~0 rows (aproximadamente)
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `people_id`) VALUES
	(1, 'Alex', 'raaz11chip@gmail.com', NULL, '$2y$10$3Ic/tnDuFgSUd/9S90yjyOUpXICr1/sEhU6PwF00DutULVvL59Ha6', NULL, '2021-10-27 02:02:09', '2021-10-27 02:02:09', 1);

-- Volcando estructura para tabla megappolis.yeipi_contracts
CREATE TABLE IF NOT EXISTS `yeipi_contracts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` bigint(20) unsigned NOT NULL,
  `delivery_id` bigint(20) unsigned NOT NULL,
  `empieza` datetime NOT NULL,
  `acaba` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.yeipi_contracts: ~0 rows (aproximadamente)

-- Volcando estructura para tabla megappolis.yeipi_customers
CREATE TABLE IF NOT EXISTS `yeipi_customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `people_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `direccion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitud` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitud` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.yeipi_customers: ~0 rows (aproximadamente)
REPLACE INTO `yeipi_customers` (`id`, `people_id`, `created_at`, `updated_at`, `direccion`, `latitud`, `longitud`) VALUES
	(1, 1, '2021-10-28 01:27:46', '2021-10-28 01:29:33', 'Posta Llojeta Nº100, Avenida Mario Mercado, Bajo Llojeta, Cotahuma, La Paz, Pedro Domingo Murillo, La Paz, Bolivia', '-16.50572', '-68.14293');

-- Volcando estructura para tabla megappolis.yeipi_deliveries
CREATE TABLE IF NOT EXISTS `yeipi_deliveries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `people_id` bigint(20) unsigned NOT NULL,
  `puntuacion` tinyint(4) NOT NULL,
  `valoracion` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount` decimal(5,2) DEFAULT 2.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.yeipi_deliveries: ~0 rows (aproximadamente)

-- Volcando estructura para tabla megappolis.yeipi_details
CREATE TABLE IF NOT EXISTS `yeipi_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(10) unsigned NOT NULL DEFAULT 1,
  `precio` decimal(8,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fechaConseguido` date DEFAULT NULL,
  `fechaNoConseguido` date DEFAULT NULL,
  `stock_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.yeipi_details: ~2 rows (aproximadamente)
REPLACE INTO `yeipi_details` (`id`, `order_id`, `descripcion`, `cantidad`, `precio`, `created_at`, `updated_at`, `fechaConseguido`, `fechaNoConseguido`, `stock_id`) VALUES
	(1, 1, '', 1, 2.5000, '2021-11-20 02:27:33', '2021-11-20 02:42:31', NULL, NULL, 1),
	(2, 1, '', 1, 12.0000, '2021-11-20 02:27:39', '2021-11-20 02:27:39', NULL, NULL, 6);

-- Volcando estructura para tabla megappolis.yeipi_orders
CREATE TABLE IF NOT EXISTS `yeipi_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `delivery_id` bigint(20) unsigned DEFAULT NULL,
  `fechaSolicitud` datetime DEFAULT NULL,
  `fechaSalida` datetime DEFAULT NULL,
  `fechaEntrega` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fechaRecepcion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.yeipi_orders: ~0 rows (aproximadamente)
REPLACE INTO `yeipi_orders` (`id`, `customer_id`, `delivery_id`, `fechaSolicitud`, `fechaSalida`, `fechaEntrega`, `created_at`, `updated_at`, `fechaRecepcion`) VALUES
	(1, 1, NULL, NULL, NULL, NULL, '2021-11-20 02:26:20', '2021-11-20 02:26:20', NULL);

-- Volcando estructura para tabla megappolis.yeipi_products
CREATE TABLE IF NOT EXISTS `yeipi_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.yeipi_products: ~2 rows (aproximadamente)
REPLACE INTO `yeipi_products` (`id`, `descripcion`, `marca`, `created_at`, `updated_at`) VALUES
	(1, 'Azucar', NULL, '2021-11-04 01:43:34', '2021-11-04 01:43:34'),
	(2, 'Arroz', NULL, '2021-11-04 01:43:38', '2021-11-04 01:43:38'),
	(3, 'Pan', NULL, '2021-11-04 01:43:55', '2021-11-04 01:43:55'),
	(4, 'Tampico (Citrus Punch) 3L', 'Delizia', '2021-11-18 19:09:40', '2021-11-18 19:09:40');

-- Volcando estructura para tabla megappolis.yeipi_provider
CREATE TABLE IF NOT EXISTS `yeipi_provider` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `people_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.yeipi_provider: ~0 rows (aproximadamente)
REPLACE INTO `yeipi_provider` (`id`, `people_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2021-10-28 01:48:19', '2021-10-28 01:48:19');

-- Volcando estructura para tabla megappolis.yeipi_shops
CREATE TABLE IF NOT EXISTS `yeipi_shops` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitud` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitud` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abre` time DEFAULT NULL,
  `cierra` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.yeipi_shops: ~0 rows (aproximadamente)
REPLACE INTO `yeipi_shops` (`id`, `nombre`, `direccion`, `latitud`, `longitud`, `abre`, `cierra`, `created_at`, `updated_at`, `provider_id`) VALUES
	(1, 'La Caserita', 'CEFI, Avenida Buenos Aires, Cotahuma, La Paz, Pedro Domingo Murillo, La Paz, 0201, Bolivia', '-16.51188', '-68.14374', '06:00:00', '22:00:00', '2021-11-05 01:05:10', '2021-11-05 01:05:10', 1);

-- Volcando estructura para tabla megappolis.yeipi_stocks
CREATE TABLE IF NOT EXISTS `yeipi_stocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `shop_id` bigint(20) unsigned NOT NULL,
  `precio` decimal(5,2) DEFAULT NULL,
  `stock` decimal(5,2) DEFAULT 1.00,
  `medida` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla megappolis.yeipi_stocks: ~5 rows (aproximadamente)
REPLACE INTO `yeipi_stocks` (`id`, `product_id`, `shop_id`, `precio`, `stock`, `medida`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 2.50, 0.00, 'pieza', '2021-11-04 01:53:26', '2021-11-20 02:42:31'),
	(2, 2, 1, 2.50, 20.00, 'pieza', '2021-11-04 01:53:43', '2021-11-04 01:53:43'),
	(3, 1, 1, 0.60, 0.00, 'libra', '2021-11-05 01:18:54', '2021-11-08 18:39:22'),
	(5, 3, 1, 0.50, 0.00, 'pieza', '2021-11-05 01:19:19', '2021-11-20 01:59:54'),
	(6, 4, 1, 12.00, 18.00, 'pieza', '2021-11-18 19:50:14', '2021-11-20 02:27:39');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
