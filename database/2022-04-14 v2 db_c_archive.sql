/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100316
 Source Host           : localhost:3306
 Source Schema         : db_c_archive

 Target Server Type    : MySQL
 Target Server Version : 100316
 File Encoding         : 65001

 Date: 14/04/2022 22:16:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for log_history
-- ----------------------------
DROP TABLE IF EXISTS `log_history`;
CREATE TABLE `log_history`  (
  `id_log` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `data_status` int(1) NOT NULL DEFAULT 1,
  `login` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  `logout` timestamp(0) NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id_log`) USING BTREE,
  INDEX `id_user`(`id_user`) USING BTREE,
  CONSTRAINT `log_history_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 288 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log_history
-- ----------------------------
INSERT INTO `log_history` VALUES (269, 'P00000002', 'Login', 1, '2022-04-13 09:52:40', '2022-04-13 09:52:40');
INSERT INTO `log_history` VALUES (270, 'P00000002', 'Logout', 1, '2022-04-13 10:23:14', '2022-04-13 10:23:37');
INSERT INTO `log_history` VALUES (271, 'P00000002', 'Logout', 1, '2022-04-13 10:30:18', '2022-04-13 10:45:27');
INSERT INTO `log_history` VALUES (272, 'P00000004', 'Logout', 1, '2022-04-13 10:45:42', '2022-04-13 10:51:22');
INSERT INTO `log_history` VALUES (273, 'P00000004', 'Logout', 1, '2022-04-13 16:46:10', '2022-04-13 17:56:52');
INSERT INTO `log_history` VALUES (274, 'P00000004', 'Logout', 1, '2022-04-13 17:22:30', '2022-04-13 17:22:59');
INSERT INTO `log_history` VALUES (275, 'P00000004', 'Logout', 1, '2022-04-13 18:31:16', '2022-04-13 19:06:44');
INSERT INTO `log_history` VALUES (276, 'P00000004', 'Login', 1, '2022-04-13 18:53:14', '2022-04-13 18:53:14');
INSERT INTO `log_history` VALUES (277, 'P00000004', 'Logout', 1, '2022-04-13 19:13:33', '2022-04-14 04:49:55');
INSERT INTO `log_history` VALUES (278, 'P00000003', 'Logout', 1, '2022-04-14 04:50:10', '2022-04-14 04:50:33');
INSERT INTO `log_history` VALUES (279, 'P00000004', 'Login', 1, '2022-04-14 04:50:41', '2022-04-14 04:50:41');
INSERT INTO `log_history` VALUES (280, 'P00000004', 'Logout', 1, '2022-04-14 08:50:56', '2022-04-14 10:24:30');
INSERT INTO `log_history` VALUES (281, 'P00000003', 'Logout', 1, '2022-04-14 10:24:47', '2022-04-14 10:31:10');
INSERT INTO `log_history` VALUES (282, 'P00000004', 'Logout', 1, '2022-04-14 10:31:17', '2022-04-14 12:59:49');
INSERT INTO `log_history` VALUES (283, 'P00000002', 'Login', 1, '2022-04-14 13:10:52', '2022-04-14 13:10:52');
INSERT INTO `log_history` VALUES (284, 'P00000002', 'Login', 1, '2022-04-14 13:57:05', '2022-04-14 13:57:05');
INSERT INTO `log_history` VALUES (285, 'P00000004', 'Logout', 1, '2022-04-14 22:08:03', '2022-04-14 22:11:46');
INSERT INTO `log_history` VALUES (286, 'P00000003', 'Logout', 1, '2022-04-14 22:12:08', '2022-04-14 22:13:01');
INSERT INTO `log_history` VALUES (287, 'P00000002', 'Login', 1, '2022-04-14 22:13:20', '2022-04-14 22:13:20');

-- ----------------------------
-- Table structure for tbl_menu
-- ----------------------------
DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE `tbl_menu`  (
  `id_menu` int(20) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id_menu`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 93 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_menu
-- ----------------------------
INSERT INTO `tbl_menu` VALUES (1, 'Home', 1, '2022-04-13 20:44:26', '2022-04-13 21:21:32');
INSERT INTO `tbl_menu` VALUES (2, 'Master', 1, '2022-04-13 10:27:30', '2022-04-13 20:44:39');
INSERT INTO `tbl_menu` VALUES (3, 'Setting', 1, '2022-04-13 19:56:35', '2022-04-13 20:44:37');

-- ----------------------------
-- Table structure for tbl_pajak
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pajak`;
CREATE TABLE `tbl_pajak`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pajak` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_wajib_pajak` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `npbp_swh_bumi` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kls_desa_swh_bumi` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kls_nasional_swh_bumi` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `luas_swh_bumi` int(10) DEFAULT NULL,
  `pajak_swh_bumi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `npbp_drt_bumi` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kls_desa_drt_bumi` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `kls_nasional_drt_bumi` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `luas_drt_bumi` int(10) DEFAULT NULL,
  `pajak_drt_bumi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dbpn_bgn` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `gol_kelas_bgn` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `luas_bgn` int(10) DEFAULT NULL,
  `pajak_bgn` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mutasi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `log_user` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `data_status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_pajak`(`id_pajak`) USING BTREE,
  INDEX `id_wajib_pajak`(`id_wajib_pajak`) USING BTREE,
  CONSTRAINT `tbl_pajak_ibfk_1` FOREIGN KEY (`id_wajib_pajak`) REFERENCES `tbl_wajib_pajak` (`id_wajib_pajak`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_pajak
-- ----------------------------
INSERT INTO `tbl_pajak` VALUES (2, 'PJK20220414-00000001', 'WP20220413-00000001', '1', '2', '3', 4, '5', '6', '7', '8', 9, '10', '11', '12', 13, '14', '15', '4', 1, '2022-04-14 12:53:04', '2022-04-14 12:56:30');
INSERT INTO `tbl_pajak` VALUES (3, 'PJK20220414-00000002', 'WP20220413-00000001', 'sdfff', '', '', 0, '', 'sdf', '', '', 0, '', '', 'sdf', 0, '', '', '4', 1, '2022-04-14 12:53:22', '2022-04-14 12:56:30');
INSERT INTO `tbl_pajak` VALUES (4, 'PJK20220414-00000003', 'WP20220414-00000001', 'sdf', '', '', 0, '', '', '', '', 0, '', 'qwe', '', 0, '', '', 'P00000004', 0, '2022-04-14 22:10:24', '2022-04-14 22:11:29');

-- ----------------------------
-- Table structure for tbl_role
-- ----------------------------
DROP TABLE IF EXISTS `tbl_role`;
CREATE TABLE `tbl_role`  (
  `id_role` int(20) NOT NULL AUTO_INCREMENT,
  `name_role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id_role`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_role
-- ----------------------------
INSERT INTO `tbl_role` VALUES (1, 'Superadmin', 1, '2022-03-09 18:20:36', '2022-03-09 18:20:44');
INSERT INTO `tbl_role` VALUES (2, 'Administrator', 1, '2021-04-26 11:55:01', '2022-03-09 18:20:42');
INSERT INTO `tbl_role` VALUES (3, 'Pengawas', 1, '2021-04-26 11:55:04', '2022-04-12 12:42:17');
INSERT INTO `tbl_role` VALUES (4, 'Operator', 1, '2021-04-26 20:05:04', '2022-04-12 12:42:30');

-- ----------------------------
-- Table structure for tbl_sub_menu
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sub_menu`;
CREATE TABLE `tbl_sub_menu`  (
  `id_sub_menu` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_menu` int(20) NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int(1) NOT NULL,
  `data_status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id_sub_menu`) USING BTREE,
  INDEX `id_menu`(`id_menu`) USING BTREE,
  CONSTRAINT `tbl_sub_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `tbl_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_sub_menu
-- ----------------------------
INSERT INTO `tbl_sub_menu` VALUES (1, 1, 'Dashboard', 'main/Dashboard', 'fa fa-home', 1, 1, '2022-04-13 20:45:25', '2022-04-14 04:47:53');
INSERT INTO `tbl_sub_menu` VALUES (2, 2, 'Master Pajak', 'main/Pajak/index', 'fa fa-database', 1, 1, '2022-04-13 10:28:17', '2022-04-13 20:59:40');
INSERT INTO `tbl_sub_menu` VALUES (3, 3, 'User', 'menu/User/index', 'fa fa-user', 1, 1, '2022-04-13 19:57:11', '2022-04-14 13:22:11');

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `id_user` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_role` int(20) NOT NULL,
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status_active` int(1) NOT NULL DEFAULT 1,
  `file_gambar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `login_attempt` int(1) NOT NULL DEFAULT 0,
  `data_status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id_user`) USING BTREE,
  INDEX `id_role`(`id_role`) USING BTREE,
  CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `tbl_role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('P00000001', 1, 'Superadmin App', 'superadmin@c-archive.com', '$2y$10$x1Kr8XgVI5P7N/IIRrWTgOyFeniDkVLfM9wVeR0aKDHk38GCshyWO', 1, 'assets/images/profile/P00001.png', 0, 1, '2022-03-09 18:26:06', '2022-04-14 13:55:33');
INSERT INTO `tbl_user` VALUES ('P00000002', 2, 'Master Admin', 'master@c-archive.com', '$2y$10$x1Kr8XgVI5P7N/IIRrWTgOyFeniDkVLfM9wVeR0aKDHk38GCshyWO', 1, 'assets/images/profile/P00001.png', 0, 1, '2022-03-09 18:26:06', '2022-04-14 13:56:18');
INSERT INTO `tbl_user` VALUES ('P00000003', 3, 'Pengawas - Anda', 'pengawas@c-archive.com', '$2y$10$x1Kr8XgVI5P7N/IIRrWTgOyFeniDkVLfM9wVeR0aKDHk38GCshyWO', 1, 'assets/images/profile/P00001.png', 0, 1, '2022-03-09 18:26:06', '2022-04-14 13:55:22');
INSERT INTO `tbl_user` VALUES ('P00000004', 4, 'Operator - Adinda', 'operator@c-archive.com', '$2y$10$x1Kr8XgVI5P7N/IIRrWTgOyFeniDkVLfM9wVeR0aKDHk38GCshyWO', 1, 'assets/images/profile/P00001.png', 0, 1, '2022-03-09 18:26:06', '2022-04-14 22:15:43');
INSERT INTO `tbl_user` VALUES ('P00000005', 3, 'Endah', 'endah@gmail.com', '$2y$10$otVR6ElMbG5RImBAN56M6eecUsRheq3ENSwsWsVZwHtJ5XtgMttOK', 1, 'assets/images/default/default.png', 3, 1, '2022-04-14 13:54:52', '2022-04-14 22:15:35');

-- ----------------------------
-- Table structure for tbl_user_access_menu
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_access_menu`;
CREATE TABLE `tbl_user_access_menu`  (
  `id_user_access_menu` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_role` int(20) NOT NULL,
  `id_menu` int(20) NOT NULL,
  `data_status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id_user_access_menu`) USING BTREE,
  INDEX `id_role`(`id_role`) USING BTREE,
  INDEX `id_menu`(`id_menu`) USING BTREE,
  CONSTRAINT `tbl_user_access_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `tbl_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_user_access_menu_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `tbl_role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user_access_menu
-- ----------------------------
INSERT INTO `tbl_user_access_menu` VALUES (27, 1, 2, 1, '2022-04-13 10:29:12', '2022-04-13 10:29:12');
INSERT INTO `tbl_user_access_menu` VALUES (28, 2, 2, 1, '2022-04-13 10:29:21', '2022-04-13 10:29:21');
INSERT INTO `tbl_user_access_menu` VALUES (29, 3, 2, 1, '2022-04-13 10:29:24', '2022-04-13 10:29:24');
INSERT INTO `tbl_user_access_menu` VALUES (30, 4, 2, 1, '2022-04-13 10:29:58', '2022-04-13 10:29:58');
INSERT INTO `tbl_user_access_menu` VALUES (31, 1, 1, 1, '2022-04-13 20:46:47', '2022-04-13 20:46:47');
INSERT INTO `tbl_user_access_menu` VALUES (32, 2, 1, 1, '2022-04-13 20:46:47', '2022-04-13 20:46:47');
INSERT INTO `tbl_user_access_menu` VALUES (33, 3, 1, 1, '2022-04-13 20:46:47', '2022-04-13 20:46:47');
INSERT INTO `tbl_user_access_menu` VALUES (34, 4, 1, 1, '2022-04-13 20:46:47', '2022-04-13 20:46:47');
INSERT INTO `tbl_user_access_menu` VALUES (35, 2, 3, 1, '2022-04-14 13:11:39', '2022-04-14 13:11:39');

-- ----------------------------
-- Table structure for tbl_wajib_pajak
-- ----------------------------
DROP TABLE IF EXISTS `tbl_wajib_pajak`;
CREATE TABLE `tbl_wajib_pajak`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wajib_pajak` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_wajib_pajak` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `data_status` int(1) DEFAULT 1,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_wajib_pajak`(`id_wajib_pajak`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_wajib_pajak
-- ----------------------------
INSERT INTO `tbl_wajib_pajak` VALUES (4, 'WP20220413-00000001', 'Adinda', 'Banjar', 1, '2022-04-14 04:18:48', '2022-04-14 12:56:30');
INSERT INTO `tbl_wajib_pajak` VALUES (5, 'WP20220413-00000002', 'Adinda', 'Ciamis', 1, '2022-04-14 04:20:59', '2022-04-14 04:20:59');
INSERT INTO `tbl_wajib_pajak` VALUES (6, 'WP20220413-00000003', 'asd', 'asd', 0, '2022-04-14 04:44:22', '2022-04-14 04:44:30');
INSERT INTO `tbl_wajib_pajak` VALUES (7, 'WP20220413-00000004', 'sdf', 'sdf', 1, '2022-04-14 04:45:00', '2022-04-14 04:45:00');
INSERT INTO `tbl_wajib_pajak` VALUES (8, 'WP20220413-00000005', 'asd', 'asd', 0, '2022-04-14 04:45:40', '2022-04-14 04:46:09');
INSERT INTO `tbl_wajib_pajak` VALUES (9, 'WP20220413-00000006', 'cvb', 'cv', 0, '2022-04-14 04:45:54', '2022-04-14 04:46:04');
INSERT INTO `tbl_wajib_pajak` VALUES (10, 'WP20220414-00000001', 'Siti', 'Ciamis', 1, '2022-04-14 22:08:38', '2022-04-14 22:08:38');

-- ----------------------------
-- Triggers structure for table tbl_menu
-- ----------------------------
DROP TRIGGER IF EXISTS `TG_DS_menu_submenu`;
delimiter ;;
CREATE DEFINER = `root`@`localhost` TRIGGER `TG_DS_menu_submenu` BEFORE UPDATE ON `tbl_menu` FOR EACH ROW BEGIN
		IF new.data_status IS NULL OR new.data_status = 1 THEN
			update tbl_sub_menu set data_status=1 WHERE id_menu=new.id_menu;
		ELSEIF new.data_status = 0 THEN
			update tbl_sub_menu set data_status=0 WHERE id_menu=new.id_menu;
		ELSE
			update tbl_sub_menu set data_status=0 WHERE id_menu=new.id_menu;
		END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbl_menu
-- ----------------------------
DROP TRIGGER IF EXISTS `TG_DS_menu_uam`;
delimiter ;;
CREATE DEFINER = `root`@`localhost` TRIGGER `TG_DS_menu_uam` BEFORE UPDATE ON `tbl_menu` FOR EACH ROW BEGIN
		IF new.data_status IS NULL OR new.data_status = 1 THEN
			update tbl_user_access_menu set data_status=1 WHERE id_menu=new.id_menu;
		ELSEIF new.data_status = 0 THEN
			update tbl_user_access_menu set data_status=0 WHERE id_menu=new.id_menu;
		ELSE
			update tbl_user_access_menu set data_status=0 WHERE id_menu=new.id_menu;
		END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbl_role
-- ----------------------------
DROP TRIGGER IF EXISTS `TG_DS_role_user`;
delimiter ;;
CREATE DEFINER = `root`@`localhost` TRIGGER `TG_DS_role_user` BEFORE UPDATE ON `tbl_role` FOR EACH ROW BEGIN
		IF new.data_status IS NULL OR new.data_status = 1 THEN
			update tbl_user set data_status=1 WHERE id_role=new.id_role;
		ELSEIF new.data_status = 0 THEN
			update tbl_user set data_status=0 WHERE id_role=new.id_role;
		ELSE
			update tbl_user set data_status=0 WHERE id_role=new.id_role;
		END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbl_role
-- ----------------------------
DROP TRIGGER IF EXISTS `TG_DS_role_uam`;
delimiter ;;
CREATE DEFINER = `root`@`localhost` TRIGGER `TG_DS_role_uam` BEFORE UPDATE ON `tbl_role` FOR EACH ROW BEGIN
		IF new.data_status IS NULL OR new.data_status = 1 THEN
			update tbl_user_access_menu set data_status=1 WHERE id_role=new.id_role;
		ELSEIF new.data_status = 0 THEN
			update tbl_user_access_menu set data_status=0 WHERE id_role=new.id_role;
		ELSE
			update tbl_user_access_menu set data_status=0 WHERE id_role=new.id_role;
		END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbl_user
-- ----------------------------
DROP TRIGGER IF EXISTS `TG_DS_user_log`;
delimiter ;;
CREATE DEFINER = `root`@`localhost` TRIGGER `TG_DS_user_log` BEFORE UPDATE ON `tbl_user` FOR EACH ROW BEGIN
		IF new.data_status IS NULL OR new.data_status = 1 THEN
			update log_history set data_status=1 WHERE id_user=new.id_user;
		ELSEIF new.data_status = 0 THEN
			update log_history set data_status=0 WHERE id_user=new.id_user;
		ELSE
			update log_history set data_status=0 WHERE id_user=new.id_user;
		END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbl_wajib_pajak
-- ----------------------------
DROP TRIGGER IF EXISTS `TG_DS_wp_pjk`;
delimiter ;;
CREATE DEFINER = `root`@`localhost` TRIGGER `TG_DS_wp_pjk` BEFORE UPDATE ON `tbl_wajib_pajak` FOR EACH ROW BEGIN
		IF new.data_status IS NULL OR new.data_status = 1 THEN
			update tbl_pajak set data_status=1 WHERE id_wajib_pajak=new.id_wajib_pajak;
		ELSEIF new.data_status = 0 THEN
			update tbl_pajak set data_status=0 WHERE id_wajib_pajak=new.id_wajib_pajak;
		ELSE
			update tbl_pajak set data_status=0 WHERE id_wajib_pajak=new.id_wajib_pajak;
		END IF;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
