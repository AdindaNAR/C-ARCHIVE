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

 Date: 12/04/2022 13:03:27
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
) ENGINE = InnoDB AUTO_INCREMENT = 269 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 90 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

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
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `id_user` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_role` int(20) NOT NULL,
  `nama_user` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email_user` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password_user` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
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
INSERT INTO `tbl_user` VALUES ('1', 1, 'Superadmin App', 'superadmin@c-archive.com', 'superadmin123', 1, 'superadmin.jpg', 0, 1, '2022-03-09 18:26:06', '2022-04-12 12:54:43');
INSERT INTO `tbl_user` VALUES ('2', 2, 'Master Admin', 'master@c-archive.com', 'master223', 1, 'master.jpg', 0, 1, '2022-03-09 18:26:06', '2022-04-12 12:54:49');
INSERT INTO `tbl_user` VALUES ('3', 3, 'Pengawas - Anda', 'pengawas@c-archive.com', 'pengawas323', 1, 'pengawas.jpg', 0, 1, '2022-03-09 18:26:06', '2022-04-12 12:55:36');
INSERT INTO `tbl_user` VALUES ('4', 4, 'Operator - Anda', 'operator@c-archive.com', 'operator523', 1, 'operator.jpg', 0, 1, '2022-03-09 18:26:06', '2022-04-12 12:55:53');

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
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

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

SET FOREIGN_KEY_CHECKS = 1;
