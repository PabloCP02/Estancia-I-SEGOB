-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-08-2024 a las 05:25:42
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prototipo1-segob`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formularios`
--

CREATE TABLE `formularios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `formulario` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formularios`
--

INSERT INTO `formularios` (`id`, `formulario`, `created_at`, `updated_at`) VALUES
(1, 'uploads/01_1_CNGE_2023_M1_S1_VF_02mar23.xlsx', '2024-08-21 03:08:47', '2024-08-21 03:08:47'),
(2, 'uploads/01_2_CNGE_2023_M1_S2_VF_02mar23.xlsx', '2024-08-21 03:08:55', '2024-08-21 03:08:55'),
(3, 'uploads/01_3_CNGE_2023_M1_S3_VF_01jun23.xlsx', '2024-08-21 03:09:02', '2024-08-21 03:09:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historicos`
--

CREATE TABLE `historicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `inicio` date NOT NULL,
  `fin` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `historicos`
--

INSERT INTO `historicos` (`id`, `archivo`, `inicio`, `fin`, `created_at`, `updated_at`) VALUES
(12, 'completado/historico_2024-08-20.zip', '2024-08-20', '2024-08-20', '2024-08-21 01:18:25', '2024-08-21 01:23:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mensaje` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `user_id`, `receiver_id`, `mensaje`, `created_at`, `updated_at`) VALUES
(68, 21, 1, 'Soy Heriberto', '2024-08-19 16:35:19', '2024-08-19 16:35:19'),
(69, 1, 21, 'Ya puedes empezar el llenado', '2024-08-19 17:20:19', '2024-08-19 17:20:19'),
(70, 1, 27, 'Ya puedes comenzar el censo correspondiente a este año', '2024-08-21 01:20:41', '2024-08-21 01:20:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2024_04_15_131250_create_archivos_table', 3),
(22, '2014_10_12_000000_create_users_table', 4),
(23, '2014_10_12_100000_create_password_reset_tokens_table', 4),
(24, '2019_08_19_000000_create_failed_jobs_table', 4),
(25, '2019_12_14_000001_create_personal_access_tokens_table', 4),
(26, '2024_04_15_133057_create_archivos_table', 4),
(27, '2024_04_15_133057_create_formularios_table', 5),
(28, '2024_07_25_180130_create_status_table', 6),
(29, '2024_08_18_015039_create_historicos_table', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dependencia_id` bigint(20) UNSIGNED NOT NULL,
  `formulario` varchar(100) NOT NULL,
  `revision` varchar(255) DEFAULT NULL,
  `completado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `dependencia_id`, `formulario`, `revision`, `completado`, `created_at`, `updated_at`) VALUES
(1, 7, 'uploads/01_1_CNGE_2023_M1_S1_VF_02mar23.xlsx', NULL, NULL, NULL, NULL),
(2, 7, 'uploads/01_2_CNGE_2023_M1_S2_VF_02mar23.xlsx', NULL, NULL, NULL, NULL),
(3, 7, 'uploads/01_3_CNGE_2023_M1_S3_VF_01jun23.xlsx', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jessica Olvera Gordillo', 'admin@admin.com', 'Administrador', NULL, '$2y$10$bRvmQ/ylXXGRKBYMDA3xM.NeVb0U.8qD7HAlriscBWVTQeEgD7L36', 'admin', NULL, '2024-04-18 19:41:40', '2024-04-18 19:41:40'),
(5, 'María Pérez García', 'maria.perez@sefiplan.qroo.gob.mx', 'Secretaría de Finanzas y Planeación (SEFIPLAN)', NULL, '$2y$10$IUOHSd51z0k4nSsO/kWibeoo3Sm3jWHd0cpqbAJ8ktj0OKhUm575C', NULL, NULL, '2024-08-15 01:28:32', '2024-08-15 01:28:32'),
(6, 'Juan Rodríguez López', 'juan.rodriguez@sesa.qroo.gob.mx', 'Secretaría de Salud (SESA)', NULL, '$2y$10$Ajup8/fvDLamjT.0g.pUreGJa.AUbWp9ubDzQ81TcWOS2JD1h69Qu', NULL, NULL, '2024-08-15 01:29:00', '2024-08-15 01:29:00'),
(7, 'Ana Martínez Hernández', 'ana.martinez@seq.qroo.gob.mx', 'Secretaría de Educación (SEQ)', NULL, '$2y$10$z1hVoj31pPGg/1TY4wZPGuWHb5VcmDqKZtYJS0uhcGKTcj5dgss..', NULL, NULL, '2024-08-15 01:29:25', '2024-08-15 01:29:25'),
(8, 'Luis González Ruiz', 'luis.gonzalez@sedetur.qroo.gob.mx', 'Secretaría de Turismo (SEDETUR)', NULL, '$2y$10$kfynyE9e6JWNITduRJDt0Oh/RIz4RBRW3/okc8mQ.bQoMKELxfQxG', NULL, NULL, '2024-08-15 01:29:46', '2024-08-15 01:29:46'),
(9, 'Patricia Morales Díaz', 'patricia.morales@sedeso.qroo.gob.mx', 'Secretaría de Desarrollo Social (SEDESO)', NULL, '$2y$10$BxT5VAT3dertdUgQKtNYHOWWOyTFSgYh/e7fhXmhgHyuw8Roy.hju', NULL, NULL, '2024-08-15 01:30:09', '2024-08-15 01:30:09'),
(10, 'Laura Jiménez Torres', 'laura.jimenez@iqm.qroo.gob.mx', 'Instituto Quintanarroense de la Mujer (IQM)', NULL, '$2y$10$E4HY2uBfSroPQbAc6QCFhuyQ7E42KNcB6YikDrRIUTsPTGMcB2cWK', NULL, NULL, '2024-08-15 01:30:47', '2024-08-15 01:30:47'),
(11, 'Carlos Vázquez Romero', 'carlos.vazquez@sede.qroo.gob.mx', 'Secretaría de Desarrollo Económico (SEDE)', NULL, '$2y$10$jx1UafClQKYu9/ayPZUt0eiZd72ShavBrtl9avqx4G5IxELd95L0i', NULL, NULL, '2024-08-15 01:31:11', '2024-08-15 01:31:11'),
(12, 'Roberto Sánchez Ramírez', 'roberto.sanchez@ssp.qroo.gob.mx', 'Secretaría de Seguridad Pública (SSP)', NULL, '$2y$10$VlNOSUGcma9RdPDCtgYTJ.ZZaUVK8a/7pZzcRvAQLrNosOjkM3cia', NULL, NULL, '2024-08-15 01:31:37', '2024-08-15 01:31:37'),
(13, 'Gabriela Fernández Ortega', 'gabriela.fernandez@sema.qroo.gob.mx', 'Secretaría de Ecología y Medio Ambiente (SEMA)', NULL, '$2y$10$mwgyK4pXXu4LCaw9gK8h5ujq83kLFyHQ/2aGAZ6EAJHRDVgfoKpZ6', NULL, NULL, '2024-08-15 01:32:02', '2024-08-15 01:32:02'),
(14, 'Ricardo Torres Pérez', 'ricardo.torres@sintra.qroo.gob.mx', 'Secretaría de Infraestructura y Transporte (SINTRA)', NULL, '$2y$10$jCreqwvLkV4i8BOYEQOOretU18EHOXde/PnTFGKWdyOvfcGak9a.C', NULL, NULL, '2024-08-15 01:32:28', '2024-08-15 01:32:28'),
(27, 'Dra. Ingrid Citlalli Suárez McLiberty', 'upb@upb.edu.mx', 'Universidad Politécnica de Bacalar', NULL, '$2y$10$LzOwhXuAAuh8Llbeuh9CCeK3tn4Y5GfNna4ow4j2gczDsjiesz5DC', NULL, NULL, '2024-08-21 01:19:46', '2024-08-21 01:19:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `formularios`
--
ALTER TABLE `formularios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historicos`
--
ALTER TABLE `historicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mensajes_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formularios`
--
ALTER TABLE `formularios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historicos`
--
ALTER TABLE `historicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
