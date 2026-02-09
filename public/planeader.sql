/*
 Navicat Premium Data Transfer

 Source Server         : ServerCeigep
 Source Server Type    : MySQL
 Source Server Version : 101103
 Source Host           : 172.21.9.73:3306
 Source Schema         : planeader

 Target Server Type    : MySQL
 Target Server Version : 101103
 File Encoding         : 65001

 Date: 25/07/2024 10:48:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `enlace` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seccion` enum('Inicio','COPLADEP','Programas Derivados','Plan Estatal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Inicio',
  `estado` enum('Activo','Inactivo','Pendiente') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendiente',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of banners
-- ----------------------------
INSERT INTO `banners` VALUES (1, 'Banner Principal del apartado de COPLADEP', 'Banners-PLANEADER (2)_20240522221831.jpg', 'Este es el banner principal de la nueva página del Planeader para el apartado de COPLADEP', '#', 'COPLADEP', 'Activo', '2024-05-22 19:45:36', '2024-05-22 22:18:31');
INSERT INTO `banners` VALUES (2, 'Banner Principal de Programas Derivados', 'Banners-PROGRAMAS-DERIVADOS (1)_20240522221824.jpg', 'Este es el banner principal de la nueva página del Planeader enfocado a los Programas Derivados', '#', 'Programas Derivados', 'Activo', '2024-05-22 19:46:34', '2024-05-22 22:18:24');
INSERT INTO `banners` VALUES (3, 'Banner Principal del Plan Estatal de Desarrollo  2019-2024', 'Banners-PED (2)_20240522221838.jpg', 'Este es el banner principal de la nueva página del Planeader enfocado al Plan Estatal de Desarrollo 2019-2024', '#', 'Plan Estatal', 'Activo', '2024-05-22 19:47:12', '2024-05-22 22:18:38');
INSERT INTO `banners` VALUES (4, 'Banner Principal de portal web de Planeación para el Desarrollo', 'Banners-PLANEADER-portada (1)_20240522223737.jpg', 'Este es el banner principal de la nueva página de la dirección de Planeación para el Desarrollo', '#', 'Inicio', 'Activo', '2024-05-22 22:19:14', '2024-05-22 22:37:37');

-- ----------------------------
-- Table structure for documentosSubcomites
-- ----------------------------
DROP TABLE IF EXISTS `documentosSubcomites`;
CREATE TABLE `documentosSubcomites`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anio` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_documento` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` enum('Informe','Acta','Programa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Informe',
  `tipo_acta` enum('Ordinaria','Extraordinaria') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `publicado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `subcomite_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `documentossubcomites_subcomite_id_foreign`(`subcomite_id`) USING BTREE,
  CONSTRAINT `documentossubcomites_subcomite_id_foreign` FOREIGN KEY (`subcomite_id`) REFERENCES `subcomites` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 251 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of documentosSubcomites
-- ----------------------------
INSERT INTO `documentosSubcomites` VALUES (1, 'Acta de la Primera Sesión Ordinaria', '2020', 'Acta Primera Sesión20240510202955.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:29:55', '2024-05-15 16:26:44', 3);
INSERT INTO `documentosSubcomites` VALUES (2, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Acta Segunda sesiòn20240510203019.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:30:19', '2024-05-15 18:51:42', 3);
INSERT INTO `documentosSubcomites` VALUES (3, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta primera sesión 202120240510203047.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:30:47', '2024-05-15 16:12:54', 3);
INSERT INTO `documentosSubcomites` VALUES (4, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Acta Segunda Sesión Ordinaria 202220240510203107.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:31:07', '2024-05-15 18:54:43', 3);
INSERT INTO `documentosSubcomites` VALUES (5, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta Primera Sesión Ordinaria 202320240510203125.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:31:25', '2024-05-15 16:27:37', 3);
INSERT INTO `documentosSubcomites` VALUES (6, 'Programa Anual de Trabajo', '2021', 'PAT 2021 Seguridad Pública, Justicia y Estado de Derecho20240510203147.pdf', 'Programa', NULL, 1, '2024-05-10 20:31:47', '2024-05-16 15:51:02', 3);
INSERT INTO `documentosSubcomites` VALUES (7, 'Programa Anual de Trabajo', '2022', 'PAT 2022 seguridad20240510203201.pdf', 'Programa', NULL, 1, '2024-05-10 20:32:01', '2024-05-16 15:51:53', 3);
INSERT INTO `documentosSubcomites` VALUES (8, 'Programa Anual de Trabajo', '2023', 'Programa Anual de Trabajo 202320240510203215.pdf', 'Programa', NULL, 1, '2024-05-10 20:32:15', '2024-05-16 15:52:31', 3);
INSERT INTO `documentosSubcomites` VALUES (9, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240510203235.pdf', 'Informe', NULL, 1, '2024-05-10 20:32:35', '2024-05-16 15:53:30', 3);
INSERT INTO `documentosSubcomites` VALUES (10, 'Informe Anual de Trabajo', '2021', 'Sectorial de Seguridad Pública, Justicia y Estado IAT20240510203252.pdf', 'Informe', NULL, 1, '2024-05-10 20:32:52', '2024-05-16 15:54:14', 3);
INSERT INTO `documentosSubcomites` VALUES (11, 'Acta de la Primera Sesión Ordinaria', '2020', '2020 Acta 1ra Sesión20240510203402.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:34:02', '2024-05-15 16:29:47', 4);
INSERT INTO `documentosSubcomites` VALUES (12, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Segunda Sesión 2020testadas20240510203428.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:34:28', '2024-05-15 18:55:42', 4);
INSERT INTO `documentosSubcomites` VALUES (13, 'Acta de la Quinta Sesión Ordinaria', '2020', 'Quinta Sesión 2020testadas20240510203456.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:34:56', '2024-05-15 18:50:04', 4);
INSERT INTO `documentosSubcomites` VALUES (14, 'Acta de la Sexta Sesión Ordinaria', '2020', 'Sexta Sesión 2020testadas20240510203515.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:35:15', '2024-05-16 00:42:29', 4);
INSERT INTO `documentosSubcomites` VALUES (15, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta Primera Sesion Ordinaria 202120240510203532.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:35:32', '2024-05-15 16:30:27', 4);
INSERT INTO `documentosSubcomites` VALUES (16, 'Acta de la Segunda Sesión Ordinaria', '2021', '2 sesión ordinaria SSRCP 202120240510203548.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:35:48', '2024-05-15 18:58:55', 4);
INSERT INTO `documentosSubcomites` VALUES (17, 'Acta de la Tercera Sesión Ordinaria', '2021', 'TERCERA SESIÓN SSRCP 202120240510203606.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:36:06', '2024-05-15 19:00:33', 4);
INSERT INTO `documentosSubcomites` VALUES (18, 'Acta de la Primera Sesión Ordinaria', '2022', 'Primera Sesión 202220240510203624.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:36:24', '2024-05-15 16:31:17', 4);
INSERT INTO `documentosSubcomites` VALUES (19, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Segunda Sesión 202220240510203639.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:36:39', '2024-05-15 19:02:04', 4);
INSERT INTO `documentosSubcomites` VALUES (20, 'Acta de la Tercera Sesión Ordinaria', '2022', 'ACTA TERCERA SESIÓN ORDINARIA20240510203657.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:36:57', '2024-05-16 15:34:35', 4);
INSERT INTO `documentosSubcomites` VALUES (21, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta Primera Sesión 202320240510203719.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:37:19', '2024-05-15 16:32:14', 4);
INSERT INTO `documentosSubcomites` VALUES (22, 'Acta de la Segunda Sesión Ordinaria', '2023', 'Acta Segunda Sesión 202320240510203736.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:37:36', '2024-05-15 19:03:51', 4);
INSERT INTO `documentosSubcomites` VALUES (23, 'Acta de la Tercera Sesión Ordinaria', '2023', 'Acta Tercer Seseon Sectorial Campo20240510203749.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 20:37:49', '2024-05-16 15:37:01', 4);
INSERT INTO `documentosSubcomites` VALUES (24, 'Programa Anual de Trabajo', '2021', 'PAT 202120240510203825.pdf', 'Programa', NULL, 1, '2024-05-10 20:38:25', '2024-05-16 15:37:47', 4);
INSERT INTO `documentosSubcomites` VALUES (25, 'Programa Anual de Trabajo', '2022', 'PAT  202220240510203837.pdf', 'Programa', NULL, 1, '2024-05-10 20:38:37', '2024-05-16 15:43:47', 4);
INSERT INTO `documentosSubcomites` VALUES (26, 'Programa Anual de Trabajo', '2023', 'PAT 2023 Desarrollo Rural20240510203846.pdf', 'Programa', NULL, 1, '2024-05-10 20:38:46', '2024-05-16 15:44:25', 4);
INSERT INTO `documentosSubcomites` VALUES (27, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240510203920.pdf', 'Informe', NULL, 1, '2024-05-10 20:39:20', '2024-05-16 15:45:56', 4);
INSERT INTO `documentosSubcomites` VALUES (28, 'Informe Anual de Trabajo', '2021', 'IAT Campo Poblano202220240510203947.pdf', 'Informe', NULL, 1, '2024-05-10 20:39:47', '2024-05-16 15:46:47', 4);
INSERT INTO `documentosSubcomites` VALUES (29, 'Informe Anual de Trabajo', '2022', 'IAT SSRCP 202220240510204003.pdf', 'Informe', NULL, 1, '2024-05-10 20:40:03', '2024-05-16 15:47:34', 4);
INSERT INTO `documentosSubcomites` VALUES (30, 'Informe Anual de Trabajo', '2023', 'Informe Anual de Trabajo 202320240510204019.pdf', 'Informe', NULL, 1, '2024-05-10 20:40:19', '2024-05-16 15:48:59', 4);
INSERT INTO `documentosSubcomites` VALUES (31, 'Programa Anual de Trabajo', '2024', 'PAT SUBCOMITÉ 2024 SDR20240510204109.pdf', 'Programa', NULL, 1, '2024-05-10 20:41:09', '2024-05-16 15:49:42', 4);
INSERT INTO `documentosSubcomites` VALUES (32, 'Acta de la Primera Sesión Ordinaria', '2020', 'Acta Primera Sesión Ordinaria 2020 testadas20240513154429.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 15:44:29', '2024-05-15 16:33:40', 5);
INSERT INTO `documentosSubcomites` VALUES (33, 'Acta de la Segunda Sesión Ordinaria', '2020', 'ACTA Segunda Sesión Ordinaria 2020_SSDE20240513154457.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 15:44:57', '2024-05-15 19:05:06', 5);
INSERT INTO `documentosSubcomites` VALUES (34, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta 1° sesión ordinaria 202120240513154558.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 15:45:58', '2024-05-15 16:35:02', 5);
INSERT INTO `documentosSubcomites` VALUES (35, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta 2° Sesión Ordinaria20240513154858.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 15:48:58', '2024-05-15 19:07:04', 5);
INSERT INTO `documentosSubcomites` VALUES (36, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta Primera Sesión Ordinaria 2022 testadas20240513155056.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 15:50:56', '2024-05-15 16:35:52', 5);
INSERT INTO `documentosSubcomites` VALUES (37, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Acta Segunda Sesión 2022 Economia20240513155144.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 15:51:44', '2024-05-15 19:08:09', 5);
INSERT INTO `documentosSubcomites` VALUES (38, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta_1°SO_2023_SSDE20240513155208.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 15:52:08', '2024-05-15 16:36:37', 5);
INSERT INTO `documentosSubcomites` VALUES (39, 'Acta de la Segunda Sesión Ordinaria', '2023', 'SS Desarrollo Económico Segunda Sesion 2023 (1)20240513155221.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 15:52:21', '2024-05-15 19:09:12', 5);
INSERT INTO `documentosSubcomites` VALUES (40, 'Acta de la Primera Sesión Ordinaria', '2024', 'Acta_1SO_2024_SSDE_Firmada20240513155351.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 15:53:51', '2024-05-15 16:37:30', 5);
INSERT INTO `documentosSubcomites` VALUES (41, 'Programa Anual de Trabajo', '2021', 'PAT 2021 Economía propuesta20240513155442.pdf', 'Programa', NULL, 1, '2024-05-13 15:54:42', '2024-05-16 00:26:58', 5);
INSERT INTO `documentosSubcomites` VALUES (42, 'Programa Anual de Trabajo', '2022', 'PAT 202220240513155452.pdf', 'Programa', NULL, 1, '2024-05-13 15:54:52', '2024-05-16 00:28:43', 5);
INSERT INTO `documentosSubcomites` VALUES (43, 'Programa Anual de Trabajo', '2023', 'Anexo 1_PAT2023_SE (Economia)20240513155504.pdf', 'Programa', NULL, 1, '2024-05-13 15:55:04', '2024-05-16 00:29:47', 5);
INSERT INTO `documentosSubcomites` VALUES (44, 'Programa Anual de Trabajo', '2024', 'Plantilla_PAT2024_SE_SSDE20240513155514.pdf', 'Programa', NULL, 1, '2024-05-13 15:55:14', '2024-05-16 00:30:26', 5);
INSERT INTO `documentosSubcomites` VALUES (50, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240513160019.pdf', 'Informe', NULL, 1, '2024-05-13 16:00:19', '2024-05-16 00:31:59', 5);
INSERT INTO `documentosSubcomites` VALUES (51, 'Informe Anual de Trabajo', '2021', 'Anexo 1_IAT2021_SSDE_SE20240513160031.pdf', 'Informe', NULL, 1, '2024-05-13 16:00:31', '2024-05-16 00:32:38', 5);
INSERT INTO `documentosSubcomites` VALUES (52, 'Informe Anual de Trabajo', '2022', 'IAT2022_SE (Economia) (1)20240513160045.pdf', 'Informe', NULL, 1, '2024-05-13 16:00:45', '2024-05-16 00:33:28', 5);
INSERT INTO `documentosSubcomites` VALUES (53, 'Informe Anual de Trabajo', '2023', 'IAT 202320240513160055.pdf', 'Informe', NULL, 1, '2024-05-13 16:00:55', '2024-05-16 00:34:14', 5);
INSERT INTO `documentosSubcomites` VALUES (54, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta Primera Sesión Ordinaria 2021testadas20240513160323.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:03:23', '2024-05-15 16:38:40', 6);
INSERT INTO `documentosSubcomites` VALUES (56, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta Segunda Sesión Ordinaria 2021testadas20240513160400.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:04:00', '2024-05-15 19:10:38', 6);
INSERT INTO `documentosSubcomites` VALUES (57, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta Primera Sesión Ordinaria 2022- testadas20240513160420.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:04:20', '2024-05-15 16:40:35', 6);
INSERT INTO `documentosSubcomites` VALUES (59, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Acta Segunda Sesión Ordinaria Disminución de las Desigualdades20240513160513.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:05:13', '2024-05-15 19:13:22', 6);
INSERT INTO `documentosSubcomites` VALUES (60, 'Acta de la Primera Sesión Ordinaria', '2023', 'ACTA1R_120240513160534.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:05:34', '2024-05-15 16:41:25', 6);
INSERT INTO `documentosSubcomites` VALUES (61, 'Acta de la Primera Sesión Extraordinaria', '2023', 'Acta Extra SSDD 2320240513160546.pdf', 'Acta', 'Extraordinaria', 1, '2024-05-13 16:05:46', '2024-05-15 18:39:34', 6);
INSERT INTO `documentosSubcomites` VALUES (62, 'Acta de la Segunda Sesión Ordinaria', '2023', 'Acta Ordinaria SSDD 2320240513160605.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:06:05', '2024-05-15 19:14:28', 6);
INSERT INTO `documentosSubcomites` VALUES (63, 'Acta de la Primera Sesión Ordinaria', '2024', 'ACTA 1RA SESIÓN 24 SSDD20240513160720.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:07:20', '2024-05-15 16:42:25', 6);
INSERT INTO `documentosSubcomites` VALUES (64, 'Programa Anual de Trabajo', '2021', 'PAT 202120240513160755.pdf', 'Programa', NULL, 1, '2024-05-13 16:07:55', '2024-05-16 00:35:07', 6);
INSERT INTO `documentosSubcomites` VALUES (65, 'Programa Anual de Trabajo', '2022', 'PAT Bienestar 2022-nov20240513160805.pdf', 'Programa', NULL, 1, '2024-05-13 16:08:05', '2024-05-16 00:36:10', 6);
INSERT INTO `documentosSubcomites` VALUES (66, 'Programa Anual de Trabajo', '2023', 'Programa Anual de Trabajo 2023 SSDD20240513160815.pdf', 'Programa', NULL, 1, '2024-05-13 16:08:15', '2024-05-16 00:36:56', 6);
INSERT INTO `documentosSubcomites` VALUES (67, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Actividades 202020240513160848.pdf', 'Informe', NULL, 1, '2024-05-13 16:08:48', '2024-05-16 00:37:39', 6);
INSERT INTO `documentosSubcomites` VALUES (68, 'Informe Anual de Trabajo', '2021', 'FORMATO IAT 2021 BIENESTAR20240513160859.pdf', 'Informe', NULL, 1, '2024-05-13 16:08:59', '2024-05-16 00:39:00', 6);
INSERT INTO `documentosSubcomites` VALUES (69, 'Informe Anual de Trabajo', '2022', 'INFORM_120240513160908.pdf', 'Informe', NULL, 1, '2024-05-13 16:09:08', '2024-05-16 00:39:44', 6);
INSERT INTO `documentosSubcomites` VALUES (70, 'Informe Anual de Trabajo', '2023', 'IAT 2023 APROBADO20240513160920.pdf', 'Informe', NULL, 1, '2024-05-13 16:09:20', '2024-05-16 00:41:26', 6);
INSERT INTO `documentosSubcomites` VALUES (71, 'Acta de la Primera Sesión Ordinaria', '2020', '2020 Acta 1ra Sesión20240513161202.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:12:02', '2024-05-15 16:43:55', 7);
INSERT INTO `documentosSubcomites` VALUES (72, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Acta SEICOPLADEP 2da Sesión 202020240513161215.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:12:15', '2024-05-15 19:17:23', 7);
INSERT INTO `documentosSubcomites` VALUES (73, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta Primera Sesión 2021testadas20240513161232.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:12:32', '2024-05-15 16:44:45', 7);
INSERT INTO `documentosSubcomites` VALUES (74, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta Segunda Sesión 2021testadas20240513161244.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:12:44', '2024-05-15 19:20:17', 7);
INSERT INTO `documentosSubcomites` VALUES (75, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta Primera Sesión 2022testadas20240513161308.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:13:08', '2024-05-15 16:48:37', 7);
INSERT INTO `documentosSubcomites` VALUES (76, 'Acta de la Segunda Sesión Ordinaria', '2022', '2. Acta 2da Sesión 2220240513161321.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:13:21', '2024-05-15 19:44:05', 7);
INSERT INTO `documentosSubcomites` VALUES (77, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta 1SO_SEICOPLADEP20240513161338.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:13:38', '2024-05-15 17:01:10', 7);
INSERT INTO `documentosSubcomites` VALUES (78, 'Acta de la Segunda Sesión Ordinaria', '2023', 'ACTA2S-1123 (1)20240513161350.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:13:50', '2024-05-15 19:44:55', 7);
INSERT INTO `documentosSubcomites` VALUES (79, 'Programa Anual de Trabajo', '2021', 'PAT 202120240513161425.pdf', 'Programa', NULL, 1, '2024-05-13 16:14:25', '2024-05-15 23:44:44', 7);
INSERT INTO `documentosSubcomites` VALUES (80, 'Programa Anual de Trabajo', '2022', 'PAT2022 infra20240513161440.pdf', 'Programa', NULL, 1, '2024-05-13 16:14:40', '2024-05-15 23:45:45', 7);
INSERT INTO `documentosSubcomites` VALUES (81, 'Programa Anual de Trabajo', '2023', 'PAT 2023 SEICOPLADEP20240513161451.pdf', 'Programa', NULL, 1, '2024-05-13 16:14:51', '2024-05-15 23:46:27', 7);
INSERT INTO `documentosSubcomites` VALUES (82, 'Programa Anual de Trabajo', '2024', 'PAT 2024 (1)20240513161501.pdf', 'Programa', NULL, 1, '2024-05-13 16:15:01', '2024-05-15 23:47:12', 7);
INSERT INTO `documentosSubcomites` VALUES (83, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240513161526.pdf', 'Informe', NULL, 1, '2024-05-13 16:15:26', '2024-05-15 23:48:03', 7);
INSERT INTO `documentosSubcomites` VALUES (84, 'Informe Anual de Trabajo', '2021', 'IAT Infraestructura20240513161538.pdf', 'Informe', NULL, 1, '2024-05-13 16:15:38', '2024-05-15 23:49:02', 7);
INSERT INTO `documentosSubcomites` VALUES (85, 'Informe Anual de Trabajo', '2022', 'IAT2022_V220240513161547.pdf', 'Informe', NULL, 1, '2024-05-13 16:15:47', '2024-05-15 23:49:44', 7);
INSERT INTO `documentosSubcomites` VALUES (86, 'Acta de la Primera Sesión Ordinaria', '2019', 'Acta 1ra Sesión Ordinaria 202020240513161743.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:17:43', '2024-05-15 17:14:40', 8);
INSERT INTO `documentosSubcomites` VALUES (87, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Acta Segunda Sesión 2020testadas20240513161759.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:17:59', '2024-05-15 19:47:52', 8);
INSERT INTO `documentosSubcomites` VALUES (88, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta 1ra. Sesión IPI20240513161819.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:18:19', '2024-05-15 17:23:17', 8);
INSERT INTO `documentosSubcomites` VALUES (89, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta Segunda Sesión 2021testadas20240513161845.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:18:45', '2024-05-15 19:49:45', 8);
INSERT INTO `documentosSubcomites` VALUES (90, 'Acta de la Tercera Sesión Ordinaria', '2021', 'Acta Tercera Sesión 2021testadas20240513161858.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:18:58', '2024-05-16 00:09:09', 8);
INSERT INTO `documentosSubcomites` VALUES (91, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta Primera Sesión 2022testadas20240513161920.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:19:20', '2024-05-15 17:26:24', 8);
INSERT INTO `documentosSubcomites` VALUES (92, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Acta 2a. Sesión Subcomité Especial de Pueblos Originarios con Firmas20240513161936.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:19:36', '2024-05-15 19:53:46', 8);
INSERT INTO `documentosSubcomites` VALUES (93, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta Primera Sesión 202320240513161951.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:19:51', '2024-05-15 17:33:39', 8);
INSERT INTO `documentosSubcomites` VALUES (94, 'Programa Anual de Trabajo', '2021', 'PAT 202120240513162033.pdf', 'Programa', NULL, 1, '2024-05-13 16:20:33', '2024-05-16 00:10:53', 8);
INSERT INTO `documentosSubcomites` VALUES (95, 'Programa Anual de Trabajo', '2022', '3. 1ra Ordinaria 2022 Sub Pueblos Orig_Seguimiento PAT 202220240513162049.pdf', 'Programa', NULL, 1, '2024-05-13 16:20:49', '2024-05-16 00:12:09', 8);
INSERT INTO `documentosSubcomites` VALUES (96, 'Programa Anual de Trabajo', '2023', 'PAT 2023 (1)20240513162100.pdf', 'Programa', NULL, 1, '2024-05-13 16:21:00', '2024-05-16 00:12:47', 8);
INSERT INTO `documentosSubcomites` VALUES (97, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240513162126.pdf', 'Informe', NULL, 1, '2024-05-13 16:21:26', '2024-05-16 00:13:38', 8);
INSERT INTO `documentosSubcomites` VALUES (98, 'Informe Anual de Trabajo', '2021', '2. 1ra Ordinaria 2022 Sub Pueblos Orig_Informe 202120240513162146.pdf', 'Informe', NULL, 1, '2024-05-13 16:21:46', '2024-05-16 00:14:25', 8);
INSERT INTO `documentosSubcomites` VALUES (99, 'Acta de la Primera Sesión Ordinaria', '2020', 'Acta Primera Sesión 2020testadas20240513162521.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:25:21', '2024-05-15 17:37:41', 9);
INSERT INTO `documentosSubcomites` VALUES (100, 'Acta de la Segunda Sesión Ordinaria', '2020', 'ACTA 2da Sesion 2020 SEIS20240513162539.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:25:39', '2024-05-15 19:55:06', 9);
INSERT INTO `documentosSubcomites` VALUES (101, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta Segunda Sesión 2021testadas20240513162711.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:27:11', '2024-05-15 20:04:06', 9);
INSERT INTO `documentosSubcomites` VALUES (102, 'Acta de la Segunda Sesión Ordinaria', '2023', 'ACTA.SEGUNDA SESIÓN 2023.SEIS (firmas completas)20240513162746.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:27:46', '2024-05-15 20:07:08', 9);
INSERT INTO `documentosSubcomites` VALUES (103, 'Programa Anual de Trabajo', '2021', 'PAT 202120240513162855.pdf', 'Programa', NULL, 1, '2024-05-13 16:28:55', '2024-05-15 21:14:17', 9);
INSERT INTO `documentosSubcomites` VALUES (104, 'Programa Anual de Trabajo', '2022', 'Plan Anual de Trabajo 202220240513162906.pdf', 'Programa', NULL, 1, '2024-05-13 16:29:06', '2024-05-15 21:15:17', 9);
INSERT INTO `documentosSubcomites` VALUES (105, 'Programa Anual de Trabajo', '2023', 'PAT 2023 SEIS_VF20240513162918.pdf', 'Programa', NULL, 1, '2024-05-13 16:29:18', '2024-05-15 21:16:03', 9);
INSERT INTO `documentosSubcomites` VALUES (106, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240513162932.pdf', 'Informe', NULL, 1, '2024-05-13 16:29:32', '2024-05-15 21:16:45', 9);
INSERT INTO `documentosSubcomites` VALUES (107, 'Informe Anual de Trabajo', '2021', 'IGUALDAD SUSTANTIVA IAT20240513162946.pdf', 'Informe', NULL, 1, '2024-05-13 16:29:46', '2024-05-15 21:17:43', 9);
INSERT INTO `documentosSubcomites` VALUES (108, 'Informe Anual de Trabajo', '2022', 'Informe Anual de Trabajo 2022_Subcomité Especial de Igualdad Sustantiva20240513162958.pdf', 'Informe', NULL, 1, '2024-05-13 16:29:58', '2024-05-15 23:42:02', 9);
INSERT INTO `documentosSubcomites` VALUES (109, 'Informe Anual de Trabajo', '2023', 'Informe Anual de Trabajo 2023 SEIS20240513163007.pdf', 'Informe', NULL, 1, '2024-05-13 16:30:07', '2024-05-15 23:43:16', 9);
INSERT INTO `documentosSubcomites` VALUES (110, 'Programa Anual de Trabajo', '2024', 'PAT 2024 SEIS (1)20240513163124.pdf', 'Programa', NULL, 1, '2024-05-13 16:31:24', '2024-05-15 23:43:56', 9);
INSERT INTO `documentosSubcomites` VALUES (111, 'Acta de la Primera Sesión Ordinaria', '2020', '2020 Acta 1ra Sesión20240513163518.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:35:18', '2024-05-15 17:40:28', 10);
INSERT INTO `documentosSubcomites` VALUES (112, 'Acta de la Segunda Sesión Ordinaria', '2020', '2020 Acta 2da Sesión20240513163531.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:35:31', '2024-05-15 20:30:39', 10);
INSERT INTO `documentosSubcomites` VALUES (113, 'Acta de la Tercera Sesión Ordinaria', '2020', '2020 Acta 3ra Sesión20240513163547.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:35:47', '2024-05-15 20:29:16', 10);
INSERT INTO `documentosSubcomites` VALUES (114, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta 1ra. Sesión 2021 Medio Ambiente20240513163605.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:36:05', '2024-05-15 17:40:59', 10);
INSERT INTO `documentosSubcomites` VALUES (115, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta Segunda Sesion Ordinaria Medio Ambiente 202120240513163625.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:36:25', '2024-05-15 20:31:40', 10);
INSERT INTO `documentosSubcomites` VALUES (116, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta Primera Sesión2022testadas20240513163645.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:36:45', '2024-05-15 17:42:15', 10);
INSERT INTO `documentosSubcomites` VALUES (117, 'Acta de la Segunda Sesión Ordinaria', '2022', 'ACTA SEGUNDA SESIÓN ORDINARIA 202220240513163658.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:36:58', '2024-05-15 20:32:41', 10);
INSERT INTO `documentosSubcomites` VALUES (118, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta Primera Sesión Ordinaria 2023 SECAACC VF20240513163717.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:37:17', '2024-05-15 17:43:14', 10);
INSERT INTO `documentosSubcomites` VALUES (119, 'Acta de la Segunda Sesión Ordinaria', '2023', 'Acta 2a Sesión Ordinaria del 202320240513163730.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:37:30', '2024-05-15 20:33:41', 10);
INSERT INTO `documentosSubcomites` VALUES (120, 'Programa Anual de Trabajo', '2021', 'PAT 202120240513163755.pdf', 'Programa', NULL, 1, '2024-05-13 16:37:55', '2024-05-15 20:34:25', 10);
INSERT INTO `documentosSubcomites` VALUES (121, 'Programa Anual de Trabajo', '2022', 'U.V.PAT2022 Medio Ambiente (1)20240513163810.pdf', 'Programa', NULL, 1, '2024-05-13 16:38:10', '2024-05-15 20:35:18', 10);
INSERT INTO `documentosSubcomites` VALUES (122, 'Programa Anual de Trabajo', '2023', 'PAT 2023_ Medio Ambiente20240513163822.pdf', 'Programa', NULL, 1, '2024-05-13 16:38:22', '2024-05-15 20:35:56', 10);
INSERT INTO `documentosSubcomites` VALUES (123, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240513163842.pdf', 'Informe', NULL, 1, '2024-05-13 16:38:42', '2024-05-15 20:36:50', 10);
INSERT INTO `documentosSubcomites` VALUES (124, 'Informe Anual de Trabajo', '2021', 'IAT Medio Ambiente20240513163856.pdf', 'Informe', NULL, 1, '2024-05-13 16:38:56', '2024-05-15 20:37:32', 10);
INSERT INTO `documentosSubcomites` VALUES (125, 'Informe Anual de Trabajo', '2022', 'Informe Anual de Trabajo 2022 (Medio Ambiente)20240513163906.pdf', 'Informe', NULL, 1, '2024-05-13 16:39:06', '2024-05-15 20:38:11', 10);
INSERT INTO `documentosSubcomites` VALUES (126, 'Informe Anual de Trabajo', '2023', 'SE Cambio Climático IAT 202320240513163916.pdf', 'Informe', NULL, 1, '2024-05-13 16:39:16', '2024-05-15 20:38:55', 10);
INSERT INTO `documentosSubcomites` VALUES (127, 'Programa Anual de Trabajo', '2024', 'PAT 202420240513163951.pdf', 'Programa', NULL, 1, '2024-05-13 16:39:51', '2024-05-15 20:39:44', 10);
INSERT INTO `documentosSubcomites` VALUES (128, 'Acta de la Primera Sesión Ordinaria', '2020', 'Acta Primera Sesión 2020testadas20240513164552.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:45:52', '2024-05-15 17:45:34', 11);
INSERT INTO `documentosSubcomites` VALUES (129, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Acta Segunda Sesión SIPINNA 202020240513164607.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:46:07', '2024-05-16 00:04:17', 11);
INSERT INTO `documentosSubcomites` VALUES (130, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta Primera Sesión SIPINNA 202120240513164624.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:46:24', '2024-05-15 17:46:21', 11);
INSERT INTO `documentosSubcomites` VALUES (131, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta Segunda Sesión 2021testadas20240513164639.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:46:39', '2024-05-16 00:05:24', 11);
INSERT INTO `documentosSubcomites` VALUES (132, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta Primera Sesión 202320240513164702.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:47:02', '2024-05-15 17:47:40', 11);
INSERT INTO `documentosSubcomites` VALUES (133, 'Programa Anual de Trabajo', '2021', 'PAT 202120240513164718.pdf', 'Programa', NULL, 1, '2024-05-13 16:47:18', '2024-05-16 00:06:04', 11);
INSERT INTO `documentosSubcomites` VALUES (134, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240513164737.pdf', 'Informe', NULL, 1, '2024-05-13 16:47:37', '2024-05-16 00:06:48', 11);
INSERT INTO `documentosSubcomites` VALUES (135, 'Informe Anual de Trabajo', '2021', 'Informe Anual de Trabajo SIPINNA 202120240513164754.pdf', 'Informe', NULL, 1, '2024-05-13 16:47:54', '2024-05-16 00:07:25', 11);
INSERT INTO `documentosSubcomites` VALUES (136, 'Informe Anual de Trabajo', '2022', 'Informe Anual SESIPINNA 202220240513164811.pdf', 'Informe', NULL, 1, '2024-05-13 16:48:11', '2024-05-16 00:08:01', 11);
INSERT INTO `documentosSubcomites` VALUES (137, 'Acta de la Primera Sesión Ordinaria', '2020', 'Acta Primera Sesión Agenda 2030.T2020testadas20240513165326.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:53:26', '2024-05-15 17:54:31', 12);
INSERT INTO `documentosSubcomites` VALUES (138, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Acta Segunda Sesión Ordinaria 2020 Agenda 2030.Ttestadas20240513165345.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:53:45', '2024-05-15 20:14:41', 12);
INSERT INTO `documentosSubcomites` VALUES (139, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta Primera Sesión Agenda2030.Ttestadas20240513165448.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:54:48', '2024-05-15 17:55:10', 12);
INSERT INTO `documentosSubcomites` VALUES (140, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta Segunda Sesión Agenda 2030testadas.T20240513165600.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:56:00', '2024-05-15 20:16:02', 12);
INSERT INTO `documentosSubcomites` VALUES (141, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta 2030 2022 con firmas.Ttestadas20240513165659.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:56:59', '2024-05-15 17:55:44', 12);
INSERT INTO `documentosSubcomites` VALUES (142, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Acta 2SO2023 SEAA203020240513165738.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:57:38', '2024-05-15 20:16:53', 12);
INSERT INTO `documentosSubcomites` VALUES (143, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta_Primera Sesion2023_ Agenda 203020240513165809.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:58:09', '2024-05-15 17:56:55', 12);
INSERT INTO `documentosSubcomites` VALUES (144, 'Acta de la Segunda Sesión Ordinaria', '2023', 'Acta SEAA2030_firmas20240513165837.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:58:37', '2024-05-15 20:17:59', 12);
INSERT INTO `documentosSubcomites` VALUES (145, 'Acta de la Primera Sesión Ordinaria', '2024', 'Acta Agenda 2030 28.05.202420240528173752.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 16:58:56', '2024-05-28 17:53:28', 12);
INSERT INTO `documentosSubcomites` VALUES (146, 'Programa Anual de Trabajo', '2021', 'PAT 202120240513165914.pdf', 'Programa', NULL, 1, '2024-05-13 16:59:14', '2024-05-15 20:19:10', 12);
INSERT INTO `documentosSubcomites` VALUES (147, 'Programa Anual de Trabajo', '2022', 'PAT SEAA203020240513165952.pdf', 'Programa', NULL, 1, '2024-05-13 16:59:52', '2024-05-15 20:19:51', 12);
INSERT INTO `documentosSubcomites` VALUES (148, 'Programa Anual de Trabajo', '2023', 'PAT 2023-SEAA203020240513170017.pdf', 'Programa', NULL, 1, '2024-05-13 17:00:17', '2024-05-15 20:21:25', 12);
INSERT INTO `documentosSubcomites` VALUES (149, 'Programa Anual de Trabajo', '2024', 'PAT 2024-SEAA2030 (1)20240513170042.pdf', 'Programa', NULL, 1, '2024-05-13 17:00:42', '2024-05-15 20:22:12', 12);
INSERT INTO `documentosSubcomites` VALUES (150, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240513170101.pdf', 'Informe', NULL, 1, '2024-05-13 17:01:01', '2024-05-15 20:23:07', 12);
INSERT INTO `documentosSubcomites` VALUES (151, 'Informe Anual de Trabajo', '2021', 'IAT 2021 Agenda 203020240513170115.pdf', 'Informe', NULL, 1, '2024-05-13 17:01:15', '2024-05-15 20:24:13', 12);
INSERT INTO `documentosSubcomites` VALUES (152, 'Informe Anual de Trabajo', '2022', 'IAT 2022 SEAA203020240513170130.pdf', 'Informe', NULL, 1, '2024-05-13 17:01:30', '2024-05-15 20:24:58', 12);
INSERT INTO `documentosSubcomites` VALUES (153, 'Informe Anual de Trabajo', '2023', 'IAT 2023 SEAA203020240513170142.pdf', 'Informe', NULL, 1, '2024-05-13 17:01:42', '2024-05-15 20:25:41', 12);
INSERT INTO `documentosSubcomites` VALUES (154, 'Acta de la Primera Sesión Ordinaria', '2020', 'Acta de Instalación y 1ra. Sesión 2020 - Subcomité Especial Gobierno Democrático, Innovador y Transparente20240513170526.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:05:26', '2024-05-15 18:01:11', 13);
INSERT INTO `documentosSubcomites` VALUES (156, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Acta 2da.Sesión 2020 - Subcomité Especial Gobierno Democrático, Innovador y Transparente20240513170609.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:06:09', '2024-05-15 21:01:37', 13);
INSERT INTO `documentosSubcomites` VALUES (158, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta 1ra. Sesion 2021 - Subcomité Especial Gobierno Democrático, Innovador y Transparente20240513170649.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:06:49', '2024-05-15 18:02:01', 13);
INSERT INTO `documentosSubcomites` VALUES (159, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta 2da. Sesión Ordinaria Subcomite 2021 (Administración)20240513170715.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:07:15', '2024-05-15 21:02:47', 13);
INSERT INTO `documentosSubcomites` VALUES (160, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta Primera Sesión Ordinaria 202220240513170738.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:07:38', '2024-05-15 18:03:25', 13);
INSERT INTO `documentosSubcomites` VALUES (161, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Acta 2da. Sesión Ordinaria Subcomite 202220240513170757.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:07:57', '2024-05-15 21:03:48', 13);
INSERT INTO `documentosSubcomites` VALUES (162, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta Primera Sesión 202320240513170826.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:08:26', '2024-05-15 18:04:07', 13);
INSERT INTO `documentosSubcomites` VALUES (163, 'Acta de la Segunda Sesión Ordinaria', '2023', 'ACTA COPLADEP-SEGDIT-02-202320240513170851.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:08:51', '2024-05-15 21:05:04', 13);
INSERT INTO `documentosSubcomites` VALUES (164, 'Acta de la Primera Sesión Ordinaria', '2024', 'Acta_1ra_SO _2024 _SGDIyT20240513170906.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:09:06', '2024-05-15 18:04:47', 13);
INSERT INTO `documentosSubcomites` VALUES (165, 'Programa Anual de Trabajo', '2021', 'PAT 2021 20240513170923.pdf', 'Programa', NULL, 1, '2024-05-13 17:09:23', '2024-05-15 21:06:11', 13);
INSERT INTO `documentosSubcomites` VALUES (166, 'Programa Anual de Trabajo', '2022', 'PAT 202220240513170938.pdf', 'Programa', NULL, 1, '2024-05-13 17:09:38', '2024-05-15 21:06:58', 13);
INSERT INTO `documentosSubcomites` VALUES (167, 'Programa Anual de Trabajo', '2023', 'Programa Anual de Trabajo 2023 (Administración)20240513170950.pdf', 'Programa', NULL, 1, '2024-05-13 17:09:50', '2024-05-15 21:08:00', 13);
INSERT INTO `documentosSubcomites` VALUES (168, 'Programa Anual de Trabajo', '2024', 'PAT 2024 - SEGDIyT_23NOV202320240513171002.pdf', 'Programa', NULL, 1, '2024-05-13 17:10:02', '2024-05-15 21:08:45', 13);
INSERT INTO `documentosSubcomites` VALUES (169, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240513171056.pdf', 'Informe', NULL, 1, '2024-05-13 17:10:56', '2024-05-15 21:09:29', 13);
INSERT INTO `documentosSubcomites` VALUES (170, 'Informe Anual de Trabajo', '2021', 'IAT 2021 Gobierno Democrativo Innovador y Transparente20240513171114.pdf', 'Informe', NULL, 1, '2024-05-13 17:11:14', '2024-05-15 21:10:13', 13);
INSERT INTO `documentosSubcomites` VALUES (171, 'Informe Anual de Trabajo', '2022', 'Informe Anual de Trabajo 2022 (Administración)20240513171126.pdf', 'Informe', NULL, 1, '2024-05-13 17:11:26', '2024-05-15 21:10:53', 13);
INSERT INTO `documentosSubcomites` VALUES (172, 'Informe Anual de Trabajo', '2023', 'Informe Anual 2023 de Trabajo20240513171139.pdf', 'Informe', NULL, 1, '2024-05-13 17:11:39', '2024-05-15 21:12:05', 13);
INSERT INTO `documentosSubcomites` VALUES (173, 'Acta de la Primera Sesión Ordinaria', '2020', 'Acta de Instalación y Primera Sesión Energía 202020240513171506.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:15:06', '2024-05-15 18:07:03', 14);
INSERT INTO `documentosSubcomites` VALUES (174, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Acta Segunda Sesión ordinaria 202020240513171523.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:15:23', '2024-05-15 20:42:30', 14);
INSERT INTO `documentosSubcomites` VALUES (175, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta Energía Primera Sesión 202120240513171538.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:15:38', '2024-05-15 18:07:51', 14);
INSERT INTO `documentosSubcomites` VALUES (176, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta Segunda Sesión Ordinaria SEDESU 2021 firmada20240513171554.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:15:54', '2024-05-15 20:45:21', 14);
INSERT INTO `documentosSubcomites` VALUES (177, 'Acta de la Primera Sesión Ordinaria', '2022', 'Energia_ Acta Primera Sesión Ordinaria 202220240513171613.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:16:13', '2024-05-15 18:09:51', 14);
INSERT INTO `documentosSubcomites` VALUES (178, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Acta Segunda Sesión Ordinaria 2022 Energia20240513171629.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:16:29', '2024-05-15 20:46:20', 14);
INSERT INTO `documentosSubcomites` VALUES (179, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta Energia Primera Sesión 202320240513171701.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:17:01', '2024-05-15 18:10:44', 14);
INSERT INTO `documentosSubcomites` VALUES (180, 'Programa Anual de Trabajo', '2021', 'PAT 202120240513171722.pdf', 'Programa', NULL, 1, '2024-05-13 17:17:22', '2024-05-15 20:47:32', 14);
INSERT INTO `documentosSubcomites` VALUES (181, 'Programa Anual de Trabajo', '2022', 'PAT2022 Energia20240513171734.pdf', 'Programa', NULL, 1, '2024-05-13 17:17:34', '2024-05-15 20:48:06', 14);
INSERT INTO `documentosSubcomites` VALUES (182, 'Programa Anual de Trabajo', '2023', 'Energia_PAT 202320240513171744.pdf', 'Programa', NULL, 1, '2024-05-13 17:17:44', '2024-05-15 20:48:56', 14);
INSERT INTO `documentosSubcomites` VALUES (183, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 202020240513171759.pdf', 'Informe', NULL, 1, '2024-05-13 17:17:59', '2024-05-15 20:49:41', 14);
INSERT INTO `documentosSubcomites` VALUES (184, 'Informe Anual de Trabajo', '2022', 'Informe Anual de Trabajo 2022 Energia20240513171813.pdf', 'Informe', NULL, 1, '2024-05-13 17:18:13', '2024-05-15 20:50:31', 14);
INSERT INTO `documentosSubcomites` VALUES (185, 'Programa Anual de Trabajo', '2024', 'PAT 2024 (1)20240513171841.pdf', 'Programa', NULL, 1, '2024-05-13 17:18:41', '2024-05-15 20:51:17', 14);
INSERT INTO `documentosSubcomites` VALUES (187, 'Acta de la Segunda Sesión Ordinaria', '2023', 'Acta Segunda Sesión Energia20240513172015.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:20:15', '2024-05-15 20:55:34', 14);
INSERT INTO `documentosSubcomites` VALUES (188, 'Acta de la Primera Sesión Ordinaria', '2020', 'Acta Primera sesion 202020240513172246.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:22:46', '2024-05-15 18:12:45', 15);
INSERT INTO `documentosSubcomites` VALUES (189, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Acta Segunda sesion ordinaria 202020240513172305.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:23:05', '2024-05-15 23:54:20', 15);
INSERT INTO `documentosSubcomites` VALUES (190, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta Primera Sesión.T 2021testadas20240513172327.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:23:27', '2024-05-15 18:13:21', 15);
INSERT INTO `documentosSubcomites` VALUES (191, 'Acta de la Primera Sesión Extraordinaria', '2021', 'Acta_PRIMERA SESIÓN EXTRAORDINARIA 2021_Juventud20240513172346.pdf', 'Acta', 'Extraordinaria', 1, '2024-05-13 17:23:46', '2024-05-15 18:45:47', 15);
INSERT INTO `documentosSubcomites` VALUES (192, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta_SEGUNDA SESIÓN ORDINARIA 2021-Juventud20240513172405.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:24:06', '2024-05-15 23:55:26', 15);
INSERT INTO `documentosSubcomites` VALUES (193, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta Primera Sesión 2022 con circunstanciada20240513172425.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:24:25', '2024-05-15 18:14:14', 15);
INSERT INTO `documentosSubcomites` VALUES (194, 'Acta de la Primera Sesión Extraordinaria', '2022', 'Primera Sesión Extraordinaria 2022-Juventud20240513172441.pdf', 'Acta', 'Extraordinaria', 1, '2024-05-13 17:24:41', '2024-05-15 18:47:57', 15);
INSERT INTO `documentosSubcomites` VALUES (195, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta Primera Sesión 202320240513172501.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:25:01', '2024-05-15 18:16:41', 15);
INSERT INTO `documentosSubcomites` VALUES (196, 'Acta de la Segunda Sesión Ordinaria', '2023', 'Acta Segunda Sesión 2023 Juventud20240513172522.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:25:22', '2024-05-15 23:56:30', 15);
INSERT INTO `documentosSubcomites` VALUES (197, 'Programa Anual de Trabajo', '2021', 'PAT 202120240513172536.pdf', 'Programa', NULL, 1, '2024-05-13 17:25:36', '2024-05-15 23:57:09', 15);
INSERT INTO `documentosSubcomites` VALUES (198, 'Programa Anual de Trabajo', '2022', 'PAT 2022 IPJ20240513172549.pdf', 'Programa', NULL, 1, '2024-05-13 17:25:49', '2024-05-15 23:58:02', 15);
INSERT INTO `documentosSubcomites` VALUES (199, 'Programa Anual de Trabajo', '2023', 'PAT 202320240513172604.pdf', 'Programa', NULL, 1, '2024-05-13 17:26:04', '2024-05-15 23:58:48', 15);
INSERT INTO `documentosSubcomites` VALUES (200, 'Programa Anual de Trabajo', '2024', 'PAT 202420240513172619.pdf', 'Programa', NULL, 1, '2024-05-13 17:26:19', '2024-05-15 23:59:24', 15);
INSERT INTO `documentosSubcomites` VALUES (201, 'Informe Anual de Trabajo', '2020', 'Informe Anual de Trabajo 2020 (1)20240513172646.pdf', 'Informe', NULL, 1, '2024-05-13 17:26:46', '2024-05-16 00:00:02', 15);
INSERT INTO `documentosSubcomites` VALUES (202, 'Informe Anual de Trabajo', '2021', 'IAT JUVENTUD202120240513172700.pdf', 'Informe', NULL, 1, '2024-05-13 17:27:00', '2024-05-16 00:00:39', 15);
INSERT INTO `documentosSubcomites` VALUES (203, 'Informe Anual de Trabajo', '2022', 'Informe Anual de trabajo 2022 (Juventud)20240513172714.pdf', 'Informe', NULL, 1, '2024-05-13 17:27:14', '2024-05-16 00:01:12', 15);
INSERT INTO `documentosSubcomites` VALUES (204, 'Informe Anual de Trabajo', '2023', 'IAT 2023 (1)20240513172732.pdf', 'Informe', NULL, 1, '2024-05-13 17:27:32', '2024-05-16 00:01:51', 15);
INSERT INTO `documentosSubcomites` VALUES (205, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta SEA 2022_120240513172958.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:29:58', '2024-05-15 18:19:39', 17);
INSERT INTO `documentosSubcomites` VALUES (206, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Acta-2da SO-Subcomité Especial Anticorrupción 202220240513173013.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:30:13', '2024-05-15 20:09:44', 17);
INSERT INTO `documentosSubcomites` VALUES (207, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta 1ra Sesión Ordinaria 202320240513173033.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:30:33', '2024-05-15 18:20:18', 17);
INSERT INTO `documentosSubcomites` VALUES (208, 'Acta de la Primera Sesión Ordinaria', '2024', 'Acta 1SO2024 Subcomité Especial Anticorrupción20240513173049.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:30:49', '2024-05-15 18:21:17', 17);
INSERT INTO `documentosSubcomites` VALUES (209, 'Programa Anual de Trabajo', '2022', 'PAT pagina202220240513173109.pdf', 'Programa', NULL, 1, '2024-05-13 17:31:09', '2024-05-16 16:20:50', 17);
INSERT INTO `documentosSubcomites` VALUES (210, 'Programa Anual de Trabajo', '2023', 'PAT 202320240513173122.pdf', 'Programa', NULL, 1, '2024-05-13 17:31:22', '2024-05-15 20:12:46', 17);
INSERT INTO `documentosSubcomites` VALUES (211, 'Programa Anual de Trabajo', '2024', 'Programa Anual de Trabajo 2024 Anticorrupcion20240513173150.pdf', 'Programa', NULL, 1, '2024-05-13 17:31:50', '2024-05-15 20:13:30', 17);
INSERT INTO `documentosSubcomites` VALUES (213, 'Informe Anual de Trabajo', '2023', 'IAT2023_EA20240513173424.pdf', 'Informe', NULL, 1, '2024-05-13 17:32:12', '2024-05-16 16:21:53', 17);
INSERT INTO `documentosSubcomites` VALUES (214, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta instalación y circunstanciada subcomité especial de derechos humanos20240513173623.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:36:23', '2024-05-15 18:23:34', 16);
INSERT INTO `documentosSubcomites` VALUES (215, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta Primera Sesión 202320240513173641.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:36:41', '2024-05-15 18:25:19', 16);
INSERT INTO `documentosSubcomites` VALUES (216, 'Programa Anual de Trabajo', '2023', 'PAT 2023_ Derechos Humanos20240513173655.pdf', 'Programa', NULL, 1, '2024-05-13 17:36:55', '2024-05-15 20:40:41', 16);
INSERT INTO `documentosSubcomites` VALUES (217, 'Informe Anual de Trabajo', '2022', 'IAT 202220240513173707.pdf', 'Informe', NULL, 1, '2024-05-13 17:37:07', '2024-05-15 20:41:35', 16);
INSERT INTO `documentosSubcomites` VALUES (218, 'Acta de la Primera Sesión Ordinaria', '2020', 'Acta Primera Sesión Ordinaria  2020testadas SDR20240513173954.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:39:54', '2024-05-15 18:26:55', 18);
INSERT INTO `documentosSubcomites` VALUES (219, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Acta Segunda Sesión Ordinaria  2020testadas SDR20240513174010.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:40:10', '2024-05-16 00:15:49', 18);
INSERT INTO `documentosSubcomites` VALUES (220, 'Acta de la Primera Sesión Ordinaria', '2021', 'Acta Primera Sesión Ordinaria  2021testadas SDR20240513174026.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:40:26', '2024-05-15 18:27:37', 18);
INSERT INTO `documentosSubcomites` VALUES (221, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Acta Segunda Sesión Ordinaria 2021testadas SDR20240513174045.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:40:45', '2024-05-16 00:16:59', 18);
INSERT INTO `documentosSubcomites` VALUES (222, 'Acta de la Primera Sesión Ordinaria', '2022', 'Acta PrimeraSesion SDR 2022 con firma testadas20240513174107.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:41:07', '2024-05-15 18:28:18', 18);
INSERT INTO `documentosSubcomites` VALUES (223, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Acta Segunda Sesión Ordinaria 2022 Subcomité de Desarrollo Regional20240513174124.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:41:24', '2024-05-16 00:17:57', 18);
INSERT INTO `documentosSubcomites` VALUES (224, 'Acta de la Primera Sesión Ordinaria', '2023', 'Primera Sesión 2023 Desarrollo Regional20240513174154.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:41:54', '2024-05-15 18:29:22', 18);
INSERT INTO `documentosSubcomites` VALUES (225, 'Acta de la Segunda Sesión Ordinaria', '2023', 'Acta_DR_Firmas 2a 2320240513174221.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:42:21', '2024-05-16 00:19:21', 18);
INSERT INTO `documentosSubcomites` VALUES (226, 'Acta de la Primera Sesión Ordinaria', '2024', 'Acta Primera Sesión 2024-Desarrollo Regional20240513174241.pdf', 'Acta', 'Ordinaria', 1, '2024-05-13 17:42:41', '2024-05-15 18:31:14', 18);
INSERT INTO `documentosSubcomites` VALUES (227, 'Programa Anual de Trabajo', '2021', 'PAT 202120240513174307.pdf', 'Programa', NULL, 1, '2024-05-13 17:43:07', '2024-05-16 00:21:01', 18);
INSERT INTO `documentosSubcomites` VALUES (228, 'Programa Anual de Trabajo', '2022', 'PAT 2022 Regional20240513174333.pdf', 'Programa', NULL, 1, '2024-05-13 17:43:33', '2024-05-16 00:21:36', 18);
INSERT INTO `documentosSubcomites` VALUES (229, 'Programa Anual de Trabajo', '2023', 'u.v.PAT 2023 SDR20240513174345.pdf', 'Programa', NULL, 1, '2024-05-13 17:43:45', '2024-05-16 00:22:09', 18);
INSERT INTO `documentosSubcomites` VALUES (230, 'Programa Anual de Trabajo', '2024', 'PAT 2024 - SDR20240513174359.pdf', 'Programa', NULL, 1, '2024-05-13 17:43:59', '2024-05-16 00:22:46', 18);
INSERT INTO `documentosSubcomites` VALUES (231, 'Informe Anual de Trabajo', '2020', 'IAT 202020240513174538.pdf', 'Informe', NULL, 1, '2024-05-13 17:45:38', '2024-05-16 00:23:29', 18);
INSERT INTO `documentosSubcomites` VALUES (232, 'Informe Anual de Trabajo', '2021', 'IAT Sub DR 202120240513174549.pdf', 'Informe', NULL, 1, '2024-05-13 17:45:49', '2024-05-16 00:24:39', 18);
INSERT INTO `documentosSubcomites` VALUES (233, 'Informe Anual de Trabajo', '2022', 'IAT 202220240513174611.pdf', 'Informe', NULL, 1, '2024-05-13 17:46:11', '2024-05-16 00:25:22', 18);
INSERT INTO `documentosSubcomites` VALUES (234, 'Informe Anual de Trabajo', '2023', 'IAT 202320240513174624.pdf', 'Informe', NULL, 1, '2024-05-13 17:46:24', '2024-05-16 00:25:55', 18);
INSERT INTO `documentosSubcomites` VALUES (235, 'Informe Anual de Trabajo', '2023', 'Informe Anual de Trabajo 202320240517163426.pdf', 'Informe', NULL, 1, '2024-05-17 16:34:26', '2024-05-17 16:35:27', 7);
INSERT INTO `documentosSubcomites` VALUES (236, 'Informe Anual de Trabajo', '2023', 'IAT 202320240517192244.pdf', 'Informe', NULL, 1, '2024-05-17 19:22:44', '2024-05-17 20:01:13', 14);
INSERT INTO `documentosSubcomites` VALUES (237, 'Acta de la Primera Sesión Ordinaria', '2024', 'Acta Primera Sesión 202420240517192634.pdf', 'Acta', 'Ordinaria', 1, '2024-05-17 19:26:34', '2024-05-17 20:01:37', 14);
INSERT INTO `documentosSubcomites` VALUES (238, 'Acta de la Primera Sesión Ordinaria', '2024', 'Acta Primera Sesión 2024-Juventudes20240517193252.pdf', 'Acta', 'Ordinaria', 1, '2024-05-17 19:32:52', '2024-05-17 20:01:50', 15);
INSERT INTO `documentosSubcomites` VALUES (239, 'Acta de la Primera Sesión Ordinaria', '2023', 'ACTA.PRIMERA SESIÓN 2023.SEIS20240517193855.pdf', 'Acta', 'Ordinaria', 1, '2024-05-17 19:38:55', '2024-05-17 20:01:00', 9);
INSERT INTO `documentosSubcomites` VALUES (240, 'Acta de la Segunda Sesión Ordinaria', '2023', 'Versión final Acta_2a_SO2023-Subcomité_Especial_Anticorrupción20240517201059.pdf', 'Acta', 'Ordinaria', 1, '2024-05-17 20:10:59', '2024-05-17 21:01:29', 17);
INSERT INTO `documentosSubcomites` VALUES (241, 'Programa Anual de Trabajo', '2024', '3. Programa Trabajo 2024 24Nov2320240517223510.pdf', 'Programa', NULL, 1, '2024-05-17 22:35:10', '2024-06-05 15:50:34', 8);
INSERT INTO `documentosSubcomites` VALUES (242, 'Acta de la Primera Sesión Ordinaria', '2024', 'Acta 1a. Sesion Pueblos Originarios 2024 VERSION FINAL20240517223956.pdf', 'Acta', 'Ordinaria', 1, '2024-05-17 22:39:56', '2024-06-05 15:50:50', 8);
INSERT INTO `documentosSubcomites` VALUES (243, 'Acta de la Segunda Sesión Ordinaria', '2023', 'Acta 2a. sesion 2023 Subcomite Especial de Pueblos Originarios version final20240517224350.pdf', 'Acta', 'Ordinaria', 1, '2024-05-17 22:43:50', '2024-06-05 15:51:08', 8);
INSERT INTO `documentosSubcomites` VALUES (244, 'Informe Anual de Trabajo', '2023', '2. Informe Anual Trabajo 2023 24Nov2320240517225106.pdf', 'Informe', NULL, 1, '2024-05-17 22:51:06', '2024-06-05 15:51:24', 8);
INSERT INTO `documentosSubcomites` VALUES (247, 'Acta de la Primera Sesión Ordinaria', '2024', 'Acta 1ra Sesión Ordinaria 202420240618171330.pdf', 'Acta', 'Ordinaria', 1, '2024-06-18 17:13:30', '2024-06-18 19:32:38', 10);
INSERT INTO `documentosSubcomites` VALUES (248, 'Informe Anual de Trabajo', '2023', '4. Informe Anual de Trabajo 202320240618180350.pdf', 'Informe', NULL, 1, '2024-06-18 18:03:50', '2024-06-18 19:31:41', 3);
INSERT INTO `documentosSubcomites` VALUES (249, 'Programa Anual de Trabajo', '2024', '5. Programa Anual de Trabajo 202420240618180623.pdf', 'Programa', NULL, 1, '2024-06-18 18:06:23', '2024-06-18 19:31:18', 3);
INSERT INTO `documentosSubcomites` VALUES (250, 'Acta de la Primera Sesión Ordinaria', '2024', '1a.S.O._SSSPJED_202420240715225803.pdf', 'Acta', 'Ordinaria', 1, '2024-07-15 22:58:03', '2024-07-15 22:58:13', 3);

-- ----------------------------
-- Table structure for documentos_copladep
-- ----------------------------
DROP TABLE IF EXISTS `documentos_copladep`;
CREATE TABLE `documentos_copladep`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anio` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_documento` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` enum('Informe','Acta','Programa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Informe',
  `tipo_acta` enum('Ordinaria','Extraordinaria') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `publicado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of documentos_copladep
-- ----------------------------
INSERT INTO `documentos_copladep` VALUES (1, 'Informe Anual de Trabajo', '2020', 'Anexo 2 Informe Anual de Actividades Subcomités 202020240510174658.pdf', 'Informe', NULL, 1, '2024-05-10 17:46:58', '2024-05-15 15:38:25');
INSERT INTO `documentos_copladep` VALUES (2, 'Informe Anual de Trabajo', '2021', 'Anexo 1 IAT 2021 del COPLADEP20240510174729.pdf', 'Informe', NULL, 1, '2024-05-10 17:47:29', '2024-05-15 15:38:45');
INSERT INTO `documentos_copladep` VALUES (3, 'Informe Anual de Trabajo', '2022', 'vf. COPLADEP_IAT20240510174805.pdf', 'Informe', NULL, 1, '2024-05-10 17:48:05', '2024-05-15 15:39:06');
INSERT INTO `documentos_copladep` VALUES (4, 'Informe Anual de Trabajo', '2023', '6. Informe Anual de Trabajo 2023 COPLADEP20240510174815.pdf', 'Informe', NULL, 1, '2024-05-10 17:48:15', '2024-05-15 15:39:33');
INSERT INTO `documentos_copladep` VALUES (5, 'Programa Anual de Trabajo', '2021', '6. Programa Anual de Trabajo 202120240510174914.pdf', 'Programa', NULL, 1, '2024-05-10 17:49:14', '2024-05-15 15:40:07');
INSERT INTO `documentos_copladep` VALUES (6, 'Programa Anual de Trabajo', '2022', 'PAT COPLADEP 2022 (pdf)20240510174937.pdf', 'Programa', NULL, 1, '2024-05-10 17:49:37', '2024-05-15 15:40:28');
INSERT INTO `documentos_copladep` VALUES (7, 'Programa Anual de Trabajo', '2023', 'vf. Programa Anual de Trabajo 2023 COPLADEP20240510174954.pdf', 'Programa', NULL, 1, '2024-05-10 17:49:54', '2024-05-15 15:40:48');
INSERT INTO `documentos_copladep` VALUES (8, 'Programa Anual de Trabajo', '2024', 'Programa Anual de Trabajo 202420240510175008.pdf', 'Programa', NULL, 1, '2024-05-10 17:50:08', '2024-05-15 15:41:06');
INSERT INTO `documentos_copladep` VALUES (9, 'Acta de la Primera Sesión Ordinaria', '2019', '2019 Acta Primera Sesion20240510175104.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 17:51:04', '2024-05-15 15:29:18');
INSERT INTO `documentos_copladep` VALUES (10, 'Acta de la Segunda Sesión Ordinaria', '2019', 'Segunda Sesión Ordinaria 2019testadas20240510175118.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 17:51:18', '2024-05-15 15:29:43');
INSERT INTO `documentos_copladep` VALUES (11, 'Acta de la Primera Sesión Ordinaria', '2020', 'Primera Sesión 2020 testadas20240510175146.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 17:51:46', '2024-05-15 15:30:14');
INSERT INTO `documentos_copladep` VALUES (13, 'Acta de la Segunda Sesión Ordinaria', '2020', 'Segunda Sesión 2020 testadas20240510175307.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 17:53:07', '2024-05-15 15:35:34');
INSERT INTO `documentos_copladep` VALUES (15, 'Acta de la Primera Sesión Ordinaria', '2021', 'Primera Sesión 2021 testadas20240510175523.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 17:55:23', '2024-05-15 15:31:50');
INSERT INTO `documentos_copladep` VALUES (16, 'Acta de la Segunda Sesión Ordinaria', '2021', 'Segunda Sesión 2021 testadas20240510175550.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 17:55:50', '2024-05-15 15:32:59');
INSERT INTO `documentos_copladep` VALUES (17, 'Acta de la Primera Sesión Ordinaria', '2022', 'Primera Sesión 2022 testadas20240510175615.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 17:56:15', '2024-05-15 15:33:57');
INSERT INTO `documentos_copladep` VALUES (18, 'Acta de la Segunda Sesión Ordinaria', '2022', 'Acta Segunda Sesión 2022 con Acta Circunstanciada20240510175703.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 17:57:03', '2024-05-15 15:36:28');
INSERT INTO `documentos_copladep` VALUES (19, 'Acta de la Primera Sesión Ordinaria', '2023', 'Acta Primera Sesión O 2023 COPLADEP con formatos20240510175817.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 17:58:17', '2024-05-15 15:34:32');
INSERT INTO `documentos_copladep` VALUES (20, 'Acta de la Primera Sesión Extraordinaria', '2023', 'Acta Primera Sesión Extraordinaria 202320240510175849.pdf', 'Acta', 'Extraordinaria', 1, '2024-05-10 17:58:49', '2024-05-15 15:34:54');
INSERT INTO `documentos_copladep` VALUES (21, 'Acta de la Segunda Sesión Ordinaria', '2023', 'Acta_COPLADEP_Firmas 2da 2320240510175929.pdf', 'Acta', 'Ordinaria', 1, '2024-05-10 17:59:29', '2024-05-15 15:37:03');
INSERT INTO `documentos_copladep` VALUES (23, 'Acta de la Primera Sesión Ordinaria', '2024', 'Acta COPLADEP15.07.202420240715225535.pdf', 'Acta', 'Ordinaria', 1, '2024-07-15 22:55:35', '2024-07-15 22:56:32');

-- ----------------------------
-- Table structure for encuestas
-- ----------------------------
DROP TABLE IF EXISTS `encuestas`;
CREATE TABLE `encuestas`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `satisfaccion` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of encuestas
-- ----------------------------
INSERT INTO `encuestas` VALUES (1, 3, '2024-06-12 17:16:00', '2024-06-12 17:16:00');
INSERT INTO `encuestas` VALUES (2, 3, '2024-06-12 18:01:21', '2024-06-12 18:01:21');
INSERT INTO `encuestas` VALUES (3, 3, '2024-06-12 18:07:21', '2024-06-12 18:07:21');
INSERT INTO `encuestas` VALUES (4, 1, '2024-06-12 18:07:58', '2024-06-12 18:07:58');
INSERT INTO `encuestas` VALUES (5, 3, '2024-06-12 18:12:05', '2024-06-12 18:12:05');
INSERT INTO `encuestas` VALUES (6, 2, '2024-06-12 18:12:41', '2024-06-12 18:12:41');
INSERT INTO `encuestas` VALUES (7, 3, '2024-06-12 18:41:54', '2024-06-12 18:41:54');
INSERT INTO `encuestas` VALUES (8, 1, '2024-06-12 18:50:26', '2024-06-12 18:50:26');
INSERT INTO `encuestas` VALUES (9, 3, '2024-06-12 19:05:55', '2024-06-12 19:05:55');
INSERT INTO `encuestas` VALUES (10, 3, '2024-06-12 20:41:49', '2024-06-12 20:41:49');
INSERT INTO `encuestas` VALUES (11, 3, '2024-06-12 22:59:31', '2024-06-12 22:59:31');
INSERT INTO `encuestas` VALUES (12, 3, '2024-06-13 15:12:59', '2024-06-13 15:12:59');
INSERT INTO `encuestas` VALUES (13, 3, '2024-06-13 20:49:09', '2024-06-13 20:49:09');
INSERT INTO `encuestas` VALUES (14, 2, '2024-06-13 20:50:23', '2024-06-13 20:50:23');
INSERT INTO `encuestas` VALUES (15, 2, '2024-06-13 23:40:27', '2024-06-13 23:40:27');
INSERT INTO `encuestas` VALUES (16, 2, '2024-06-14 22:18:29', '2024-06-14 22:18:29');
INSERT INTO `encuestas` VALUES (17, 2, '2024-06-14 22:48:25', '2024-06-14 22:48:25');
INSERT INTO `encuestas` VALUES (18, 3, '2024-06-17 17:35:00', '2024-06-17 17:35:00');
INSERT INTO `encuestas` VALUES (19, 3, '2024-06-17 19:46:11', '2024-06-17 19:46:11');
INSERT INTO `encuestas` VALUES (20, 3, '2024-06-18 14:47:13', '2024-06-18 14:47:13');
INSERT INTO `encuestas` VALUES (21, 1, '2024-06-18 21:41:01', '2024-06-18 21:41:01');
INSERT INTO `encuestas` VALUES (22, 3, '2024-06-18 22:19:02', '2024-06-18 22:19:02');
INSERT INTO `encuestas` VALUES (23, 2, '2024-06-19 15:39:42', '2024-06-19 15:39:42');
INSERT INTO `encuestas` VALUES (24, 3, '2024-06-19 19:13:22', '2024-06-19 19:13:22');
INSERT INTO `encuestas` VALUES (25, 3, '2024-06-20 06:01:20', '2024-06-20 06:01:20');
INSERT INTO `encuestas` VALUES (26, 3, '2024-06-20 23:31:38', '2024-06-20 23:31:38');
INSERT INTO `encuestas` VALUES (27, 3, '2024-06-21 00:12:08', '2024-06-21 00:12:08');
INSERT INTO `encuestas` VALUES (28, 3, '2024-06-21 00:13:11', '2024-06-21 00:13:11');
INSERT INTO `encuestas` VALUES (29, 3, '2024-06-21 00:13:29', '2024-06-21 00:13:29');
INSERT INTO `encuestas` VALUES (30, 2, '2024-06-27 00:19:14', '2024-06-27 00:19:14');
INSERT INTO `encuestas` VALUES (31, 1, '2024-06-27 19:19:37', '2024-06-27 19:19:37');
INSERT INTO `encuestas` VALUES (32, 3, '2024-06-27 22:54:18', '2024-06-27 22:54:18');
INSERT INTO `encuestas` VALUES (33, 3, '2024-07-02 17:55:34', '2024-07-02 17:55:34');
INSERT INTO `encuestas` VALUES (34, 3, '2024-07-05 20:14:52', '2024-07-05 20:14:52');
INSERT INTO `encuestas` VALUES (35, 3, '2024-07-05 20:14:52', '2024-07-05 20:14:52');
INSERT INTO `encuestas` VALUES (36, 1, '2024-07-10 18:32:21', '2024-07-10 18:32:21');
INSERT INTO `encuestas` VALUES (37, 2, '2024-07-16 23:25:33', '2024-07-16 23:25:33');
INSERT INTO `encuestas` VALUES (38, 3, '2024-07-21 03:19:32', '2024-07-21 03:19:32');
INSERT INTO `encuestas` VALUES (39, 3, '2024-07-21 03:21:18', '2024-07-21 03:21:18');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for formularioscontacto
-- ----------------------------
DROP TABLE IF EXISTS `formularioscontacto`;
CREATE TABLE `formularioscontacto`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `asunto` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for marcojuridico
-- ----------------------------
DROP TABLE IF EXISTS `marcojuridico`;
CREATE TABLE `marcojuridico`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_documento` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `portada` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `publicado` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of marcojuridico
-- ----------------------------
INSERT INTO `marcojuridico` VALUES (1, 'Ley de Coordinación  Hacendaria del Estado de Puebla y sus Municipios.', 'Ley de Coordinación  Hacendaria del Estado de Puebla y sus Municipios_20240506194819.pdf', 'Doc 3 Marco2024041819191420240506194223.png', 1, '2024-05-06 19:42:23', '2024-05-06 19:54:34', 1);
INSERT INTO `marcojuridico` VALUES (2, 'Ley de Desarrollo Económico Sustentable del Estado de Puebla.', 'Ley de Desarrollo Económico Sustentable del Estado de Puebla20240506194721.pdf', 'Ley de Desarrollo Economico Sus20240506194721.png', 2, '2024-05-06 19:47:21', '2024-05-06 19:54:48', 1);
INSERT INTO `marcojuridico` VALUES (3, 'Ley de Planeación para el Desarrollo del Estado de Puebla', 'Ley de Planeación para el Desarrollo del Estado de Puebla.20240506194857.pdf', 'Doc 1 Marco2024041819164420240506194857.png', 3, '2024-05-06 19:48:57', '2024-05-06 19:54:54', 1);
INSERT INTO `marcojuridico` VALUES (4, 'Ley Orgánica de la Administración Pública del Estado de Puebla', 'Ley Orgánica de la Administración Pública del Estado de Puebla20240506195038.pdf', 'Ley Orgánica de la Administración Pública del Estado de Puebla20240506195038.png', 4, '2024-05-06 19:50:38', '2024-05-06 19:55:01', 1);
INSERT INTO `marcojuridico` VALUES (5, 'Ley Orgánica Municipal', 'Ley Orgánica Municipal20240506195115.pdf', 'Doc 4 Marco2024041819194920240506195115.png', 5, '2024-05-06 19:51:15', '2024-05-06 19:55:06', 1);
INSERT INTO `marcojuridico` VALUES (6, 'Reglamento Interior de la Secretaría de Planeación y Finanzas', 'Reglamento Interior de la Secretaría de Planeación y Finanzas.20240506195204.pdf', 'Reglamento Interior de la Secretaría de Planeación y Finanzas.20240506195204.png', 6, '2024-05-06 19:52:04', '2024-05-06 19:54:08', 1);
INSERT INTO `marcojuridico` VALUES (7, 'Lineamientos Generales para el Seguimiento y Evaluación de los Documentos Rectores y Programas Presupuestarios de la Administración Pública del Estado de Puebla', 'Lineamientos Generales para el Seguimiento y Evaluación de los Documentos Rectores20240506195243.pdf', 'Portada Lineamientos2024042222374020240506195243.png', 7, '2024-05-06 19:52:43', '2024-05-06 19:54:21', 1);
INSERT INTO `marcojuridico` VALUES (8, 'Lineamientos para el Funcionamiento del Comité de Planeación para el Desarrollo del Estado de Puebla.', 'Lineamientos para el Funcionamiento del COPLADEP20240506195333.pdf', 'Doc 2 Marco2024041819173120240506195333.png', 8, '2024-05-06 19:53:33', '2024-05-06 19:54:14', 1);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (9, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (10, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (11, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1);
INSERT INTO `migrations` VALUES (12, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (13, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (14, '2024_03_26_161254_create_sessions_table', 1);
INSERT INTO `migrations` VALUES (15, '2024_03_26_161909_create_documentos_subcomites_table', 1);
INSERT INTO `migrations` VALUES (16, '2024_03_27_182810_create_productos_table', 1);
INSERT INTO `migrations` VALUES (17, '2024_04_02_175934_create_documentos_copladep_table', 2);
INSERT INTO `migrations` VALUES (18, '2024_04_02_232749_create_regiones_table', 3);
INSERT INTO `migrations` VALUES (19, '2024_04_02_232806_create_municipios_table', 3);
INSERT INTO `migrations` VALUES (20, '2024_04_02_232818_create_planes_municipales_table', 3);
INSERT INTO `migrations` VALUES (21, '2024_04_04_164535_create_plan_estatals_table', 4);
INSERT INTO `migrations` VALUES (22, '2024_04_04_180338_create_programa_derivados_table', 5);
INSERT INTO `migrations` VALUES (23, '2024_04_05_170426_create_subcomites_table', 6);
INSERT INTO `migrations` VALUES (24, '2024_04_05_173708_add_subcomite_id_to_documentossubcomites_table', 7);
INSERT INTO `migrations` VALUES (25, '2024_04_09_182315_create_banners_table', 8);
INSERT INTO `migrations` VALUES (26, '2024_04_09_225632_add_icono_to_subcomites_table', 9);
INSERT INTO `migrations` VALUES (27, '2024_04_09_234048_add_plan_estatal_id_to_subcomites_table', 10);
INSERT INTO `migrations` VALUES (28, '2024_04_18_172823_marco_juridico', 11);
INSERT INTO `migrations` VALUES (29, '2024_05_06_183343_add_publicado_to_marcojuridico_table', 12);
INSERT INTO `migrations` VALUES (30, '2024_05_06_184004_add_validador_to_users_table', 13);
INSERT INTO `migrations` VALUES (31, '2024_05_14_153650_create_encuestas_table', 14);
INSERT INTO `migrations` VALUES (32, '2024_05_14_200522_create_formularioscontacto_table', 15);

-- ----------------------------
-- Table structure for municipios
-- ----------------------------
DROP TABLE IF EXISTS `municipios`;
CREATE TABLE `municipios`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sitio_web` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `municipios_region_id_foreign`(`region_id`) USING BTREE,
  CONSTRAINT `municipios_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regiones` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 636 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of municipios
-- ----------------------------
INSERT INTO `municipios` VALUES (1, 'Acajete', 'https://acajetegob.wordpress.com/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (2, 'Acateno', 'https://www.acateno.gob.mx/', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (3, 'Acatlán', 'https://www.acatlandeosorio.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (4, 'Acatzingo', 'https://acatzingo.puebla.gob.mx/', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (5, 'Acteopan', 'https://miacteopan.gob.mx/', 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (6, 'Ahuacatlán', 'https://www.facebook.com/profile.php?id=100076290422906', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (7, 'Ahuatlán', 'https://ahuatlanpuebla.com/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (8, 'Ahuazotepec', 'https://www.ahuazotepec.gob.mx/', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (9, 'Ahuehuetitla', 'https://ahuehuetitla.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (10, 'Ajalpan', 'https://ajalpan.gob.mx/', 14, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (11, 'Albino Zertuche', 'http://www.albinozertuche.gob.mx/', 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (12, 'Aljojuca', 'https://ayuntamientoaljojuca.gob.mx/', 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (13, 'Altepexi', 'https://ayuntamientoaltepexi.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (14, 'Amixtlán', 'https://www.ayuntamientoamixtlan.gob.mx/', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (15, 'Amozoc', 'https://amozoc.gob.mx/', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (16, 'Aquixtla', 'https://www.aquixtla.gob.mx/', 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (17, 'Atempan', 'https://www.atempan.gob.mx/', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (18, 'Atexcal', 'https://ayuntamientoatexcal.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (19, 'Atlixco', 'https://www.atlixco.gob.mx/', 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (20, 'Atoyatempan', 'https://atoyatempanpuebla.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (21, 'Atzala', 'https://atzala.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (22, 'Atzitzihuacán', 'https://atzitzihuacan.gob.mx/', 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (23, 'Atzitzintla', 'https://ayuntamientoatzitzintla.com/', 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (24, 'Axutla', 'https://axutla.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (25, 'Ayotoxco de Guerrero', 'https://www.ayotoxcodegro.gob.mx/', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (26, 'Calpan', 'https://www.municipiocalpan.gob.mx/', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (27, 'Caltepec', 'https://caltepec.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (28, 'Camocuautla', 'https://ayuntamientodecamocuautla.gob.mx/', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (29, 'Caxhuacan', 'https://www.ayuntamientomunicipaldecaxhuacan.com/', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (30, 'Coatepec', 'https://coatepec.puebla.gob.mx/', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (31, 'Coatzingo', 'https://coatzingo.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (32, 'Cohetzala', 'https://www.cohetzala.gob.mx/', 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (33, 'Cohuecán', 'https://www.cohuecan.gob.mx/', 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (34, 'Coronango', 'https://www.coronango.gob.mx/', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (35, 'Coxcatlán', 'https://coxcatlan.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (36, 'Coyomeapan', 'https://coyomeapan.com/', 14, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (37, 'Coyotepec', 'https://ayuntamientocoyotepec.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (38, 'Cuapiaxtla de Madero', 'https://cuapiaxtlademadero.com/web/', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (39, 'Cuautempan', 'https://cuautempan.puebla.gob.mx/', 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (40, 'Cuautinchán', 'https://cuautinchan.puebla.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (41, 'Cuautlancingo', 'https://cuautlancingo.gob.mx/', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (42, 'Cuayuca de Andrade', 'https://cuayucadeandrade.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (43, 'Cuetzalan del Progreso', 'https://www.cuetzalan.gob.mx/', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (44, 'Cuyoaco', 'https://municipiodecuyoaco.com/', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (45, 'Chalchicomula de Sesma', 'https://chalchicomuladesesma.gob.mx/', 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (46, 'Chapulco', 'https://chapulco.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (47, 'Chiautla', 'https://ayuntamientochiautla.gob.mx/', 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (48, 'Chiautzingo', 'https://www.chiautzingo.gob.mx/', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (49, 'Chiconcuautla', 'https://chiconcuautla.gob.mx/', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (50, 'Chichiquila', 'https://chichiquila.gob.mx/', 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (51, 'Chietla', 'https://chietla.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (52, 'Chigmecatitlán', 'https://www.chigmecatitlan.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (53, 'Chignahuapan', 'https://chignahuapan.gob.mx/', 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (54, 'Chignautla', 'https://chignautla.puebla.gob.mx/', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (55, 'Chila', 'https://chiladelasflores.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (56, 'Chila de la Sal', 'https://chiladelasal.gob.mx/web/', 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (57, 'Honey', 'https://honey.gob.mx/', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (58, 'Chilchotla', 'https://chilchotla.gob.mx/', 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (59, 'Chinantla', 'https://chinantla.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (60, 'Domingo Arenas', 'https://domingoarenas.puebla.gob.mx/', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (61, 'Eloxochitlán', 'https://eloxochitlanpuebla.gob.mx/', 14, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (62, 'Epatlán', 'https://epatlan.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (63, 'Esperanza', 'https://esperanzapuebla.gob.mx/', 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (64, 'Francisco Z. Mena', 'https://www.zmena.gob.mx/', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (65, 'General Felipe Ángeles', 'https://felipeangeles.gob.mx/', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (66, 'Guadalupe', 'https://municipioguadalupepuebla.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (67, 'Guadalupe Victoria', 'https://ayuntamientoguadalupevictoriapuebla.gob.mx/', 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (68, 'Hermenegildo Galeana', 'https://www.hermenegildogaleana.gob.mx/', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (69, 'Huaquechula', 'https://huaquechula.gob.mx/', 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (70, 'Huatlatlauca', 'https://ayuntamientohuatlatlauca.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (71, 'Huauchinango', 'https://huauchinango.gob.mx/', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (72, 'Huehuetla', NULL, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (73, 'Huehuetlán el Chico', 'http://huehuetlanelchico-puebla.gob.mx/', 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (74, 'Huejotzingo', 'http://huejotzingo.gob.mx/', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (75, 'Hueyapan', NULL, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (76, 'Hueytamalco', 'https://www.hueytamalco.gob.mx/', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (77, 'Hueytlalpan', 'https://hueytlalpanpuebla.mx/', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (78, 'Huitzilan de Serdán', 'http://huitzilandeserdanpue.gob.mx/', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (79, 'Huitziltepec', 'https://huitziltepec.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (80, 'Atlequizayan', NULL, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (81, 'Ixcamilpa de Guerrero', NULL, 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (82, 'Ixcaquixtla', 'https://ayuntamientoixcaquixtla.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (83, 'Ixtacamaxtitlán', 'https://ixtacamaxtitlan.com/', 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (84, 'Ixtepec', 'https://ixtepec.puebla.gob.mx/', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (85, 'Izúcar de Matamoros', 'https://www.izucar.gob.mx/inicio/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (86, 'Jalpan', NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (87, 'Jolalpan', 'https://jolalpan.gob.mx/', 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (88, 'Jonotla', 'https://municipio-jonotla.com.mx/Index.html', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (89, 'Jopala', 'https://www.jopala.gob.mx/', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (90, 'Juan C. Bonilla', 'https://www.jcb.gob.mx/', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (91, 'Juan Galindo', 'https://ayuntamientojuangalindo.gob.mx/', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (92, 'Juan N. Méndez', NULL, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (93, 'Lafragua', 'https://municipiodelafragua.com/', 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (94, 'Libres', 'https://www.libres.gob.mx/', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (95, 'La Magdalena Tlatlauquitepec', 'https://www.lamagdalenatlatlauquitepec.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (96, 'Mazapiltepec de Juárez', 'https://mazapiltepecdejuarez.puebla.gob.mx/', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (97, 'Mixtla', 'https://mixtla.puebla.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (98, 'Molcaxac', 'https://www.molcaxacpue.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (99, 'Cañada Morelos', 'https://canadamorelospuebla.gob.mx/', 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (100, 'Naupan', 'https://naupan.gob.mx/', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (101, 'Nauzontla', 'https://nauzontlagob.com/', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (102, 'Nealtican', 'https://www.nealtican.gob.mx/', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (103, 'Nicolás Bravo', 'https://nicolas-bravo.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (104, 'Nopalucan', 'https://nopalucan.gob.mx/', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (105, 'Ocotepec', 'https://ocotepecpuebla.gob.mx/', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (106, 'Ocoyucan', 'https://ocoyucanpuebla.gob.mx/', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (107, 'Olintla', 'https://olintla.gob.mx/', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (108, 'Oriental', 'https://www.oriental.puebla.gob.mx/', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (109, 'Pahuatlán', 'https://municipiopahuatlan.org/', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (110, 'Palmar de Bravo', 'https://palmardebravo.gob.mx/', 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (111, 'Pantepec', 'https://www.pantepecpue.gob.mx/', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (112, 'Petlalcingo', 'https://ayuntamientodepetlalcingo.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (113, 'Piaxtla', 'https://www.piaxtla.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (114, 'Puebla', 'https://www.pueblacapital.gob.mx/', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (115, 'Quecholac', 'https://www.municipioquecholac.gob.mx/', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (116, 'Quimixtlán', 'https://quimixtlan.gob.mx/', 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (117, 'Rafael Lara Grajales', 'https://rafaellaragrajales.puebla.gob.mx/', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (118, 'Los Reyes de Juárez', NULL, 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (119, 'San Andrés Cholula', 'https://sach.gob.mx/', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (120, 'San Antonio Cañada', 'https://ayuntamientosanantonio.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (121, 'San Diego la Mesa Tochimiltzingo', 'https://sandiegolamesatochimiltzingopuebla.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (122, 'San Felipe Teotlalcingo', NULL, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (123, 'San Felipe Tepatlán', 'https://www.sanfelipetepatlan.gob.mx/', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (124, 'San Gabriel Chilac', 'https://chilacpuebla.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (125, 'San Gregorio Atzompa', 'https://atzompa.gob.mx/', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (126, 'San Jerónimo Tecuanipan', 'https://sjtecuanipan.gob.mx/', 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (127, 'San Jerónimo Xayacatlán', 'https://sanjeronimoxayacatlan.ayuntamientodigital.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (128, 'San José Chiapa', 'https://sanjosechiapa.puebla.gob.mx/', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (129, 'San José Miahuatlán', 'https://sanjosemiahuatlan.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (130, 'San Juan Atenco', 'https://ayuntamientosanjuanatenco.gob.mx/', 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (131, 'San Juan Atzompa', 'https://sanjuanatzompa.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (132, 'San Martín Texmelucan', 'https://sanmartintexmelucan.gob.mx/', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (133, 'San Martín Totoltepec', 'https://www.sanmartintotoltepec.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (134, 'San Matías Tlalancaleca', 'https://sanmatiastlalancaleca.gob.mx/wp/', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (135, 'San Miguel Ixitlán', 'https://ixitlan.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (136, 'San Miguel Xoxtla', 'https://sanmiguelxoxtla.puebla.gob.mx/cabildo.php', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (137, 'San Nicolás Buenos Aires', 'https://snbuenosaires.gob.mx/', 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (138, 'San Nicolás de los Ranchos', 'https://sannicolasdelosranchos.gob.mx/', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (139, 'San Pablo Anicano', 'https://municipiodesanpabloanicano.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (140, 'San Pedro Cholula', 'https://cholula.gob.mx/', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (141, 'San Pedro Yeloixtlahuaca', 'https://sanpedroyeloixtlahuacapue.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (142, 'San Salvador el Seco', 'https://www.sansalvadorelseco.com/', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (143, 'San Salvador el Verde', 'https://sansalvadorelverde.puebla.gob.mx/', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (144, 'San Salvador Huixcolotla', 'https://www.huixcolotla.gob.mx/', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (145, 'San Sebastián Tlacotepec', 'https://www.sansebastiantlacotepec.org/', 14, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (146, 'Santa Catarina Tlaltempan', 'https://santacatarinatlaltempan.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (147, 'Santa Inés Ahuatempan', 'https://ahuatempan.gob.mx/Vista/index.php', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (148, 'Santa Isabel Cholula', 'https://santaisabelcholula.gob.mx/', 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (149, 'Santiago Miahuatlán', 'https://santiagomiahuatlan.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (150, 'Huehuetlán el Grande', NULL, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (151, 'Santo Tomás Hueyotlipan', 'https://santotomashueyotlipan.puebla.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (152, 'Soltepec', 'https://soltepec.gob.mx/', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (153, 'Tecali de Herrera', 'https://tecalideherrera.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (154, 'Tecamachalco', 'https://tecamachalco.gob.mx/', 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (155, 'Tecomatlán', 'https://www.tecomatlan.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (156, 'Tehuacán', 'https://oficial.tehuacan.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (157, 'Tehuitzingo', 'https://ayuntamientotehuitzingo.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (158, 'Tenampulco', 'https://tenampulcopuebla.gob.mx/', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (159, 'Teopantlán', 'https://teopantlan.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (160, 'Teotlalco', 'https://teotlalco.puebla.gob.mx/presidente.php', 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (161, 'Tepanco de López', 'https://tepanco.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (162, 'Tepango de Rodríguez', NULL, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (163, 'Tepatlaxco de Hidalgo', 'https://tepatlaxcodehidalgopuebla.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (164, 'Tepeaca', 'https://tepeaca.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (165, 'Tepemaxalco', NULL, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (166, 'Tepeojuma', 'https://municipiodetepeojuma.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (167, 'Tepetzintla', 'http://tepetzintlapuebla.gob.mx/', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (168, 'Tepexco', 'https://www.tepexcopue.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (169, 'Tepexi de Rodríguez', 'https://sites.google.com/view/tepexiderodriguez/h-ayuntamiento-de-tepexi', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (170, 'Tepeyahualco', 'https://ayuntamientotepeyahualco.gob.mx/inicio', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (171, 'Tepeyahualco de Cuauhtémoc', 'https://tepeyahualcodecuauhtemocpuebla.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (172, 'Tetela de Ocampo', 'https://www.teteladeocampo.gob.mx/', 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (173, 'Teteles de Avila Castillo', 'https://teteles.gob.mx/', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (174, 'Teziutlán', 'https://teziutlan.gob.mx/Vista/index.php', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (175, 'Tianguismanalco', 'https://www.tianguismanalcopuebla.gob.mx/', 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (176, 'Tilapa', 'https://www.tilapa.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (177, 'Tlacotepec de Benito Juárez', 'https://tlacotepecdebenitojuarez.gob.mx/', 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (178, 'Tlacuilotepec', 'https://www.tlacuilotepec.com/', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (179, 'Tlachichuca', 'https://tlachichuca.gob.mx/', 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (180, 'Tlahuapan', 'https://tlahuapan.org/', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (181, 'Tlaltenango', 'https://tlaltenango.puebla.gob.mx/', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (182, 'Tlanepantla', 'https://tlanepantlapuebla.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (183, 'Tlaola', 'https://www.tlaola.gob.mx/', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (184, 'Tlapacoya', 'https://www.tlapacoya.gob.mx/', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (185, 'Tlapanalá', 'https://tlapanala.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (186, 'Tlatlauquitepec', 'https://ayuntamientotlatlauquitepec.gob.mx/', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (187, 'Tlaxco', NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (188, 'Tochimilco', 'https://www.tochimilco.gob.mx/', 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (189, 'Tochtepec', 'https://tochtepec.puebla.gob.mx/', 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (190, 'Totoltepec de Guerrero', 'https://totoltepecdegropue.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (191, 'Tulcingo', 'https://tulcingopuebla.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (192, 'Tuzamapan de Galeana', 'https://www.ayuntamientotuzamapandegaleana.com/', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (193, 'Tzicatlacoyan', 'https://tzicatlacoyan.puebla.gob.mx/', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (194, 'Venustiano Carranza', 'https://vcarranzapuebla.gob.mx/', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (195, 'Vicente Guerrero', 'https://vicenteguerrero.puebla.gob.mx/', 14, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (196, 'Xayacatlán de Bravo', 'https://xayacatlanpresidencia.gob.mx/', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (197, 'Xicotepec', 'https://xicotepecpuebla.gob.mx/', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (198, 'Xicotlán', 'https://xicotlan.gob.mx/', 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (199, 'Xiutetelco', 'https://xiutetelco.gob.mx/Vista/', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (200, 'Xochiapulco', 'https://www.xochiapulco.gob.mx/', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (201, 'Xochiltepec', 'https://www.xochiltepec.gob.mx/', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (202, 'Xochitlán de Vicente Suárez', 'https://xochitlanvs.gob.mx/', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (203, 'Xochitlán Todos Santos', 'https://www.xochitlantodossantos.gob.mx/', 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (204, 'Yaonáhuac', 'https://yaonahuac.gob.mx/', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (205, 'Yehualtepec', 'https://yehualtepec.gob.mx/', 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (206, 'Zacapala', 'https://zacapala.gob.mx/', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (207, 'Zacapoaxtla', 'https://zacapoaxtla.gob.mx/', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (208, 'Zacatlán', 'https://zacatlan.gob.mx/', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (209, 'Zapotitlán', 'https://www.zapotitlansalinas.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (210, 'Zapotitlán de Méndez', 'https://zapotitlan-de-mendez.gob.mx/', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (211, 'Zaragoza', 'https://municipiodezaragozapuebla.com/', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (212, 'Zautla', 'https://ayuntamientodezautla.gob.mx/', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (213, 'Zihuateutla', 'https://zihuateutla.org/', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (214, 'Zinacatepec', 'https://www.zinacantepec.gob.mx/', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (215, 'Zongozotla', 'https://zongozotla.gob.mx/', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (216, 'Zoquiapan', 'https://municipiozoquiapan.org.mx/', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `municipios` VALUES (217, 'Zoquitlán', 'https://ayuntamientozoquitlan.gob.mx/', 14, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for plan_estatals
-- ----------------------------
DROP TABLE IF EXISTS `plan_estatals`;
CREATE TABLE `plan_estatals`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periodo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_documento` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `portada` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gobernador` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publicado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of plan_estatals
-- ----------------------------
INSERT INTO `plan_estatals` VALUES (11, 'Plan Estatal de Desarrollo 2005-2011', '2005-2011', 'Plan Estatal de Desarrollo 2005-2011_20240429190412.pdf', 'Portada_2_20240429194433.png', 'Mario Marín Torres', 1, '2024-04-05 15:18:45', '2024-05-15 17:49:43');
INSERT INTO `plan_estatals` VALUES (12, 'Plan Estatal de Desarrollo 2011-2017', '2011-2017', 'Plan Estatal de Desarrollo 2011-201720240405151936.pdf', '20240405151936.jpg', 'Rafael Moreno Valle Rosas', 1, '2024-04-05 15:19:36', '2024-05-15 18:05:29');
INSERT INTO `plan_estatals` VALUES (14, 'Plan Estatal de Desarrollo 2019', '2019', 'Plan Estatal de Desarrollo 201920240405154512.pdf', '20240405154512.jpg', 'Guillermo Pacheco Pulido', 1, '2024-04-05 15:45:12', '2024-05-15 18:08:03');
INSERT INTO `plan_estatals` VALUES (15, 'Plan Estatal de Desarrollo 2019-2024', '2019-2024', 'PlanEstataldeDesarrollo2019-202420240405154911.pdf', 'Portada_3_20240429194445.png', 'Luis Miguel Gerónimo Barbosa Huerta', 1, '2024-04-05 15:49:11', '2024-05-15 18:08:42');
INSERT INTO `plan_estatals` VALUES (16, 'Plan Estatal de Desarrollo 2019-2024: Modificación y Adecuación', '2019-2024', 'Plan Estatal de Desarrollo 2019-2024 S20240405173120.pdf', 'Portada-4_20240429201713.png', 'Sergio Salomón Céspedes Peregrina', 1, '2024-04-05 17:31:20', '2024-05-15 18:10:28');
INSERT INTO `plan_estatals` VALUES (20, 'Plan Estatal de Desarrollo 2017-2018', '2017-2018', 'Plan Estatal de Desarrollo 2017-201820240429200840.pdf', '20240429200840.png', 'José Antonio Gali Fayad', 1, '2024-04-29 20:08:40', '2024-05-15 18:06:54');

-- ----------------------------
-- Table structure for planes_municipales
-- ----------------------------
DROP TABLE IF EXISTS `planes_municipales`;
CREATE TABLE `planes_municipales`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periodo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_documento` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio_id` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('Ordinario','Extraordinario') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `publicado` tinyint(1) NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `planes_municipales_municipio_id_foreign`(`municipio_id`) USING BTREE,
  CONSTRAINT `planes_municipales_municipio_id_foreign` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 562 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of planes_municipales
-- ----------------------------
INSERT INTO `planes_municipales` VALUES (13, 'Actualización del Plan Municipal de Desarrollo Acajete 2021-2024', '2021-2024', '001 ACAJETE20240404163807.pdf', 1, NULL, 1, '2024-04-04 16:38:07', '2024-05-15 17:31:37');
INSERT INTO `planes_municipales` VALUES (16, 'Plan Municipal de Desarrollo Acajete 2021-2024', '2021-2024', 'Acajete_PMD 2021-202420240408173328.pdf', 1, NULL, 1, '2024-04-08 17:33:28', '2024-05-15 17:41:47');
INSERT INTO `planes_municipales` VALUES (17, 'Plan Municipal de Desarrollo Acajete 2018-2021', '2018-2021', 'Acajete20240408173432.pdf', 1, NULL, 1, '2024-04-08 17:34:32', '2024-05-15 23:19:17');
INSERT INTO `planes_municipales` VALUES (20, 'Actualización del Plan Municipal de Desarrollo Acateno 2021-2024', '2021-2024', 'Acateno_PMD_2021-202420240415172803.pdf', 2, NULL, 1, '2024-04-15 17:28:03', '2024-05-15 17:32:56');
INSERT INTO `planes_municipales` VALUES (21, 'Plan Municipal de Desarrollo Acateno 2014-2018', '2014-2018', 'Acateno20240415173109.pdf', 2, NULL, 1, '2024-04-15 17:31:09', '2024-05-15 17:45:03');
INSERT INTO `planes_municipales` VALUES (22, 'Actualización del Plan Municipal de Desarrollo Acatlán de Osorio 2021-2024', '2021-2024', '003 ACATLAN20240415173254.pdf', 3, NULL, 1, '2024-04-15 17:32:54', '2024-05-15 17:40:06');
INSERT INTO `planes_municipales` VALUES (23, 'Plan Municipal de Desarrollo Acatlán 2021-2024', '2021-2024', 'Acatlán_PMD_2021-2024_20240415173345.pdf', 3, NULL, 1, '2024-04-15 17:33:20', '2024-05-15 17:54:11');
INSERT INTO `planes_municipales` VALUES (25, 'Actualización del Plan Municipal de Desarrollo Acatzingo 2021-2024', '2021-2024', '004 ACATZINGO20240415173532.pdf', 4, NULL, 1, '2024-04-15 17:35:32', '2024-05-15 17:54:56');
INSERT INTO `planes_municipales` VALUES (26, 'Plan Municipal de Desarrollo Acatzingo 2018-2021', '2018-2021', 'Acatzingo20240415173556.pdf', 4, NULL, 1, '2024-04-15 17:35:56', '2024-05-15 17:55:49');
INSERT INTO `planes_municipales` VALUES (27, 'Actualización del Plan Municipal de Desarrollo Acteopan 2021-2024', '2021-2024', '005 ACTEOPAN20240415173820.pdf', 5, NULL, 1, '2024-04-15 17:38:20', '2024-05-15 20:03:57');
INSERT INTO `planes_municipales` VALUES (28, 'Plan Municipal de Desarrollo Acteopan 2021-2024', '2021-2024', 'Acteopan_PMD_2021-202420240415173840.pdf', 5, NULL, 1, '2024-04-15 17:38:40', '2024-05-15 19:50:15');
INSERT INTO `planes_municipales` VALUES (29, 'Plan Municipal de Desarrollo Acteopan 2018-2021', '2018-2021', 'PLAN DE DESARROLLO 2018-2021 ACTEOPAN20240415173903.pdf', 5, NULL, 1, '2024-04-15 17:39:03', '2024-05-16 21:06:20');
INSERT INTO `planes_municipales` VALUES (30, 'Plan Municipal de Desarrollo Ahuacatlán 2021-2024', '2021-2024', 'Ahuacatlán_PMD_2021-202420240415174040.pdf', 6, NULL, 1, '2024-04-15 17:40:40', '2024-05-15 19:52:47');
INSERT INTO `planes_municipales` VALUES (31, 'Plan Municipal de Desarrollo Ahuacatlán 2018-2021', '2018-2021', 'Ahuacatlán20240415174107.pdf', 6, NULL, 1, '2024-04-15 17:41:07', '2024-05-16 21:05:48');
INSERT INTO `planes_municipales` VALUES (32, 'Plan Municipal de Desarrollo Ahuatlán 2021-2024', '2021-2024', 'Ahuatlán_PMD_2021-202420240415174220.pdf', 7, NULL, 1, '2024-04-15 17:42:20', '2024-05-15 19:57:16');
INSERT INTO `planes_municipales` VALUES (33, 'Plan Municipal de Desarrollo Ahuatlán 2018-2021', '2018-2021', 'Ahuatlán20240415174249.pdf', 7, NULL, 1, '2024-04-15 17:42:49', '2024-05-16 22:45:11');
INSERT INTO `planes_municipales` VALUES (34, 'Plan Municipal de Desarrollo Ahuazotepec 2021-2024', '2021-2024', 'Ahuazotepec_PMD_2021-202420240415174404.pdf', 8, NULL, 1, '2024-04-15 17:44:04', '2024-05-15 20:00:27');
INSERT INTO `planes_municipales` VALUES (35, 'Plan Municipal de Desarrollo Ahuazotepec 2018-2021', '2018-2021', 'Ahuazotepec20240415174436.pdf', 8, NULL, 1, '2024-04-15 17:44:36', '2024-05-16 22:45:50');
INSERT INTO `planes_municipales` VALUES (36, 'Plan Municipal de Desarrollo Ahuehuetitla 2021-2024', '2021-2024', 'PLAN DE DESARROLLO MUNICIPAL DE AHUEHUETITLA 21-24 (1)20240415174551.pdf', 9, NULL, 1, '2024-04-15 17:45:51', '2024-05-15 20:01:34');
INSERT INTO `planes_municipales` VALUES (37, 'Plan Municipal de Desarrollo Ahuehuetitla 2018-2021', '2018-2021', 'Ahuehuetitla20240415174615.pdf', 9, NULL, 1, '2024-04-15 17:46:15', '2024-05-16 22:46:31');
INSERT INTO `planes_municipales` VALUES (38, 'Plan Municipal de Desarrollo Ajalpan 2021-2024', '2021-2024', 'Ajalpan_PMD_2021-202420240415174732.pdf', 10, NULL, 1, '2024-04-15 17:47:33', '2024-05-15 20:05:58');
INSERT INTO `planes_municipales` VALUES (39, 'Plan Municipal de Desarrollo Ajalpan 2018-2021', '2018-2021', 'Ajalpan20240415174800.pdf', 10, NULL, 1, '2024-04-15 17:48:00', '2024-05-16 22:47:44');
INSERT INTO `planes_municipales` VALUES (40, 'Actualización del Plan Municipal de Desarrollo Albino Zertuche 2021-2024', '2021-2024', '011 ALBINO ZERTUCHE20240415175103.pdf', 11, NULL, 1, '2024-04-15 17:51:03', '2024-05-15 20:03:25');
INSERT INTO `planes_municipales` VALUES (41, 'Plan Municipal de Desarrollo Albino Zertuche 2021-2024', '2021-2024', 'Albino Zertuche_PMD_2021-202420240415175122.pdf', 11, NULL, 1, '2024-04-15 17:51:22', '2024-05-15 20:07:07');
INSERT INTO `planes_municipales` VALUES (42, 'Plan Municipal de Desarrollo Albino Zertuche 2018-2021', '2018-2021', 'Albino Zertuche20240415175143.pdf', 11, NULL, 1, '2024-04-15 17:51:43', '2024-05-16 22:48:29');
INSERT INTO `planes_municipales` VALUES (43, 'Plan Municipal de Desarrollo Chignahuapan 2021-2024', '2021-2024', 'Chignahuapan_PMD_2021-202420240415182658.pdf', 53, NULL, 1, '2024-04-15 18:26:58', '2024-05-15 22:45:20');
INSERT INTO `planes_municipales` VALUES (44, 'Plan Municipal de Desarrollo Chignahuapan 2018-2021', '2018-2021', 'Chignahuapan20240415182731.pdf', 53, NULL, 1, '2024-04-15 18:27:31', '2024-05-16 19:48:01');
INSERT INTO `planes_municipales` VALUES (45, 'Plan Municipal de Desarrollo Aljojuca 2021-2024', '2021-2024', 'Aljojuca_PMD_2021-202420240415191244.pdf', 12, NULL, 1, '2024-04-15 19:12:44', '2024-05-15 20:08:26');
INSERT INTO `planes_municipales` VALUES (46, 'Plan Municipal de Desarrollo Aljojuca 2018-2021', '2018-2021', 'Aljojuca20240415191307.pdf', 12, NULL, 1, '2024-04-15 19:13:07', '2024-05-16 22:49:43');
INSERT INTO `planes_municipales` VALUES (47, 'Plan Municipal de Desarrollo Altepexi 2021-2024', '2021-2024', 'Altepexi_PMD 2021-202420240415192224.pdf', 13, NULL, 1, '2024-04-15 19:22:24', '2024-05-15 20:09:50');
INSERT INTO `planes_municipales` VALUES (48, 'Plan Municipal de Desarrollo Altepexi 2018-2021', '2018-2021', 'Altepexi20240415192245.pdf', 13, NULL, 1, '2024-04-15 19:22:45', '2024-05-16 22:53:35');
INSERT INTO `planes_municipales` VALUES (49, 'Plan Municipal de Desarrollo Amixtlán 2021-2024', '2021-2024', 'Amixtlán_PMD_2021-202420240415192410.pdf', 14, NULL, 1, '2024-04-15 19:24:10', '2024-05-15 20:13:26');
INSERT INTO `planes_municipales` VALUES (50, 'Plan Municipal de Desarrollo Amixtlán 2018-2021', '2018-2021', 'Amixtlán20240415192435.pdf', 14, NULL, 1, '2024-04-15 19:24:35', '2024-05-16 22:54:45');
INSERT INTO `planes_municipales` VALUES (52, 'Actualización del Plan Municipal de Desarrollo Aquixtla 2021-2024', '2021-2024', 'Actualización del Plan Municipal de Desarrollo Aquixtla 2021-2024_20240614181615.pdf', 16, NULL, 1, '2024-04-15 19:35:49', '2024-06-14 19:46:15');
INSERT INTO `planes_municipales` VALUES (53, 'Plan Municipal de Desarrollo Atempan 2021-2024', '2021-2024', 'Atempan_PMD_2021-202420240415193744.pdf', 17, NULL, 1, '2024-04-15 19:37:44', '2024-05-15 20:20:01');
INSERT INTO `planes_municipales` VALUES (54, 'Plan Municipal de Desarrollo Atempan 2019-2021', '2019-2021', 'Atempan20240415193820.pdf', 17, NULL, 1, '2024-04-15 19:38:20', '2024-05-15 20:21:14');
INSERT INTO `planes_municipales` VALUES (56, 'Plan Municipal de Desarrollo Atexcal 2019-2021', '2018-2021', 'Atexcal20240415194059.pdf', 18, NULL, 1, '2024-04-15 19:40:59', '2024-06-14 17:48:32');
INSERT INTO `planes_municipales` VALUES (57, 'Plan Municipal de Desarrollo Amozoc 2021-2024', '2021-2024', 'Amozoc_PMD_ 2021-202420240416152958.pdf', 15, NULL, 1, '2024-04-16 15:29:58', '2024-05-15 20:15:32');
INSERT INTO `planes_municipales` VALUES (58, 'Plan Municipal de Desarrollo Amozoc 2019-2021', '2019-2021', 'Amozoc20240416153020.pdf', 15, NULL, 1, '2024-04-16 15:30:20', '2024-05-15 20:16:21');
INSERT INTO `planes_municipales` VALUES (59, 'Actualización del Plan Municipal de Desarrollo Atlixco 2021-2024', '2021-2024', '020 ATLIXCO20240416153332.pdf', 19, NULL, 1, '2024-04-16 15:33:32', '2024-05-15 20:04:16');
INSERT INTO `planes_municipales` VALUES (60, 'Plan Municipal de Desarrollo Atlixco 2021-2024', '2021-2024', 'Atlixco_PMD_2021-202420240416153359.pdf', 19, NULL, 1, '2024-04-16 15:33:59', '2024-05-15 20:24:57');
INSERT INTO `planes_municipales` VALUES (61, 'Plan Municipal de Desarrollo Atlixco 2018-2021', '2018-2021', 'Atlixco20240416153417.pdf', 19, NULL, 1, '2024-04-16 15:34:17', '2024-05-16 19:30:51');
INSERT INTO `planes_municipales` VALUES (62, 'Actualización del Plan Municipal de Desarrollo Atoyatempan 2021-2024', '2021-2024', '021 ATOYATEMPAN20240416153548.pdf', 20, NULL, 1, '2024-04-16 15:35:48', '2024-05-17 00:09:29');
INSERT INTO `planes_municipales` VALUES (63, 'Plan Municipal de Desarrollo Atoyatempan 2021-2024', '2021-2024', 'Atoyatempan_PDM_2021-202420240416153607.pdf', 20, NULL, 1, '2024-04-16 15:36:07', '2024-05-15 20:26:46');
INSERT INTO `planes_municipales` VALUES (64, 'Plan Municipal de Desarrollo Atoyatempan 2018-2021', '2018-2021', 'Atoyatempan20240416153630.pdf', 20, NULL, 1, '2024-04-16 15:36:30', '2024-05-16 19:31:51');
INSERT INTO `planes_municipales` VALUES (65, 'Plan Municipal de Desarrollo Atzala 2021-2024', '2021-2024', 'Atzala_PMD_2021-202420240416153740.pdf', 21, NULL, 1, '2024-04-16 15:37:40', '2024-05-15 20:28:10');
INSERT INTO `planes_municipales` VALUES (66, 'Plan Municipal de Desarrollo Atzala 2018-2021', '2018-2021', 'Atzala20240416153811.pdf', 21, NULL, 1, '2024-04-16 15:38:11', '2024-05-16 19:32:22');
INSERT INTO `planes_municipales` VALUES (67, 'Plan Municipal de Desarrollo Atzitzihuacán 2021-2024', '2021-2024', 'PMD Atzitzihuacan 21-24_ final20240416153930.pdf', 22, NULL, 1, '2024-04-16 15:39:30', '2024-05-15 20:31:17');
INSERT INTO `planes_municipales` VALUES (68, 'Plan Municipal de Desarrollo Atzitzihuacán 2018-2021', '2018-2021', 'Atzitzihuacan20240416154007.pdf', 22, NULL, 1, '2024-04-16 15:40:07', '2024-05-16 19:32:51');
INSERT INTO `planes_municipales` VALUES (69, 'Actualización del Plan Municipal de Desarrollo Atzitzintla 2021-2024', '2021-2024', '024 ATZITZINTLA20240416154157.pdf', 23, NULL, 1, '2024-04-16 15:41:57', '2024-05-15 20:35:04');
INSERT INTO `planes_municipales` VALUES (70, 'Plan Municipal de Desarrollo Atzitzintla 2021-2024', '2021-2024', 'Atzitzintla_PMD 2021-2024 ABREVIADO20240416154223.pdf', 23, NULL, 1, '2024-04-16 15:42:23', '2024-05-15 20:33:01');
INSERT INTO `planes_municipales` VALUES (71, 'Plan Municipal de Desarrollo Atzitzintla 2018-2021', '2018-2021', 'Atzitzintla20240416154255.pdf', 23, NULL, 1, '2024-04-16 15:42:55', '2024-05-16 19:33:33');
INSERT INTO `planes_municipales` VALUES (72, 'Actualización del Plan Municipal de Desarrollo Axutla 2021-2024', '2021-2024', '025 AXUTLA20240416154447.pdf', 24, NULL, 1, '2024-04-16 15:44:47', '2024-05-15 20:34:41');
INSERT INTO `planes_municipales` VALUES (73, 'Plan Municipal de Desarrollo Axutla 2021-2024', '2021-2024', 'Axutla_PMD_2021-202420240416154507.pdf', 24, NULL, 1, '2024-04-16 15:45:07', '2024-05-15 20:34:08');
INSERT INTO `planes_municipales` VALUES (74, 'Plan Municipal de Desarrollo Axutla 2018-2021', '2018-2021', 'Axutla20240416154531.pdf', 24, NULL, 1, '2024-04-16 15:45:31', '2024-05-16 19:33:59');
INSERT INTO `planes_municipales` VALUES (75, 'Plan Municipal de Desarrollo Ayotoxco de Guerrero 2021-2024', '2021-2024', 'Ayotoxco de Guerrero_PMD_2021-202420240416154656.pdf', 25, NULL, 1, '2024-04-16 15:46:56', '2024-05-15 20:38:28');
INSERT INTO `planes_municipales` VALUES (76, 'Plan Municipal de Desarrollo Ayotoxco de Guerrero 2018-2021', '2018-2021', 'Ayotoxco de Guerrero20240416154726.pdf', 25, NULL, 1, '2024-04-16 15:47:26', '2024-05-16 19:35:14');
INSERT INTO `planes_municipales` VALUES (77, 'Plan Municipal de Desarrollo Calpan 2021-2024', '2021-2024', 'Calpan_PMD _2021-202420240416155001.pdf', 26, NULL, 1, '2024-04-16 15:50:01', '2024-05-15 20:40:04');
INSERT INTO `planes_municipales` VALUES (78, 'Plan Municipal de Desarrollo Calpan 2019-2021', '2019-2021', 'Calpan20240416155028.pdf', 26, NULL, 1, '2024-04-16 15:50:28', '2024-05-15 20:43:00');
INSERT INTO `planes_municipales` VALUES (80, 'Plan Municipal de Desarrollo Caltepec 2018-2021', '2018-2021', 'Caltepec20240416155207.pdf', 27, NULL, 1, '2024-04-16 15:52:07', '2024-05-16 19:35:51');
INSERT INTO `planes_municipales` VALUES (81, 'Actualización del Plan Municipal de Desarrollo Caltepec 2021-2024', '2021-2024', '028 CALTEPEC20240416155309.pdf', 27, NULL, 1, '2024-04-16 15:53:09', '2024-05-15 20:45:10');
INSERT INTO `planes_municipales` VALUES (82, 'Plan Municipal de Desarrollo Caltepec 2021-2024', '2021-2024', 'Caltepec_PMD_2021-202420240416155449.pdf', 27, NULL, 1, '2024-04-16 15:54:49', '2024-05-15 20:47:16');
INSERT INTO `planes_municipales` VALUES (83, 'Plan Municipal de Desarrollo Acatzingo 2021-2024', '2021-2024', 'Acatzingo_PMD_2021-202420240416155632.pdf', 4, NULL, 1, '2024-04-16 15:56:32', '2024-05-15 19:49:36');
INSERT INTO `planes_municipales` VALUES (84, 'Plan Municipal de Desarrollo Camocuautla 2021-2024', '2021-2024', 'Camocuautla_PMD-3_2021-202420240416155836.pdf', 28, NULL, 1, '2024-04-16 15:58:36', '2024-05-15 20:49:25');
INSERT INTO `planes_municipales` VALUES (85, 'Plan Municipal de Desarrollo Camocuautla 2018-2021', '2018-2021', 'Plan Desarrollo Municipal Camocuautla20240416155857.pdf', 28, NULL, 1, '2024-04-16 15:58:57', '2024-05-16 19:36:28');
INSERT INTO `planes_municipales` VALUES (87, 'Plan Municipal de Desarrollo Caxhuacan 2021-2024', '2021-2024', 'Caxhuacan_PMD_2021-202420240416160201.pdf', 29, NULL, 1, '2024-04-16 16:02:01', '2024-05-15 20:51:40');
INSERT INTO `planes_municipales` VALUES (88, 'Plan Municipal de Desarrollo Caxhuacan 2018-2021', '2018-2021', 'Caxhuacan20240416160226.pdf', 29, NULL, 1, '2024-04-16 16:02:26', '2024-05-16 19:36:52');
INSERT INTO `planes_municipales` VALUES (89, 'Modificación y Adecuación al Plan Municipal de Desarrollo Coatepec 2021-2024', '2021-2024', '046 COATEPEC20240416160420.pdf', 30, NULL, 1, '2024-04-16 16:04:20', '2024-05-15 20:57:08');
INSERT INTO `planes_municipales` VALUES (90, 'Plan Municipal de Desarrollo Coatepec 2021-2024', '2021-2024', 'Coatepec_PMD_2021-202420240416160453.pdf', 30, NULL, 1, '2024-04-16 16:04:53', '2024-05-15 23:01:31');
INSERT INTO `planes_municipales` VALUES (91, 'Plan Municipal de Desarrollo Coatepec 2018-2021', '2018-2021', 'Coatepec20240416160526.pdf', 30, NULL, 1, '2024-04-16 16:05:26', '2024-05-15 23:02:07');
INSERT INTO `planes_municipales` VALUES (92, 'Plan Municipal de Desarrollo Coatzingo 2021-2024', '2021-2024', 'Coatzingo_PMD_2021-202420240416160726.pdf', 31, NULL, 1, '2024-04-16 16:07:26', '2024-05-15 23:03:41');
INSERT INTO `planes_municipales` VALUES (93, 'Plan Municipal de Desarrollo Coatzingo 2018-2021', '2018-2021', 'Coatzingo20240416160750.pdf', 31, NULL, 1, '2024-04-16 16:07:50', '2024-05-15 23:06:31');
INSERT INTO `planes_municipales` VALUES (94, 'Plan Municipal de Desarrollo Cohetzala 2021-2024', '2021-2024', 'Cohetzala_PMD_2021-202420240416160940.pdf', 32, NULL, 1, '2024-04-16 16:09:40', '2024-05-15 23:06:58');
INSERT INTO `planes_municipales` VALUES (95, 'Plan Municipal de Desarrollo Cohetzala 2018-2021', '2018-2021', 'Cohetzala20240416161004.pdf', 32, NULL, 1, '2024-04-16 16:10:04', '2024-05-15 23:07:40');
INSERT INTO `planes_municipales` VALUES (96, 'Actualización del Plan Municipal de Desarrollo Cohuecán 2021-2024', '2021-2024', '049 COHUECAN20240416161157.pdf', 33, NULL, 1, '2024-04-16 16:11:57', '2024-05-15 23:08:43');
INSERT INTO `planes_municipales` VALUES (97, 'Plan Municipal de Desarrollo Cohuecán 2021-2024', '2021-2024', 'Cohuecan_PMD_2021-202420240416161221.pdf', 33, NULL, 1, '2024-04-16 16:12:21', '2024-05-15 23:09:16');
INSERT INTO `planes_municipales` VALUES (98, 'Plan Municipal de Desarrollo Cohuecán 2018-2021', '2018-2021', 'Cohuecan20240416161246.pdf', 33, NULL, 1, '2024-04-16 16:12:46', '2024-05-15 23:09:42');
INSERT INTO `planes_municipales` VALUES (99, 'Plan Municipal de Desarrollo Coronango 2021-2024', '2021-2024', 'Coronango_PMD_2021-202420240416161358.pdf', 34, NULL, 1, '2024-04-16 16:13:58', '2024-05-15 23:10:23');
INSERT INTO `planes_municipales` VALUES (100, 'Plan Municipal de Desarrollo Coronango 2018-2021', '2018-2021', 'Coronango20240416161426.pdf', 34, NULL, 1, '2024-04-16 16:14:26', '2024-05-15 23:11:51');
INSERT INTO `planes_municipales` VALUES (101, 'Plan Municipal de Desarrollo Coxcatlán 2021-2024', '2021-2024', 'Coxcatlán_PMD_2021-202420240416161615.pdf', 35, NULL, 1, '2024-04-16 16:16:15', '2024-05-15 23:13:45');
INSERT INTO `planes_municipales` VALUES (102, 'Plan Municipal de Desarrollo Coxcatlán 2018-2021', '2018-2021', 'Coxcatlán20240416161641.pdf', 35, NULL, 1, '2024-04-16 16:16:41', '2024-05-15 23:23:32');
INSERT INTO `planes_municipales` VALUES (103, 'Plan Municipal de Desarrollo Coyomeapan 2021-2024', '2021-2024', 'Coyomeapan_PMD_2021-202420240416162154.pdf', 36, NULL, 1, '2024-04-16 16:21:54', '2024-05-15 23:24:00');
INSERT INTO `planes_municipales` VALUES (104, 'Plan Municipal de Desarrollo Coyomeapan 2018-2021', '2018-2021', 'Coyomeapan20240416162222.pdf', 36, NULL, 1, '2024-04-16 16:22:22', '2024-05-15 23:24:30');
INSERT INTO `planes_municipales` VALUES (105, 'Actualización del Plan Municipal de Desarrollo Coyotepec 2021-2024', '2021-2024', '053 COYOTEPEC20240416162502.pdf', 37, NULL, 1, '2024-04-16 16:25:02', '2024-05-15 23:25:10');
INSERT INTO `planes_municipales` VALUES (106, 'Plan Municipal de Desarrollo Coyotepec 2021-2024', '2021-2024', 'Coyotepec_PMD_2021-202420240416162528.pdf', 37, NULL, 1, '2024-04-16 16:25:28', '2024-05-15 23:25:50');
INSERT INTO `planes_municipales` VALUES (107, 'Plan Municipal de Desarrollo Coyotepec 2018-2021', '2018-2021', 'Coyotepec20240416162604.pdf', 37, NULL, 1, '2024-04-16 16:26:04', '2024-05-15 23:26:18');
INSERT INTO `planes_municipales` VALUES (108, 'Modificación y Adecuación al Plan Municipal de Desarrollo Cuapiaxtla de Madero 2021-2024', '2021-2024', '054 CUAPIAXTLA DE MADERO20240416162722.pdf', 38, NULL, 1, '2024-04-16 16:27:22', '2024-05-15 23:27:35');
INSERT INTO `planes_municipales` VALUES (109, 'Plan Municipal de Desarrollo Cuapiaxtla de Madero 2021-2024', '2021-2024', 'Cuapiaxtla de Madero_PMD_2021-202420240416162741.pdf', 38, NULL, 1, '2024-04-16 16:27:41', '2024-05-15 23:28:20');
INSERT INTO `planes_municipales` VALUES (110, 'Plan Municipal de Desarrollo Cuapiaxtla de Madero 2018-2021', '2018-2021', 'Cuapiaxtla de Madero20240416162804.pdf', 38, NULL, 1, '2024-04-16 16:28:04', '2024-05-15 23:28:50');
INSERT INTO `planes_municipales` VALUES (111, 'Plan Municipal de Desarrollo Cuautempan 2021-2024', '2021-2024', 'Cuautempan20240416162954.pdf', 39, NULL, 1, '2024-04-16 16:29:54', '2024-05-15 23:29:18');
INSERT INTO `planes_municipales` VALUES (112, 'Plan Municipal de Desarrollo Cuautempan 2018-2021', '2018-2021', 'Cuautempan220240416163039.pdf', 39, NULL, 1, '2024-04-16 16:30:39', '2024-05-15 23:30:08');
INSERT INTO `planes_municipales` VALUES (113, 'Plan Municipal de Desarrollo Cuautinchán 2021-2024', '2021-2024', 'Cuautinchán_PMD_2021-202420240416163142.pdf', 40, NULL, 1, '2024-04-16 16:31:42', '2024-05-15 23:31:08');
INSERT INTO `planes_municipales` VALUES (114, 'Plan Municipal de Desarrollo Cuautinchán 2018-2021', '2018-2021', 'Cuatinchan20240416163216.pdf', 40, NULL, 1, '2024-04-16 16:32:16', '2024-05-15 23:34:45');
INSERT INTO `planes_municipales` VALUES (115, 'Modificación y Adecuación al Plan Municipal de Desarrollo Cuautlancingo 2021-2024', '2021-2024', '057 CUAUTLANCINGO20240416163328.pdf', 41, NULL, 1, '2024-04-16 16:33:28', '2024-05-15 23:34:15');
INSERT INTO `planes_municipales` VALUES (116, 'Plan Municipal de Desarrollo Cuautlancingo 2021-2024', '2021-2024', 'Cuautlancingo_PMD_2021-202420240416163354.pdf', 41, NULL, 1, '2024-04-16 16:33:54', '2024-05-15 23:35:26');
INSERT INTO `planes_municipales` VALUES (117, 'Plan Municipal de Desarrollo Cuautlancingo 2018-2021', '2018-2021', 'Cuautlancingo20240416163417.pdf', 41, NULL, 1, '2024-04-16 16:34:17', '2024-05-15 23:36:06');
INSERT INTO `planes_municipales` VALUES (118, 'Modificación y Adecuación al Plan Municipal de Desarrollo Cuayuca de Andrade 2021-2024', '2021-2024', '058 CUAYUCA DE ANDRADE20240416163524.pdf', 42, NULL, 1, '2024-04-16 16:35:24', '2024-05-15 23:36:31');
INSERT INTO `planes_municipales` VALUES (119, 'Plan Municipal de Desarrollo Cuayuca de Andrade 2021-2024', '2021-2024', 'Cuayuca de Andrade_PMD_2021-202420240416163544.pdf', 42, NULL, 1, '2024-04-16 16:35:44', '2024-05-15 23:37:21');
INSERT INTO `planes_municipales` VALUES (120, 'Plan Municipal de Desarrollo Cuayuca de Andrade 2018-2021', '2018-2021', 'Cuayuaca de Andrade20240416163608.pdf', 42, NULL, 1, '2024-04-16 16:36:08', '2024-05-15 23:37:55');
INSERT INTO `planes_municipales` VALUES (121, 'Plan Municipal de Desarrollo Cuetzalan del Progreso 2021-2024', '2021-2024', 'Cuetzalan del Progreso_PMD_ 2021-202420240416164042.pdf', 43, NULL, 1, '2024-04-16 16:40:42', '2024-05-15 23:38:20');
INSERT INTO `planes_municipales` VALUES (122, 'Plan Municipal de Desarrollo Cuetzalan del Progreso 2018-2021', '201-2021', 'Cuetzalan del Progreso20240416164111.pdf', 43, NULL, 1, '2024-04-16 16:41:11', '2024-05-15 23:39:45');
INSERT INTO `planes_municipales` VALUES (123, 'Plan Municipal de Desarrollo Cuyoaco 2021-2024', '2021-2024', 'Cuyoaco_PMD_2021-2024 abreviado20240416164217.pdf', 44, NULL, 1, '2024-04-16 16:42:17', '2024-05-15 23:39:03');
INSERT INTO `planes_municipales` VALUES (124, 'Plan Municipal de Desarrollo Cuyoaco 2018-2021', '2018-2021', 'Cuyoaco20240416164241.pdf', 44, NULL, 1, '2024-04-16 16:42:41', '2024-05-15 23:40:20');
INSERT INTO `planes_municipales` VALUES (126, 'Plan Municipal de Desarrollo Chalchicomula de Sesma 2021-2024', '2021-2024', 'Chalchicomula de Sesma_PMD_2021-202420240416164719.pdf', 45, NULL, 1, '2024-04-16 16:47:19', '2024-05-15 20:58:19');
INSERT INTO `planes_municipales` VALUES (127, 'Plan Municipal de Desarrollo Chalchicomula de Sesma 2019-2021', '2019-2021', 'Chalchicomula de Sesma20240416164745.pdf', 45, NULL, 1, '2024-04-16 16:47:45', '2024-05-15 21:02:28');
INSERT INTO `planes_municipales` VALUES (128, 'Modificación y Adecuación al Plan Municipal de Desarrollo Chapulco 2021-2024', '2021-2024', '033 CHAPULCO20240416164845.pdf', 46, NULL, 1, '2024-04-16 16:48:45', '2024-05-15 19:37:42');
INSERT INTO `planes_municipales` VALUES (129, 'Plan Municipal de Desarrollo Chapulco 2021-2024', '2021-2024', 'Chapulco_PMD_2021-202420240416164900.pdf', 46, NULL, 1, '2024-04-16 16:49:00', '2024-05-15 21:05:21');
INSERT INTO `planes_municipales` VALUES (130, 'Plan Municipal de Desarrollo Chapulco 2018-2021', '2018-2021', 'Chapulco20240416164925.pdf', 46, NULL, 1, '2024-04-16 16:49:25', '2024-05-16 19:39:10');
INSERT INTO `planes_municipales` VALUES (131, 'Modificación y Adecuación al Plan Municipal de Desarrollo Chiautla 2021-2024', '2021-2024', '034 CHIAUTLA20240416165041.pdf', 47, NULL, 1, '2024-04-16 16:50:41', '2024-05-15 19:38:46');
INSERT INTO `planes_municipales` VALUES (132, 'Plan Municipal de Desarrollo Chiautla 2021-2024', '2021-2024', 'Chiautla_PMD_2021-202420240416165106.pdf', 47, NULL, 1, '2024-04-16 16:51:06', '2024-05-15 22:33:41');
INSERT INTO `planes_municipales` VALUES (133, 'Plan Municipal de Desarrollo Chiautla 2018-2021', '2018-2021', 'Chiautla20240416165148.pdf', 47, NULL, 1, '2024-04-16 16:51:48', '2024-05-16 19:39:42');
INSERT INTO `planes_municipales` VALUES (134, 'Plan Municipal de Desarrollo Chiautzingo 2021-2024', '2021-2024', 'Chiautzingo_PMD _2021-202420240416165517.pdf', 48, NULL, 1, '2024-04-16 16:55:17', '2024-05-15 22:35:21');
INSERT INTO `planes_municipales` VALUES (135, 'Plan Municipal de Desarrollo Chiautzingo 2018-2021', '2018-2021', 'PMD CHIAUTZINGO20240416165546.pdf', 48, NULL, 1, '2024-04-16 16:55:46', '2024-05-16 19:40:36');
INSERT INTO `planes_municipales` VALUES (136, 'Actualización del Plan Municipal de Desarrollo Chiconcuautla 2021-2024', '2021-2024', '037 CHICONCUAUTLA20240416165648.pdf', 49, NULL, 1, '2024-04-16 16:56:48', '2024-05-15 21:03:44');
INSERT INTO `planes_municipales` VALUES (137, 'Plan Municipal de Desarrollo Chiconcuautla 2021-2024', '2021-2024', 'Chiconcuautla_PMD _2021-202420240416165706.pdf', 49, NULL, 1, '2024-04-16 16:57:06', '2024-05-15 22:41:45');
INSERT INTO `planes_municipales` VALUES (138, 'Plan Municipal de Desarrollo Chiconcuautla 2018-2021', '2018-2021', 'PLAN MUNICIPAL Chiconcuautla20240416165730.pdf', 49, NULL, 1, '2024-04-16 16:57:30', '2024-05-15 23:17:37');
INSERT INTO `planes_municipales` VALUES (139, 'Plan Municipal de Desarrollo Chichiquila 2021-2024', '2021-2024', 'Chichiquila_PMD 2021-202420240416165912.pdf', 50, NULL, 1, '2024-04-16 16:59:12', '2024-05-15 22:36:40');
INSERT INTO `planes_municipales` VALUES (140, 'Plan Municipal de Desarrollo Chichiquila 2018-2021', '2018-2021', 'Chichiquila20240416165932.pdf', 50, NULL, 1, '2024-04-16 16:59:32', '2024-05-16 19:44:54');
INSERT INTO `planes_municipales` VALUES (141, 'Modificación y Adecuación al Plan Municipal de Desarrollo Chietla 2021-2024', '2021-2024', '038 CHIETLA20240416170037.pdf', 51, NULL, 1, '2024-04-16 17:00:37', '2024-05-15 19:48:19');
INSERT INTO `planes_municipales` VALUES (142, 'Plan Municipal de Desarrollo Chietla 2021-2024', '2021-2024', 'Chietla_PMD_2021-202420240416170054.pdf', 51, NULL, 1, '2024-04-16 17:00:54', '2024-05-15 22:42:49');
INSERT INTO `planes_municipales` VALUES (143, 'Plan Municipal de Desarrollo Chietla 2018-2021', '2018-2021', 'Chietla20240416170132.pdf', 51, NULL, 1, '2024-04-16 17:01:32', '2024-05-16 22:47:02');
INSERT INTO `planes_municipales` VALUES (144, 'Plan Municipal de Desarrollo Chigmecatitlán 2021-2024', '2021-2024', 'Chigmecatitlán_PMD_ 2021-202420240416170243.pdf', 52, NULL, 1, '2024-04-16 17:02:43', '2024-05-15 22:44:17');
INSERT INTO `planes_municipales` VALUES (145, 'Plan Municipal de Desarrollo Chigmecatitlán 2018-2021', '2018-2021', 'PLAN DE DESARROLLO MUNICIPAL CHIGMECATITLÁN20240416170303.pdf', 52, NULL, 1, '2024-04-16 17:03:03', '2024-05-16 19:45:51');
INSERT INTO `planes_municipales` VALUES (146, 'Modificación y Adecuación al Plan Municipal de Desarrollo Chignautla 2021-2024', '2021-2024', '041 CHIGNAUTLA20240416170400.pdf', 54, NULL, 1, '2024-04-16 17:04:00', '2024-05-15 22:47:34');
INSERT INTO `planes_municipales` VALUES (147, 'Plan Municipal de Desarrollo Chignautla 2021-2024', '2021-2024', 'Chignautla_PMD_ 2021-202420240416170418.pdf', 54, NULL, 1, '2024-04-16 17:04:18', '2024-05-15 22:47:58');
INSERT INTO `planes_municipales` VALUES (148, 'Plan Municipal de Desarrollo Chignautla 2018-2021', '2018-2021', 'Chignautla20240416170442.pdf', 54, NULL, 1, '2024-04-16 17:04:42', '2024-05-16 19:48:50');
INSERT INTO `planes_municipales` VALUES (149, 'Plan Municipal de Desarrollo Chila 2021-2024', '2021-2024', 'Chila_PMD_2021-202420240416170530.pdf', 55, NULL, 1, '2024-04-16 17:05:30', '2024-05-15 22:48:58');
INSERT INTO `planes_municipales` VALUES (150, 'Plan Municipal de Desarrollo Chila 2018-2021', '2018-2021', 'Chila20240416170553.pdf', 55, NULL, 1, '2024-04-16 17:05:53', '2024-05-16 19:50:44');
INSERT INTO `planes_municipales` VALUES (151, 'Plan Municipal de Desarrollo Chila 2021-2024', '2021-2024', 'PMD_CHILADELASAL_2021202420240416170639.pdf', 56, NULL, 1, '2024-04-16 17:06:39', '2024-05-15 22:50:03');
INSERT INTO `planes_municipales` VALUES (152, 'Plan Municipal de Desarrollo Chila 2018-2021', '2018-2021', 'PMD Chila de la Sal version completa20240416170700.pdf', 56, NULL, 1, '2024-04-16 17:07:00', '2024-05-16 19:52:12');
INSERT INTO `planes_municipales` VALUES (153, 'Plan Municipal de Desarrollo Honey 2021-2024', '2021-2024', 'PMDHoney20240416171142.pdf', 57, NULL, 1, '2024-04-16 17:11:42', '2024-05-15 23:40:57');
INSERT INTO `planes_municipales` VALUES (154, 'Plan Municipal de Desarrollo Honey 2018-2021', '2018-2021', 'Honey20240416171241.pdf', 57, NULL, 1, '2024-04-16 17:12:41', '2024-05-16 00:00:39');
INSERT INTO `planes_municipales` VALUES (155, 'Plan Municipal de Desarrollo Chilchotla 2021-2024', '2022-2024', 'Chilchotla_PMD_2022 - 202420240416171412.pdf', 58, NULL, 1, '2024-04-16 17:14:12', '2024-05-15 22:51:58');
INSERT INTO `planes_municipales` VALUES (156, 'Plan Municipal de Desarrollo Chilchotla 2018-2021', '2018-2021', 'PMD CHIILCHOTLA20240416171437.pdf', 58, NULL, 1, '2024-04-16 17:14:37', '2024-05-16 19:52:41');
INSERT INTO `planes_municipales` VALUES (157, 'Actualización del Plan Municipal de Desarrollo Chinantla 2021-2024', '2021-2024', '045 CHINANTLA20240416171600.pdf', 59, NULL, 1, '2024-04-16 17:16:00', '2024-05-15 22:54:02');
INSERT INTO `planes_municipales` VALUES (158, 'Plan Municipal de Desarrollo Chinantla 2021-2024', '2021-2024', 'Chinantla_PMD _021-202420240416171617.pdf', 59, NULL, 1, '2024-04-16 17:16:17', '2024-05-15 22:56:13');
INSERT INTO `planes_municipales` VALUES (159, 'Plan Municipal de Desarrollo Chinantla 2018-2021', '2018-2021', 'Chinantla20240416171639.pdf', 59, NULL, 1, '2024-04-16 17:16:39', '2024-05-15 22:59:19');
INSERT INTO `planes_municipales` VALUES (161, 'Plan Municipal de Desarrollo Domingo Arenas 2021-2024', '2021-2024', 'Domingo Arenas_PMD_2021-202420240509204601.pdf', 60, NULL, 1, '2024-05-09 20:46:01', '2024-05-15 23:41:35');
INSERT INTO `planes_municipales` VALUES (162, 'Plan Municipal de Desarrollo Domingo Arenas 2018-2021', '2018-2021', 'Domingo Arenas20240513180002.pdf', 60, NULL, 1, '2024-05-13 18:00:02', '2024-05-15 23:43:19');
INSERT INTO `planes_municipales` VALUES (163, 'Actualización del Plan Municipal de Desarrollo Domingo Arenas 2021-2024', '2021-2024', '061 DOMINGO ARENAS20240513180100.pdf', 60, NULL, 1, '2024-05-13 18:01:00', '2024-05-15 23:43:57');
INSERT INTO `planes_municipales` VALUES (164, 'Plan Municipal de Desarrollo Eloxochitlán 2018-2021', '2018-2021', 'Eloxochitlan20240513180314.pdf', 61, NULL, 1, '2024-05-13 18:03:14', '2024-05-15 23:44:40');
INSERT INTO `planes_municipales` VALUES (165, 'Plan Municipal de Desarrollo Eloxochitlán 2021-2024', '2021-2024', 'Eloxochitlán_PMD_ 2021-202420240513180333.pdf', 61, NULL, 1, '2024-05-13 18:03:33', '2024-05-15 23:45:06');
INSERT INTO `planes_municipales` VALUES (166, 'Plan Municipal de Desarrollo Epatlán 2018-2021', '2018-2021', 'Epatlán20240513180505.pdf', 62, NULL, 1, '2024-05-13 18:05:05', '2024-05-15 23:45:57');
INSERT INTO `planes_municipales` VALUES (167, 'Plan Municipal de Desarrollo Epatlán 2021-2024', '2021-2024', 'Epatlán_PMD_2021-202420240513180523.pdf', 62, NULL, 1, '2024-05-13 18:05:23', '2024-05-15 23:47:14');
INSERT INTO `planes_municipales` VALUES (168, 'Actualización del Plan Municipal de Desarrollo Epatlán 2021-2024', '2021-2024', '063 EPATLAN20240513180553.pdf', 62, NULL, 1, '2024-05-13 18:05:53', '2024-05-15 23:46:41');
INSERT INTO `planes_municipales` VALUES (169, 'Plan Municipal de Desarrollo Esperanza 2018-2021', '2018-2021', 'Esperanza20240513180718.pdf', 63, NULL, 1, '2024-05-13 18:07:18', '2024-05-15 23:47:45');
INSERT INTO `planes_municipales` VALUES (170, 'Plan Municipal de Desarrollo Esperanza 2021-2024', '2021-2024', 'Esperanza_PMD _ 2021-202420240513180738.pdf', 63, NULL, 1, '2024-05-13 18:07:38', '2024-05-15 23:48:34');
INSERT INTO `planes_municipales` VALUES (171, 'Modificación y Adecuación al Plan Municipal de Desarrollo Esperanza 2021-2024', '2021-2024', '064 ESPERANZA20240513180758.pdf', 63, NULL, 1, '2024-05-13 18:07:58', '2024-05-15 23:49:00');
INSERT INTO `planes_municipales` VALUES (172, 'Plan Municipal de Desarrollo Francisco Z. Mena 2018-2021', '2018-2021', 'PLAN DE DESARROLLO MUNICIPAL FRANCISCO Z. MENA20240513180859.pdf', 64, NULL, 1, '2024-05-13 18:08:59', '2024-05-16 22:52:11');
INSERT INTO `planes_municipales` VALUES (173, 'Plan Municipal de Desarrollo Francisco Z. Mena 2021-2024', '2021-2024', 'Francisco Z Mena_PMD_2021-202420240513180914.pdf', 64, NULL, 1, '2024-05-13 18:09:14', '2024-05-15 23:50:17');
INSERT INTO `planes_municipales` VALUES (174, 'Plan Municipal de Desarrollo General Felipe Ángeles 2018-2021', '2018-2021', 'General Felipe Angeles20240513181018.pdf', 65, NULL, 1, '2024-05-13 18:10:18', '2024-05-15 23:51:00');
INSERT INTO `planes_municipales` VALUES (175, 'Plan Municipal de Desarrollo General Felipe Ángeles 2021-2024', '2021-2024', 'General Felipe Ángeles_PMD_2021-202420240513181041.pdf', 65, NULL, 1, '2024-05-13 18:10:41', '2024-05-15 23:52:45');
INSERT INTO `planes_municipales` VALUES (176, 'Modificación y Adecuación al Plan Municipal de Desarrollo General Felipe Ángeles 2021-2024', '2021-2024', '66 FELIPE ANGELES20240513181100.pdf', 65, NULL, 1, '2024-05-13 18:11:00', '2024-05-15 23:53:28');
INSERT INTO `planes_municipales` VALUES (177, 'Plan Municipal de Desarrollo Guadalupe 2018-2021', '2018-2021', 'Guadalupe20240513181231.pdf', 66, NULL, 1, '2024-05-13 18:12:31', '2024-05-15 23:54:15');
INSERT INTO `planes_municipales` VALUES (178, 'Plan Municipal de Desarrollo Guadalupe 2021-2024', '2021-2024', 'Guadalupe_PMD_2021-202420240513181252.pdf', 66, NULL, 1, '2024-05-13 18:12:52', '2024-05-15 23:55:33');
INSERT INTO `planes_municipales` VALUES (179, 'Plan Municipal de Desarrollo Guadalupe Victoria 2019-2021', '2019-2021', 'Gudalupe Victoria20240513181518.pdf', 67, NULL, 1, '2024-05-13 18:15:18', '2024-05-15 23:54:59');
INSERT INTO `planes_municipales` VALUES (180, 'Plan Municipal de Desarrollo Guadalupe Victoria 2021-2024', '2021-2024', 'Guadalupe Victoria_PMD_2021-202420240513181539.pdf', 67, NULL, 1, '2024-05-13 18:15:39', '2024-05-15 23:56:42');
INSERT INTO `planes_municipales` VALUES (181, 'Modificación y Adecuación al Plan Municipal de Desarrollo Guadalupe Victoria 2021-2024', '2021-2024', '068 GUADALUPE VICTORIA20240513181605.pdf', 67, NULL, 1, '2024-05-13 18:16:05', '2024-05-15 23:56:11');
INSERT INTO `planes_municipales` VALUES (182, 'Plan Municipal de Desarrollo Hermenegildo Galeana 2018-2021', '2018-2021', 'Hermenegildo Galeana20240513181716.pdf', 68, NULL, 1, '2024-05-13 18:17:16', '2024-05-15 23:57:44');
INSERT INTO `planes_municipales` VALUES (183, 'Plan Municipal de Desarrollo Hermenegildo Galeana 2021-2024', '2021-2024', 'Hermenegildo Galeana_PMD_2021-202420240513181734.pdf', 68, NULL, 1, '2024-05-13 18:17:34', '2024-05-16 00:00:04');
INSERT INTO `planes_municipales` VALUES (184, 'Plan Municipal de Desarrollo Huaquechula 2018-2021', '2018-2021', 'Huaquechula20240513181840.pdf', 69, NULL, 1, '2024-05-13 18:18:40', '2024-05-16 22:53:57');
INSERT INTO `planes_municipales` VALUES (185, 'Plan Municipal de Desarrollo Huaquechula 2021-2024', '2021-2024', 'Huaquechula_PMD_2021-202420240513181858.pdf', 69, NULL, 1, '2024-05-13 18:18:58', '2024-05-16 00:01:46');
INSERT INTO `planes_municipales` VALUES (186, 'Actualización del Plan Municipal de Desarrollo Huaquechula 2021-2024', '2021-2024', '071 HUAQUECHULA20240513181916.pdf', 69, NULL, 1, '2024-05-13 18:19:16', '2024-05-16 00:02:42');
INSERT INTO `planes_municipales` VALUES (187, 'Plan Municipal de Desarrollo Huatlatlauca 2018-2021', '2018-2021', 'Huatlatlauca20240513182027.pdf', 70, NULL, 1, '2024-05-13 18:20:27', '2024-05-16 22:52:58');
INSERT INTO `planes_municipales` VALUES (188, 'Plan Municipal de Desarrollo Huatlatlauca 2021-2024', '2021-2024', 'Huatlatlauca_PMD_2021-202420240513182050.pdf', 70, NULL, 1, '2024-05-13 18:20:50', '2024-05-16 00:04:29');
INSERT INTO `planes_municipales` VALUES (189, 'Plan Municipal de Desarrollo Huauchinango 2018-2021', '2018-2021', 'Huauchinango20240513182138.pdf', 71, NULL, 1, '2024-05-13 18:21:38', '2024-05-16 00:06:49');
INSERT INTO `planes_municipales` VALUES (190, 'Plan Municipal de Desarrollo Huauchinango 2021-2024', '2021-2024', 'Huauchinango_PMD 2021-202420240513182207.pdf', 71, NULL, 1, '2024-05-13 18:22:07', '2024-05-16 00:08:44');
INSERT INTO `planes_municipales` VALUES (191, 'Plan Municipal de Desarrollo Huehuetla 2018-2021', '2018-2021', 'Huehuetla20240513182256.pdf', 72, NULL, 1, '2024-05-13 18:22:56', '2024-05-16 00:10:37');
INSERT INTO `planes_municipales` VALUES (192, 'Plan Municipal de Desarrollo Huehuetla 2021-2024', '2021-2024', 'Huehuetla PMD 2021-202420240513182313.pdf', 72, NULL, 1, '2024-05-13 18:23:13', '2024-05-16 00:11:04');
INSERT INTO `planes_municipales` VALUES (193, 'Actualización del Plan Municipal de Desarrollo Huehuetla 2021-2024', '2021-2024', '074 HUEHUETLA20240513182343.pdf', 72, NULL, 1, '2024-05-13 18:23:43', '2024-05-16 00:11:56');
INSERT INTO `planes_municipales` VALUES (194, 'Plan Municipal de Desarrollo Huehuetlán el Chico 2018-2021', '2018-2021', 'Huehuetlan El Chico20240513183031.pdf', 73, NULL, 1, '2024-05-13 18:30:31', '2024-05-16 00:12:45');
INSERT INTO `planes_municipales` VALUES (195, 'Plan Municipal de Desarrollo Huehuetlán el Chico 2021-2024', '2021-2024', 'Huehuetlán el Chico_PMD_2021-202420240513183049.pdf', 73, NULL, 1, '2024-05-13 18:30:49', '2024-05-16 00:13:30');
INSERT INTO `planes_municipales` VALUES (196, 'Actualización del Plan Municipal de Desarrollo Huehuetlán el Chico 2021-2024', '2021-2024', '075 HUEHUETLAN EL CHICO20240513183114.pdf', 73, NULL, 1, '2024-05-13 18:31:14', '2024-05-16 00:14:34');
INSERT INTO `planes_municipales` VALUES (197, 'Plan Municipal de Desarrollo Huehuetlán el Grande 2018-2021', '2018-2021', 'Huehuetlán el Grande20240513183301.pdf', 150, NULL, 1, '2024-05-13 18:33:01', '2024-05-16 22:50:03');
INSERT INTO `planes_municipales` VALUES (198, 'Plan Municipal de Desarrollo Huehuetlán el Grande 2021-2024', '2021-2024', 'Huehuetlan El Grande_PMD_2021_2024 (1)20240513183329.pdf', 150, NULL, 1, '2024-05-13 18:33:29', '2024-05-16 00:16:23');
INSERT INTO `planes_municipales` VALUES (199, 'Plan Municipal de Desarrollo Huejotzingo 2018-2021', '2018-2021', 'Huejotzingo20240513183430.pdf', 74, NULL, 1, '2024-05-13 18:34:30', '2024-05-16 00:17:07');
INSERT INTO `planes_municipales` VALUES (200, 'Plan Municipal de Desarrollo Huejotzingo 2021-2024', '2021-2024', 'Huejotzingo_PMD_2021-202420240513183457.pdf', 74, NULL, 1, '2024-05-13 18:34:57', '2024-05-16 00:19:53');
INSERT INTO `planes_municipales` VALUES (201, 'Plan Municipal de Desarrollo Hueyapan 2018-2021', '2018-2021', 'Hueyapan20240513183543.pdf', 75, NULL, 1, '2024-05-13 18:35:43', '2024-05-16 00:20:37');
INSERT INTO `planes_municipales` VALUES (202, 'Plan Municipal de Desarrollo Hueyapan 2021-2024', '2021-2024', 'Hueyapan_PMD_2021-202420240513183602.pdf', 75, NULL, 1, '2024-05-13 18:36:02', '2024-05-16 00:21:19');
INSERT INTO `planes_municipales` VALUES (203, 'Plan Municipal de Desarrollo Hueytamalco 2018-2021', '2018-2021', 'Hueytamalco20240513183703.pdf', 76, NULL, 1, '2024-05-13 18:37:03', '2024-05-16 00:22:05');
INSERT INTO `planes_municipales` VALUES (204, 'Plan Municipal de Desarrollo Hueytamalco 2021-2024', '2021-2024', 'Hueytamalco_PMD_ 2021-202420240513183718.pdf', 76, NULL, 1, '2024-05-13 18:37:18', '2024-05-16 00:23:05');
INSERT INTO `planes_municipales` VALUES (205, 'Plan Municipal de Desarrollo Hueytlalpan 2018-2021', '2018-2021', 'Hueytlalpan20240513184046.pdf', 77, NULL, 1, '2024-05-13 18:40:46', '2024-05-16 00:23:52');
INSERT INTO `planes_municipales` VALUES (206, 'Plan Municipal de Desarrollo Hueytlalpan 2021-2024', '2021-2024', 'Hueytlalpan_PDM_2021-202420240513184104.pdf', 77, NULL, 1, '2024-05-13 18:41:04', '2024-05-16 00:24:36');
INSERT INTO `planes_municipales` VALUES (207, 'Plan Municipal de Desarrollo Huitzilan de Serdán 2018-2021', '2018-2021', 'Huitzilan de Serdán Puebla20240513184224.pdf', 78, NULL, 1, '2024-05-13 18:42:24', '2024-05-16 00:25:18');
INSERT INTO `planes_municipales` VALUES (208, 'Plan Municipal de Desarrollo Huitzilan de Serdán 2021-2024', '2021-2024', 'Huitzilan de Serdán_PMD_2021-202420240513184247.pdf', 78, NULL, 1, '2024-05-13 18:42:47', '2024-05-16 00:26:03');
INSERT INTO `planes_municipales` VALUES (209, 'Actualización del Plan Municipal de Desarrollo Huitzilan de Serdán 2021-2024', '2021-2024', '081 HUITZILAN DE SERDÁN20240513184311.pdf', 78, NULL, 1, '2024-05-13 18:43:11', '2024-05-16 00:26:38');
INSERT INTO `planes_municipales` VALUES (210, 'Plan Municipal de Desarrollo Huitziltepec 2018-2021', '2018-2021', 'Huitziltepec20240513184400.pdf', 79, NULL, 1, '2024-05-13 18:44:00', '2024-05-16 00:27:20');
INSERT INTO `planes_municipales` VALUES (211, 'Plan Municipal de Desarrollo Huitziltepec 2021-2024', '2021-2024', 'Huitziltepec_PMD 2021-202420240513184434.pdf', 79, NULL, 1, '2024-05-13 18:44:34', '2024-05-16 00:27:52');
INSERT INTO `planes_municipales` VALUES (212, 'Actualización del Plan Municipal de Desarrollo Huitziltepec 2021-2024', '2021-2024', '081 HUITZILTEPEC20240513184458.pdf', 79, NULL, 1, '2024-05-13 18:44:58', '2024-05-16 00:28:45');
INSERT INTO `planes_municipales` VALUES (213, 'Plan Municipal de Desarrollo Ixcamilpa de Guerrero 2018-2021', '2018-2021', 'Ixcamilpa de Guerrero20240513184915.pdf', 81, NULL, 1, '2024-05-13 18:49:15', '2024-05-16 00:29:28');
INSERT INTO `planes_municipales` VALUES (214, 'Plan Municipal de Desarrollo Ixcamilpa de Guerrero 2021-2024', '2021-2024', 'Ixcamilpa de Guerrero_PMD_2021-202420240513184935.pdf', 81, NULL, 1, '2024-05-13 18:49:35', '2024-05-16 00:30:03');
INSERT INTO `planes_municipales` VALUES (215, 'Plan Municipal de Desarrollo Ixcaquixtla 2018-2021', '2018-2021', 'Ixcaquixtla20240513185029.pdf', 82, NULL, 1, '2024-05-13 18:50:29', '2024-05-16 00:30:49');
INSERT INTO `planes_municipales` VALUES (216, 'Plan Municipal de Desarrollo Ixcaquixtla 2021-2024', '2021-2024', 'Ixcaquixtla_PMD_2021-202420240513185104.pdf', 82, NULL, 1, '2024-05-13 18:51:04', '2024-05-16 00:31:23');
INSERT INTO `planes_municipales` VALUES (217, 'Actualización del Plan Municipal de Desarrollo Ixcaquixtla 2021-2024', '2021-2024', 'IXCAQUIXTLA 2021 - 202420240513185127.pdf', 82, NULL, 1, '2024-05-13 18:51:27', '2024-05-16 00:31:55');
INSERT INTO `planes_municipales` VALUES (218, 'Plan Municipal de Desarrollo Ixtacamaxtitlán 2018-2021', '2018-2021', 'Ixtacamaxtitlán20240513185349.pdf', 83, NULL, 1, '2024-05-13 18:53:49', '2024-05-16 00:32:50');
INSERT INTO `planes_municipales` VALUES (219, 'Plan Municipal de Desarrollo Ixtacamaxtitlán 2021-2024', '2021-2024', 'Ixtacamaxtitlán20240513185932.pdf', 83, NULL, 1, '2024-05-13 18:59:32', '2024-05-16 00:33:33');
INSERT INTO `planes_municipales` VALUES (220, 'Plan Municipal de Desarrollo Ixtepec 2018-2021', '2018-2021', 'Ixtepec20240513190104.pdf', 84, NULL, 1, '2024-05-13 19:01:04', '2024-05-16 00:34:21');
INSERT INTO `planes_municipales` VALUES (221, 'Plan Municipal de Desarrollo Ixtepec 2021-2024', '2021-2024', 'Ixtepec_PMD_2021-202420240513190121.pdf', 84, NULL, 1, '2024-05-13 19:01:21', '2024-05-16 00:35:21');
INSERT INTO `planes_municipales` VALUES (222, 'Plan Municipal de Desarrollo Izúcar de Matamoros 2018-2021', '2018-2021', 'Izúcar de Matamoros20240513190230.pdf', 85, NULL, 1, '2024-05-13 19:02:30', '2024-05-16 00:36:15');
INSERT INTO `planes_municipales` VALUES (223, 'Plan Municipal de Desarrollo Izúcar de Matamoros 2021-2024', '2021-2024', 'Izúcar de Matamoros_PMD_2022-202420240513190249.pdf', 85, NULL, 1, '2024-05-13 19:02:49', '2024-05-16 00:37:21');
INSERT INTO `planes_municipales` VALUES (224, 'Actualización del Plan Municipal de Desarrollo Izúcar de Matamoros 2021-2024', '2021-2024', '087 IZUCAR DE MATAMOROS20240513190315.pdf', 85, NULL, 1, '2024-05-13 19:03:15', '2024-05-16 00:38:02');
INSERT INTO `planes_municipales` VALUES (225, 'Plan Municipal de Desarrollo Jalpan 2018-2021', '2018-2021', 'Jalpan20240513190401.pdf', 86, NULL, 1, '2024-05-13 19:04:01', '2024-05-16 00:38:46');
INSERT INTO `planes_municipales` VALUES (226, 'Plan Municipal de Desarrollo Jalpan 2021-2024', '2021-2024', 'Jalpan_PMD_ 2021-202420240513190416.pdf', 86, NULL, 1, '2024-05-13 19:04:16', '2024-05-16 00:39:16');
INSERT INTO `planes_municipales` VALUES (227, 'Plan Municipal de Desarrollo Jolalpan 2018-2021', '2018-2021', 'Jolalpan20240513190450.pdf', 87, NULL, 1, '2024-05-13 19:04:50', '2024-05-16 00:40:38');
INSERT INTO `planes_municipales` VALUES (228, 'Plan Municipal de Desarrollo Jolalpan 2021-2024', '2021-2024', 'Jolalpan_PMD_2021-202420240513190504.pdf', 87, NULL, 1, '2024-05-13 19:05:04', '2024-05-16 00:41:08');
INSERT INTO `planes_municipales` VALUES (229, 'Plan Municipal de Desarrollo Jonotla 2018-2021', '2018-2021', 'Jonotla20240513190542.pdf', 88, NULL, 1, '2024-05-13 19:05:42', '2024-05-16 00:41:46');
INSERT INTO `planes_municipales` VALUES (230, 'Plan Municipal de Desarrollo Jonotla 2021-2024', '2021-2024', 'Jonotla_PMD _ 2021-202420240513190602.pdf', 88, NULL, 1, '2024-05-13 19:06:02', '2024-05-16 15:15:52');
INSERT INTO `planes_municipales` VALUES (231, 'Plan Municipal de Desarrollo Jopala 2018-2021', '2018-2021', 'Jopala20240513190653.pdf', 89, NULL, 1, '2024-05-13 19:06:53', '2024-05-16 15:16:54');
INSERT INTO `planes_municipales` VALUES (232, 'Plan Municipal de Desarrollo Jopala 2021-2024', '2021-2024', 'Jopala_PMD_2021-202420240513190714.pdf', 89, NULL, 1, '2024-05-13 19:07:14', '2024-05-16 15:17:39');
INSERT INTO `planes_municipales` VALUES (233, 'Plan Municipal de Desarrollo Juan C. Bonilla 2018-2021', '2018-2021', 'Juan C. Bonilla20240513190759.pdf', 90, NULL, 1, '2024-05-13 19:07:59', '2024-05-16 15:19:18');
INSERT INTO `planes_municipales` VALUES (234, 'Plan Municipal de Desarrollo Juan C. Bonilla 2021-2024', '2021-2024', 'Juan C. Bonilla_PMD_2021-202420240513190816.pdf', 90, NULL, 1, '2024-05-13 19:08:16', '2024-05-16 15:22:59');
INSERT INTO `planes_municipales` VALUES (235, 'Actualización del Plan Municipal de Desarrollo Juan C. Bonilla 2021-2024', '2021-2024', '092 JUAN C. BONILLA20240513190831.pdf', 90, NULL, 1, '2024-05-13 19:08:31', '2024-05-16 15:23:48');
INSERT INTO `planes_municipales` VALUES (236, 'Plan Municipal de Desarrollo Juan Galindo 2018-2021', '2018-2021', 'Juan Galindo20240513190912.pdf', 91, NULL, 1, '2024-05-13 19:09:12', '2024-05-16 15:24:38');
INSERT INTO `planes_municipales` VALUES (237, 'Plan Municipal de Desarrollo Juan Galindo 2021-2024', '2021-2024', 'Juan Galindo_PMD_2021-202420240513190927.pdf', 91, NULL, 1, '2024-05-13 19:09:27', '2024-05-16 15:25:20');
INSERT INTO `planes_municipales` VALUES (238, 'Plan Municipal de Desarrollo Juan N. Méndez 2018-2021', '2018-2021', 'Juan N. Méndez20240513191005.pdf', 92, NULL, 1, '2024-05-13 19:10:05', '2024-05-16 15:26:18');
INSERT INTO `planes_municipales` VALUES (239, 'Plan Municipal de Desarrollo Juan N. Méndez 2021-2024', '2021-2024', 'Juan N. Méndez_PMD_2021-202420240513191019.pdf', 92, NULL, 1, '2024-05-13 19:10:19', '2024-05-16 15:27:16');
INSERT INTO `planes_municipales` VALUES (240, 'Plan Municipal de Desarrollo La Magdalena Tlatlauquitepec 2018-2021', '2018-2021', 'La MagdalenaTlatlauquitepec20240513191112.pdf', 95, NULL, 1, '2024-05-13 19:11:12', '2024-05-16 22:49:17');
INSERT INTO `planes_municipales` VALUES (241, 'Plan Municipal de Desarrollo La Magdalena Tlatlauquitepec 2021-2024', '2021-2024', 'La Magdalena Tlatlauquitepec _PMD_2021-202420240513191128.pdf', 95, NULL, 1, '2024-05-13 19:11:28', '2024-05-16 15:28:52');
INSERT INTO `planes_municipales` VALUES (242, 'Plan Municipal de Desarrollo Lafragua 2018-2021', '2018-2021', 'Lafragua20240513191226.pdf', 93, NULL, 1, '2024-05-13 19:12:26', '2024-05-16 15:31:38');
INSERT INTO `planes_municipales` VALUES (243, 'Plan Municipal de Desarrollo Lafragua 2021-2024', '2021-2024', 'Lafragua_PMD_2021-202420240513191240.pdf', 93, NULL, 1, '2024-05-13 19:12:40', '2024-05-16 15:32:16');
INSERT INTO `planes_municipales` VALUES (244, 'Actualización del Plan Municipal de Desarrollo Lafragua 2021-2024', '2021-2024', '096 LAFRAGUA20240513191252.pdf', 93, NULL, 1, '2024-05-13 19:12:52', '2024-05-16 15:32:59');
INSERT INTO `planes_municipales` VALUES (245, 'Plan Municipal de Desarrollo Libres 2018-2021', '2018-2021', 'Libres20240513191336.pdf', 94, NULL, 1, '2024-05-13 19:13:36', '2024-05-16 15:33:51');
INSERT INTO `planes_municipales` VALUES (246, 'Plan Municipal de Desarrollo Libres 2021-2024', '2021-2024', 'Libres_PMD_2021-202420240513191358.pdf', 94, NULL, 1, '2024-05-13 19:13:58', '2024-05-16 15:35:07');
INSERT INTO `planes_municipales` VALUES (247, 'Plan Municipal de Desarrollo Los Reyes de Juárez 2018-2021', '2018-2021', 'Los Reyes de Juárez20240513191439.pdf', 118, NULL, 1, '2024-05-13 19:14:39', '2024-05-16 15:34:30');
INSERT INTO `planes_municipales` VALUES (248, 'Plan Municipal de Desarrollo Los Reyes de Juárez 2021-2024', '2021-2024', 'Los Reyes de Juarez_PMD_ 2021-202420240513191451.pdf', 118, NULL, 1, '2024-05-13 19:14:51', '2024-05-16 15:36:05');
INSERT INTO `planes_municipales` VALUES (249, 'Plan Municipal de Desarrollo Mazapiltepec de Juárez 2018-2021', '2018-2021', 'Mazapiltepec de Juárez20240513191847.pdf', 96, NULL, 1, '2024-05-13 19:18:47', '2024-05-16 22:48:58');
INSERT INTO `planes_municipales` VALUES (250, 'Plan Municipal de Desarrollo Mazapiltepec de Juárez 2021-2024', '2021-2024', 'Mazapiltepec de Juárez_PMD_2021-202420240513191901.pdf', 96, NULL, 1, '2024-05-13 19:19:01', '2024-05-16 15:39:19');
INSERT INTO `planes_municipales` VALUES (251, 'Actualización del Plan Municipal de Desarrollo Mazapiltepec de Juárez 2021-2024', '2021-2024', '99 MAZAPILTEPEC20240513191917.pdf', 96, NULL, 1, '2024-05-13 19:19:17', '2024-05-16 15:42:18');
INSERT INTO `planes_municipales` VALUES (252, 'Plan Municipal de Desarrollo Mixtla 2019-2021', '2019-2021', 'Mixtla20240513192025.pdf', 97, NULL, 1, '2024-05-13 19:20:25', '2024-05-16 15:43:10');
INSERT INTO `planes_municipales` VALUES (253, 'Plan Municipal de Desarrollo Mixtla 2021-2024', '2021-2024', 'Mixtla_PMD_2021-202420240513192038.pdf', 97, NULL, 1, '2024-05-13 19:20:38', '2024-05-16 15:56:00');
INSERT INTO `planes_municipales` VALUES (254, 'Plan Municipal de Desarrollo Molcaxac 2018-2021', '2018-2021', 'Molcaxac20240513192124.pdf', 98, NULL, 1, '2024-05-13 19:21:24', '2024-05-16 15:56:40');
INSERT INTO `planes_municipales` VALUES (255, 'Plan Municipal de Desarrollo Molcaxac 2021-2024', '2021-2024', 'Molcaxac_PMD_2021-202420240513192207.pdf', 98, NULL, 1, '2024-05-13 19:22:07', '2024-05-16 15:57:25');
INSERT INTO `planes_municipales` VALUES (256, 'Actualización del Plan Municipal de Desarrollo Molcaxac 2021-2024', '2021-2024', '101 MOLCAXAC20240513192344.pdf', 98, NULL, 1, '2024-05-13 19:23:44', '2024-05-16 15:58:47');
INSERT INTO `planes_municipales` VALUES (257, 'Plan Municipal de Desarrollo Naupan 2018-2021', '2018-2021', 'Naupan20240513192436.pdf', 100, NULL, 1, '2024-05-13 19:24:36', '2024-05-16 15:59:46');
INSERT INTO `planes_municipales` VALUES (258, 'Plan Municipal de Desarrollo Naupan 2021-2024', '2021-2024', 'Naupan_PMD_2021 -202420240513192450.pdf', 100, NULL, 1, '2024-05-13 19:24:50', '2024-05-16 16:01:06');
INSERT INTO `planes_municipales` VALUES (259, 'Actualización del Plan Municipal de Desarrollo Naupan 2021-2024', '2021-2024', '102 NAUPAN20240513192507.pdf', 100, NULL, 1, '2024-05-13 19:25:07', '2024-05-16 16:02:41');
INSERT INTO `planes_municipales` VALUES (260, 'Plan Municipal de Desarrollo Nauzontla 2019-2021', '2018-2021', 'Nauzontla20240513192552.pdf', 101, NULL, 1, '2024-05-13 19:25:52', '2024-05-16 16:05:49');
INSERT INTO `planes_municipales` VALUES (261, 'Plan Municipal de Desarrollo Nauzontla 2021-2024', '2021-2024', 'Nauzontla_PMD_2021-202420240513192608.pdf', 101, NULL, 1, '2024-05-13 19:26:08', '2024-05-16 16:08:48');
INSERT INTO `planes_municipales` VALUES (262, 'Plan Municipal de Desarrollo Nealtican 2018-2021', '2018-2021', 'Nealtican20240513192647.pdf', 102, NULL, 1, '2024-05-13 19:26:47', '2024-05-16 16:11:04');
INSERT INTO `planes_municipales` VALUES (263, 'Plan Municipal de Desarrollo Nealtican 2021-2024', '2021-2024', 'Nealtican_PMD_2021-202420240513192700.pdf', 102, NULL, 1, '2024-05-13 19:27:00', '2024-05-16 16:12:23');
INSERT INTO `planes_municipales` VALUES (264, 'Actualización del Plan Municipal de Desarrollo Nealtican 2021-2024', '2021-2024', '104 NEALTICAN20240513192719.pdf', 102, NULL, 1, '2024-05-13 19:27:19', '2024-05-16 16:13:17');
INSERT INTO `planes_municipales` VALUES (265, 'Plan Municipal de Desarrollo Nicolás Bravo 2018-2021', '2018-2021', 'Nicolás Bravo20240513192817.pdf', 103, NULL, 1, '2024-05-13 19:28:17', '2024-05-16 22:54:23');
INSERT INTO `planes_municipales` VALUES (266, 'Plan Municipal de Desarrollo Nicolás Bravo 2021-2024', '2021-2024', 'Nicolás Bravo_PMD_2021-202420240513192832.pdf', 103, NULL, 1, '2024-05-13 19:28:32', '2024-05-16 16:14:58');
INSERT INTO `planes_municipales` VALUES (267, 'Actualización del Plan Municipal de Desarrollo Nicolás Bravo 2021-2024', '2021-2024', 'Nicolás Bravo20240513193016.pdf', 103, NULL, 1, '2024-05-13 19:30:16', '2024-05-16 16:16:21');
INSERT INTO `planes_municipales` VALUES (268, 'Plan Municipal de Desarrollo Nopalucan', '2018-2021', 'Nopalucan20240513193201.pdf', 104, NULL, 1, '2024-05-13 19:32:01', '2024-07-15 22:52:59');
INSERT INTO `planes_municipales` VALUES (270, 'Plan Municipal de Desarrollo Ocotepec 2018-2021', '2018-2021', 'Ocotepec20240513193333.pdf', 105, NULL, 1, '2024-05-13 19:33:33', '2024-05-16 16:20:06');
INSERT INTO `planes_municipales` VALUES (271, 'Plan Municipal de Desarrollo Ocotepec 2021-2024', '2021-2024', 'Ocotepec_PMD_2021-202420240513193351.pdf', 105, NULL, 1, '2024-05-13 19:33:51', '2024-05-16 16:21:09');
INSERT INTO `planes_municipales` VALUES (272, 'Plan Municipal de Desarrollo Ocoyucan 2018-2021', '2018-2021', 'Plan de Desarrollo Municipal Ocoyucan (1)20240513193439.pdf', 106, NULL, 1, '2024-05-13 19:34:39', '2024-05-16 22:55:16');
INSERT INTO `planes_municipales` VALUES (273, 'Plan Municipal de Desarrollo Ocoyucan 2021-2024', '2021-2024', 'Ocoyucan_PMD_2021-202420240513193453.pdf', 106, NULL, 1, '2024-05-13 19:34:53', '2024-05-16 16:26:12');
INSERT INTO `planes_municipales` VALUES (274, 'Actualización al Plan Municipal de Desarrollo Ocoyucan 2021-2024', '2021-2024', '108 OCOYUCAN20240513193514.pdf', 106, NULL, 1, '2024-05-13 19:35:14', '2024-05-16 16:27:12');
INSERT INTO `planes_municipales` VALUES (275, 'Plan Municipal de Desarrollo Olintla 2018-2021', '2018-2021', 'Olintla20240513193544.pdf', 107, NULL, 1, '2024-05-13 19:35:44', '2024-05-16 16:28:29');
INSERT INTO `planes_municipales` VALUES (276, 'Plan Municipal de Desarrollo Olintla 2021-2024', '2021-2024', 'Olintla_PMD_ 2021-202420240513193604.pdf', 107, NULL, 1, '2024-05-13 19:36:04', '2024-05-16 16:31:05');
INSERT INTO `planes_municipales` VALUES (277, 'Plan Municipal de Desarrollo Oriental 2019-2021', '2019-2021', 'Oriental20240513193640.pdf', 108, NULL, 1, '2024-05-13 19:36:40', '2024-05-16 16:31:47');
INSERT INTO `planes_municipales` VALUES (278, 'Plan Municipal de Desarrollo Oriental 2021-2024', '2021-2024', 'Oriental_PMD_2021-202420240513193657.pdf', 108, NULL, 1, '2024-05-13 19:36:57', '2024-05-16 16:32:49');
INSERT INTO `planes_municipales` VALUES (279, 'Plan Municipal de Desarrollo Pahutlán 2018-2021', '2018-2021', 'Pahuatlan20240513194018.pdf', 109, NULL, 1, '2024-05-13 19:40:18', '2024-05-16 16:34:17');
INSERT INTO `planes_municipales` VALUES (280, 'Plan Municipal de Desarrollo Pahuatlán 2021-2024', '2021-2024', 'Pahuatlan20240513194036.pdf', 109, NULL, 1, '2024-05-13 19:40:36', '2024-05-16 16:35:42');
INSERT INTO `planes_municipales` VALUES (281, 'Plan Municipal de Desarrollo Palmar de Bravo 2018-2021', '2018-2021', 'Palmar de Bravo20240513194244.pdf', 110, NULL, 1, '2024-05-13 19:42:44', '2024-05-16 16:36:27');
INSERT INTO `planes_municipales` VALUES (282, 'Plan Municipal de Desarrollo Palmar de Bravo 2021-2024', '2021-2024', 'Palmar de Bravo_PMD_2021-202420240513194306.pdf', 110, NULL, 1, '2024-05-13 19:43:06', '2024-05-16 16:38:36');
INSERT INTO `planes_municipales` VALUES (283, 'Actualización del Plan Municipal de Desarrollo Palmar de Bravo 2021-2024', '2021-2024', '112 PALMAR DE BRAVO20240513194320.pdf', 110, NULL, 1, '2024-05-13 19:43:20', '2024-05-16 16:39:36');
INSERT INTO `planes_municipales` VALUES (284, 'Plan Municipal de Desarrollo Pantepec 2018-2021', '2018-2021', 'Pantepec20240513194415.pdf', 111, NULL, 1, '2024-05-13 19:44:15', '2024-05-16 16:40:18');
INSERT INTO `planes_municipales` VALUES (285, 'Plan Municipal de Desarrollo Pantepec 2021-2024', '2021-2024', 'Pantepec_PMD_2021-202420240513194431.pdf', 111, NULL, 1, '2024-05-13 19:44:31', '2024-05-16 16:41:40');
INSERT INTO `planes_municipales` VALUES (287, 'Modificación y Adecuación al Plan Municipal de Desarrollo Pantepec 2021-2024', '2021-2024', '113 PANTEPEC20240513194444.pdf', 111, NULL, 1, '2024-05-13 19:44:44', '2024-05-16 16:43:46');
INSERT INTO `planes_municipales` VALUES (288, 'Plan Municipal de Desarrollo Petlalcingo 2018-2021', '2018-2021', 'Petlalcingo20240513194524.pdf', 112, NULL, 1, '2024-05-13 19:45:24', '2024-05-16 16:45:16');
INSERT INTO `planes_municipales` VALUES (289, 'Plan Municipal de Desarrollo Petlalcingo 2021-2024', '2021-2024', 'Petlalcingo_PMD_2021-202220240513194556.pdf', 112, NULL, 1, '2024-05-13 19:45:56', '2024-05-16 16:46:13');
INSERT INTO `planes_municipales` VALUES (290, 'Plan Municipal de Desarrollo Piaxtla 2018-2021', '2018-2021', 'Piaxtla20240513194751.pdf', 113, NULL, 1, '2024-05-13 19:47:51', '2024-05-16 16:47:17');
INSERT INTO `planes_municipales` VALUES (291, 'Plan Municipal de Desarrollo Piaxtla 2021-2024', '2021-2024', 'Piaxtla_PMD_2021-202420240513194813.pdf', 113, NULL, 1, '2024-05-13 19:48:13', '2024-05-16 16:48:04');
INSERT INTO `planes_municipales` VALUES (292, 'Actualización del Plan Municipal de Desarrollo Piaxtla 2021-2024', '2021-2024', '115 PIAXTLA20240513194843.pdf', 113, NULL, 1, '2024-05-13 19:48:43', '2024-05-16 16:49:09');
INSERT INTO `planes_municipales` VALUES (293, 'Plan Municipal de Desarrollo Puebla 2018-2021', '2018-2021', 'Puebla20240513195015.pdf', 114, NULL, 1, '2024-05-13 19:50:15', '2024-05-16 16:50:17');
INSERT INTO `planes_municipales` VALUES (294, 'Plan Municipal de Desarrollo Puebla 2021-2024', '2021-2024', 'Puebla_PMD_2021-202420240513195031.pdf', 114, NULL, 1, '2024-05-13 19:50:31', '2024-05-16 16:51:19');
INSERT INTO `planes_municipales` VALUES (295, 'Plan Municipal de Desarrollo Quecholac 2018-2021', '2018-2021', 'Quecholac20240513195134.pdf', 115, NULL, 1, '2024-05-13 19:51:34', '2024-05-16 16:52:50');
INSERT INTO `planes_municipales` VALUES (296, 'Plan Municipal de Desarrollo Quecholac 2021-2024', '2021-2024', 'Quecholac_PMD_2021-202420240513195148.pdf', 115, NULL, 1, '2024-05-13 19:51:48', '2024-05-16 16:53:45');
INSERT INTO `planes_municipales` VALUES (297, 'Actualización del Plan Municipal de Desarrollo Quecholac 2021-2024', '2021-2024', '117 QUECHOLAC20240513195159.pdf', 115, NULL, 1, '2024-05-13 19:51:59', '2024-05-16 16:54:25');
INSERT INTO `planes_municipales` VALUES (298, 'Plan Municipal de Desarrollo Quimixtlán 2018-2021', '2018-2021', 'Quimixtlán20240513195244.pdf', 116, NULL, 1, '2024-05-13 19:52:44', '2024-05-16 16:55:14');
INSERT INTO `planes_municipales` VALUES (299, 'Plan Municipal de Desarrollo Quimixtlán 2022-2024', '2022-2024', 'Quimixtlán_PMD_ 2021-202420240513195258.pdf', 116, NULL, 1, '2024-05-13 19:52:58', '2024-05-16 16:56:20');
INSERT INTO `planes_municipales` VALUES (301, 'Actualización del Plan Municipal de Desarrollo Quimixtlán 2021-2024', '2021-2024', '118 QUIMIXTLAN20240513195311.pdf', 116, NULL, 1, '2024-05-13 19:53:11', '2024-05-16 16:58:01');
INSERT INTO `planes_municipales` VALUES (302, 'Plan Municipal de Desarrollo Rafael Lara Grajales 2018-2021', '2018-2021', 'Plan de Desarrollo Municipal Rafael Lara Grajales 2018-2021 20240513195649.pdf', 117, NULL, 1, '2024-05-13 19:56:49', '2024-05-16 17:00:22');
INSERT INTO `planes_municipales` VALUES (303, 'Plan Municipal de Desarrollo Rafael Lara Grajales 2021-2024', '2021-2024', 'Plan Municipal de Desarrollo del Honorable Ayuntamiento de Rafael Lara Grajales Puebla 2021-202420240513195702.pdf', 117, NULL, 1, '2024-05-13 19:57:02', '2024-05-16 17:02:36');
INSERT INTO `planes_municipales` VALUES (304, 'Actualización del Plan Municipal de Desarrollo Rafael Lara Grajales 2021-2024', '2021-2024', '119 RAFAEL LARA GRAJALES20240513195714.pdf', 117, NULL, 1, '2024-05-13 19:57:14', '2024-05-16 17:06:30');
INSERT INTO `planes_municipales` VALUES (305, 'Plan Municipal de Desarrollo San Andrés Cholula 2018-2021', '2018-2021', 'San Andrés Cholula20240513200206.pdf', 119, NULL, 1, '2024-05-13 20:02:06', '2024-05-16 17:09:22');
INSERT INTO `planes_municipales` VALUES (306, 'Plan Municipal de Desarrollo San Andrés Cholula 2021-2024', '2021-2024', 'San Andrés Cholula_PMD 2021-202420240513200224.pdf', 119, NULL, 1, '2024-05-13 20:02:24', '2024-05-16 17:10:23');
INSERT INTO `planes_municipales` VALUES (307, 'Plan Municipal de Desarrollo San Antonio Cañada 2018-2021', '2018-2021', 'San Antonio Cañada20240513200401.pdf', 120, NULL, 1, '2024-05-13 20:04:01', '2024-05-16 17:11:22');
INSERT INTO `planes_municipales` VALUES (308, 'Plan Municipal de Desarrollo San Diego la Mesa Tochimiltzingo 2018-2021', '2018-2021', 'San Diego La Mesa Tochimiltzingo20240513200828.pdf', 121, NULL, 1, '2024-05-13 20:08:28', '2024-05-16 17:12:22');
INSERT INTO `planes_municipales` VALUES (309, 'Plan Municipal de Desarrollo San Diego la Mesa Tochimiltzingo 2021-2024', '2021-2024', 'San Diego La Mesa Tochimiltzingo_PMD_2021-202420240513200843.pdf', 121, NULL, 1, '2024-05-13 20:08:43', '2024-05-16 17:14:57');
INSERT INTO `planes_municipales` VALUES (310, 'Plan Municipal de Desarrollo San Felipe Teotlalcingo 2018-2021', '2018-2021', 'PLAN DE DESARROLLO 2018-2021 San Felipe Teotlalcingo20240513201011.pdf', 122, NULL, 1, '2024-05-13 20:10:11', '2024-05-16 17:16:20');
INSERT INTO `planes_municipales` VALUES (311, 'Plan Municipal de Desarrollo San Felipe Teotlalcingo 2021-2024', '2021-2024', 'San Felipe Teotlacingo_PMD_2021-202420240513201029.pdf', 122, NULL, 1, '2024-05-13 20:10:29', '2024-05-16 17:17:27');
INSERT INTO `planes_municipales` VALUES (312, 'Actualización del Plan Municipal de Desarrollo San Felipe Teotlalcingo 2021-2024', '2021-2024', '123 SAN FELIPE TEOTLALCINGO20240513201043.pdf', 122, NULL, 1, '2024-05-13 20:10:43', '2024-05-16 17:19:23');
INSERT INTO `planes_municipales` VALUES (313, 'Plan Municipal de Desarrollo San Felipe Tepatlán 2018-2021', '2018-2021', 'PMD Tepatlan 20240513201310.pdf', 123, NULL, 1, '2024-05-13 20:13:10', '2024-05-16 17:20:15');
INSERT INTO `planes_municipales` VALUES (314, 'Plan Municipal de Desarrollo San Felipe Tepatlán 2021-2024', '2021-2024', 'San Felipe Tepatlán_PMD_2021-202420240513201328.pdf', 123, NULL, 1, '2024-05-13 20:13:28', '2024-05-16 17:20:30');
INSERT INTO `planes_municipales` VALUES (315, 'Plan Municipal de Desarrollo San Gabriel Chilac 2018-2021', '2018-2021', 'PMDSanGabrielChilac20240513201519.pdf', 124, NULL, 1, '2024-05-13 20:15:19', '2024-05-16 17:20:50');
INSERT INTO `planes_municipales` VALUES (316, 'Plan Municipal de Desarrollo San Gabriel Chilac 2021-2024', '2021-2024', 'San Gabriel Chilac_PMD_2021-202420240513201534.pdf', 124, NULL, 1, '2024-05-13 20:15:34', '2024-05-16 17:21:38');
INSERT INTO `planes_municipales` VALUES (317, 'Plan Municipal de Desarrollo San Gregorio Atzompa 2018-2021', '2018-2021', 'San Gregorio Atzompa20240513201619.pdf', 125, NULL, 1, '2024-05-13 20:16:19', '2024-05-16 17:22:06');
INSERT INTO `planes_municipales` VALUES (318, 'Plan Municipal de Desarrollo San Gregorio Atzompa 2021-2024', '2021-2024', 'San Gregorio Atzompa_PMD_2021-202420240513201637.pdf', 125, NULL, 1, '2024-05-13 20:16:37', '2024-05-16 17:22:22');
INSERT INTO `planes_municipales` VALUES (319, 'Actualización del Plan Municipal de Desarrollo San Gregorio Atzompa 2021-2024', '2021-2024', '126 SAN GREGORIO ATZOMPA20240513201652.pdf', 125, NULL, 1, '2024-05-13 20:16:52', '2024-05-16 17:23:40');
INSERT INTO `planes_municipales` VALUES (320, 'Plan Municipal de Desarrollo San Jerónimo Tecuanipan 2018-2021', '2018-2021', 'San Jerónimo Tecuanipan20240513201741.pdf', 126, NULL, 1, '2024-05-13 20:17:41', '2024-05-16 17:24:26');
INSERT INTO `planes_municipales` VALUES (321, 'Plan Municipal de Desarrollo San Jerónimo Tecuanipan 2021-2024', '2021-2024', 'San Jerónimo Tecuanipan_PMD_2021-202420240513201758.pdf', 126, NULL, 1, '2024-05-13 20:17:58', '2024-05-16 17:26:26');
INSERT INTO `planes_municipales` VALUES (322, 'Plan Municipal de Desarrollo San Jerónimo Xayacatlán 2018-20291', '2018-2021', 'San Jerónimo Xayacatlán20240513201846.pdf', 127, NULL, 1, '2024-05-13 20:18:46', '2024-05-16 17:28:06');
INSERT INTO `planes_municipales` VALUES (323, 'Plan Municipal de Desarrollo San Jerónimo Xayacatlán 2021-2024', '2021-2024', 'San Jerónimo Xayacatlán_PMD_ 2021-202420240513201910.pdf', 127, NULL, 1, '2024-05-13 20:19:10', '2024-05-16 17:29:00');
INSERT INTO `planes_municipales` VALUES (324, 'Plan Municipal de Desarrollo San José Chiapa 2019-2021', '2019-2021', 'PMD_San_Jose_Chiapa_2019_2021_0605202020240513202029.pdf', 128, NULL, 1, '2024-05-13 20:20:29', '2024-05-16 17:29:44');
INSERT INTO `planes_municipales` VALUES (325, 'Plan Municipal de Desarrollo San José Chiapa 2021-2024', '2021-2024', 'San José Chiapa_PMD_2021-202420240513202104.pdf', 128, NULL, 1, '2024-05-13 20:21:04', '2024-05-16 17:30:00');
INSERT INTO `planes_municipales` VALUES (326, 'Plan Municipal de Desarrollo San José Miahuatlán 2019-2021', '2019-2021', 'San José Miahuatlán20240513202142.pdf', 129, NULL, 1, '2024-05-13 20:21:43', '2024-05-16 17:30:19');
INSERT INTO `planes_municipales` VALUES (327, 'Plan Municipal de Desarrollo San José Miahuatlán 2021-2024', '2021-2024', 'San José Miahuatlán_PMD_2021-202420240513202204.pdf', 129, NULL, 1, '2024-05-13 20:22:04', '2024-05-16 17:31:47');
INSERT INTO `planes_municipales` VALUES (328, 'Plan Municipal de Desarrollo San Juan Atenco 2018-2021', '2018-2021', 'San Juan Atenco20240513202244.pdf', 130, NULL, 1, '2024-05-13 20:22:44', '2024-05-16 17:32:07');
INSERT INTO `planes_municipales` VALUES (329, 'Plan Municipal de Desarrollo San Juan Atenco 2021-2024', '2021-2024', 'San Juan Atenco_PMD_2021-202420240513202314.pdf', 130, NULL, 1, '2024-05-13 20:23:14', '2024-05-16 17:32:57');
INSERT INTO `planes_municipales` VALUES (330, 'Plan Municipal de Desarrollo San Juan Atzompa 2018-2021', '2018-2021', 'San Juan Atzompa20240513202349.pdf', 131, NULL, 1, '2024-05-13 20:23:49', '2024-05-16 17:33:14');
INSERT INTO `planes_municipales` VALUES (331, 'Plan Municipal de Desarrollo San Juan Atzompa 2021-2024', '2021-2024', 'San Juan Atzompa_PMD_ 2021-202420240513202405.pdf', 131, NULL, 1, '2024-05-13 20:24:05', '2024-05-16 17:34:20');
INSERT INTO `planes_municipales` VALUES (332, 'Plan Municipal de Desarrollo San Martín Texmelucan 2018-2021', '2018-2021', 'San Martín Texmelucan20240513202453.pdf', 132, NULL, 1, '2024-05-13 20:24:53', '2024-05-16 17:34:47');
INSERT INTO `planes_municipales` VALUES (333, 'Plan Municipal de Desarrollo San Martín Texmelucan 2021-2024', '2021-2024', 'San Martín Texmelucan PMD 2021-202420240513202811.pdf', 132, NULL, 1, '2024-05-13 20:28:11', '2024-05-16 17:36:24');
INSERT INTO `planes_municipales` VALUES (334, 'Plan Municipal de Desarrollo San Martín Totoltepec 2018-2021', '2018-2021', 'San Martín Totoltepec20240513202922.pdf', 133, NULL, 1, '2024-05-13 20:29:22', '2024-05-16 17:36:50');
INSERT INTO `planes_municipales` VALUES (335, 'Plan Municipal de Desarrollo San Martín Totoltepec 2021-2024', '2021-2024', 'PMD SAN MARTÍN TOTOLTEPEC 2021-202420240513202937.pdf', 133, NULL, 1, '2024-05-13 20:29:37', '2024-05-16 17:37:05');
INSERT INTO `planes_municipales` VALUES (336, 'Plan Municipal de Desarrollo San Matías Tlalancaleca 2018-2021', '2018-2021', 'San Matías Tlalancaleca20240513203026.pdf', 134, NULL, 1, '2024-05-13 20:30:26', '2024-05-16 17:37:21');
INSERT INTO `planes_municipales` VALUES (337, 'Plan Municipal de Desarrollo San Matías Tlalancaleca 2021-2024', '2021-2024', 'San Matías Tlalancaleca_PMD_2021-202420240513203049.pdf', 134, NULL, 1, '2024-05-13 20:30:49', '2024-05-16 17:39:36');
INSERT INTO `planes_municipales` VALUES (338, 'Plan Municipal de Desarrollo San Miguel Ixitlán 2018-2021', '2018-2021', 'San Miguel Ixitlán20240513203130.pdf', 135, NULL, 1, '2024-05-13 20:31:30', '2024-05-16 17:38:26');
INSERT INTO `planes_municipales` VALUES (339, 'Plan Municipal de Desarrollo San Miguel Ixitlán 2021-2024', '2021-2024', 'PLAN_MUNICIPAL_DE_DESARROLLO_san miguel ixitlan20240513203147.pdf', 135, NULL, 1, '2024-05-13 20:31:47', '2024-05-16 17:40:37');
INSERT INTO `planes_municipales` VALUES (340, 'Plan Municipal de Desarrollo San Miguel Xoxtla 2018-2021', '2018-2021', 'San Miguel Xoxtla20240513203230.pdf', 136, NULL, 1, '2024-05-13 20:32:30', '2024-05-16 17:41:26');
INSERT INTO `planes_municipales` VALUES (341, 'Plan Municipal de Desarrollo San Miguel Xoxtla 2021-2024', '2021-2024', 'San Miguel Xoxtla_PMD_2021-202420240513203255.pdf', 136, NULL, 1, '2024-05-13 20:32:55', '2024-05-16 17:42:09');
INSERT INTO `planes_municipales` VALUES (342, 'Modificación y Adecuación al Plan Municipal de Desarrollo San Miguel Xoxtla 2021-2024', '2021-2024', '137 SAN MIGUEL XOXTLA20240513203317.pdf', 136, NULL, 1, '2024-05-13 20:33:17', '2024-05-16 17:42:27');
INSERT INTO `planes_municipales` VALUES (343, 'Plan Municipal de Desarrollo San Nicolás Buenos Aires 2018-2021', '2018-2021', 'San Nicolás Buenos Aires20240513203405.pdf', 137, NULL, 1, '2024-05-13 20:34:05', '2024-05-16 17:43:03');
INSERT INTO `planes_municipales` VALUES (344, 'Plan Municipal de Desarrollo San Nicolás Buenos Aires 2021-2024', '2021-2024', 'PMD San Nicolás Buenos Aires 21-2420240513203425.pdf', 137, NULL, 1, '2024-05-13 20:34:25', '2024-05-16 17:43:17');
INSERT INTO `planes_municipales` VALUES (345, 'Plan Municipal de Desarrollo San Nicolás de Los Ranchos 2018-2021', '2018-2021', 'San Nicolas de los Ranchos20240513203457.pdf', 138, NULL, 1, '2024-05-13 20:34:57', '2024-05-16 17:44:13');
INSERT INTO `planes_municipales` VALUES (346, 'Plan Municipal de Desarrollo San Nicolás de Los Ranchos 2021-2024', '2021-2024', 'San Nicolás de los Ranchos_PMD_2021-2024720240513203514.pdf', 138, NULL, 1, '2024-05-13 20:35:14', '2024-05-16 17:44:41');
INSERT INTO `planes_municipales` VALUES (347, 'Plan Municipal de Desarrollo San Pablo Anicano 2018-2021', '2018-2021', 'San Pablo Anicano20240513203600.pdf', 139, NULL, 1, '2024-05-13 20:36:00', '2024-05-16 17:45:00');
INSERT INTO `planes_municipales` VALUES (348, 'Plan Municipal de Desarrollo San Pablo Anicano 2021-2024', '2021-2024', 'San Pablo Anicano_PMD_2021-202420240513203629.pdf', 139, NULL, 1, '2024-05-13 20:36:29', '2024-05-16 17:45:51');
INSERT INTO `planes_municipales` VALUES (349, 'Actualización del Plan Municipal de Desarrollo San Pablo Anicano 2021-2024', '2021-2024', '140 SAN PABLO ANICANO20240513203655.pdf', 139, NULL, 1, '2024-05-13 20:36:55', '2024-05-16 17:46:46');
INSERT INTO `planes_municipales` VALUES (350, 'Plan Municipal de Desarrollo San Pedro Cholula 2018-2021', '2018-2021', 'San Pedro Cholula20240513203802.pdf', 140, NULL, 1, '2024-05-13 20:38:02', '2024-05-16 17:47:05');
INSERT INTO `planes_municipales` VALUES (351, 'Plan Municipal de Desarrollo San Pedro Cholula 2021-2024', '2021-2024', 'San Pedro Cholula_PMD_2021-202420240513203825.pdf', 140, NULL, 1, '2024-05-13 20:38:25', '2024-05-16 17:48:40');
INSERT INTO `planes_municipales` VALUES (352, 'Actualización del Plan Municipal de Desarrollo San Pedro Cholula 2021-2024', '2021-2024', '141 SAN PEDRO CHOLULA20240513203848.pdf', 140, NULL, 1, '2024-05-13 20:38:48', '2024-05-16 17:49:07');
INSERT INTO `planes_municipales` VALUES (353, 'Plan Municipal de Desarrollo San Pedro Yeloixtlahuaca 2018-2021', '2018-2021', 'San Pedro Yeloixtlahuaca20240513203926.pdf', 141, NULL, 1, '2024-05-13 20:39:26', '2024-05-16 17:49:34');
INSERT INTO `planes_municipales` VALUES (354, 'Plan Municipal de Desarrollo San Pedro Yeloixtlahuaca 2021-2024', '2021-2024', 'San Pedro Yeloixtlahuaca_PMD_2021-202420240513203940.pdf', 141, NULL, 1, '2024-05-13 20:39:40', '2024-05-16 17:49:53');
INSERT INTO `planes_municipales` VALUES (355, 'Plan Municipal de Desarrollo San Salvador El Seco 2018-2021', '2018-2021', 'San Salvador el Seco20240513204123.pdf', 142, NULL, 1, '2024-05-13 20:41:23', '2024-05-16 17:50:32');
INSERT INTO `planes_municipales` VALUES (356, 'Plan Municipal de Desarrollo San Salvador El Seco 2021-2024', '2021-2024', 'San Salvador El Seco_PMD_2021-202420240513204145.pdf', 142, NULL, 1, '2024-05-13 20:41:45', '2024-05-16 17:50:58');
INSERT INTO `planes_municipales` VALUES (357, 'Plan Municipal de Desarrollo San Salvador El Verde 2019-2021', '2019-2021', 'San Salvador El Verde20240513204214.pdf', 143, NULL, 1, '2024-05-13 20:42:14', '2024-05-16 17:51:26');
INSERT INTO `planes_municipales` VALUES (358, 'Plan Municipal de Desarrollo San Salvador El Verde 2019-2021', '2019-2021', 'San Salvador El Verde20240513204215.pdf', 143, NULL, 1, '2024-05-13 20:42:15', '2024-05-16 17:52:14');
INSERT INTO `planes_municipales` VALUES (359, 'Plan Municipal de Desarrollo San Salvador El Verde 2021-2024', '2021-2024', 'San Salvador el Verde_PMD_2021-202420240513204229.pdf', 143, NULL, 1, '2024-05-13 20:42:29', '2024-05-16 17:54:25');
INSERT INTO `planes_municipales` VALUES (360, 'Actualización del Plan Municipal de Desarrollo San Salvador El Verde 2021-2024', '2021-2024', '144 SAN SALVADOR EL VERDE20240513204240.pdf', 143, NULL, 1, '2024-05-13 20:42:40', '2024-05-16 17:54:42');
INSERT INTO `planes_municipales` VALUES (361, 'Plan Municipal de Desarrollo San Salvador Huixcolotla 2019-2021', '2019-2021', 'San Salvador Huixcolotla20240513204314.pdf', 144, NULL, 1, '2024-05-13 20:43:14', '2024-05-16 17:56:19');
INSERT INTO `planes_municipales` VALUES (362, 'Plan Municipal de Desarrollo San Salvador Huixcolotla 2022-2024', '2022-2024', 'San Salvador Huixcolotla_PMD_2021-202220240513204329.pdf', 144, NULL, 1, '2024-05-13 20:43:29', '2024-05-16 17:56:43');
INSERT INTO `planes_municipales` VALUES (363, 'Plan Municipal de Desarrollo San Sebastián Tlacotepec 2018-2021', '2018-2021', 'San Sebastián Tlacotepec20240513204416.pdf', 145, NULL, 1, '2024-05-13 20:44:16', '2024-05-16 17:57:22');
INSERT INTO `planes_municipales` VALUES (364, 'Plan Municipal de Desarrollo San Sebastián Tlacotepec 2021-2024', '2021-2024', 'San Sebastián Tlacotepec_PMD_ 2021-202420240513204431.pdf', 145, NULL, 1, '2024-05-13 20:44:31', '2024-05-16 17:57:53');
INSERT INTO `planes_municipales` VALUES (365, 'Plan Municipal de Desarrollo San Sebastián Tlacotepec 2021-2024', '2021-2024', 'San Sebastián Tlacotepec_PMD_ 2021-202420240513204432.pdf', 145, NULL, 1, '2024-05-13 20:44:32', '2024-05-16 17:59:08');
INSERT INTO `planes_municipales` VALUES (366, 'Actualización del Plan Municipal de Desarrollo San Sebastián Tlacotepec 2021-2024', '2021-2024', '146 SAN SEBASTIAN TLACOTEPEC20240513204448.pdf', 145, NULL, 1, '2024-05-13 20:44:48', '2024-05-16 17:59:34');
INSERT INTO `planes_municipales` VALUES (367, 'Plan Municipal de Desarrollo Santa Catarina Tlaltempan 2018-2021', '2018-2021', 'Santa Catarina Tlaltempan20240513204546.pdf', 146, NULL, 1, '2024-05-13 20:45:46', '2024-05-16 18:00:01');
INSERT INTO `planes_municipales` VALUES (368, 'Plan Municipal de Desarrollo Santa Catarina Tlaltempan 2021-2024', '2021-2024', 'Santa Catarina Tlaltempan_PMD_2021-202220240513204631.pdf', 146, NULL, 1, '2024-05-13 20:46:31', '2024-05-16 18:00:23');
INSERT INTO `planes_municipales` VALUES (369, 'Plan Municipal de Desarrollo Santa Inés Ahuatempan 2018-2021', '2018-2021', 'Santa Ines Ahuatempan20240513204656.pdf', 147, NULL, 1, '2024-05-13 20:46:56', '2024-05-16 18:01:10');
INSERT INTO `planes_municipales` VALUES (370, 'Plan Municipal de Desarrollo Santa Inés Ahuatempan 2021-2024', '2021-2024', 'Santa Inés Ahuatempan_PMD_2021-202420240513205107.pdf', 147, NULL, 1, '2024-05-13 20:51:07', '2024-05-16 18:01:47');
INSERT INTO `planes_municipales` VALUES (371, 'Plan Municipal de Desarrollo Santa Isabel Cholula 2018-2021', '2018-2021', 'Santa Isabel Cholula20240513205153.pdf', 148, NULL, 1, '2024-05-13 20:51:53', '2024-05-16 18:03:56');
INSERT INTO `planes_municipales` VALUES (372, 'Plan Municipal de Desarrollo Santa Isabel Cholula 2021-2024', '2021-2024', 'Santa Isabel Cholula_PMD_2021-202420240513205212.pdf', 148, NULL, 1, '2024-05-13 20:52:12', '2024-05-16 18:04:14');
INSERT INTO `planes_municipales` VALUES (373, 'Actualización del Plan Municipal de Desarrollo Santa Isabel Cholula 2021-2024', '2021-2024', '149 SANTA ISABEL CHOLULA20240513205240.pdf', 148, NULL, 1, '2024-05-13 20:52:40', '2024-05-16 18:15:16');
INSERT INTO `planes_municipales` VALUES (374, 'Plan Municipal de Desarrollo Santiago Miahuatlán 2018-2021', '2018-2021', 'Santiago Miahuatlán20240513205337.pdf', 149, NULL, 1, '2024-05-13 20:53:37', '2024-05-16 18:04:37');
INSERT INTO `planes_municipales` VALUES (375, 'Plan Municipal de Desarrollo Santiago Miahuatlán 2021-2024', '2021-2024', 'Santiago Miahuatlán_PMD_2021-202420240513205349.pdf', 149, NULL, 1, '2024-05-13 20:53:49', '2024-05-16 18:04:59');
INSERT INTO `planes_municipales` VALUES (376, 'Plan Municipal de Desarrollo Santo Tomás Hueyotlipan 2018-2021', '2018-2021', 'Santo Tomás Hueyotlipan20240513205526.pdf', 151, NULL, 1, '2024-05-13 20:55:26', '2024-05-16 18:05:27');
INSERT INTO `planes_municipales` VALUES (377, 'Plan Municipal de Desarrollo Santo Tomás Hueyotlipan 2021-2024', '2021-2024', 'Santo Tomás Hueyotilpan_PMD_2021-202420240513205603.pdf', 151, NULL, 1, '2024-05-13 20:56:03', '2024-05-16 18:07:09');
INSERT INTO `planes_municipales` VALUES (378, 'Modificación y Adecuación al Plan Municipal de Desarrollo Santo Tomás Hueyotlipan 2021-2024', '2021-2024', '151 SANTO TOMAS HUEYOTLIPAN20240513205621.pdf', 151, NULL, 1, '2024-05-13 20:56:21', '2024-05-16 18:15:30');
INSERT INTO `planes_municipales` VALUES (379, 'Plan Municipal de Desarrollo Soltepec 2018-2021', '2018-2021', 'plan de desarrollo20240513205715.pdf', 152, NULL, 1, '2024-05-13 20:57:15', '2024-05-16 18:07:31');
INSERT INTO `planes_municipales` VALUES (380, 'Plan Municipal de Desarrollo Soltepec 2021-2024', '2021-2024', 'Soltepec_PMD_2021-202420240513205727.pdf', 152, NULL, 1, '2024-05-13 20:57:27', '2024-05-16 18:08:49');
INSERT INTO `planes_municipales` VALUES (381, 'Actualización del Plan Municipal de Desarrollo Soltepec 2021-2024', '2021-2024', '152 SOLTEPEC20240513205739.pdf', 152, NULL, 1, '2024-05-13 20:57:39', '2024-05-16 18:17:51');
INSERT INTO `planes_municipales` VALUES (382, 'Plan Municipal de Desarrollo Tecali de Herrera 2019-2021', '2019-2021', 'Tecali de Herrera20240513221904.pdf', 153, NULL, 1, '2024-05-13 22:19:04', '2024-05-16 18:09:18');
INSERT INTO `planes_municipales` VALUES (383, 'Plan Municipal de Desarrollo Tecali de Herrera 2021-2024', '2021-2024', 'Tecali de Herrera_PMD_2021-202420240513221918.pdf', 153, NULL, 1, '2024-05-13 22:19:18', '2024-05-16 18:11:29');
INSERT INTO `planes_municipales` VALUES (384, 'Plan Municipal de Desarrollo Tecamachalco 2018-2021', '2018-2021', 'PMD_2021_2024_TECAMACHALCO20240513222228.pdf', 154, NULL, 1, '2024-05-13 22:22:28', '2024-05-16 18:12:18');
INSERT INTO `planes_municipales` VALUES (385, 'Plan Municipal de Desarrollo Tecamachalco 2021-2024', '2021-2024', 'PMD_2021_2024_TECAMACHALCO20240513222254.pdf', 154, NULL, 1, '2024-05-13 22:22:54', '2024-05-16 18:13:02');
INSERT INTO `planes_municipales` VALUES (386, 'Plan Municipal de Desarrollo Tecomatlán 2018-2021', '2018-2021', 'Plan Municipal de Tecomatlán 2018-202120240513222537.pdf', 155, NULL, 1, '2024-05-13 22:25:37', '2024-05-16 18:13:25');
INSERT INTO `planes_municipales` VALUES (387, 'Plan Municipal de Desarrollo Tecomatlán 2021-2024', '2021-2024', 'Tecomatlán_PMD_2021-202420240513222553.pdf', 155, NULL, 1, '2024-05-13 22:25:53', '2024-05-16 18:18:15');
INSERT INTO `planes_municipales` VALUES (388, 'Plan Municipal de Desarrollo Tehuacán 2019-2021', '2018-2021', 'Tehuacán20240513222655.pdf', 156, NULL, 1, '2024-05-13 22:26:55', '2024-05-16 18:18:26');
INSERT INTO `planes_municipales` VALUES (389, 'Plan Municipal de Desarrollo Tehuacán 2021-2024', '2021-2024', 'Tehuacán_PMD_2021-202420240513223048.pdf', 156, NULL, 1, '2024-05-13 22:30:48', '2024-05-16 18:17:31');
INSERT INTO `planes_municipales` VALUES (390, 'Modificación y Adecuación al Plan Municipal de Desarrollo Tehuacán 2021-2024', '2021-2024', 'TEHUACÁN PMD MYA20240513224213.pdf', 156, NULL, 1, '2024-05-13 22:42:13', '2024-05-16 18:17:01');
INSERT INTO `planes_municipales` VALUES (391, 'Plan Municipal de Desarrollo Tehuitzingo 2018-2021', '2018-2021', 'Tehuitzingo20240513224315.pdf', 157, NULL, 1, '2024-05-13 22:43:15', '2024-05-16 18:21:13');
INSERT INTO `planes_municipales` VALUES (392, 'Plan Municipal de Desarrollo Tehuitzingo 2021-2024', '2021-2024', 'Tehuitzingo_PMD_2021-202420240513224332.pdf', 157, NULL, 1, '2024-05-13 22:43:32', '2024-05-16 18:21:28');
INSERT INTO `planes_municipales` VALUES (393, 'Plan Municipal de Desarrollo Tenampulco 2018-2021', '2018-2021', 'Tenampulco20240513224403.pdf', 158, NULL, 1, '2024-05-13 22:44:03', '2024-05-16 18:21:43');
INSERT INTO `planes_municipales` VALUES (394, 'Plan Municipal de Desarrollo Tenampulco 2021-2024', '2021-2024', 'Tenampulco_PDM_2021-202420240513224417.pdf', 158, NULL, 1, '2024-05-13 22:44:17', '2024-05-16 18:22:03');
INSERT INTO `planes_municipales` VALUES (395, 'Plan Municipal de Desarrollo Teopantlán 2018-2021', '2018-2021', 'Teopantlan20240513224501.pdf', 159, NULL, 1, '2024-05-13 22:45:01', '2024-05-16 18:22:20');
INSERT INTO `planes_municipales` VALUES (396, 'Plan Municipal de Desarrollo Teopantlán 2021-2024', '2021-2024', 'Teopantlán_PMD_2021-2002420240513224513.pdf', 159, NULL, 1, '2024-05-13 22:45:13', '2024-05-16 18:23:10');
INSERT INTO `planes_municipales` VALUES (397, 'Actualización del Plan Municipal de Desarrollo Teopantlán 2021-2024', '2021-2024', '159 TEOPANTLAN20240513224529.pdf', 159, NULL, 1, '2024-05-13 22:45:29', '2024-05-16 18:23:46');
INSERT INTO `planes_municipales` VALUES (398, 'Plan Municipal de Desarrollo Teotlalco 2018-2021', '2018-2021', 'PLAN DE DESARROLLO teotlalco20240513224616.pdf', 160, NULL, 1, '2024-05-13 22:46:16', '2024-05-16 18:24:39');
INSERT INTO `planes_municipales` VALUES (399, 'Plan Municipal de Desarrollo Teotlalco 2021-2024', '2021-2024', 'Teotlalco_PMD 2021 202420240513224727.pdf', 160, NULL, 1, '2024-05-13 22:47:27', '2024-05-16 18:25:08');
INSERT INTO `planes_municipales` VALUES (400, 'Plan Municipal de Desarrollo Tepanco de López 2018-2021', '2018-2021', 'PMD Tepanco 2018 - 2021 24-01-202020240513225047.pdf', 161, NULL, 1, '2024-05-13 22:50:47', '2024-05-16 18:25:32');
INSERT INTO `planes_municipales` VALUES (401, 'Plan Municipal de Desarrollo Tepanco de López 2021-2024', '2021-2024', 'Tepanco de López_PMD_2021-202420240513225103.pdf', 161, NULL, 1, '2024-05-13 22:51:03', '2024-05-16 18:27:16');
INSERT INTO `planes_municipales` VALUES (402, 'Plan Municipal de Desarrollo Tepango de Rodríguez 2018-2021', '2018-2021', 'Tepango de Rodríguez20240513225136.pdf', 162, NULL, 1, '2024-05-13 22:51:36', '2024-05-16 18:27:31');
INSERT INTO `planes_municipales` VALUES (403, 'Plan Municipal de Desarrollo Tepango de Rodríguez 2021-2024', '2021-2024', 'Tepango de Rodríguez_PMD_2021-202420240513225151.pdf', 162, NULL, 1, '2024-05-13 22:51:51', '2024-05-16 18:27:44');
INSERT INTO `planes_municipales` VALUES (404, 'Actualización del Plan Municipal de Desarrollo Tepango de Rodríguez 2021-2024', '2021-2024', '162 TEPANGO DE RODRIGUEZ20240513225206.pdf', 162, NULL, 1, '2024-05-13 22:52:06', '2024-05-16 18:28:09');
INSERT INTO `planes_municipales` VALUES (405, 'Plan Municipal de Desarrollo Tepeaca 2018-2021', '2018-2021', 'Tepeaca20240513225252.pdf', 164, NULL, 1, '2024-05-13 22:52:52', '2024-05-16 18:29:16');
INSERT INTO `planes_municipales` VALUES (406, 'Plan Municipal de Desarrollo Tepeaca 2021-2024', '2021-2024', 'Tepeaca_PMD_2021-202420240513225402.pdf', 164, NULL, 1, '2024-05-13 22:54:02', '2024-05-16 18:31:46');
INSERT INTO `planes_municipales` VALUES (407, 'Plan Municipal de Desarrollo Tepemaxalco 2018-2021', '2018-2021', 'Plan de Desarollo 2019-2021 Tepemaxalco20240513225451.pdf', 165, NULL, 1, '2024-05-13 22:54:51', '2024-05-16 18:32:27');
INSERT INTO `planes_municipales` VALUES (408, 'Plan Municipal de Desarrollo Tepemaxalco 2021-2024', '2021-2024', 'Tepemaxalco_PMD_2021-202420240513225505.pdf', 165, NULL, 1, '2024-05-13 22:55:05', '2024-05-16 18:32:42');
INSERT INTO `planes_municipales` VALUES (409, 'Plan Municipal de Desarrollo Tepeojuma 2018-2021', '2018-2021', 'Tepeojuma20240513225553.pdf', 166, NULL, 1, '2024-05-13 22:55:53', '2024-05-16 18:33:37');
INSERT INTO `planes_municipales` VALUES (410, 'Plan Municipal de Desarrollo Tepeojuma 2021-2024', '2021-2024', 'Tepeojuma_PMD_2021-202420240513225611.pdf', 166, NULL, 1, '2024-05-13 22:56:11', '2024-05-16 18:33:59');
INSERT INTO `planes_municipales` VALUES (412, 'Actualización del Plan Municipal de Desarrollo Tepeojuma 2021-2024', '2021-2024', '166 TEPEOJUMA20240513225634.pdf', 166, NULL, 1, '2024-05-13 22:56:34', '2024-05-16 18:36:11');
INSERT INTO `planes_municipales` VALUES (413, 'Plan Municipal de Desarrollo Tepetzintla 2018-2021', '2018-2021', 'Tepetzintla20240513230647.pdf', 167, NULL, 1, '2024-05-13 23:06:47', '2024-05-16 18:36:31');
INSERT INTO `planes_municipales` VALUES (414, 'Plan Municipal de Desarrollo Tepetzintla 2021-2024', '2021-2024', 'Tepetzintla_PDM_2021-2024 (1)20240513230701.pdf', 167, NULL, 1, '2024-05-13 23:07:01', '2024-05-16 18:36:58');
INSERT INTO `planes_municipales` VALUES (415, 'Plan Municipal de Desarrollo Tepexco 2018-2021', '2018-2021', 'Tepexco20240513230742.pdf', 168, NULL, 1, '2024-05-13 23:07:42', '2024-05-16 18:37:20');
INSERT INTO `planes_municipales` VALUES (416, 'Plan Municipal de Desarrollo Tepexco 2022-2024', '2022-2024', 'Tepexco_PMD_2021-202420240513230817.pdf', 168, NULL, 1, '2024-05-13 23:08:17', '2024-05-16 18:38:50');
INSERT INTO `planes_municipales` VALUES (417, 'Plan Municipal de Desarrollo Tepexi de Rodríguez 2018-2021', '2018-2021', 'Tepexi de Rodríguez20240513230903.pdf', 169, NULL, 1, '2024-05-13 23:09:03', '2024-05-16 18:39:02');
INSERT INTO `planes_municipales` VALUES (418, 'Plan Municipal de Desarrollo Tepexi de Rodríguez 2021-2024', '2021-2024', 'MTR_PMD_COMPLETO_FINAL20240513230942.pdf', 169, NULL, 1, '2024-05-13 23:09:42', '2024-05-16 18:39:19');
INSERT INTO `planes_municipales` VALUES (419, 'Plan Municipal de Desarrollo Tepeyahualco 2018-2021', '2018-2021', 'Tepeyahualco120240513231038.pdf', 170, NULL, 1, '2024-05-13 23:10:38', '2024-05-16 18:39:37');
INSERT INTO `planes_municipales` VALUES (420, 'Plan Municipal de Desarrollo Tepeyahualco 2021-2024', '2021-2024', 'Tepeyahualco20240513231054.pdf', 170, NULL, 1, '2024-05-13 23:10:54', '2024-05-16 18:42:06');
INSERT INTO `planes_municipales` VALUES (421, 'Actualización del Plan Municipal de Desarrollo Tepeyahualco 2021-2024', '2021-2024', '170 TEPEYAHUALCO20240513231110.pdf', 170, NULL, 1, '2024-05-13 23:11:10', '2024-05-16 18:42:34');
INSERT INTO `planes_municipales` VALUES (422, 'Plan Municipal de Desarrollo Tepeyahualco de Cuauhtémoc 2018-2021', '2018-2021', 'Tepeyahualco de Cuauhtémoc20240513231145.pdf', 171, NULL, 1, '2024-05-13 23:11:45', '2024-05-16 18:45:34');
INSERT INTO `planes_municipales` VALUES (423, 'Plan Municipal de Desarrollo Tepeyahualco de Cuauhtémoc 2021-2024', '2021-2024', 'Tepeyahualco de Cuauhtémoc_PDM_2021-202420240513231201.pdf', 171, NULL, 1, '2024-05-13 23:12:01', '2024-05-16 18:45:59');
INSERT INTO `planes_municipales` VALUES (424, 'Plan Municipal de Desarrollo Tetela de Ocampo 2018-2021', '2018-2021', 'Tetela de Ocampo20240513231241.pdf', 172, NULL, 1, '2024-05-13 23:12:41', '2024-05-16 18:47:15');
INSERT INTO `planes_municipales` VALUES (425, 'Plan Municipal de Desarrollo Tetela de Ocampo 2021-2024', '2021-2024', 'Tetela de Ocampo_PMD_2021-202420240513231300.pdf', 172, NULL, 1, '2024-05-13 23:13:00', '2024-05-16 18:47:38');
INSERT INTO `planes_municipales` VALUES (426, 'Plan Municipal de Desarrollo Teteles de Avila Castillo 2018-2021', '2018-2021', 'Teteles de Ávila Castillo20240513231342.pdf', 173, NULL, 1, '2024-05-13 23:13:42', '2024-05-16 18:48:04');
INSERT INTO `planes_municipales` VALUES (427, 'Plan Municipal de Desarrollo Teteles de Avila Castillo 2021-2024', '2021-2024', 'Teteles de Avila Castillo_PMD_2021-202420240513231607.pdf', 173, NULL, 1, '2024-05-13 23:16:07', '2024-05-16 18:54:59');
INSERT INTO `planes_municipales` VALUES (428, 'Plan Municipal de Desarrollo Teziutlán 2018-2021', '2018-2021', 'Teziutlan20240513231724.pdf', 174, NULL, 1, '2024-05-13 23:17:24', '2024-05-16 18:57:05');
INSERT INTO `planes_municipales` VALUES (429, 'Plan Municipal de Desarrollo Teziutlán 2021-2024', '2021-2024', 'Teziutlán_PMD_2021-202420240513231737.pdf', 174, NULL, 1, '2024-05-13 23:17:37', '2024-05-16 18:58:12');
INSERT INTO `planes_municipales` VALUES (430, 'Plan Municipal de Desarrollo Tianguismanalco 2018-2021', '2018-2021', 'Plan de Desarrollo Municipal del Municipio de Tianguismanalco 2018-202120240513231834.pdf', 175, NULL, 1, '2024-05-13 23:18:34', '2024-05-16 18:58:31');
INSERT INTO `planes_municipales` VALUES (431, 'Plan Municipal de Desarrollo Tianguismanalco 2021-2024', '2021-2024', 'Tianguismanalco_PMD_2021-202420240513231850.pdf', 175, NULL, 1, '2024-05-13 23:18:50', '2024-05-16 18:54:48');
INSERT INTO `planes_municipales` VALUES (432, 'Plan Municipal de Desarrollo Tilapa 2018-2021', '2018-2021', 'Tilapa20240513231939.pdf', 176, NULL, 1, '2024-05-13 23:19:39', '2024-05-16 18:59:44');
INSERT INTO `planes_municipales` VALUES (433, 'Plan Municipal de Desarrollo Tilapa 2021-2024', '2021-2024', 'Tilapa_PMD_2021-202420240513231954.pdf', 176, NULL, 1, '2024-05-13 23:19:54', '2024-05-16 18:59:59');
INSERT INTO `planes_municipales` VALUES (434, 'Actualización del Plan Municipal de Desarrollo Tilapa 2021-2024', '2021-2024', '176 TILAPA20240513232014.pdf', 176, NULL, 1, '2024-05-13 23:20:14', '2024-05-16 19:00:21');
INSERT INTO `planes_municipales` VALUES (435, 'Plan Municipal de Desarrollo Tlachichuca 2019-2021', '2019-2021', 'Tlachichuca20240513232054.pdf', 179, NULL, 1, '2024-05-13 23:20:54', '2024-05-16 19:00:53');
INSERT INTO `planes_municipales` VALUES (436, 'Plan Municipal de Desarrollo Tlachichuca 2021-2024', '2021-2024', 'Tlachichuca_PMD_2021-202420240513232138.pdf', 179, NULL, 1, '2024-05-13 23:21:38', '2024-05-16 19:03:58');
INSERT INTO `planes_municipales` VALUES (437, 'Plan Municipal de Desarrollo Tlacotepec de Benito Juárez 2019-2021', '2019-2021', 'Tlacotepec de Benito Juárez20240513232236.pdf', 177, NULL, 1, '2024-05-13 23:22:36', '2024-05-16 19:05:48');
INSERT INTO `planes_municipales` VALUES (438, 'Plan Municipal de Desarrollo Tlacotepec de Benito Juárez 2021-2024', '2021-2024', 'Tlacotepec de Benito Juárez PMD_2021-202420240513232252.pdf', 177, NULL, 1, '2024-05-13 23:22:52', '2024-05-16 19:06:10');
INSERT INTO `planes_municipales` VALUES (439, 'Actualización del Plan Municipal de Desarrollo Tlacotepec de Benito Juárez 2021-2024', '2021-2024', 'TLACOTEPEC PMD MYA20240513232308.pdf', 177, NULL, 1, '2024-05-13 23:23:08', '2024-05-16 19:06:33');
INSERT INTO `planes_municipales` VALUES (440, 'Plan Municipal de Desarrollo Tlacuilotepec 2018-2021', '2018-2021', '2.1 PLAN DE DESARROLLO MUNICIPAL20240513232338.pdf', 178, NULL, 1, '2024-05-13 23:23:38', '2024-05-16 19:08:48');
INSERT INTO `planes_municipales` VALUES (441, 'Plan Municipal de Desarrollo Tlacuilotepec 2021-2024', '2021-2024', 'Tlacuilotepec_PDM_2021 -202420240513232353.pdf', 178, NULL, 1, '2024-05-13 23:23:53', '2024-05-16 19:09:03');
INSERT INTO `planes_municipales` VALUES (442, 'Plan Municipal de Desarrollo Tlahuapan 2018-2021', '2018-2021', 'Tlahuapan20240513232443.pdf', 180, NULL, 1, '2024-05-13 23:24:43', '2024-05-16 19:09:41');
INSERT INTO `planes_municipales` VALUES (443, 'Plan Municipal de Desarrollo Tlahuapan 2021-2024', '2021-2024', 'Tlahuapan_PMD_2021-202420240513232504.pdf', 180, NULL, 1, '2024-05-13 23:25:04', '2024-05-16 19:11:31');
INSERT INTO `planes_municipales` VALUES (444, 'Actualización del Plan Municipal de Desarrollo Tlahuapan 2022-2024', '2022-2024', '180 TLAHUAPAN20240513232528.pdf', 180, NULL, 1, '2024-05-13 23:25:28', '2024-05-16 19:12:03');
INSERT INTO `planes_municipales` VALUES (445, 'Plan Municipal de Desarrollo Tlaltenango 2018-2021', '2018-2021', 'Plan de Desarrollo Municipio de Tlaltenango 202020240513235414.pdf', 181, NULL, 1, '2024-05-13 23:54:14', '2024-05-16 19:12:33');
INSERT INTO `planes_municipales` VALUES (446, 'Plan Municipal de Desarrollo Tlaltenango 2021-2024', '2021-2024', 'Tlatenango_PMD_2021-202420240513235430.pdf', 181, NULL, 1, '2024-05-13 23:54:30', '2024-05-16 19:13:25');
INSERT INTO `planes_municipales` VALUES (447, 'Plan Municipal de Desarrollo Tlanepantla 2019-2021', '2019-2021', 'Tlanepantla20240513235512.pdf', 182, NULL, 1, '2024-05-13 23:55:12', '2024-05-16 19:15:12');
INSERT INTO `planes_municipales` VALUES (448, 'Plan Municipal de Desarrollo Tlanepantla 2021-2024', '2021-2024', 'Tlanepantla_PMD_2021-202420240513235529.pdf', 182, NULL, 1, '2024-05-13 23:55:29', '2024-05-16 19:16:01');
INSERT INTO `planes_municipales` VALUES (449, 'Plan Municipal de Desarrollo Tlaola 2018-2021', '2018-2021', 'Tlaola20240513235608.pdf', 183, NULL, 1, '2024-05-13 23:56:08', '2024-05-16 19:07:49');
INSERT INTO `planes_municipales` VALUES (450, 'Plan Municipal de Desarrollo Tlaola 2021-2024', '2021-2024', 'Tlaola_PMD_2021-202420240513235621.pdf', 183, NULL, 1, '2024-05-13 23:56:21', '2024-05-16 19:16:26');
INSERT INTO `planes_municipales` VALUES (451, 'Plan Municipal de Desarrollo Tlapacoya 2019-2021', '2019-2021', 'Tlapacoya20240513235846.pdf', 184, NULL, 1, '2024-05-13 23:58:46', '2024-05-16 19:17:05');
INSERT INTO `planes_municipales` VALUES (452, 'Plan Municipal de Desarrollo Tlapacoya 2021-2024', '2021-2024', 'Tlapacoya PMD_2021-202420240513235903.pdf', 184, NULL, 1, '2024-05-13 23:59:03', '2024-05-16 19:20:24');
INSERT INTO `planes_municipales` VALUES (453, 'Plan Municipal de Desarrollo Tlapanalá 2018-2021', '2018-2021', 'Tlapanalá20240513235936.pdf', 185, NULL, 1, '2024-05-13 23:59:36', '2024-05-16 19:20:43');
INSERT INTO `planes_municipales` VALUES (454, 'Plan Municipal de Desarrollo Tlapanalá 2021-2024', '2021-2024', 'Tlapanalá_PMD_2021-202420240513235951.pdf', 185, NULL, 1, '2024-05-13 23:59:51', '2024-05-16 19:11:55');
INSERT INTO `planes_municipales` VALUES (455, 'Plan Municipal de Desarrollo Tlatlauquitepec 2018-2021', '2018-2021', 'PLAN DE DESARROLLO MUNICIPAL TLATLAUQUITEPEC 2018-202120240514000202.pdf', 186, NULL, 1, '2024-05-14 00:02:02', '2024-05-16 19:12:16');
INSERT INTO `planes_municipales` VALUES (456, 'Plan Municipal de Desarrollo Tlatlauquitepec 2021-2024', '2021-2024', 'Tlatlauquitepec_PMD 2021-202420240514000218.pdf', 186, NULL, 1, '2024-05-14 00:02:18', '2024-05-16 19:18:51');
INSERT INTO `planes_municipales` VALUES (457, 'Plan Municipal de Desarrollo Tlaxco 2018-2021', '2018-2021', 'Tlaxco20240514000251.pdf', 187, NULL, 1, '2024-05-14 00:02:51', '2024-05-16 19:12:42');
INSERT INTO `planes_municipales` VALUES (458, 'Plan Municipal de Desarrollo Tlaxco 2021-2024', '2021-2024', 'Tlaxco_PMD_2021-202420240514000306.pdf', 187, NULL, 1, '2024-05-14 00:03:06', '2024-05-16 19:19:10');
INSERT INTO `planes_municipales` VALUES (459, 'Plan Municipal de Desarrollo Tochimilco 2018-2021', '2018-2021', 'Tochimilco20240514000343.pdf', 188, NULL, 1, '2024-05-14 00:03:43', '2024-05-16 19:15:23');
INSERT INTO `planes_municipales` VALUES (460, 'Plan Municipal de Desarrollo Tochimilco 2021-2024', '2021-2024', 'Tochimilco_PMD_2021-202420240514000358.pdf', 188, NULL, 1, '2024-05-14 00:03:58', '2024-05-16 19:19:56');
INSERT INTO `planes_municipales` VALUES (461, 'Plan Municipal de Desarrollo Tochtepec 2018-2021', '2018-2021', 'Tochtepec20240514000435.pdf', 189, NULL, 1, '2024-05-14 00:04:35', '2024-05-16 19:20:11');
INSERT INTO `planes_municipales` VALUES (462, 'Plan Municipal de Desarrollo Tochtepec 2021-2024', '2021-2024', 'Tochtepec_PMD_2021-202420240514000502.pdf', 189, NULL, 1, '2024-05-14 00:05:02', '2024-05-16 23:25:55');
INSERT INTO `planes_municipales` VALUES (463, 'Plan Municipal de Desarrollo Totoltepec de Guerrero 2018-2021', '2018-2021', 'Totoltepec de Guerrero20240514000550.pdf', 190, NULL, 1, '2024-05-14 00:05:50', '2024-05-16 19:23:07');
INSERT INTO `planes_municipales` VALUES (464, 'Plan Municipal de Desarrollo Totoltepec de Guerrero 2021-2024', '2021-2024', 'Totoltepec de Guerrero_PMD_ 2021-202420240514000606.pdf', 190, NULL, 1, '2024-05-14 00:06:06', '2024-05-16 19:23:28');
INSERT INTO `planes_municipales` VALUES (465, 'Actualización del Plan Municipal de Desarrollo Totoltepec de Guerrero 2021-2024', '2021-2024', 'Toltepec PMD MyA20240514000621.pdf', 190, NULL, 1, '2024-05-14 00:06:21', '2024-05-16 19:24:47');
INSERT INTO `planes_municipales` VALUES (466, 'Plan Municipal de Desarrollo Tulcingo 2018-2024', '2018-2024', 'Tulcingo20240514000702.pdf', 191, NULL, 1, '2024-05-14 00:07:02', '2024-05-16 19:25:14');
INSERT INTO `planes_municipales` VALUES (467, 'Plan Municipal de Desarrollo Tulcingo 2021-2024', '2021-2024', 'Tulcingo_PMD_ 2021-202420240514000719.pdf', 191, NULL, 1, '2024-05-14 00:07:19', '2024-05-16 19:25:39');
INSERT INTO `planes_municipales` VALUES (468, 'Plan Municipal de Desarrollo Tuzamapan de Galeana 2018-2021', '2018-2021', 'Tuzamapan de Galeana20240514000753.pdf', 192, NULL, 1, '2024-05-14 00:07:53', '2024-05-16 19:26:39');
INSERT INTO `planes_municipales` VALUES (469, 'Plan Municipal de Desarrollo Tuzamapan de Galeana 2021-2024', '2021-2024', 'Tuzamapan de Galeana_PDM_2021-202420240514000807.pdf', 192, NULL, 1, '2024-05-14 00:08:07', '2024-05-16 19:10:45');
INSERT INTO `planes_municipales` VALUES (470, 'Plan Municipal de Desarrollo Tzicatlacoyan 2018-2021', '2018-2021', 'Tzicatlacoyan20240514000847.pdf', 193, NULL, 1, '2024-05-14 00:08:47', '2024-05-15 22:53:05');
INSERT INTO `planes_municipales` VALUES (471, 'Plan Municipal de Desarrollo Tzicatlacoyan 2021-2024', '2021-2024', 'Tzicatlacoyan_PMD_ 2021-202420240514000901.pdf', 193, NULL, 1, '2024-05-14 00:09:01', '2024-05-15 22:50:30');
INSERT INTO `planes_municipales` VALUES (472, 'Actualización del Plan Municipal de Desarrollo Tzicatlacoyan 2021-2024', '2021-2024', '193 TZICATLACOYAN20240514000914.pdf', 193, NULL, 1, '2024-05-14 00:09:14', '2024-05-15 22:49:54');
INSERT INTO `planes_municipales` VALUES (473, 'Plan Municipal de Desarrollo Venustiano Carranza 2018-2021', '2018-2021', 'Venustiano Carranza20240514165356.pdf', 194, NULL, 1, '2024-05-14 16:53:56', '2024-05-15 22:49:08');
INSERT INTO `planes_municipales` VALUES (474, 'Plan Municipal de Desarrollo Venustiano Carranza 2021-2024', '2021-2024', 'Venustiano Carranza_PMD_2021-202420240514165407.pdf', 194, NULL, 1, '2024-05-14 16:54:07', '2024-05-15 22:48:33');
INSERT INTO `planes_municipales` VALUES (475, 'Plan Municipal de Desarrollo Vicente Guerrero 2018-2021', '2018-2021', 'Vicente Guerrero20240514165448.pdf', 195, NULL, 1, '2024-05-14 16:54:48', '2024-05-15 22:48:00');
INSERT INTO `planes_municipales` VALUES (476, 'Plan Municipal de Desarrollo Vicente Guerrero 2021-2024', '2021-2024', 'Vicente Guerrero_PMD_2021-202420240514165504.pdf', 195, NULL, 1, '2024-05-14 16:55:04', '2024-05-15 22:46:44');
INSERT INTO `planes_municipales` VALUES (477, 'Actualización del Plan Municipal de Desarrollo Vicente Guerrero 2021-2024', '2021-2024', '195 VICENTE GUERRERO20240514165532.pdf', 195, NULL, 1, '2024-05-14 16:55:32', '2024-05-15 22:47:24');
INSERT INTO `planes_municipales` VALUES (478, 'Plan Municipal de Desarrollo Xayacatlán de Bravo 2018-2021', '2018-2021', 'Xayacatlán de Bravo20240514165614.pdf', 196, NULL, 1, '2024-05-14 16:56:14', '2024-05-15 22:45:56');
INSERT INTO `planes_municipales` VALUES (479, 'Plan Municipal de Desarrollo Xayacatlán de Bravo 2021-2024', '2021-2024', 'Xayacatlán de Bravo_PMD_2021-202420240514165629.pdf', 196, NULL, 1, '2024-05-14 16:56:29', '2024-05-15 22:45:24');
INSERT INTO `planes_municipales` VALUES (480, 'Plan Municipal de Desarrollo Xicotepec 2018-2021', '2018-2021', 'Xicotepec20240514165704.pdf', 197, NULL, 1, '2024-05-14 16:57:04', '2024-05-15 22:44:57');
INSERT INTO `planes_municipales` VALUES (481, 'Plan Municipal de Desarrollo Xicotepec 2021-2024', '2021-2024', 'Xicotepec_PMD 2021-202420240514165725.pdf', 197, NULL, 1, '2024-05-14 16:57:25', '2024-05-15 22:42:16');
INSERT INTO `planes_municipales` VALUES (482, 'Plan Municipal de Desarrollo Xicotlán 2018-2021', '2018-2021', 'Xicotlán20240514165755.pdf', 198, NULL, 1, '2024-05-14 16:57:55', '2024-05-15 22:40:22');
INSERT INTO `planes_municipales` VALUES (483, 'Plan Municipal de Desarrollo Xicotlán 2021-2024', '2021-2024', 'Xicotlán_PMD_2021-202420240514165822.pdf', 198, NULL, 1, '2024-05-14 16:58:22', '2024-05-15 22:39:44');
INSERT INTO `planes_municipales` VALUES (484, 'Plan Municipal de Desarrollo Xiutetelco 2018-2021', '2018-2021', 'Xiutetelco20240514165911.pdf', 199, NULL, 1, '2024-05-14 16:59:11', '2024-05-15 22:37:08');
INSERT INTO `planes_municipales` VALUES (485, 'Plan Municipal de Desarrollo Xiutetelco 2021-2024', '2021-2024', 'Xiutetelco_PMD_2021-202420240514165926.pdf', 199, NULL, 1, '2024-05-14 16:59:26', '2024-05-15 21:02:56');
INSERT INTO `planes_municipales` VALUES (486, 'Actualización del Plan Municipal de Desarrollo Xiutetelco 2021-2024', '2021-2024', '199 XIUTETELCO20240514165940.pdf', 199, NULL, 1, '2024-05-14 16:59:40', '2024-05-15 21:06:56');
INSERT INTO `planes_municipales` VALUES (487, 'Plan Municipal de Desarrollo Xochiapulco 2018-2021', '2018-2021', 'Xochiapulco20240514170100.pdf', 200, NULL, 1, '2024-05-14 17:01:00', '2024-05-15 21:01:19');
INSERT INTO `planes_municipales` VALUES (488, 'Plan Municipal de Desarrollo Xochiapulco 2021-2024', '2021-2024', 'Xochiapulco_PMD_2021-202420240514170125.pdf', 200, NULL, 1, '2024-05-14 17:01:25', '2024-05-15 20:59:06');
INSERT INTO `planes_municipales` VALUES (489, 'Modificación y Adecuación al Plan Municipal de Desarrollo Xochiapulco 2021-2024', '2021-2024', '87 Xochiapulco20240514170139.pdf', 200, NULL, 1, '2024-05-14 17:01:39', '2024-05-15 21:00:26');
INSERT INTO `planes_municipales` VALUES (490, 'Plan Municipal de Desarrollo Xochiltepec 2018-2021', '2018-2021', 'Xochiltepec20240514170254.pdf', 201, NULL, 1, '2024-05-14 17:02:54', '2024-05-15 20:57:15');
INSERT INTO `planes_municipales` VALUES (491, 'Plan Municipal de Desarrollo Xochiltepec 2021-2024', '2021-2024', 'Xochiltepec_PMD_ 202120240514170307.pdf', 201, NULL, 1, '2024-05-14 17:03:07', '2024-05-15 20:56:19');
INSERT INTO `planes_municipales` VALUES (492, 'Modificación y Adecuación al Plan Municipal de Desarrollo Xochiltepec 2021-2024', '2021-2024', '201 XOCHILTEPEC20240514170319.pdf', 201, NULL, 1, '2024-05-14 17:03:19', '2024-05-15 20:55:44');
INSERT INTO `planes_municipales` VALUES (493, 'Plan Municipal de Desarrollo Xochitlán de Vicente Suárez 2018-2021', '2018-2021', 'Xochitlán de Vicente Suárez20240514170410.pdf', 202, NULL, 1, '2024-05-14 17:04:10', '2024-05-15 20:55:18');
INSERT INTO `planes_municipales` VALUES (494, 'Plan Municipal de Desarrollo Xochitlán de Vicente Suárez 2021-2024', '2021-2024', 'PMD 2021_Xochitlan de Vicente Suarez20240514170427.pdf', 202, NULL, 1, '2024-05-14 17:04:27', '2024-05-15 20:54:47');
INSERT INTO `planes_municipales` VALUES (495, 'Actualización del Plan Municipal de Desarrollo Xochitlán de Vicente Suárez 2021-2024', '2021-2024', '202 XOCHITLÁN DE VICENTE SUAREZ20240514170444.pdf', 202, NULL, 1, '2024-05-14 17:04:44', '2024-05-15 20:54:26');
INSERT INTO `planes_municipales` VALUES (496, 'Plan Municipal de Desarrollo Xochitlán Todos Santos 2018-2021', '2018-2021', 'Xochitlán Todos Santos20240514170529.pdf', 203, NULL, 1, '2024-05-14 17:05:29', '2024-05-15 20:53:44');
INSERT INTO `planes_municipales` VALUES (497, 'Plan Municipal de Desarrollo Xochitlán Todos Santos 2021-2024', '2021-2024', 'Xochitlán de Todos Santos_PDM_2021-202420240514170547.pdf', 203, NULL, 1, '2024-05-14 17:05:47', '2024-05-15 20:52:55');
INSERT INTO `planes_municipales` VALUES (498, 'Plan Municipal de Desarrollo Yaonáhuac 2019-2021', '2019-2021', 'Yaonáhuac20240514170631.pdf', 204, NULL, 1, '2024-05-14 17:06:31', '2024-05-15 20:49:26');
INSERT INTO `planes_municipales` VALUES (499, 'Plan Municipal de Desarrollo Yaonáhuac 2021-2024', '2021-2024', 'Yaonáhuac_PMD_2021-202420240514170644.pdf', 204, NULL, 1, '2024-05-14 17:06:44', '2024-05-15 20:48:26');
INSERT INTO `planes_municipales` VALUES (500, 'Plan Municipal de Desarrollo Yehualtepec 2018-2021', '2018-2021', 'Yehualtepec20240514170718.pdf', 205, NULL, 1, '2024-05-14 17:07:18', '2024-05-15 20:47:42');
INSERT INTO `planes_municipales` VALUES (501, 'Plan Municipal de Desarrollo Yehualtepec 2021-2024', '2021-2024', 'Yehualtepec_PMD_2021-202420240514170733.pdf', 205, NULL, 1, '2024-05-14 17:07:33', '2024-05-15 20:45:47');
INSERT INTO `planes_municipales` VALUES (502, 'Plan Municipal de Desarrollo Zacapala 2018-2021', '2018-2021', 'PMD ZACAPALA 2018-2021 (R) (1)20240514170914.pdf', 206, NULL, 1, '2024-05-14 17:09:14', '2024-05-15 20:43:13');
INSERT INTO `planes_municipales` VALUES (503, 'Plan Municipal de Desarrollo Zacapala 2021-2024', '2021-2024', 'Plan de Desarrollo Municipal Zacapala20240514170927.pdf', 206, NULL, 1, '2024-05-14 17:09:27', '2024-05-15 20:43:43');
INSERT INTO `planes_municipales` VALUES (504, 'Modificación y Adecuación al Plan Municipal de Desarrollo Zacapala 2021-2024', '2021-2024', '206 ZACAPALA20240514170940.pdf', 206, NULL, 1, '2024-05-14 17:09:40', '2024-05-15 20:42:34');
INSERT INTO `planes_municipales` VALUES (505, 'Plan Municipal de Desarrollo Zacapoaxtla 2018-2021', '2018-2021', 'Zacapoaxtla20240514171016.pdf', 207, NULL, 1, '2024-05-14 17:10:16', '2024-05-15 20:41:06');
INSERT INTO `planes_municipales` VALUES (506, 'Plan Municipal de Desarrollo Zacapoaxtla 2021-2024', '2021-2024', 'Zacapoaxtla_PDM_2021-202420240514171029.pdf', 207, NULL, 1, '2024-05-14 17:10:29', '2024-05-15 20:37:00');
INSERT INTO `planes_municipales` VALUES (507, 'Actualización del Plan Municipal de Desarrollo Zacapoaxtla 2021-2024', '2021-2024', '207 ZACAPOAXTLA20240514171042.pdf', 207, NULL, 1, '2024-05-14 17:10:42', '2024-05-15 20:36:17');
INSERT INTO `planes_municipales` VALUES (508, 'Plan Municipal de Desarrollo Zacatlán 2018-2021', '2018-2021', 'Zacatlán20240514171114.pdf', 208, NULL, 1, '2024-05-14 17:11:14', '2024-05-15 20:35:29');
INSERT INTO `planes_municipales` VALUES (509, 'Plan Municipal de Desarrollo Zacatlán 2021-2024', '2021-2024', 'Zacatlán_PMD_2021-202420240514171129.pdf', 208, NULL, 1, '2024-05-14 17:11:29', '2024-05-15 20:34:32');
INSERT INTO `planes_municipales` VALUES (510, 'Plan Municipal de Desarrollo Zapotitlán 2018-2021', '2018-2021', 'Zapotitlán20240514171211.pdf', 209, NULL, 1, '2024-05-14 17:12:11', '2024-05-15 20:33:39');
INSERT INTO `planes_municipales` VALUES (511, 'Plan Municipal de Desarrollo Zapotitlán 2021-2024', '2021-2024', 'Zapotitlán_PMD_ 2021-202420240514171225.pdf', 209, NULL, 1, '2024-05-14 17:12:25', '2024-05-15 20:32:52');
INSERT INTO `planes_municipales` VALUES (512, 'Plan Municipal de Desarrollo Zapotitlán de Méndez 2018-2021', '2018-2021', 'Zapotitlán de Méndez20240514171303.pdf', 210, NULL, 1, '2024-05-14 17:13:03', '2024-05-15 20:32:09');
INSERT INTO `planes_municipales` VALUES (513, 'Plan Municipal de Desarrollo Zapotitlán de Méndez 2021-2024', '2021-2024', 'Zapotitlán de Méndez_PMD_2021-202420240514171318.pdf', 210, NULL, 1, '2024-05-14 17:13:18', '2024-05-15 20:31:34');
INSERT INTO `planes_municipales` VALUES (514, 'Plan Municipal de Desarrollo Zaragoza 2018-2021', '2018-2021', 'Zaragoza20240514171354.pdf', 211, NULL, 1, '2024-05-14 17:13:54', '2024-05-15 20:31:05');
INSERT INTO `planes_municipales` VALUES (515, 'Plan Municipal de Desarrollo Zaragoza 2021-2024', '2021-2024', 'Zaragoza_PMD_2021-202420240514171419.pdf', 211, NULL, 1, '2024-05-14 17:14:19', '2024-05-15 20:30:28');
INSERT INTO `planes_municipales` VALUES (516, 'Actualización del Plan Municipal de Desarrollo Zaragoza 2021-2024', '2021-2024', '211 ZARAGOZA20240514171521.pdf', 211, NULL, 1, '2024-05-14 17:15:21', '2024-05-15 20:30:01');
INSERT INTO `planes_municipales` VALUES (517, 'Plan Municipal de Desarrollo Zautla 2018-2021', '2018-2021', 'Zautla20240514171558.pdf', 212, NULL, 1, '2024-05-14 17:15:58', '2024-05-15 20:29:15');
INSERT INTO `planes_municipales` VALUES (518, 'Plan Municipal de Desarrollo Zautla 2021-2024', '2021-2024', 'Zautla_PMD_2021-202220240514171614.pdf', 212, NULL, 1, '2024-05-14 17:16:14', '2024-05-15 20:28:38');
INSERT INTO `planes_municipales` VALUES (519, 'Plan Municipal de Desarrollo Zihuateutla 2018-2021', '2018-2021', 'Zihuateutla20240514171700.pdf', 213, NULL, 1, '2024-05-14 17:17:00', '2024-05-15 20:14:53');
INSERT INTO `planes_municipales` VALUES (520, 'Plan Municipal de Desarrollo Zihuateutla 2021-2024', '2021-2024', 'Zihuateutla_PMD_ 2021-202420240514171713.pdf', 213, NULL, 1, '2024-05-14 17:17:13', '2024-05-15 20:09:42');
INSERT INTO `planes_municipales` VALUES (521, 'Actualización del Plan Municipal de Desarrollo Zihuateutla 2021-2024', '2021-2024', '213 ZIHUATEUTLA20240514171725.pdf', 213, NULL, 1, '2024-05-14 17:17:25', '2024-05-15 20:09:11');
INSERT INTO `planes_municipales` VALUES (522, 'Plan Municipal de Desarrollo Zinacatepec 2018-2021', '2018-2021', 'Zinacatepec20240514171817.pdf', 214, NULL, 1, '2024-05-14 17:18:17', '2024-05-16 20:09:25');
INSERT INTO `planes_municipales` VALUES (523, 'Plan Municipal de Desarrollo Zinacatepec 2021-2024', '2021-2024', 'Zinacatepec_PMD_2021-202420240514171829.pdf', 214, NULL, 1, '2024-05-14 17:18:29', '2024-05-15 20:06:13');
INSERT INTO `planes_municipales` VALUES (524, 'Actualización del Plan Municipal de Desarrollo Zinacatepec 2021-2024', '2021-2024', '214 ZINACATEPEC20240514171842.pdf', 214, NULL, 1, '2024-05-14 17:18:42', '2024-05-15 20:05:48');
INSERT INTO `planes_municipales` VALUES (525, 'Plan Municipal de Desarrollo Zongozotla 2018-2021', '2018-2021', 'Zongozotla20240514171915.pdf', 215, NULL, 1, '2024-05-14 17:19:15', '2024-05-16 20:08:57');
INSERT INTO `planes_municipales` VALUES (526, 'Plan Municipal de Desarrollo Zongozotla 2021-2024', '2021-2024', 'PLAN MUNICIPAL ZONGOZOTLA TIERRA DE BIEN 220240514171928.pdf', 215, NULL, 1, '2024-05-14 17:19:28', '2024-05-15 20:04:27');
INSERT INTO `planes_municipales` VALUES (527, 'Plan Municipal de Desarrollo Zoquiapan 2018-2021', '2018-2021', 'Zoquiapan20240514172002.pdf', 216, NULL, 1, '2024-05-14 17:20:02', '2024-05-15 20:03:07');
INSERT INTO `planes_municipales` VALUES (528, 'Plan Municipal de Desarrollo Zoquiapan 2021-2024', '2021-2024', 'Zoquiapan_PMD_2021-202420240514172014.pdf', 216, NULL, 1, '2024-05-14 17:20:14', '2024-05-15 20:01:47');
INSERT INTO `planes_municipales` VALUES (529, 'Actualización del Plan Municipal de Desarrollo Zoquiapan 2021-2024', '2021-2024', '216 ZOQUIAPAN20240514172024.pdf', 216, NULL, 1, '2024-05-14 17:20:24', '2024-05-15 20:00:48');
INSERT INTO `planes_municipales` VALUES (530, 'Plan Municipal de Desarrollo Zoquitlán 2019-2021', '2019-2021', 'Zoquitlán20240514172101.pdf', 217, NULL, 1, '2024-05-14 17:21:01', '2024-05-15 19:59:32');
INSERT INTO `planes_municipales` VALUES (531, 'Plan Municipal de Desarrollo Zoquitlán 2021-2024', '2021-2024', 'Zoquitlán_PMD_2021-202420240514172113.pdf', 217, NULL, 1, '2024-05-14 17:21:13', '2024-05-15 19:58:09');
INSERT INTO `planes_municipales` VALUES (532, 'Actualización del Plan Municipal de Desarrollo Zoquitlán 2021-2024', '2021-2024', '217 ZOQUITLAN20240514172126.pdf', 217, NULL, 1, '2024-05-14 17:21:26', '2024-05-15 19:57:44');
INSERT INTO `planes_municipales` VALUES (544, 'Actualización de Plan Municipal de Desarrollo Atlequizayan 2021-2024', '2021-2024', 'Actualización  ATLEQUIZAYAN 2021-202420240516231049.pdf', 80, NULL, 1, '2024-05-16 23:10:49', '2024-05-16 23:13:08');
INSERT INTO `planes_municipales` VALUES (545, 'Plan Municipal de Desarrollo Atlequizayan 2021-2024', '2021-2024', 'Atlequizayán_PDM_2021-202420240516231203.pdf', 80, NULL, 1, '2024-05-16 23:12:03', '2024-05-16 23:13:32');
INSERT INTO `planes_municipales` VALUES (546, 'Plan Municipal de Desarrollo Atlequizayan 2018-2021', '2018-2021', 'Atlequizayán 2018-202120240516231514.pdf', 80, NULL, 1, '2024-05-16 23:15:14', '2024-05-16 23:15:32');
INSERT INTO `planes_municipales` VALUES (547, 'Actualización del Plan Municipal de Desarrollo Cañada Morelos 2021-2024', '2021-2024', 'Actualización CAÑADA MORELOS 2021-202420240516231645.pdf', 99, NULL, 1, '2024-05-16 23:16:45', '2024-05-16 23:20:19');
INSERT INTO `planes_municipales` VALUES (550, 'Plan Municipal de Desarrollo Cañada Morelos 2021-2024', '2021-2024', 'Cañada Morelos_ PMD_2021-202420240516232129.pdf', 99, NULL, 1, '2024-05-16 23:21:29', '2024-05-16 23:21:42');
INSERT INTO `planes_municipales` VALUES (551, 'Plan Municipal de Desarrollo Cañada Morelos 2018-2021', '2018-2021', 'Cañada Morelos 2018-202120240516232223.pdf', 99, NULL, 1, '2024-05-16 23:22:23', '2024-05-16 23:22:42');
INSERT INTO `planes_municipales` VALUES (552, 'Plan Municipal de Desarrollo San Antonio Cañada 2021-2024', '2021-2024', 'San Antonio Cañada_PMD_2021-202420240516232525.pdf', 120, NULL, 1, '2024-05-16 23:25:25', '2024-05-16 23:25:42');
INSERT INTO `planes_municipales` VALUES (553, 'Modificación y Adecuación al Plan Municipal de Desarrollo Tetela de Ocampo 2021-2024', '2021-2024', 'Tetela de Ocampo 2021-2024_Actualizado20240531204904.pdf', 172, NULL, 1, '2024-05-31 20:49:04', '2024-06-05 15:52:53');
INSERT INTO `planes_municipales` VALUES (554, 'Plan Municipal de Desarrollo Tepatlaxco de Hidalgo 2018-2021', '2018-2021', 'Plan Municipal de Desarrollo Tepatlaxco de Hidalgo 2018-202120240614173837.pdf', 163, NULL, 1, '2024-06-14 17:38:37', '2024-06-14 19:47:42');
INSERT INTO `planes_municipales` VALUES (555, 'Actualización del Plan Municipal de Desarrollo de Atexcal 2021-2024', '2021-2024', 'Actualización del Plan Municipal de Desarrollo Atexcal 2021-202420240614174147.pdf', 18, NULL, 1, '2024-06-14 17:41:47', '2024-06-14 19:46:59');
INSERT INTO `planes_municipales` VALUES (556, 'Plan Municipal de Desarrollo Tepatlaxco de Hidalgo 2021-2024', '2021-2024', 'Plan Municipal de Desarrollo Tepatlaxco de Hidalgo 2021-202420240614174445.pdf', 163, NULL, 1, '2024-06-14 17:44:45', '2024-06-14 19:43:04');
INSERT INTO `planes_municipales` VALUES (557, 'Actualización del Plan Municipal de Desarrollo Huauchinango 2021-2024', '2021-2024', 'Actualización del Plan Municipal de Desarrollo Huauchinango 2021-202420240614182451.pdf', 71, NULL, 1, '2024-06-14 18:24:51', '2024-06-14 19:46:29');
INSERT INTO `planes_municipales` VALUES (558, 'Plan Municipal de Desarrollo Aquixtla 2018-2021', '2018-2021', 'Aquixtla20240615011003.pdf', 16, NULL, 1, '2024-06-15 01:10:03', '2024-06-15 01:10:20');
INSERT INTO `planes_municipales` VALUES (559, 'Actualización del Plan Municipal de Tepeyahualco de Cuauhtémoc', '2021-2024', 'Tepeyahualco de Cuauhtémoc20240618151544.pdf', 171, NULL, 1, '2024-06-18 15:15:44', '2024-06-18 15:16:50');
INSERT INTO `planes_municipales` VALUES (560, 'Actualización del Plan Municipal de Desarrollo Nopalucan', '2021-2024', 'PMD Nopalucan 2021-202420240715224720.pdf', 104, NULL, 1, '2024-07-15 22:47:20', '2024-07-15 22:47:31');
INSERT INTO `planes_municipales` VALUES (561, 'Plan Municipal de Desarrollo Nopalucan', '2021-2024', 'Nopalucan_PMD_2021-202420240715225201.pdf', 104, NULL, 1, '2024-07-15 22:52:01', '2024-07-15 22:52:21');

-- ----------------------------
-- Table structure for programa_derivados
-- ----------------------------
DROP TABLE IF EXISTS `programa_derivados`;
CREATE TABLE `programa_derivados`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_documento` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `portada` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publicado` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_derivado` enum('Sectoriales','Especiales','Institucionales','Regionales') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sectoriales',
  `planestatal_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `programa_derivados_planestatal_id_foreign`(`planestatal_id`) USING BTREE,
  CONSTRAINT `programa_derivados_planestatal_id_foreign` FOREIGN KEY (`planestatal_id`) REFERENCES `plan_estatals` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 135 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of programa_derivados
-- ----------------------------
INSERT INTO `programa_derivados` VALUES (7, 'Programa Sectorial Justicia Social y Fortalecimiento del Estado de Derecho', 'Programa Sectorial_Justicia social y fortalecimiento del estado de derecho20240408203200.pdf', 'PROGRAMA SECTORIAL_JUSTICIA SOCIAL_20240416172147.png', 1, 'Sectoriales', 16, '2024-04-08 20:32:00', '2024-05-15 19:58:23');
INSERT INTO `programa_derivados` VALUES (8, 'Programa Especial de Derechos Humanos', 'Programa Especial_Derechos humanos20240408203236.pdf', 'PROGRAMA ESPECIAL_DERECHOS HUMANOS_20240416172157.png', 1, 'Especiales', 16, '2024-04-08 20:32:36', '2024-05-15 19:33:26');
INSERT INTO `programa_derivados` VALUES (9, 'Programa Institucional Agencia de Energía del Estado de Puebla', 'Programa Institucional_Agencia de energía del estado de puebla20240408203325.pdf', 'PROGRAMA INSTITUCIONAL_AGENCIA DE ENERGÍA_20240416172124.png', 1, 'Institucionales', 16, '2024-04-08 20:33:25', '2024-05-15 20:51:13');
INSERT INTO `programa_derivados` VALUES (10, 'Programa Desarrollo Regional', 'PD2ProgramaRegional (1)20240408203409.pdf', 'PROGRAMA REGIONAL_20240416172134.png', 1, 'Regionales', 16, '2024-04-08 20:34:09', '2024-05-16 16:56:48');
INSERT INTO `programa_derivados` VALUES (13, 'Programa Especial Anticorrupción', 'Programa Especial_Anticorrupción (1)20240416172421.pdf', '20240416172421.png', 1, 'Especiales', 16, '2024-04-16 17:24:21', '2024-05-15 18:37:32');
INSERT INTO `programa_derivados` VALUES (14, 'Programa Especial Igualdad Sustantiva', 'Programa Especial_Igualdad Sustantiva (1)20240416172505.pdf', '20240416172505.png', 1, 'Especiales', 16, '2024-04-16 17:25:05', '2024-05-15 20:06:12');
INSERT INTO `programa_derivados` VALUES (15, 'Programa Especial Juventudes', 'Programa Especial_Juventudes20240416172541.pdf', '20240416172541.png', 1, 'Especiales', 16, '2024-04-16 17:25:41', '2024-05-15 20:14:41');
INSERT INTO `programa_derivados` VALUES (16, 'Programa Especial Pueblos Indígenas y Afromexicanos', 'Programa Especial_Pueblos indígenas y afromexicanos (2)_20240522201606.pdf', '20240416172619.png', 1, 'Especiales', 16, '2024-04-16 17:26:19', '2024-05-22 20:16:06');
INSERT INTO `programa_derivados` VALUES (17, 'Programa Especial Niñas, Niños y Adolescentes', 'Programa Especial_Niñas, niños y adolescentes20240416172725.pdf', '20240416172725.png', 1, 'Especiales', 16, '2024-04-16 17:27:25', '2024-05-15 20:16:53');
INSERT INTO `programa_derivados` VALUES (18, 'Programa Sectorial Fortalecimiento del Campo e Impulso a la Economía Justa y Social', 'Programa Sectorial_Fortalecimiento del campo e impulso a la economía justa y social (5)20240416173117.pdf', '20240416173117.png', 1, 'Sectoriales', 16, '2024-04-16 17:31:17', '2024-05-16 18:50:01');
INSERT INTO `programa_derivados` VALUES (19, 'Programa Sectorial Desarrollo Integral, Educación y Diversidad Cultural', 'Programa Sectorial_Desarrollo integral, educación y diversidad cultural (2)20240416173159.pdf', '20240416173159.png', 1, 'Sectoriales', 16, '2024-04-16 17:31:59', '2024-05-16 18:44:26');
INSERT INTO `programa_derivados` VALUES (20, 'Programa Sectorial Sostenibilidad Territorial y Desarrollo Integral', 'Programa Sectorial_Sostenibilidad territorial y desarrollo integral20240416173315.pdf', '20240416173315.png', 1, 'Sectoriales', 16, '2024-04-16 17:33:15', '2024-05-16 18:59:57');
INSERT INTO `programa_derivados` VALUES (21, 'Programa Sectorial Transparencia, Participación Ciudadana y Combate a la Corrupción', 'SectorialTransparencia20240416173412.pdf', '20240416173412.png', 1, 'Sectoriales', 16, '2024-04-16 17:34:12', '2024-05-16 19:02:29');
INSERT INTO `programa_derivados` VALUES (22, 'Programa Institucional Instituto de la Discapacidad del Estado de Puebla', 'Programa Institucional_Instituto de la discapacidad del estado de puebla (2)20240416173518.pdf', '20240416173518.png', 1, 'Institucionales', 16, '2024-04-16 17:35:18', '2024-05-15 23:54:12');
INSERT INTO `programa_derivados` VALUES (23, 'Programa Institucional Comisión de Mejora Regulatoria', 'Programa Institucional_Comisión de Mejora Regulatoria20240416173550.pdf', '20240416173550.png', 1, 'Institucionales', 16, '2024-04-16 17:35:50', '2024-05-15 23:30:21');
INSERT INTO `programa_derivados` VALUES (24, 'Programa Institucional Instituto Poblano de Asistencia al Migrante', 'Programa Institucional_Instituto de asistencia la migrante poblano20240416173644.pdf', '20240416173644.png', 1, 'Institucionales', 16, '2024-04-16 17:36:44', '2024-05-16 00:11:41');
INSERT INTO `programa_derivados` VALUES (25, 'Programa Institucional Sistema para el Desarrollo Integral de la Familia del Estado de Puebla', 'Programa Institucional_Sistema para el desarrollo integral de la familia del estado de puebla20240416173726.pdf', '20240416173726.png', 1, 'Institucionales', 16, '2024-04-16 17:37:26', '2024-05-16 16:34:41');
INSERT INTO `programa_derivados` VALUES (26, 'Programa Institucional Sistema de Información y Comunicación del Estado de Puebla', 'Programa Institucional_SIstema de información y comunicación del estado de puebla20240416173801.pdf', '20240416173801.png', 1, 'Institucionales', 16, '2024-04-16 17:38:01', '2024-05-16 16:27:45');
INSERT INTO `programa_derivados` VALUES (27, 'Programa Sectorial Gobernabilidad y Cultura de la Legalidad', '01 Programa Sectorial de Gobernabilidad y Cultura de la Legalidad20240416174014.pdf', '20240416174014.png', 1, 'Sectoriales', 15, '2024-04-16 17:40:14', '2024-05-16 18:51:47');
INSERT INTO `programa_derivados` VALUES (28, 'Programa Sectorial Seguridad Pública', '02 Programa Sectorial de Seguridad Publica20240416181238.pdf', '20240416181238.png', 1, 'Sectoriales', 15, '2024-04-16 18:12:38', '2024-05-16 18:56:20');
INSERT INTO `programa_derivados` VALUES (29, 'Programa Sectorial Desarrollo Rural', 'PROGRAMA SECTORIAL DE DESARROLLO RURAL 2019-202420240416181339.pdf', '20240416181339.png', 1, 'Sectoriales', 15, '2024-04-16 18:13:39', '2024-05-16 18:46:14');
INSERT INTO `programa_derivados` VALUES (30, 'Programa Sectorial Trabajo', '04 Programa Sectorial de Trabajo20240416182344.pdf', '20240416182344.png', 1, 'Sectoriales', 15, '2024-04-16 18:23:44', '2024-05-16 19:01:14');
INSERT INTO `programa_derivados` VALUES (31, 'Programa Sectorial Desarrollo Económico', '05 Programa Sectorial de Desarrollo Económico20240416183258.pdf', '20240416183258.png', 1, 'Sectoriales', 15, '2024-04-16 18:32:58', '2024-05-16 18:30:13');
INSERT INTO `programa_derivados` VALUES (32, 'Programa Sectorial Turismo', '06 Programa Sectorail de Turismo20240416183324.pdf', '20240416183324.png', 1, 'Sectoriales', 15, '2024-04-16 18:33:24', '2024-05-16 19:04:45');
INSERT INTO `programa_derivados` VALUES (33, 'Programa Sectorial Movilidad y Transporte', '07 Programa Sectorial de Movilidad y Transporte20240416183352.pdf', '20240416183352.png', 1, 'Sectoriales', 15, '2024-04-16 18:33:52', '2024-05-16 18:53:08');
INSERT INTO `programa_derivados` VALUES (34, 'Programa Sectorial Salud', '08 Programa Sectorail de Salud20240416183413.pdf', '20240416183413.png', 1, 'Sectoriales', 15, '2024-04-16 18:34:13', '2024-05-16 18:54:58');
INSERT INTO `programa_derivados` VALUES (35, 'Programa Sectorial Educación', '09 Programa Sectorial de Educacion20240416183432.pdf', '20240416183432.png', 1, 'Sectoriales', 15, '2024-04-16 18:34:32', '2024-05-16 18:48:18');
INSERT INTO `programa_derivados` VALUES (36, 'Programa Sectorial Bienestar', '10 Programa Sectorial de Bienestar20240416183505.pdf', '20240416183505.png', 1, 'Sectoriales', 15, '2024-04-16 18:35:05', '2024-05-16 18:27:32');
INSERT INTO `programa_derivados` VALUES (37, 'Programa Sectorial Cultura', '11 Programa Sectorial de Cultura20240416183524.pdf', '20240416183524.png', 1, 'Sectoriales', 15, '2024-04-16 18:35:24', '2024-05-16 18:29:20');
INSERT INTO `programa_derivados` VALUES (38, 'Programa Regional Región 1 Xicotepec', '0_ProRegionales 01 Xicotepec20240416192219.pdf', '20240416192219.png', 1, 'Regionales', 15, '2024-04-16 19:22:19', '2024-05-16 17:00:32');
INSERT INTO `programa_derivados` VALUES (39, 'Programa Regional Región 2 Huauchinango', '0_ProRegionales 02 Huauchinango20240416192253.pdf', '20240416192253.png', 1, 'Regionales', 15, '2024-04-16 19:22:53', '2024-05-16 18:12:11');
INSERT INTO `programa_derivados` VALUES (40, 'Programa Regional Región 3 Zacatlán', '0_ProRegionales 03 Zacatlan20240416192315.pdf', '20240416192315.png', 1, 'Regionales', 15, '2024-04-16 19:23:15', '2024-05-16 18:20:07');
INSERT INTO `programa_derivados` VALUES (41, 'Programa Regional Región 4 Huehuetla', '0_ProRegionales 04 Huehuetla20240416192343.pdf', '20240416192343.png', 1, 'Regionales', 15, '2024-04-16 19:23:43', '2024-05-16 18:21:22');
INSERT INTO `programa_derivados` VALUES (42, 'Programa Regional Región 5 Zacapoaxtla', '0_ProRegionales 05 Zacapoaxtla20240416192408.pdf', '20240416192408.png', 1, 'Regionales', 15, '2024-04-16 19:24:08', '2024-05-16 18:22:11');
INSERT INTO `programa_derivados` VALUES (43, 'Programa Regional Región 6 Teziutlán', '0_ProRegionales 06 Teziutlan20240416192435.pdf', '20240416192435.png', 1, 'Regionales', 15, '2024-04-16 19:24:35', '2024-05-16 18:23:27');
INSERT INTO `programa_derivados` VALUES (44, 'Programa Regional Región 7 Chignahuapan', '0_ProRegionales 07 Chignahuapan20240416192501.pdf', '20240416192501.png', 1, 'Regionales', 15, '2024-04-16 19:25:01', '2024-05-16 18:24:49');
INSERT INTO `programa_derivados` VALUES (45, 'Programa Regional Región 8 Libres', '0_ProRegionales 08 Libres20240416192556.pdf', '20240416192556.png', 1, 'Regionales', 15, '2024-04-16 19:25:56', '2024-05-16 18:25:25');
INSERT INTO `programa_derivados` VALUES (46, 'Programa Regional Región 9 Quimixtlán', '0_ProRegionales 09 Quimixtlán20240416192621.pdf', '20240416192621.png', 1, 'Regionales', 15, '2024-04-16 19:26:21', '2024-05-16 18:26:49');
INSERT INTO `programa_derivados` VALUES (47, 'Programa Regional Región 10 Acatzingo', '0_ProRegionales 10 Acatzingo20240416192644.pdf', '20240416192644.png', 1, 'Regionales', 15, '2024-04-16 19:26:44', '2024-05-16 17:01:18');
INSERT INTO `programa_derivados` VALUES (48, 'Programa Regional Región 11 Ciudad Serdán', '0_ProRegionales 11 Ciudad Serdán20240416192709.pdf', '20240416192709.png', 1, 'Regionales', 15, '2024-04-16 19:27:09', '2024-05-16 18:02:54');
INSERT INTO `programa_derivados` VALUES (49, 'Programa Regional Región 12 Tecamachalco', '0_ProRegionales 12 Tecamachalco20240416192732.pdf', '20240416192732.png', 1, 'Regionales', 15, '2024-04-16 19:27:32', '2024-05-16 18:04:25');
INSERT INTO `programa_derivados` VALUES (50, 'Programa Regional Región 13 Tehuacán', '0_ProRegionales 13 Tehuacán20240416192755.pdf', '20240416192755.png', 1, 'Regionales', 15, '2024-04-16 19:27:55', '2024-05-16 18:05:04');
INSERT INTO `programa_derivados` VALUES (51, 'Programa Regional Región 14 Sierra Negra', '0_ProRegionales 14 Sierra Negra20240416192821.pdf', '20240416192821.png', 1, 'Regionales', 15, '2024-04-16 19:28:21', '2024-05-16 18:06:26');
INSERT INTO `programa_derivados` VALUES (52, 'Programa Regional Región 15 Izúcar de Matamoros', '0_ProRegionales 15 Izúcar de Matamoros20240416192849.pdf', '20240416192849.png', 1, 'Regionales', 15, '2024-04-16 19:28:49', '2024-05-16 18:07:34');
INSERT INTO `programa_derivados` VALUES (53, 'Programa Regional Región 16 Chiautla', '0_ProRegionales 16 Chiautla20240416192911.pdf', '20240416192911.png', 1, 'Regionales', 15, '2024-04-16 19:29:11', '2024-05-16 18:08:06');
INSERT INTO `programa_derivados` VALUES (54, 'Programa Regional Región 17 Acatlán', '0_ProRegionales 17 Acatlán20240416192933.pdf', '20240416192933.png', 1, 'Regionales', 15, '2024-04-16 19:29:33', '2024-05-16 18:08:49');
INSERT INTO `programa_derivados` VALUES (55, 'Programa Regional Región 18 Tepexi de Rodríguez', '0_ProRegionales 18 Tepexi de Rodríguez20240416192956.pdf', '20240416192956.png', 1, 'Regionales', 15, '2024-04-16 19:29:56', '2024-05-16 18:09:36');
INSERT INTO `programa_derivados` VALUES (56, 'Programa Regional Región 19 Atlixco', '0_ProRegionales 19 Atlixco20240416193018.pdf', '20240416193018.png', 1, 'Regionales', 15, '2024-04-16 19:30:18', '2024-05-16 18:10:32');
INSERT INTO `programa_derivados` VALUES (57, 'Programa Regional Región 20 San Martín Texmelucan', '0_ProRegionales 20 San Martín Texmelucan20240416193044.pdf', '20240416193044.png', 1, 'Regionales', 15, '2024-04-16 19:30:44', '2024-05-16 18:12:54');
INSERT INTO `programa_derivados` VALUES (58, 'Programa Institucional Carreteras de Cuota Puebla', '01 Programa Institucional de Carreteras de Cuota Puebla20240416194603.pdf', '20240416194603.png', 1, 'Institucionales', 15, '2024-04-16 19:46:03', '2024-05-15 21:07:02');
INSERT INTO `programa_derivados` VALUES (59, 'Programa Institucional Comisión de Mejora Regulatoria del Estado de Puebla', '2 Programa Institucional de Mejora Regulatoria20240416194638.pdf', '20240416194638.png', 1, 'Institucionales', 15, '2024-04-16 19:46:38', '2024-05-15 23:32:11');
INSERT INTO `programa_derivados` VALUES (60, 'Programa Institucional Ciudad Modelo', '03 Programa Institucional de Ciudad Modelo20240416194703.pdf', '20240416194703.png', 1, 'Institucionales', 15, '2024-04-16 19:47:03', '2024-05-15 21:09:54');
INSERT INTO `programa_derivados` VALUES (61, 'Programa Institucional Comisión Estatal de Agua y Saneamiento del Estado de Puebla', '04 Prog Institucional de la Comisión Estatal de Agua y Saneamiento del Estado de Puebla20240416194725.pdf', '20240416194725.png', 1, 'Institucionales', 15, '2024-04-16 19:47:25', '2024-05-15 23:33:46');
INSERT INTO `programa_derivados` VALUES (62, 'Programa Institucional Consejo Estatal de Coordinación del Sistema Nacional de Seguridad Pública', '05 Programa Institucinoal del Consejo Estatal de Coordinación del Sistema Nacional de Seguridad Pública20240416194754.pdf', '20240416194754.png', 1, 'Institucionales', 15, '2024-04-16 19:47:54', '2024-05-15 23:41:24');
INSERT INTO `programa_derivados` VALUES (63, 'Programa Institucional Consejo de Ciencia y Tecnología', '06 Programa Institucinoal del Consejo de Ciencia y Tecnología20240416194913.pdf', '20240416194913.png', 1, 'Institucionales', 15, '2024-04-16 19:49:13', '2024-05-15 23:40:00');
INSERT INTO `programa_derivados` VALUES (64, 'Programa Institucional Convenciones y Parques', '07 Programa Institucinoal de Convenciones y Parques20240416194938.pdf', '20240416194938.png', 1, 'Institucionales', 15, '2024-04-16 19:49:38', '2024-05-15 23:43:06');
INSERT INTO `programa_derivados` VALUES (65, 'Programa Institucional Centro de Conciliación Laboral del Estado de Puebla', '08 Programa Institucional del Centro de Conciliacion Laboral del Estadod e Puebla20240416195026.pdf', '20240416195026.png', 1, 'Institucionales', 15, '2024-04-16 19:50:26', '2024-05-15 21:08:48');
INSERT INTO `programa_derivados` VALUES (66, 'Programa Institucional Corporación Auxiliar de Policía de Protección Ciudadana', '09 Programa Institucional de la Corporación Auxiliar de Policía de Protección Ciudadana20240416195456.pdf', '20240416195456.png', 1, 'Institucionales', 15, '2024-04-16 19:54:56', '2024-05-15 23:46:26');
INSERT INTO `programa_derivados` VALUES (67, 'Programa Institucional Instituto Estatal de Educación para Adultos', '10 Programa Institucinoal del Instituto Estatal de Educación para Adultos20240416195655.pdf', '20240416195655.png', 1, 'Institucionales', 15, '2024-04-16 19:56:55', '2024-05-16 00:10:41');
INSERT INTO `programa_derivados` VALUES (68, 'Programa Regional Región 21-31 Área Metropolitana de la Ciudad de Puebla', 'ProRegionales 21-31 Puebla20240416200650.pdf', '20240416200650.png', 1, 'Regionales', 15, '2024-04-16 20:06:50', '2024-05-16 18:14:21');
INSERT INTO `programa_derivados` VALUES (69, 'Programa Regional Región 32 Tepeaca', '0_ProRegionales 32 Tepeaca20240416200746.pdf', '20240416200746.png', 1, 'Regionales', 15, '2024-04-16 20:07:46', '2024-05-16 18:19:02');
INSERT INTO `programa_derivados` VALUES (70, 'Programa Institucional Instituto Poblano de Asistencia al Migrante', '_11 Programa Institucional del Instituto Poblano de Asistencia al Migrante-comprimido20240416225524.pdf', '20240416225524.png', 1, 'Institucionales', 15, '2024-04-16 22:55:24', '2024-05-16 00:14:16');
INSERT INTO `programa_derivados` VALUES (71, 'Programa Institucional Instituto de Capacitación para el Trabajo', '12 ProgramaI Institucional del Instituto de Capacitación para el Trabajo20240416225606.pdf', '20240416225606.png', 1, 'Institucionales', 15, '2024-04-16 22:56:06', '2024-05-15 23:49:42');
INSERT INTO `programa_derivados` VALUES (72, 'Programa Institucional Instituto de Profesionalización del Magisterio Poblano', '13 Programa Institucinoal del Instituto de Profesionalización del Magisterio Poblano20240416225703.pdf', '20240416225703.png', 1, 'Institucionales', 15, '2024-04-16 22:57:03', '2024-05-16 00:03:16');
INSERT INTO `programa_derivados` VALUES (73, 'Programa Institucional Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio de los Poderes del Estado de Puebla', '14 Programa Institucional del Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio de los Poderes del Estado de Puebla20240416225813.pdf', '20240416225813.png', 1, 'Institucionales', 15, '2024-04-16 22:58:13', '2024-05-16 00:06:56');
INSERT INTO `programa_derivados` VALUES (74, 'Programa Institucional Museos Puebla', '15 Programa Institucional de Museos Puebla20240416225844.pdf', '20240416225844.png', 1, 'Institucionales', 15, '2024-04-16 22:58:44', '2024-05-16 16:25:34');
INSERT INTO `programa_derivados` VALUES (75, 'Programa Institucional Sistema para el Desarrollo Integral de la Familia del Estado de Puebla', '16 Programa Institucional del Sistema para el Desarrollo Integral de la Familia del Estado de Puebla20240416225923.pdf', '20240416225923.png', 1, 'Institucionales', 15, '2024-04-16 22:59:23', '2024-05-16 16:38:13');
INSERT INTO `programa_derivados` VALUES (76, 'Programa Especial Pueblos Indígenas', '02 Programa Especial de Pueblos Indigenas (1)20240416232233.pdf', '20240416232233.png', 1, 'Especiales', 15, '2024-04-16 23:22:33', '2024-05-15 20:22:51');
INSERT INTO `programa_derivados` VALUES (77, 'Programa Especial Igualdad Sustantiva', '03 Programa Especial Igualdad Sustantiva20240416232258.pdf', '20240416232258.png', 1, 'Especiales', 15, '2024-04-16 23:22:58', '2024-05-15 20:10:44');
INSERT INTO `programa_derivados` VALUES (78, 'Programa Especial Niñas, Niños y Adolescentes', '04 Programa Especial de Niñas, Niños y Adolescentes20240416232330.pdf', '20240416232330.png', 1, 'Especiales', 15, '2024-04-16 23:23:30', '2024-05-15 20:18:21');
INSERT INTO `programa_derivados` VALUES (79, 'Programa Especial Cuidado Ambiental y Atención al Cambio Climático', '05 Programa Especial Cuidado Ambiental y Atención al Cambio Climatico20240416232701.pdf', '20240416232701.png', 1, 'Especiales', 15, '2024-04-16 23:27:01', '2024-05-15 19:43:06');
INSERT INTO `programa_derivados` VALUES (81, 'Programa Especial Infraestructura', '_01 Programa Especial de Infraestructura20240416234224.pdf', '20240416234224.png', 1, 'Especiales', 15, '2024-04-16 23:42:24', '2024-05-15 20:13:48');
INSERT INTO `programa_derivados` VALUES (82, 'Programa Especial Gobierno Democrático, Innovador y Transparente', '06 Programa Especial de Gobierno Democratico, Innovador y Transparente20240416234338.pdf', '20240416234338.png', 1, 'Especiales', 15, '2024-04-16 23:43:38', '2024-05-15 19:50:29');
INSERT INTO `programa_derivados` VALUES (83, 'Programa Especial Juventudes', '07 Programa Especial de Juventudes20240416234421.pdf', '20240416234421.png', 1, 'Especiales', 15, '2024-04-16 23:44:21', '2024-05-15 20:15:50');
INSERT INTO `programa_derivados` VALUES (84, 'Programa Especial Desarrollo Energético Sustentable', '08 Programa Especial de Energia20240416234517.pdf', 'Especiales8_20240416235031.png', 1, 'Especiales', 15, '2024-04-16 23:45:17', '2024-05-15 19:49:19');
INSERT INTO `programa_derivados` VALUES (85, 'Programa Especial Para la Prevención y Gestión Integral de Residuos Sólidos Urbanos y de Manejo Especial', 'Programa_Estatal_de_Residuos20240416234625.pdf', '20240416234625.png', 1, 'Especiales', 15, '2024-04-16 23:46:25', '2024-05-15 20:20:22');
INSERT INTO `programa_derivados` VALUES (86, 'Programa Especial Anticorrupción', '1. Programa Especial Anticorrupción20240416234719.pdf', '20240416234719.png', 1, 'Especiales', 15, '2024-04-16 23:47:19', '2024-05-15 19:40:46');
INSERT INTO `programa_derivados` VALUES (88, 'Programa Especial de Derechos Humanos', 'Anexo 1. Programa Estatal de Drechos Humanos20240416234751.pdf', '20240416234751.png', 1, 'Especiales', 15, '2024-04-16 23:47:51', '2024-05-15 19:46:26');
INSERT INTO `programa_derivados` VALUES (94, 'Programa Institucional Sistema Estatal de Telecomunicaciones', '17 Programa Institucional del Sistema Estatal de Telecomunicaciones (1).pdf', 'SectorialInt17.png', 1, 'Institucionales', 15, '2024-05-10 13:21:48', '2024-05-16 16:33:27');
INSERT INTO `programa_derivados` VALUES (95, 'Programa Institucional Secretaría Ejecutiva del Sistema Estatal Anticorrupción', '18 Programa Institucinoal de la Secretaría Ejecutiva del Sistema Estatal Anticorrupción (1)20240510192558.pdf', '20240510192558.png', 1, 'Institucionales', 15, '2024-05-10 19:25:58', '2024-05-16 16:26:14');
INSERT INTO `programa_derivados` VALUES (96, 'Programa Institucional Instituto Poblano del Deporte', '19 Programa Institucional del Instituto Poblano del Deporte (1)20240510192653.pdf', '20240510192653.png', 1, 'Institucionales', 15, '2024-05-10 19:26:53', '2024-05-16 00:14:59');
INSERT INTO `programa_derivados` VALUES (97, 'Programa Institucional Comisión Estatal de Vivienda de Puebla', '20 Programa Institucinoal de la Comisión Estatal de la Vivienda de Puebla. (1)20240510192739.pdf', '20240510192739.png', 1, 'Institucionales', 15, '2024-05-10 19:27:39', '2024-05-15 23:36:40');
INSERT INTO `programa_derivados` VALUES (98, 'Programa Institucional Fideicomiso Público denominado \"Banco Estatal de Tierra\"', '21 Programa Institucional del Banco Estatal de Tierra (1)20240510192824.pdf', '20240510192824.png', 1, 'Institucionales', 15, '2024-05-10 19:28:24', '2024-05-15 23:49:01');
INSERT INTO `programa_derivados` VALUES (99, 'Programa Institucional Agencia de Energía del Estado de Puebla', '22 Programa Institucinoal de Fomento al Desarrollo Energetico Sustentable20240510193037.pdf', '20240510193037.png', 1, 'Institucionales', 15, '2024-05-10 19:30:37', '2024-05-15 21:05:47');
INSERT INTO `programa_derivados` VALUES (100, 'Programa Institucional Colegio de Bachilleres del Estado de Puebla', '23 Programa Institucional del Colegio de Bachilleres del Estado20240510193138.pdf', '20240510193138.png', 1, 'Institucionales', 15, '2024-05-10 19:31:38', '2024-05-15 21:11:33');
INSERT INTO `programa_derivados` VALUES (101, 'Programa Institucional Colegio de Educación Profesional Técnica del Estado de Puebla', '24 Programa Institucinoal del Colegio de Educación Profesional Técnica del Estado de Puebla20240510193223.pdf', '20240510193223.png', 1, 'Institucionales', 15, '2024-05-10 19:32:23', '2024-05-15 21:12:37');
INSERT INTO `programa_derivados` VALUES (102, 'Programa Institucional Colegio de Estudios Científicos y Tecnológicos del Estado de Puebla', '25 Programa Institucinoal del Colegio de Estudios Científicos y Tecnológicos del Estado de Puebla20240510193316.pdf', '20240510193316.png', 1, 'Institucionales', 15, '2024-05-10 19:33:16', '2024-05-15 21:13:31');
INSERT INTO `programa_derivados` VALUES (103, 'Programa Institucional Instituto de Educación Digital del Estado de Puebla', '26 Programa Institucinoal del Instituto de Educación Digital del Estado de Puebla20240510193351.pdf', '20240510193351.png', 1, 'Institucionales', 15, '2024-05-10 19:33:51', '2024-05-15 23:52:59');
INSERT INTO `programa_derivados` VALUES (104, 'Programa Institucional Instituto Tecnológico Superior de Acatlán de Osorio', '27 Programa Institucional ITSAcatlán2019-202420240510193425.pdf', '20240510193425.png', 1, 'Institucionales', 15, '2024-05-10 19:34:25', '2024-05-16 00:16:31');
INSERT INTO `programa_derivados` VALUES (105, 'Programa Institucional Instituto Tecnológico Superior de Atlixco', '28 Programa InstitucionalITSAtlixco2019-202420240510194347.pdf', '20240510194347.png', 1, 'Institucionales', 15, '2024-05-10 19:43:47', '2024-05-16 00:17:36');
INSERT INTO `programa_derivados` VALUES (106, 'Programa Institucional Instituto Tecnológico Superior de Ciudad Serdán', '29 Programa Institucional ITSSerdán 2019-202420240510194431.pdf', '20240510194431.png', 1, 'Institucionales', 15, '2024-05-10 19:44:31', '2024-05-16 00:18:25');
INSERT INTO `programa_derivados` VALUES (107, 'Programa Institucional Instituto Tecnológico Superior de Huauchinango', '30 Programa Institucional ITSHuauchinango 2019-202420240510194509.pdf', '20240510194509.png', 1, 'Institucionales', 15, '2024-05-10 19:45:09', '2024-05-16 00:19:28');
INSERT INTO `programa_derivados` VALUES (108, 'Programa Institucional Instituto Tecnológico Superior de la Sierra Negra de Ajalpan', '31 Programa Institucional ITSSNAjalpan2019-202420240510194543.pdf', '20240510194543.png', 1, 'Institucionales', 15, '2024-05-10 19:45:43', '2024-05-16 00:20:39');
INSERT INTO `programa_derivados` VALUES (109, 'Programa Institucional Instituto Tecnológico Superior de la Sierra Norte de Puebla', '32 Programa Institucional ITSSierra Norte 2019-202420240510195100.pdf', '20240510195100.png', 1, 'Institucionales', 15, '2024-05-10 19:51:00', '2024-05-16 00:21:28');
INSERT INTO `programa_derivados` VALUES (110, 'Programa Institucional Instituto Tecnológico Superior de Libres', '33 Programa Institucional ITSLibres2019-202420240510195139.pdf', '20240510195139.png', 1, 'Institucionales', 15, '2024-05-10 19:51:39', '2024-05-16 00:22:21');
INSERT INTO `programa_derivados` VALUES (111, 'Programa Institucional Instituto Tecnológico Superior de San Martín Texmelucan', '34 Programa InstitucionalITSSan Martin Texmelucan 2019-202420240510195346.pdf', '20240510195346.png', 1, 'Institucionales', 15, '2024-05-10 19:53:46', '2024-05-16 00:24:17');
INSERT INTO `programa_derivados` VALUES (112, 'Programa Institucional Instituto Tecnológico Superior de Tepeaca', '35 Programa Institucional ITSTepeaaca 2019-202420240510195442.pdf', '20240510195442.png', 1, 'Institucionales', 15, '2024-05-10 19:54:42', '2024-05-16 16:13:51');
INSERT INTO `programa_derivados` VALUES (113, 'Programa Institucional Instituto Tecnológico Superior de Tepexi de Rodríguez', '36 Programa Institucional ITSTepexi 2019-202420240510195518.pdf', '20240510195518.png', 1, 'Institucionales', 15, '2024-05-10 19:55:18', '2024-05-16 16:19:06');
INSERT INTO `programa_derivados` VALUES (114, 'Programa Institucional Instituto Tecnológico Superior de Teziutlán', '37 Programa Institucional ITSTeziutlán 2019-202420240510195601.pdf', '20240510195601.png', 1, 'Institucionales', 15, '2024-05-10 19:56:01', '2024-05-16 16:20:29');
INSERT INTO `programa_derivados` VALUES (115, 'Programa Institucional Instituto Tecnológico Superior de Tlatlauquitepec', '38 Programa Institucional ITSTlatlauquitepec 2019-202420240510195646.pdf', '20240510195646.png', 1, 'Institucionales', 15, '2024-05-10 19:56:46', '2024-05-16 16:21:00');
INSERT INTO `programa_derivados` VALUES (116, 'Programa Institucional Instituto Tecnológico Superior de Venustiano Carranza', '39 Programa Institucional ITSVenustianoCarranza2019-202420240510195718.pdf', '20240510195718.png', 1, 'Institucionales', 15, '2024-05-10 19:57:18', '2024-05-16 16:21:36');
INSERT INTO `programa_derivados` VALUES (117, 'Programa Institucional Instituto Tecnológico Superior de Zacapoaxtla', '40 Programa Institucional ITSZacapoaxtla 2019-202420240510195748.pdf', '20240510195748.png', 1, 'Institucionales', 15, '2024-05-10 19:57:48', '2024-05-16 16:22:57');
INSERT INTO `programa_derivados` VALUES (118, 'Programa Institucional Universidad Intercultural del Estado de Puebla', '41 Programa Institucional UIEP 2019-202420240510195836.pdf', '20240510195836.png', 1, 'Institucionales', 15, '2024-05-10 19:58:36', '2024-05-16 16:41:33');
INSERT INTO `programa_derivados` VALUES (119, 'Programa Institucional Universidad Interserrana del Estado de Puebla-Ahuacatlán', '42 Programa Institucional UIEPA 2019-202420240510195925.pdf', '20240510195925.png', 1, 'Institucionales', 15, '2024-05-10 19:59:25', '2024-05-16 16:42:12');
INSERT INTO `programa_derivados` VALUES (120, 'Programa Institucional Universidad Interserrana del Estado de Puebla-Chichotla', '43 Programa Institucional UICH 2019-202420240510200141.pdf', '20240510200141.png', 1, 'Institucionales', 15, '2024-05-10 20:01:41', '2024-05-16 16:42:56');
INSERT INTO `programa_derivados` VALUES (121, 'Programa Institucional Universidad Politécnica de Amozoc', '44 Programa Institucional UPAM 2019-202420240510200217.pdf', '20240510200217.png', 1, 'Institucionales', 15, '2024-05-10 20:02:17', '2024-05-16 16:43:47');
INSERT INTO `programa_derivados` VALUES (122, 'Programa Institucional Universidad Politécnica de Puebla', '45 Programa Institucional UPPUE 2019-202420240510200257.pdf', '20240510200257.png', 1, 'Institucionales', 15, '2024-05-10 20:02:57', '2024-05-16 16:44:46');
INSERT INTO `programa_derivados` VALUES (123, 'Programa Institucional Universidad Politécnica Metropolitana de Puebla', '46 Programa Institucional UPMP 2019-202420240510200335.pdf', '20240510200335.png', 1, 'Institucionales', 15, '2024-05-10 20:03:35', '2024-05-16 16:45:35');
INSERT INTO `programa_derivados` VALUES (124, 'Programa Institucional Universidad Tecnológica Bilingüe Internacional Sustentable', '47 Programa Institucional UTBIS 2019-202420240510200428.pdf', '20240510200428.png', 1, 'Institucionales', 15, '2024-05-10 20:04:28', '2024-05-16 16:46:08');
INSERT INTO `programa_derivados` VALUES (125, 'Programa Institucional Universidad Tecnológica de Huejotzingo', '48 Programa Institucional UTH 2019-202420240510200459.pdf', '20240510200459.png', 1, 'Institucionales', 15, '2024-05-10 20:04:59', '2024-05-16 16:47:38');
INSERT INTO `programa_derivados` VALUES (126, 'Programa Institucional Universidad Tecnológica de Izúcar de Matamoros', '49 Programa Institucional UTIM 2019-2024_20240516193618.pdf', '20240510200540.png', 1, 'Institucionales', 15, '2024-05-10 20:05:40', '2024-05-16 19:37:29');
INSERT INTO `programa_derivados` VALUES (127, 'Programa Institucional Universidad Tecnológica de Oriental', '50 Programa Institucional UTO 2019-202420240510200614.pdf', '20240510200614.png', 1, 'Institucionales', 15, '2024-05-10 20:06:14', '2024-05-16 16:50:47');
INSERT INTO `programa_derivados` VALUES (128, 'Programa Institucional Universidad Tecnológica de Puebla', '51 Programa Institucional UTP 2019-202420240510200644.pdf', '20240510200644.png', 1, 'Institucionales', 15, '2024-05-10 20:06:44', '2024-05-16 16:51:42');
INSERT INTO `programa_derivados` VALUES (129, 'Programa Institucional Universidad Tecnológica de Tecamachalco', '52 Programa Institucional UTECAM 2019-202420240510200720.pdf', '20240510200720.png', 1, 'Institucionales', 15, '2024-05-10 20:07:20', '2024-05-16 16:52:24');
INSERT INTO `programa_derivados` VALUES (130, 'Programa Institucional Universidad Tecnológica de Tehuacán', '53 Programa Institucional UTTEH 2019-202420240510200751.pdf', '20240510200751.png', 1, 'Institucionales', 15, '2024-05-10 20:07:51', '2024-05-16 16:53:37');
INSERT INTO `programa_derivados` VALUES (131, 'Programa Institucional Universidad Tecnológica de Xicotepec de Juárez', '54 Programa Institucional UTXJ 2019-202420240510200827.pdf', '20240510200827.png', 1, 'Institucionales', 15, '2024-05-10 20:08:27', '2024-05-16 16:54:20');
INSERT INTO `programa_derivados` VALUES (132, 'Programa Institucional de la Comisión Ejecutiva Estatal de Atención a Víctimas del Estado de Puebla', '56 Programa Institucional CEAVI20240510200859.pdf', '20240510200859.png', 1, 'Institucionales', 15, '2024-05-10 20:08:59', '2024-05-15 23:47:54');
INSERT INTO `programa_derivados` VALUES (133, 'Programa Institucional Instituto de la Discapacidad del Estado de Puebla', '55 Programa Institucional INDEP20240510200929.pdf', '20240510200929.png', 1, 'Institucionales', 15, '2024-05-10 20:09:29', '2024-05-15 23:57:20');
INSERT INTO `programa_derivados` VALUES (134, 'Programa Institucional Universidad de la Salud del Estado de Puebla', 'PIUSEP_1803_133020240510201015.pdf', '20240510201015.png', 1, 'Institucionales', 15, '2024-05-10 20:10:15', '2024-05-16 16:39:36');

-- ----------------------------
-- Table structure for regiones
-- ----------------------------
DROP TABLE IF EXISTS `regiones`;
CREATE TABLE `regiones`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_region` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of regiones
-- ----------------------------
INSERT INTO `regiones` VALUES (1, 'Región 1. Xicotepec', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (2, 'Región 2. Huauchinango', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (3, 'Región 3. Zacatlán', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (4, 'Región 4. Huehuetla', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (5, 'Región 5. Zacapoaxtla', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (6, 'Región 6. Teziutlán', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (7, 'Región 7. Chignahuapan', 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (8, 'Región 8. Libres', 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (9, 'Región 9. Quimixtlán', 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (10, 'Región 10. Acatzingo', 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (11, 'Región 11. Ciudad Serdán', 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (12, 'Región 12. Tecamachalco', 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (13, 'Región 13. Tehuacán', 13, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (14, 'Región 14. Sierra Negra', 14, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (15, 'Región 15. Izúcar de Matamoros', 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (16, 'Región 16. Chiautla', 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (17, 'Región 17. Acatlán', 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (18, 'Región 18. Tepexi de Rodríguez', 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (19, 'Región 19. Atlixco', 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (20, 'Región 20. San Martín Texmelucan', 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (21, 'Región 21. Área Metropolitana de Puebla', 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `regiones` VALUES (22, 'Región 22. Tepeaca', 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id`) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('03mNG7PJrD2pUbVH9D7lOTe0NOhXNuKsKe1B00hN', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaWMwTk1OcWt4c2gzTHoyRm9QOGc5YVV5YUNuTHdZZGxJTzV1WW9HaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721916278);
INSERT INTO `sessions` VALUES ('0cixU2mdKhmHr0cBDveET5BgvuwghIpfCxQaLOfu', NULL, '10.1.4.9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXU4cGFlTkxYMzB2SmFXZ3B5dndCSHlUcEY5dFpoZEFDcFRLdmFQcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925674);
INSERT INTO `sessions` VALUES ('0IVgPv8JprkZKRjTStGTtvNZNx0ZWn2FCM8QjuNE', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM2s0V0NsQmw5eG54UVp2WW0yeDkyWU1saG02ZTZ2MmVBdmtQM3V2MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923190);
INSERT INTO `sessions` VALUES ('0Z30UvBDhvlmkMyeFMHxkPhn87KksQGTPv94Yczi', NULL, '10.1.4.9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlFLZWpSQ1FyYzgxY1YwaHVNNFhKendiUVR5TXBRWEl4cU9LV3haRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9jb3BsYWRlcCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917436);
INSERT INTO `sessions` VALUES ('1lsVDYRtpzCd2qFNLRcKDmoIYSWdcTQozM4W6myB', NULL, '10.1.4.9', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnNDRkhmQzhWcXdpUUVqcW85Nm9FU2F3REtYeDk0ektlbFhQdzdSdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923242);
INSERT INTO `sessions` VALUES ('1ZpqBIVkY5nrEmMQ95UGR2ItAUW4pEHnDTAfzgaw', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZXppdm01UEFRcEJkRG16T0NwckM3dWxvYkkyQXpuNVdXQmo0QzU5diI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721922703);
INSERT INTO `sessions` VALUES ('2JvIFT6ZfygVoa4dt7hg5VAqifIoqo4Mfd0hfm51', NULL, '10.1.4.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTlBoNDZvOVNHemV0ajZyZUdoRVc1cVRrbWpXTFlaV2M2eWc2cFZzVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9wcm9ncmFtYWRlcml2YWRvcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721922813);
INSERT INTO `sessions` VALUES ('2Lsi8NINhwqsUao1goCo1TxzkUwcUgKuGPrC9bLV', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoibUZkeUNIUW10dGlEejgwR0JSRE04ak5MTFdiWE53dk1SU3JwQ05yaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721917778);
INSERT INTO `sessions` VALUES ('3hnUaWT0ky5yhm4My2EshaTkFKJtwI4xr1ZOaPu0', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUlZZdGhVSlNhWFVQSkFpYWY1ZEtGVjd3SzJPWmN3QzNpb3UwWXJtZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721916878);
INSERT INTO `sessions` VALUES ('3O5XEqpksS7x2z17JYZqY5aPhTBgwCs4oWRvgFeG', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia1I1Q0hqZDB6WXJaY1hGVmpIb0VHNnhiZGxhNXA1QlJWc000TmVFOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918171);
INSERT INTO `sessions` VALUES ('3rQWYwN77vK0FsYWAamChtKlghBe79f4Ngf1Sq0e', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYUp3NkhYa1kzR01IWmdwN3NubWludnFvODRTQ1VnVVc3aVVCODM2dyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721922032);
INSERT INTO `sessions` VALUES ('45rRf39uFxtUgYzQAJdaYy5Dt7k9mbHOXaqUQUYd', NULL, '10.1.4.9', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRVRkc1N1c0Y4eURuVFR2cUphamVPdm9zd0tjcFhSeGZpaWpkTnV6ZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923915);
INSERT INTO `sessions` VALUES ('4LKeCBQHJdLORCYbQaexfkz5wpy0vj476JueTPXV', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibzliTzNMVG9maVlib3dpMHdZS2Q3V1dvbHFneVdISDVZc0FmSDZFWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918891);
INSERT INTO `sessions` VALUES ('4tIqKLTqBPVVoaRI9wqGmigCMGyRFvr6MHaOWJHX', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmNPMzhTaURqV01YeE9DbmZ0RDlUMWNFZGdxaUh5cmdwaEVaYUswdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920512);
INSERT INTO `sessions` VALUES ('5C8goiPVKFpLEYdYPlP75jTftoAfrQKMPecKuZ9k', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibDlYbVRPWk9xMlFCUW9rQkV0WnZTUGwxaTVxNlB2d3hBZXRyd1RrUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9wbGFuZXN0YXRhbCI7fX0=', 1721921420);
INSERT INTO `sessions` VALUES ('5DUrLCCtZv2BPRnZGERz6vzjHocriJ1eu1gD2ZUR', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYlprTkZ6R3JHVWczRllTeVdLZEtiVVhLQXR1MzI5QWduenV1Njc1RSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721924378);
INSERT INTO `sessions` VALUES ('5ktN1cbS68imXXRzViQNqeXP7tYg9LG9ZcfvLlQ4', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicXNwM1pYUkJ0eExiZllwaldjdGtmd3ZBdU9wdUFEemllcnlTVTRTTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721917478);
INSERT INTO `sessions` VALUES ('5pxdGaQ6RtS8yMvfj2tu1NCBV3Lhc8WfDZoPkZWW', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTVVaOU5DVmR2ODRuQXJzVzJXZWFCVTZQREpscnZCdFdERGxWdnVSUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921988);
INSERT INTO `sessions` VALUES ('6jDXNKTnHFpP5MxlLCzDgqnWphkRbAJArEl02nvX', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNjB6ZnNJakpmUGd5Nmt1Ym5scUxUckNkdVdxTU9NNjY3aWdEM0o4VSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721922391);
INSERT INTO `sessions` VALUES ('7h3sDBguwwsrsEBN9beVDygnnQ71V7n489uiWUsH', NULL, '10.1.4.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWNDNDZmUUFCUWxrNzJpbG9sZ2dZalhLVG4waDNXS0JsR3kxNEFpTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9wbGFuZXN0YXRhbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921280);
INSERT INTO `sessions` VALUES ('7InQCmG1yLXnH98iMtIYg2a0rKkqNh3eHABNOwpP', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVUyd0lFYnZFSmNxNG9ha01HSVliNWN3WWk0R0owTkxjVmlONlh0cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721919598);
INSERT INTO `sessions` VALUES ('7oRqHIEPpF47dxrthhrTSEnOv83FVLXmENbcdoLo', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiblIzZG5KeEE1Y2phOEI4aktUbk9tT1JSNGlzSmNpR2cwRTVNa3FDYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721923478);
INSERT INTO `sessions` VALUES ('81AHnzVgwsgonfEOHjyqDBULzuUSUt4R5HyHWcZO', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiekNkRjBGZk9LeXBuTkJubnJtZTlnbHlLVXJuVmJqMmdlQmhvSEtqWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721922589);
INSERT INTO `sessions` VALUES ('8OeY14R8SQPy8uiRl1mplz9s2Nh0DijrP7FFAesE', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZUdDTUNRNkhraWJrbDFpWE5WclhUQldSZHV3ZUJwSG1sUGVJQUtpUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920421);
INSERT INTO `sessions` VALUES ('8RGow3fU6QKONIBVmyahTvtAbbIYctgvgEIJwWrM', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiczJBeGp3N05sY21Ydmg0Q1Z5aldKNllOS2tLWmhhb1NLOVRnUmgydyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721924078);
INSERT INTO `sessions` VALUES ('9lpceHxEHeKNQGm6L9aypOdMAZsAfCkpzfLYywPr', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYnQ2aktKVXl6U1BvaWVwOW5obGtXV3ZZMFVMamJCcUh0M0VaZWhKdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721919499);
INSERT INTO `sessions` VALUES ('9p7G85g0BDs1Xb7GyMaMI7o3xQGCkPNZgMInpxOX', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic1FDUTFhc2VDZ1RQcEx2MUlPNENrbWdneHVxNTFTTllOcHA5VUFhRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721915979);
INSERT INTO `sessions` VALUES ('9xc7XyE3OVeGQWykdApuhEZnA27XgbtSbaYcInEi', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaHNucXNmTUx1aVFJNERzck5lYTJNT3llTE82Rk1aaTBvUzd0VEE4VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916782);
INSERT INTO `sessions` VALUES ('aATY8Xoz7hs8OOtR6syaLHjiNtQrgsCUGLUUt0jH', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicDNia25hR0xvSkFCeTEzdk4ySmRkY2lydHpCVGkyS05PY01aODJYZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721921378);
INSERT INTO `sessions` VALUES ('ado9upDzIbn482Sih0VGTbEdDZ75EYj16ohK6FcF', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS3dYMzdmWENNNTlPSmt6Z1BYWk5kc3ZQVjlLeGdmSkJaakJSeHpQbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916376);
INSERT INTO `sessions` VALUES ('AwycjsHyh9UtRsTFzFmMQtYbaJIMFpBrV0EIY3cP', NULL, '10.1.4.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 Edg/127.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic3lPOVZ1czVMSGF4MlVsd1JQaHJ3NzF4Q3I4ZUNxcjZ0MWVJRHl6dCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9wbGFuZXN0YXRhbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920526);
INSERT INTO `sessions` VALUES ('AYoIaaUTlWr4c5tYnIie9hjCNuFE2iSoTDPHm41o', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoidWVhakxuTkNueGU0VE91ZXZvQ1dDTDNCVFc0SGdOdkdqZEtmeWp6eSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721922278);
INSERT INTO `sessions` VALUES ('bblDI9wBCLJ094Xr9Cp2K3xyg1jeOQaGeHN0eIEG', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRk1JNlRZTk5ybWJURk5wam9xRVlUTE10bnI0Q2I5UWtwN0hScUJVVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921344);
INSERT INTO `sessions` VALUES ('BbsPmMZda1dlpclkiBSX2LM9RBggBWY4Nv5OqmUC', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ0d4blVPeG1PdWI5SGFpTGEwYXJ3TnJGWHpIQUpwbmtCTHlVVjZEYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924980);
INSERT INTO `sessions` VALUES ('BlLjVoPOKXT0WiiH28PKK36BGwDkMMxHuA2F1XGq', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicnpOVzg2dWlQcklFMDdsTDdLOFBmRlZmZXZHb3lpNVE2TkUwSUZmSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923594);
INSERT INTO `sessions` VALUES ('BMIV9rL2ouLoDQILpDJngIOygpG1SFqsfezwrl0J', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiclFjbzBIMHFONUJjb3hDZ2U1alVHck43dnI3aDZ6ZTBGS1d6cFZheiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924367);
INSERT INTO `sessions` VALUES ('bN2NfvWZzdV9CSblNJ2d91IUbGSweOBX4hIsqoiI', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoibFR6aGx5ZDZ2NkN6UXRtemJZUEdQNDNwZDhLc1BWeW9aNWpFYUtZbSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721923178);
INSERT INTO `sessions` VALUES ('BsnZYUWJKlbmPSRGBod0zE3lQeqinszVAvYkVz9K', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic0FlSDlhV2gxcGlXYkJ5STJueFJoanFqNXlBd1pUUkhxVjExdWxKbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921410);
INSERT INTO `sessions` VALUES ('cv9W74wZVrjbPxVmh0XGCR7EU83DYR89G8gYPorz', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSTNZWFFHNlpDWjdXWUo3WDJyUVk3UXE0c2N2UEVxT0NPODc1dHJVUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721922207);
INSERT INTO `sessions` VALUES ('dC9kLF6jkR8CVrf5ASeX559EYx6PMkoBEFTvYxE4', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVFhuSGVMTVp5MFZHRmFNN0JoVGJTM1FXcUo2T0tvVllMUFFnbThPdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921729);
INSERT INTO `sessions` VALUES ('dCVWoXCAZhunTAfrheKONoQQsrfjK1FamXjxpQQe', NULL, '10.1.4.9', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmU4ZU9sWkIwTnU2WTU0SGtqa2gzbVdHTFA0bHIzcDF6UEN4WXF6NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916617);
INSERT INTO `sessions` VALUES ('Diek91l2IUE6WBbLvVotZNn2wQMCz6ZENWTzdBy4', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiOEpHMVRJbFdpdnk3ZEdNMFhwZVZHZERuRTBTeFNqbmxkVTE5Z3lZayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721920478);
INSERT INTO `sessions` VALUES ('dkIBcOfYlTsRhVz1fP7dZCPTVFIs2Izc6HV9era7', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUERodWhweVZ2TVlmd2pHMnZySGFZRlVTdDNMc0pvS1VKSXZSTXIydiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917982);
INSERT INTO `sessions` VALUES ('Dp6XoeWRWcDobRA78yLZO1uoVx1qEoJJKWus0T1a', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmRUWEtNN3BDRTNOSDBEaWo2VFF2OUxvMzAxeUd5bWNrRTN1eXBTQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923372);
INSERT INTO `sessions` VALUES ('dVtVfSw2e2fe1Q3q7YrzfNC0soSKSMDOnyMOhs8g', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaDFvZWdVTmdRajNHOVBMazZFZVVNWTJuNmJXVHBHNjhBS2wzM0dLMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721921978);
INSERT INTO `sessions` VALUES ('DwSsRPPfniNR7VwnK1GyNphUap6CviaBL4Ht0KRY', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUEhmb1dTNnlEbXNCaGV5VEpZQXZpM2NxMzk3YXBnRGh3VnJ1M0l2YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918859);
INSERT INTO `sessions` VALUES ('dxzBXN4RmzwLli70czxIO6smENgz6MbrY55cO9NB', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWnJyZzBhRFBRMzVNRklVVG9NbGl5UG9VUk5PMWZFNnBiUFJCOG5PVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721922878);
INSERT INTO `sessions` VALUES ('EDAcUiJfXckOOX9bu8rLkEaOVN82r3q8yeeV9EHq', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTW1oeVFheGV2Zk5oakxyTEJuUG1rVXp1MGkxN3pFZ2o3ZllKeHpvUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721915735);
INSERT INTO `sessions` VALUES ('Ef6xh66TCtu7AM8V5HRMwsznvQxGEJWCcB6CMWlf', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlYyOHdOZkxYSnBweFo1M3JYdHJtZk5GTjRDV2MyY1hxb1VTWVB3SSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9tYXJjb2p1cmlkaWNvIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721919753);
INSERT INTO `sessions` VALUES ('Ek3ojlTKutseIM0rUvPcj7SDKMsKQ99C4jM31e3l', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTlJZZHM3ckRXNWpXczRKWk1CWTQ2ZERwN3BvNW1yYjU4OXpRQTZrNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721919001);
INSERT INTO `sessions` VALUES ('emEJ9uIiGGVLLexyxBPvvHT0thgHXzFqCnY9AXWE', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOXJSN2xzb3ZVVFJKdGRGdHIzZnBMeEphZUFSamtFUlllMjBudHhxSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9wbGFuZXN0YXRhbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925458);
INSERT INTO `sessions` VALUES ('EqdeP9ZVFxKswut0eBRw7eG1Tjwm05w9fNmr4iak', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkZXbHBaeWgyd1owZ09iTnJFUkF2RmQ5dGxvekZjUVhyRmVjbUJMNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924237);
INSERT INTO `sessions` VALUES ('ERlXyRGGsaNI4F4UVrnSLsf4CHEO7S84uWPnz6Fx', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibFlSNHBEWkY3RHkxVUVTWEphR3Y2MWF5SERNQzNkRWVNaUN2SDNscyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923210);
INSERT INTO `sessions` VALUES ('Euj2LByKAwGr899zJnuuQyX3vipY1xToWzzqVDIU', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYXFRRVlXdTk1MHRUN0N1UG9wbk5BRGR1dzRqNkUza1RvaTVzZTQzVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721918378);
INSERT INTO `sessions` VALUES ('eZRBd7FYyX5MifMn77viBTE3hJBDd4nIMqV9CHeB', NULL, '10.1.4.9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid1dhbkdyMWxjU251M280dlVFRE14Zjk5bUpiZ1pkY3JreTh0QUxRMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920411);
INSERT INTO `sessions` VALUES ('FpWM0lnERHqUmpS9NSD0sMmW8Y4lZ0Awqs8Ygl58', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUklrNWU1blNkR0c3eFdWb3J5dWJyWGxZWG9sbng3WDdwUURnRWlQMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923998);
INSERT INTO `sessions` VALUES ('geYcePQRPHSTVrKYPKbNdLvboaROVDPQ7ydY4wS8', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmZEREdvWXEwQzVUcVRubXY2QWNJdVg4WVc5UTlQdk1rNllPMkFYRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925205);
INSERT INTO `sessions` VALUES ('Gj4Yfd1pFyBwDNVvompuj3k5eHVrKxiLIssSvtJ6', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTjlvM0IyaHZaR3pJYUxpbXBOSGdpZDV0dVZTdGN2U3RKSHB6R3BLRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921511);
INSERT INTO `sessions` VALUES ('GttRD7eWyXLh6QSJKk20LJdvb2ng7vIpFjy5jnRb', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0FMc2drcUoxQUFPRUJ3cjhUUTVWRnVLd2p6RkdBNTV2T1pWRFZRViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916738);
INSERT INTO `sessions` VALUES ('haA3BPJ5jVbikq6aJQ3WvFJEZhz5VlhoqZJEiFox', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibW8ydVU5NnNCRXo3Z0NuTno5R0RwdGxTSzlLcUVwOTluWXFIWTBxUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916605);
INSERT INTO `sessions` VALUES ('hDoQ9fNRdOgj2KDpWU50Kjfj5K41JXUZpDFwOqGo', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUhHZmF5Z09CblRjRVlTcXNYTjljZzNOMjVqbmZ1UTJRa1h0ekR0VSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721915663);
INSERT INTO `sessions` VALUES ('HGnhJdQoWsQiGcFuBWMFGyVFVMcnxlLPQlDim9or', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiaEh5MFl3OXY2WXRxS1BvNUJRSnEwaFdHeUtZb0ozRGxBYkhta3FpcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721918678);
INSERT INTO `sessions` VALUES ('hK4wiUIzhaMCnqYjlCKNI8Y9MifeXhPg3lPBO8FN', NULL, '10.1.4.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNVBEU1FtVkx4b2xUOE5wanBIdDNtY0FVWUhQemxzd21YUGlVeXJQRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924624);
INSERT INTO `sessions` VALUES ('hsaHOiHMF0T2Cvk0yikIX7gVrFXuvPEjxHCACJp5', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0RCWmt4Z0RzbEt2bzlJbVJIU2xZcUpwTTRCejdUVW1GTjZESWxPYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917356);
INSERT INTO `sessions` VALUES ('HtOf9S86voQ7ucPoLf0xYUQJM2zpwrACbdN8PXBt', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaHVkNnB2WlE5R2lEMEJsTTRBRTFUcXZGWUVPVFZybFJubjIxUE1nVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918699);
INSERT INTO `sessions` VALUES ('hwWTx76sC4WJBMTfLq5uFtF0dgPejtrFpXitHydV', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTERrRW5KbGxmZUNpTTdJT3ZIUnBvdG94cUExMXB0TE9WSUJVajQ3TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925519);
INSERT INTO `sessions` VALUES ('hyJJDy5jXSckmQIMsADikwtXX0X3yeYKDfybLOJ6', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYW5walVzT0pBbmRtYWhYNnNBRWZaODhOYmpVcFBFYkVKU3NQS01paCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721921078);
INSERT INTO `sessions` VALUES ('I4tcC95D8njSrgaV3flLZM9bZHergEEp15W1RUsl', NULL, '10.1.4.15', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidDF4eDBvY3BaTTQyRkhKRTJhY29zcTR6Mm5udXo3b1NCc2pBT0R3eSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916412);
INSERT INTO `sessions` VALUES ('IfBn9Kariv070E2qMeNVP0Cxb01E6WOaDnqKjPrV', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRHJ0anZmZ3lLTm03eXlZUkxmdWZpdVBrZFN4elJCUjlXZkl2TG9FQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721916970);
INSERT INTO `sessions` VALUES ('iFPqW4UOFuPLPwzZkOsdbnuSCWzz2gP3N7YGDxyT', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHhaZEltRGlLTFpHanVKTHBFVzFuc2tSUUQ4dlNQOXdVWWMzZHRtcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721919376);
INSERT INTO `sessions` VALUES ('imEGvBZn9zuNTZPjNdVVDzgvWwe7R9pqAI2J4kVM', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoialVxQ0dnY1NMaFcyQ3NwUUtDNmJ1WkdESG5JSEFjMVVhVTZoSWJWMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920833);
INSERT INTO `sessions` VALUES ('iSnrR2hG6EGHB3u8qQctly49bj61KCQJ2xJXOSYP', NULL, '10.1.4.15', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1poVWRucUlMUWQweGh1MXVLeERzM2pVcXB4ck9sUFlaUzRWdGw4RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918841);
INSERT INTO `sessions` VALUES ('iuZL83j50n0hf713sMOQglRptcgF2C8M7Sz8zGsJ', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmpySFY0SVVYQ2M3NGRTVGhuRGhHc1hHd3JGS3plNVA2eVM4QnlHQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917680);
INSERT INTO `sessions` VALUES ('IXmqOGlMuenSDkv40Gg9R6RUVIj3ZZBdO6SRS7HH', NULL, '10.1.4.9', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiazhBckxMbnlla3VXb1dJTHZkM0VyTHgzYkNRRDdwZzlCcE5zV3k3NiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921539);
INSERT INTO `sessions` VALUES ('j1TQHCvnF6z1H43D1yub9F7vxAd4dPOE0jDUnUkt', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVpGT3BISlRCTDJFckhQTFhPWTRPNlNhU2N1ZlVTSzlXTTJNUzR3TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721915835);
INSERT INTO `sessions` VALUES ('j7eR4DgPVmgUxMe3tqUTQWVkrEkI9tjL7KtSYLHH', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3huMmNJTWpJSlNoZkdFSU9GQ3cxRmRLUk9iVk0wbkhXM1NwOXJ3diI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923044);
INSERT INTO `sessions` VALUES ('j9jM5pV9EohQdzSfeEcblLhXVoiWbT8zcp5epCZn', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib1psQkFzWmg3MHVSNWxPVHkxNWpEMXNaTlJvT1d0dUZUaTNrZFpwdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924670);
INSERT INTO `sessions` VALUES ('jCFP1WaIl9TRz5KqlAYOFnvB1jbSbRRv0l997m9p', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZU9JZkxCWmNPcGVuVkJpTThrRzZKeTNiSTJyR1NZQ0F3bmpwUGJiRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920721);
INSERT INTO `sessions` VALUES ('JCXuriz3oNXDH5z2oKJRmm2R0aJ69kTg3MxaiwhN', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibkRkVmVPd1l5UERPOGpONHBUNjNRZE1FYXhjUmlYWG1iTDVhRU1EYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920134);
INSERT INTO `sessions` VALUES ('jFVvB2L5NYDYr86C0aBDntCbdwZfQ7LZqWUO6Bza', NULL, '10.1.4.9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWpBTTVUajlXUGZDQ1F4WGM2end1VjFUQUxPT0w2Tk8zdlM4b1cxZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920356);
INSERT INTO `sessions` VALUES ('Jic2nYOhHHB41dSFr4xx0x7Z772YGHKKNLj5GXxq', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWp6ZGpEaEVkWGJRZFptQWxva3pKSkgzUTZKU2RUdjNyekl3SVhPZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924721);
INSERT INTO `sessions` VALUES ('JKTOym0VPGaBl6BDWrVR57VLtFAnjtBmWzv6xkwZ', NULL, '10.1.4.9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0x4MjRmQzZzMzBmTkI2aEVpWFJyS21JVmlFZlhhcDV0MVA4SlJEWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925674);
INSERT INTO `sessions` VALUES ('jNiBAADRgZMLJS48peK1XPUNgYkSstRbX6q4G32h', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmJRUWpkMk5MTG1abmdGOEpCWllubXE0ZGFaeVhwRDE5NWJSNmVWOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920438);
INSERT INTO `sessions` VALUES ('JO71N2JybUvSDmmKhij0G1dZhihNfToSK3W6PbLx', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibnlMbG4yRXJHaTBuSEFzbVF2YXNNdkpMbDNsbTdQb2pHc1d1UlhROCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918376);
INSERT INTO `sessions` VALUES ('jStX5ZwFVegHVv6DZNaq8XXhLC5SwN7mHwwxws32', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSmg1VDNRY04zQjM1blh3a1NRSFQ2NFJzTEZiRVVFWXV1SG11eUpkdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721918078);
INSERT INTO `sessions` VALUES ('jw4qfh4XAMEevtfvLmUtkV8ezX0VXT4PmUdrQjXN', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGJNYjZlYUdEbXh4UkM4azFjeVc0cHFOaEo2am12RlJYSlZtc1FKeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924543);
INSERT INTO `sessions` VALUES ('KkwIlPaFj8JYThqOcRWvlxopqJ9U6cDKCskuwVrX', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiME5Vb2Ixd1h4QXFRdWw0RE1rcERrNVlZRVNnNkwwcTRlRDk0RlZzdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721922889);
INSERT INTO `sessions` VALUES ('KSzAH141ymcavPgypTD9hDqdiH8QYFyJVCBpDjvv', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieGZoQWgwOVRmNG93MlJOOGQwRkRBWm1BcE5tQ0ZwekpNRVNnUVVPdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917085);
INSERT INTO `sessions` VALUES ('la5zeuctj62qJsauJ3CLpuBCPzR82LaMX45FQAin', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicGdEa1NwcnFDUHlmTFQ2YXlZR1VVRno0aUpaVjhBaTZQeEVkWjNRbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917055);
INSERT INTO `sessions` VALUES ('LiBEKndcFyamv6bLLtXhsnIJJBQhWpzT07z8gZoJ', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSml3bFZPcjY2YlE4RkQ4N0lPNmFYbjBSSzZ0Um9acmF2aGE1elE0NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924728);
INSERT INTO `sessions` VALUES ('lJuxTT2BzAKBdQR4DSayq3T1KUk4OZjKE52k6KGV', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibzFGaFV4YVZjOFVvUXRON25VTE82Ykc0STcwRVJQZmdEeTlWejJxQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924115);
INSERT INTO `sessions` VALUES ('LmkjnGi690D1JlDL40NMpXxymW1t1nk7OatnOdzq', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicHRCaFRnWDBlS004T1VERU5GVW0zOXhkdXRLUU41ZlJXdG0wZXk3VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916062);
INSERT INTO `sessions` VALUES ('M187Zg8e2vf1gKBMfrVvMnDqK7wuJo6r16uTN4SY', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaU52c3pPRHdLUHlDeEp2NkI4Mnl6UlNiQlFIUHp5VFZncUdsV3E1MyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721922905);
INSERT INTO `sessions` VALUES ('m2x9YFPJUHGGUpPquAfVxMfKDj9BqBkEuJMU1NXV', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1VFejNWclFWVEJyc3FadHV2MmpNOUs4dEduZ0VQcmEzRnloOHdYNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920062);
INSERT INTO `sessions` VALUES ('m7yHl7YlEGAKbAJkcEnycqf3SqzqiXXtm21P3UIP', NULL, '10.1.4.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWjZqTkRKU2NFOGZlM2RXYm1sR2EzdGE4MVV0b1dRck5uTFNIRlRiYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9wbGFuZXN0YXRhbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925031);
INSERT INTO `sessions` VALUES ('MbwbdwbFjvjAdv66n3Pua0RGmqccfkQkpoeVggYT', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDZsWVpjOHBpNUdlRElQaUpENnJhaXFuYW9yaHZjMU11U01peXgyYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924374);
INSERT INTO `sessions` VALUES ('mcwUfQAyVchZT8eDwNlZXMq27IWWfXQenwFE8kD4', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid3BUeE83MUlXUkRiRmFHcHpmdzdnY0RXRHVuazg5cTV3SjJ4bjJmQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916143);
INSERT INTO `sessions` VALUES ('Mm1pW9XnM3KMMyykFsgYvr7huo9zluO2uEu6qtj7', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieW1jWDJwZlZucG9UdVJHOW5VdFJZRVhYRUJ2V1lXa3A2bEpWRFVtaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920741);
INSERT INTO `sessions` VALUES ('MQCNhYBZKHDgqC9fIysJK3Mq94aaFh514xjKWYKw', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiV2J4cW5NWkU5bjVnSHlRZlZMcTBFdHpnZFROVnpsRmtoTEN3SVMxUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721923778);
INSERT INTO `sessions` VALUES ('mSJYvPWqhQgOKBNKWp3ChzOILRQkMF6kbY3ZrPB3', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSW5ybGZaTENuTXhhcUY0bHUyMEIzMzhzdjZoT1dhd3VQRlQzU2tGWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925639);
INSERT INTO `sessions` VALUES ('nKgkLrLZvLYbyAp9NVBMKojXzwd6I4GkAPTXcHu8', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSDJnRHB6NjJ2QXE4VkRLaFFBUTI3aEM2dUtHeXVWZ2UxUU9TUDZtdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721925278);
INSERT INTO `sessions` VALUES ('nNJbP5TwD9VUFXD2dqphRG9FlXSB21KN6XNaDEr3', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieTlXSGdzY1I0c2dnakpucnM1dXF0aWJWNUVSRWtISW1NTUF6TlJZciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924852);
INSERT INTO `sessions` VALUES ('nOpjPZgrklWsjHoZLHIStdC3bV8cOIiSEXcuzidR', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiekpkcEZ0N1dpTEQ1MWJkM213VzEwYkRCVnZLQUM3ZHpRR2hGb0s5YyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721916579);
INSERT INTO `sessions` VALUES ('npzDwdAAsCSF70J7iiiMNlMFGn7lSz3ulra3tldi', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicnRyb2RXQW4yWUNEam53RG1FT0RjM0hhZnN5TnJwUXl5UlFlczVkSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721917179);
INSERT INTO `sessions` VALUES ('NWaxgnaDZTlfhYfOvXZbIjOKqRrOiFdl1GlalsFQ', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUmhMeTRoVTRGemJ1SldCOVhVd2VlVjRsOG1JdDZoZGJlTkVwUWVYSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721925578);
INSERT INTO `sessions` VALUES ('nZpn72BzmyftUYeVd5XCz3PtKr67OMZFvT0M3Rk8', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmlvRVlGSmhtOWdLUHFCMmtoNEE1QUJBV3l4SzFnYnVhSVlGVnZnWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921166);
INSERT INTO `sessions` VALUES ('O8Si5YIxXqhR8dvGGNi7iuWcbpGdY8Cwpk9yLDeo', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmxTVGtrbzdEakhycWlMMEhxNzJZVHJiakdZRjVla25UcW96dnJKRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917151);
INSERT INTO `sessions` VALUES ('oJYLPKuQGssoCen5ZVNH0BCLxvAcwzKorO4TLjQW', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGN1N2MyNGZMSDN5d01pVDVkNExwVDd3WkcwOHlCeXV2Mjc2ZW9XaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721922727);
INSERT INTO `sessions` VALUES ('Ozx8olrn3zYmGuyFzC6MZxbbJIUI7LJG6oDVXblX', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQUd5NG5pVUZLRk1UYUl0MlNkSmIwZzR6dHRnZ0JFY3lyNHZRSkIwUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721924416);
INSERT INTO `sessions` VALUES ('P1PT6l9zJEEGf2tTDdLROkFPdkNckRf46w8CA3qX', NULL, '10.1.4.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWFhGb281TDBIU1VvV1N5cVcxUVM2ZDN0ZndvdGFjdnh2Wm5YbHJXdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9wbGFuZXN0YXRhbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923999);
INSERT INTO `sessions` VALUES ('pB7QuYr8YLgkvqfXhlKTUHHTn6PeiZoIqokmU7HY', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnVVRjJKUEZta3pSbk5yT2JOYWVYa05QYUxmRzhldWRibHV0QjkyZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918283);
INSERT INTO `sessions` VALUES ('PEwt4C7f9E8NiNHviB4KSw94r4Vu6PtTl48ZWhsq', NULL, '10.1.4.9', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUFlNWlNNQk1kMkxiZVFvQnhWY3F5c21XTERzcWdiT293cVVUM2FXQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921540);
INSERT INTO `sessions` VALUES ('pQY3okXzEqJvslPRxyKoCcUt3oWX7R7UfbrYzfcw', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTHRzTVpQOHJNc1ZTZVhlMTNzSXhlNmhjV1ZpN2p1dHc3cnFsRkdSUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721915531);
INSERT INTO `sessions` VALUES ('praHGx4uuOhiLsEdehXQxT6Ko1by4N1bI0lrUaYY', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSGF3YXZiREE4WnNOZlY5d3RHakxIZUcwMzFON3oycm9SR3V3dkF4SiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721919579);
INSERT INTO `sessions` VALUES ('PsJF7RMBaQrk6HQek8yMqvqZuK5YyZASIt9HCLWg', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiU0o0QkN0dmhXT3BFQ1hES2l4bmFMdlUyQ0sybk5remdKTUI5MWJPTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721920778);
INSERT INTO `sessions` VALUES ('pyjXHRlKfCUDOY1xMUswleAj9m3Vpi7yU0x91Xkj', NULL, '10.1.4.9', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMlRTRTJrbzVFYkVtT3pTenNka2dDdUpaTlpXNDJmdkpPY0N6ZDlEMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921540);
INSERT INTO `sessions` VALUES ('qcnchq8qzF7JcDHCml6VXVohSOQcZwe1AUCfLIoa', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMGJyazlPeDFzaE1zeXNyYXFZc3JpMW9yeVpqeTA2WnZWdzdFcEFneCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721920178);
INSERT INTO `sessions` VALUES ('qdUraaH6dgq2SGCz75KXADlsmo8jfXFp3N05EVxY', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Edg/122.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic3ZnVlA0bm8yRFhNZ3c2ck9naWd3VktVZmVnRTJSTmg5bHdPa1RyRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9jb3BsYWRlcCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918294);
INSERT INTO `sessions` VALUES ('qdXXeeZyMlSPWIphlRlFPtPEkGswb7KETQDpiAq5', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2I1MzVGSk94bDREV0FPYkV0allIVEFhMHB6QWkxYTBVd2YxRFY4TSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917694);
INSERT INTO `sessions` VALUES ('qmWSp9glo8FjIwibFW4u5l6NdMk9q4CsgGjw0Do0', NULL, '10.1.4.9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSERhU05GTTRra0JiSzhhVnUzWkNYUWtVcWV4T203SHZ5N1Q5UjY1WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920410);
INSERT INTO `sessions` VALUES ('QUH0w4JxCJsIHglp9v82S2Gmzz6HPHzwQjZSN56C', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGJYM3hCaDV0YWhpTlFnQ3VMQW1UWVhwU2wyN2Fxc3Z0b1k3SUlVYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923927);
INSERT INTO `sessions` VALUES ('r0wCt762X5PQErxl5OqVHPYAMWgxfd6PBw8MWegl', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiNklCTnZKRlIzdGVZMXNEa0JNNnJTMG9Vb3owaGZicjBrTDlLRGRWOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721924375);
INSERT INTO `sessions` VALUES ('R3Ox5hjluLNoyPnZ4MS8Rdu0gVItYOcBpfXbzqFh', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUERZY2VrbXczTFRYaGtNMTNaZDRtM0pmUjAyODhyZ1NjVnpheDhNSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918584);
INSERT INTO `sessions` VALUES ('Rg7JxWwPxOhVSZ2vJ7hvJStb9O9fJcgTXenmJ1q9', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiS2VHWVVzaE5aSTR6VzdXUzlsNURnOWJGMUp1UmNzU25TUnVQWWVaTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721915678);
INSERT INTO `sessions` VALUES ('rGx5Y7LgLfaYmTpiJ2DWfmaXzlMGoN1WAeuVLWpj', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidFV4eDVjcjlNUTBUbUszdzJtTWpxdG16b2s4bkxKTHVBOEdtZlNBaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917797);
INSERT INTO `sessions` VALUES ('RKV22esgoqNatLg5il6UyfbOY0NLXTR6E5nBRvX2', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiczkwMmtKSUc0S1B4QnozNjV2emg4Wkx4ekpSYjE2aHhpbUpFdUtOeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721919278);
INSERT INTO `sessions` VALUES ('RqFPD7cya1p4P4DuES62KI2l2V5ARrpe01mdMxN5', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTk8wOFVOVm5kNXJGVHBWUVp2UjZDSUdrQk1lM1RrR25OT3FJWGR2VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916443);
INSERT INTO `sessions` VALUES ('s57fTFlyykcWXjzUgJmNQOGiLtYXqjYoOaq9iIF4', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQjloRHJ5bjU5bU5TVUNNT1I2a0cxcUd5RWFlM2ZzeDk3R0lza3E2cSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916747);
INSERT INTO `sessions` VALUES ('ScigE8SzHKxQFlcGJRtnleSfzfdLsbjXoM8meAuI', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWno0MFRvdGFWSGxienV0R0V5cDZJdHlqUFhhSmZsN2pzV0d3Uzk0WiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925042);
INSERT INTO `sessions` VALUES ('scxc4tiHRyqdK1gUx0dPTfjjufaUBMA9cY7aVWjx', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieFhNNDVKM0NTbzZSWnlpU0dmYndFdFVnZTZMU1ZNZVF5Mld5SWFBSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923507);
INSERT INTO `sessions` VALUES ('sUiDn3Gj24WqqrNky1ZXo0XnAteIQn5jF3txEosV', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVGdOakxqU0tsWkQ4MGpNdUtKUktlT1IwMjJjaGY4SWVVcmxFcWZjaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721915979);
INSERT INTO `sessions` VALUES ('swLUfX5MMrQIaLVV2HkTLCxFdjFZ4VRCDL71vbVz', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY3J3RWFHTU9NWUgzWEVEU2JGeEl1S3JkR1hLRjNUZnZQVzBBdmNMayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925345);
INSERT INTO `sessions` VALUES ('szrngsIXhpZvLPrktL6rI4dCAAAdvMVhjdp2QNdp', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiU01EeXA0SnpBdUJIaTVLakp3SEFWSkxPSENOQWp3NWd1TllzQXVKZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721918978);
INSERT INTO `sessions` VALUES ('T19SpbxHk71OgLwZPDGdMizn9TNLKY54KVclrHBG', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibTM3aGdaTGNENTZEVW15U2hORWpRRTRDMmNhaUFmREdJVG5PeXdnbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923676);
INSERT INTO `sessions` VALUES ('tbzbCAQcXeE5oHKQLjnRLy8yOsGePOLBDIKjYnlk', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZkZGWVpMNDR4VnB3WFpFTGxDNVlvZ1BheWV6c0pIRGdDM2pxdUdwNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721919879);
INSERT INTO `sessions` VALUES ('tL5ViE7U1JVVuO1EXDIg1T8PGjsrumbEAQi1eoq2', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWnAzYjBGU0FhRDFrMVUxdjNsc2h4WmJZV2dRNVFFbFA2bE92d0dlNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721916453);
INSERT INTO `sessions` VALUES ('TNRE9go3TlOKDC5wP3hEhzREWGYw83U6ijuWGk7C', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidEsyU2NPQU8wMEhCTTNsWDR4bWVCTVl3QUpad1pkM25JVFZEM095dyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721919296);
INSERT INTO `sessions` VALUES ('tVdCFqXa81bydaG3IdPeKDK3VnHanO73uUSRCrcC', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNU1NTlpnWWkybU1aYWpNNmNBVnN2aEdobG0waDQ2T1BmVERLVXdrVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721920120);
INSERT INTO `sessions` VALUES ('tw2IvWEZew0NEzd4oLJf0gRuL8k7oSLDZecdAHsS', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicDFGWjM0d2I3ME1nTFZCcXEweEpadHRzWjZIV0JpYkFtWm5NeGx1MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917470);
INSERT INTO `sessions` VALUES ('UdnvXPTa4Pf1uFNuLIsYlxx5MH88UTQFrzQh1WIz', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiN3dVRUJSdXB4T1JGVExKRERBajJ3TGQ0SXEzdVRoaXNaYTZZcUc2cyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721922578);
INSERT INTO `sessions` VALUES ('ul7ij3v1dUKgir4XNcIlovm1xHpyLgFBfeMtHyml', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZms1NGtWbURuNlpYMllxbmxKMlRTUXg1MjJuZUIzcmxTNFU5WEFuUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921027);
INSERT INTO `sessions` VALUES ('VBXimpU0LHyRbW8hA4qa98WWEBVxRAfn8bUFB8Ft', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVVVUDgwSlRLZnJRaGVGRnJGbFBqWEFCQlZGSGtUTVkwMVZzWDNVdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918874);
INSERT INTO `sessions` VALUES ('VGHdlyIQ5rdW82Mz5YQx2FqzussBL9l9RVmp5bRY', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlgyRmtnNlBVRHRkQTgya3JJcnhUeXZZWTdFOEJEMmR2T2czWWd5NSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921053);
INSERT INTO `sessions` VALUES ('vGPV8G94JTNar9RLUc93I49y6miYZzKEck4Xc5j2', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUUtMNDhmbEFvV0J4WW5mWk5JYndWemR2eTZMNFF1RjBZZEFjZUxiOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9wbGFuZXN0YXRhbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925645);
INSERT INTO `sessions` VALUES ('VsjEFdGp59lGSyOUqqQfeNZBfQcU7W4czgcVHAlL', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiOFBaSm9MQkhVaExjRzdkbkhiWkMxQWltOEpTbEY3ZUlhM3JLcW5ZcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721924978);
INSERT INTO `sessions` VALUES ('vZlNr3kpiMZeMf0LBeop35hPnX36q1dQ4897UNcx', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTHRhV3FXWVRZaHhrUTZiNVVWcXhoRmZnVWdhb2IwdFA1dHZacXk5TiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721924678);
INSERT INTO `sessions` VALUES ('w84GfVwdAHNCSYKHMzyBtbqiNCpeKRPRUy2DwnMx', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRlVZMlRPcjRzNVZLRVJsZzVSSlIwaUxTbmF0VVVIdFJPZmM2YktkOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721919769);
INSERT INTO `sessions` VALUES ('wAyNoqlmd7nJlhv3xG5jIGBKBb6XExTf3sxr5Fp8', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDl0eElqRzJPNE9nZ2xUeVR0Zm9JMHBYVVZZNEs1VEh6S0ZYVk9xUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921815);
INSERT INTO `sessions` VALUES ('wCYsRL1WVnHScrGFBwvfGVvVbVwuRSFKtZ3m7Bry', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYW0wSWIxZmNlT0loSEhTNlIwcUpxUGNBckttck83bnNVcHA1S3hJQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721919192);
INSERT INTO `sessions` VALUES ('WeBFGlhKntbQf4QwuabyEPdpjWTnrhWKwSr9AWD3', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM01FZ2RrZHpNVUlWZmcwTG9IUUF2SXZqV2kwa1VtV1l0S2RUaEp3WSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918485);
INSERT INTO `sessions` VALUES ('wL9F8oWq179vs9H8uyP6YPey9Qrw5sVHhtlbVOQk', NULL, '10.1.4.9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSUl4N3V1VFppUFFTc1l6WVpUYjBLa3FJUnpTMkNiWW5wTTVXRFZRRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721917831);
INSERT INTO `sessions` VALUES ('WlFT3XYiPsljPsRIouIKOf7b6LjNvVbwyP2z8jXj', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibmQ5NUxVR2tQOVhVTldSN0NFMXdMcVpBbXFPMFdUYmoyTUEyd2lrUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925302);
INSERT INTO `sessions` VALUES ('wOpSeV8LAw8xzRPb35ihCRJJOlCKdltGI09YGyXN', NULL, '10.1.4.9', 'Mozilla/5.0+(compatible; UptimeRobot/2.0; http://www.uptimerobot.com/)', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicmJwNGlxSVdOTlB0T0U0d3VHRXNGcVFXdFVpbnVNdEVPQmJjYVVscCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721921678);
INSERT INTO `sessions` VALUES ('WPUqScY2fU3A1x8dTqv2eYRO0pPiui1JWDgSA6DP', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWkQ2clg2SDNQOHQ0SmpmUHN3WjhWdUl4NzFCUVhTdW5pQmJ5R2tyQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721925658);
INSERT INTO `sessions` VALUES ('wym6JmfUc4zMqcjZyylgdQgVp6WBHUByG3fF3U7c', NULL, '10.1.4.15', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTGIzamxuWVFqU2k5dUNUMkhEYTRYWFlKeTZYZDA3bUdtOXBpU0hMdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921540);
INSERT INTO `sessions` VALUES ('wzphccgWyh03g6Z6FUVAxuTbxzQRM4KWPu2bcRFC', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid1JHOE1hSnA0RUJzQ3BVT09DUFlMV25aYmsxSG8wRU1XUnF6QUlDNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721922519);
INSERT INTO `sessions` VALUES ('X9H5DFqT7DlUWym5X5768RNYLt1CSSDduNgIUX0Q', NULL, '10.1.4.9', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GoogleOther) Chrome/126.0.6478.126 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic0I2RnJsbHo4UlJKaFRCMmFKVlNQR0ZSRWllZzF6RTloOHR5RkRHRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918842);
INSERT INTO `sessions` VALUES ('Xz4i0CgsuVr6vXRugT9ZQJtrb9QnJmIGsCiB8oaC', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlRpbjQ2Q2pzVndJOVFoM3VseFBDREFyTUh5UEJMcTF3MDh1U054RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917392);
INSERT INTO `sessions` VALUES ('Y4V2PSsMFoyuNHXLEDdzcHhlfAKXqx0X5KnPhZem', NULL, '10.1.4.15', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidEc1cmpEejNnUExNcUdWeUE5NVZUTjZHMnhLTVBWaEMwRkdQTWRRNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721918014);
INSERT INTO `sessions` VALUES ('yDP5EuZkpZNPITm1Fp7uICZldt3IXgkHvFgmH8lH', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiT0Y0TzZEeEFPT1JSajZpeGIyYzFKZUNydHZKWHdlWVc1aGsxNmRVdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1721923193);
INSERT INTO `sessions` VALUES ('yr9Pc80s2HEfakBDlFatbMi2e0VjYmTOcfqX0zDg', NULL, '10.1.4.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNk1OQkdZWTZIdzlCQkRpVGh1SXRzWHNTZHVDWGNEd1RHOWVXR2ZwNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teC9yZWdpb25hbGl6YWNpb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1721919171);
INSERT INTO `sessions` VALUES ('YTNxLZqc8QjQthUoz3Ytnw1D1rNIwhH7rRJMLW12', NULL, '10.1.4.9', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS2sxM3M0a3VrOVRjVG5pNldneFBiMnNyWm5PTHE0NXRpZ3JOOWRuZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721919035);
INSERT INTO `sessions` VALUES ('YU6mc6BV12hv1rCgDjRvsq4SD6NdjlWMNToPdw2q', NULL, '10.1.4.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNXlDaUFISVIwM2RWOVFpUDk5cFpLMHg3U28xUWJKc211RFpWYUUyMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721917318);
INSERT INTO `sessions` VALUES ('yyMcojfLLQpWlQ1boxmVpooyGDH9CtqhA8Gz5rOB', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHJCYUNwWHZueUVHclhaV09ZTG9lOUpCVlVkakJ3M1NSSlRUWkdReCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721921683);
INSERT INTO `sessions` VALUES ('yYtl5l976T9s3wHzWATArU415SrwjU6cejm0Zs6E', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmZvUzZoTFNTS3NwRDBIblRITTNHQkhCMDNvT1hFSFRtRG1MbUlEUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721923808);
INSERT INTO `sessions` VALUES ('ZE85ERFOQCAhVTAY9wwVSAFgNkPjYRKb6SPGLW90', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidVZhQUtJcHEyclBhOU5LRWwwS0hWRTZObzRja0F3UjNwOFYzdHFGRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721919819);
INSERT INTO `sessions` VALUES ('ZnIxqBNLpQhkrG9L9kRlH9i9BLRwvRgAn8HDnocO', NULL, '10.1.4.9', 'AppManager RPT-HTTPClient/0.3-3E', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQXVkckc5VHBMS3BNeFZiUW1QRTc1RHhrVVNFWjZscTBXY1NUd1hhWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721922289);
INSERT INTO `sessions` VALUES ('znTXUwLoMkP18qLu2Bwujear0HF5URZZTXDnKBou', NULL, '10.1.4.9', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkZHQ080YXd2S3lSUnRCSEZxWUhFRExrQjl3RTRHOXhGdmJMRzBuMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wbGFuZWFkZXIucHVlYmxhLmdvYi5teCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1721919036);

-- ----------------------------
-- Table structure for subcomites
-- ----------------------------
DROP TABLE IF EXISTS `subcomites`;
CREATE TABLE `subcomites`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_subcomite` enum('Sectoriales','Especiales','Regional') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `objetivo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `conformacion` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `icono` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `planestatal_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `subcomites_slug_unique`(`slug`) USING BTREE,
  INDEX `subcomites_planestatal_id_foreign`(`planestatal_id`) USING BTREE,
  CONSTRAINT `subcomites_planestatal_id_foreign` FOREIGN KEY (`planestatal_id`) REFERENCES `plan_estatals` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subcomites
-- ----------------------------
INSERT INTO `subcomites` VALUES (3, 'Subcomité Sectorial de Seguridad Pública, Justicia y Estado de Derecho', 'Sectoriales', 'Mejorar las condiciones de seguridad pública, gobernabilidad, legalidad, justicia y certeza jurídica de la población del estado de Puebla.', 'subcomite-sectorial-de-seguridad-publica-justicia-y-estado-de-derecho', 'subcomités_Seguridad Pública_20240506205633.png', '2024-04-05 18:54:19', '2024-05-15 18:41:19', 'ÍCONOS.SUBCOMITÉS_SEGURIDAD PÚBLICA_20240502181717.png', 16);
INSERT INTO `subcomites` VALUES (4, 'Subcomité Sectorial de Recuperación del Campo Poblano', 'Sectoriales', 'Rescatar al campo poblano a través de entornos regionales favorables para mejorar las actividades agropecuarias, acuícolas y apícolas con un enfoque de desarrollo sostenible, con identidad, perspectiva de género e interseccionalidad.', 'subcomite-sectorial-de-recuperacion-del-campo-poblano', 'subcomités_RecupCampo_20240506205618.png', '2024-04-05 18:55:00', '2024-05-15 18:40:39', 'ÍCONOS.SUBCOMITÉS_CAMPO_20240502181622.png', 16);
INSERT INTO `subcomites` VALUES (5, 'Subcomité Sectorial de Desarrollo Económico Para Todas y Todos', 'Sectoriales', 'Impulsar el desarrollo económico sostenible en todas las regiones del estado, con un enfoque de género, identidad e interseccionalidad.', 'subcomite-sectorial-de-desarrollo-economico-para-todas-y-todos', 'subcomités_Desarrollo Económico_20240506205550.png', '2024-04-05 18:56:35', '2024-05-15 18:38:39', 'Desarrollo_20240502181826.png', 16);
INSERT INTO `subcomites` VALUES (6, 'Subcomité Sectorial de Disminución de las Desigualdades', 'Sectoriales', 'Reducir la pobreza y la brecha de desigualdad social, entre las personas y las regiones, con un enfoque sostenible.', 'subcomite-sectorial-de-disminucion-de-las-desigualdades', 'subcomités_Desigualdades_20240506205605.png', '2024-04-05 18:57:11', '2024-05-15 18:39:21', 'ÍCONOS.SUBCOMITÉS_DESIGUALDADES_20240502181551.png', 16);
INSERT INTO `subcomites` VALUES (7, 'Subcomité Especial de Infraestructura', 'Especiales', 'Fortalecer los sistemas de infraestructura, equipamiento y tecnología que permitan el desarrollo integral, con enfoque sostenible, de los habitantes en las diversas regiones del estado, así como contribuir a la disminución de las brechas de desigualdad mediante una visión estatal de transversalidad y gobierno abierto.', 'subcomite-especial-de-infraestructura', 'subcomités_SE-infra_20240506205441.png', '2024-04-05 18:57:44', '2024-05-15 18:31:35', 'SE Infra_20240502181917.png', 16);
INSERT INTO `subcomites` VALUES (8, 'Subcomité Especial de Pueblos Originarios', 'Especiales', 'Impulsar el desarrollo integral, sostenible, con identidad y perspectiva de genero de la población indígena, bajo los principios de respeto a los derechos indígenas, inclusión y preservación del patrimonio, garantizando el acceso a una vida digna.', 'subcomite-especial-de-pueblos-originarios', 'subcomités_SE-Pueblos Ori_20240506205521.png', '2024-04-05 18:58:27', '2024-05-15 18:37:30', 'SE Pueblos O_20240503191735.png', 16);
INSERT INTO `subcomites` VALUES (9, 'Subcomité Especial de Igualdad Sustantiva', 'Especiales', 'Incorporar la perspectiva de género y de derechos humanos en los esquemas de seguridad pública y en los procesos institucional de acceso y procuración de justicia de la población. Fortalecer la participación y liderazgo de las mujeres rurales e indígenas para reducir las brechas de desigualdad de género en el campo poblano. Fortalecer la autonomía de las mujeres, para reducir las brechas de desigualdad económica y la feminización de la pobreza en el estado. Garantizar el acceso de las mujeres a los servicios públicos con perspectiva de género y a niveles deseables de desarrollo humano y bienestar social a través de la reducción de las brechas de género existentes en la entidad. Fortalecer la incorporación de la perspectiva de género en las acciones de gobierno, así como su institucionalización en la cultura organizacional de la Administración Pública Estatal.', 'subcomite-especial-de-igualdad-sustantiva', 'subcomités_SE-Igualdad sust_20240506205430.png', '2024-04-05 18:59:07', '2024-05-15 18:30:27', 'SE Igualdad S_20240502182020.png', 16);
INSERT INTO `subcomites` VALUES (10, 'Subcomité Especial de Cuidado Ambiental y Atención al Cambio Climático', 'Especiales', 'Identificar oportunidades para establecer nuevos paradigmas sociales y políticos de sustentabilidad, incidiendo en la reducción de emisiones mediante el desarrollo de proyectos de mitigación y adaptación. Así como proteger los recursos naturales mediante la eficiente implementación de esquemas de conservación que contribuyan eficientemente a revertir el deterioro ambiental y promuevan el desarrollo sostenible en el Estado, a fin de asegurar el bienestar de las presentes generaciones y la calidad de vida de las futuras.', 'subcomite-especial-de-cuidado-ambiental-y-atencion-al-cambio-climatico', 'subcomités_SE-Cuidado Ambiental_20240506205347.png', '2024-04-05 18:59:38', '2024-05-15 18:43:17', 'SE Cuidado A_20240502182526.png', 16);
INSERT INTO `subcomites` VALUES (11, 'Subcomité Especial de Niñas, Niños y Adolescentes', 'Especiales', 'Generar la política pública para la niñez y la adolescencia del Estado de Puebla, respetando las Leyes y normas que rigen la promoción, protección y en su caso restitución de los derechos humanos de la infancia y adolescencia. Asimismo busca la cooperación de todos los actores públicos, privados y de la sociedad organizada para que este grupo en estado de vulnerabilidad se desarrolle en entornos seguros y ambientales saludables.', 'subcomite-especial-de-ninas-ninos-y-adolescentes', 'subcomités_SE-Niñas y Niños_20240506205510.png', '2024-04-05 19:00:06', '2024-05-15 18:35:11', 'SE Ninas_20240502182724.png', 16);
INSERT INTO `subcomites` VALUES (12, 'Subcomité Especial de Atención a la Agenda 2030', 'Especiales', 'Fortalecer las acciones de seguimiento y evaluación a la atención de la Agenda 2030 en Puebla, con la participación del sector público, social y privado.', 'subcomite-especial-de-atencion-a-la-agenda-2030', 'subcomités_SE-A2030_20240506205303.png', '2024-04-05 19:00:42', '2024-05-15 18:16:44', 'Se Goierno_20240506204714.png', 16);
INSERT INTO `subcomites` VALUES (13, 'Subcomité Especial de Gobierno Democrático, Innovador y Transparente', 'Especiales', 'Impulsar proyectos estratégicos incluyentes para conducir al Estado a la cuarta transformación que ya se vive en el país, es por ello la importancia de trabajar coordinadamente con las instituciones de la Administración Pública Estatal, para lograr una gobernabilidad cercana, clara, honesta y eficiente para los poblanos, corresponsable a las personas en situación de vulnerabilidad y que por lo tanto sea un Gobierno abierto, equitativo e inclusivo que garantice el combate a la corrupción y donde se constituya en un valor social y humano con perspectiva de género e interseccionalidad.', 'subcomite-especial-de-gobierno-democratico-innovador-y-transparente', 'subcomités_SE-GOB DEMOCRÁTICO_20240506205420.png', '2024-04-05 19:01:09', '2024-05-15 18:27:17', 'SE Anticurrupcion_20240506204747.png', 16);
INSERT INTO `subcomites` VALUES (14, 'Subcomité Especial de Desarrollo Energético Sustentable del Estado de Puebla', 'Especiales', 'Fortalecer la infraestructura y tecnología para el acceso a la energía en el campo poblano para el desarrollo productivo en las regiones del Estado. Fortalecer la atracción de inversiones en el sector energético para el desarrollo integral. Impulsar, en el sector de energía, esquemas ambientalmente sostenibles en las actividades económicas para reducir el impacto al cambio climático. Mejorar los sistemas de transporte que fomente el desarrollo sostenible. Orientar, promover y propiciar el ordenamiento y desarrollo energético sostenible, así como la meditación energética de la tierra en el Estado de Puebla. Fortalecer los sistemas de infraestructura y equipamiento que permitan el desarrollo integral de los habitantes del estado, disminuyendo las desigualdades en las regiones. Fortalecer los mecanismos de planeación, control, evaluación y fiscalización en el sector energético para la mejora continua y el combate a la corrupción e impunidad.', 'subcomite-especial-de-desarrollo-energetico-sustentable-del-estado-de-puebla', 'subcomités_SE-DESA ENERGETICO_20240506205408.png', '2024-04-05 19:01:39', '2024-05-15 18:24:20', 'SE Derarrollo E_20240502182308.png', 16);
INSERT INTO `subcomites` VALUES (15, 'Subcomité Especial de Juventudes', 'Especiales', 'Desarrollar, integral y transversalmente, a las juventudes del Estado, a través de la sinergia institucional y la participación de los diversos sectores de la población para generar mejores oportunidades y condiciones de vida libre de violencia, con justicia, educación y bienestar social, respetando los valores y derechos de las juventudes. Promover la multiculturalidad, el cuidado y preservación de los recursos naturales, la promoción de los derechos humanos, generar entornos sanos y de fácil acceso para la convivencia y armonía de los diversos sectores de las juventudes. Con un enfoque regional e incluyente, se propiciaran condiciones para un entorno de igualdad de derechos y servicios entre toda la población joven.', 'subcomite-especial-de-juventudes', 'subcomités_SE-Juventudes_20240506205451.png', '2024-04-05 19:02:06', '2024-05-15 18:33:06', 'SE Juventudes_20240502182809.png', 16);
INSERT INTO `subcomites` VALUES (16, 'Subcomité Especial de Derechos Humanos', 'Especiales', 'Coadyuvar en el cumplimiento del Programa Estatal de Derechos Humanos, con el objeto de generar las acciones necesarias para satisfacer de manera eficaz el mandato constitucional de promover, respetar, proteger y garantizar los Derechos Humanos.', 'subcomite-especial-de-derechos-humanos', 'subcomités_SE-Derechos Humanos_20240506205357.png', '2024-04-05 19:02:37', '2024-05-15 18:21:31', 'SE Derechos H_20240502182208.png', 16);
INSERT INTO `subcomites` VALUES (17, 'Subcomité Especial Anticorrupción', 'Especiales', 'Fortalecer las acciones de seguimiento y evaluación a la atención de las prioridades públicas de corto plazo establecidas en la política estatal anticorrupción, con la participación del sector público, social y privado.', 'subcomite-especial-anticorrupcion', 'subcomités_SE-Anticorrupción_20240506205230.png', '2024-04-05 19:03:05', '2024-05-15 18:15:16', 'SE Agenda_20240506204825.png', 16);
INSERT INTO `subcomites` VALUES (18, 'Subcomité Regional de Desarrollo Regional', 'Regional', 'Fortalecer las acciones de instrumentación, seguimiento y evaluación en atención al desarrollo regional, con la participación del sector público, social y privado.', 'subcomite-regional-de-desarrollo-regional', 'subcomités_Desarrollo Regional_20240506205533.png', '2024-04-05 19:03:49', '2024-05-15 18:38:02', 'ÍCONOS.SUBCOMITÉS_SUB REGIONAL_20240502181313.png', 16);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_confirmed_at` timestamp(0) NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `profile_photo_path` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `validador` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Super Administrador', 'admin@gmail.com', NULL, '$2y$10$JKYxbH9RiynZCQPNKWWOSuflnu4a/rUL.SsNE9A2xPmuyhxtFC9fq', NULL, NULL, NULL, 'yBOqowJdhns9N8o1FEOkbbMKqaensAcoW58InC5sOy1M7R1y3x8PRqvvFzSq', NULL, NULL, 1, '2024-04-01 18:14:57', '2024-05-06 18:59:51');
INSERT INTO `users` VALUES (2, 'Dirección de Planeación y Desarrollo', 'admin2@gmail.com', NULL, '$2y$10$EBeOELXbj1nnkXunjIZHyeh4839fTOJ/ZWTVVfHS.d.FQeCwRU3Ni', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2024-04-10 23:34:38', '2024-04-10 23:34:38');
INSERT INTO `users` VALUES (3, 'Nery Pozos Moreno', 'nery.pozos@puebla.gob.mx', NULL, '$2y$10$bcFxVoabTykzxISn5PRjDuXeGF/B6pGWBc1qypbnjlS2WEWUw3Nxa', NULL, NULL, NULL, '2FLNq7KDgROpIFxF3Ml0c1ILfgjkzcXtyyES70tIcaMzbXrdX11kBen9GoUw', NULL, NULL, 0, '2024-05-02 16:40:49', '2024-05-02 16:40:49');
INSERT INTO `users` VALUES (4, 'Director de Planeación y Desarrollo', 'planeacion@puebla.gob.mx', NULL, '$2y$10$nQAXxhaadUqeCg3iHEtnw.lmZJvgq8saIEDPRVHFvuFCX2cBfTHMm', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-06 18:55:01', '2024-05-06 18:55:01');
INSERT INTO `users` VALUES (5, 'Subdirección de Seguimiento', 'karina.morales@puebla.gob.mx', NULL, '$2y$10$sAjg5nEaVDWfd5bwNF490e9joMck1mt9B5EhpJJVPs46vbD2S7Unm', NULL, NULL, NULL, 'XxkiPhGprnbQB59HAJjg7VxXVJXzziBdMsMwkvQP696SYdpL6NZbBwA8Z3nM', NULL, NULL, 1, '2024-05-06 18:58:33', '2024-05-29 18:28:07');
INSERT INTO `users` VALUES (7, 'Berenice Hernández', 'berenice.hernandez@puebla.gob.mx', NULL, '$2y$10$Pvv95lE0yJZjGPSmgT/NAOTH/WHi6Cs8Xf4zaESt8sNKGQogDmHZ2', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2024-06-18 16:59:28', '2024-06-18 16:59:28');

SET FOREIGN_KEY_CHECKS = 1;
