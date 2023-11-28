/*
 Navicat Premium Data Transfer

 Source Server         : mehelmi
 Source Server Type    : MySQL
 Source Server Version : 100425
 Source Host           : localhost:3306
 Source Schema         : hr_test

 Target Server Type    : MySQL
 Target Server Version : 100425
 File Encoding         : 65001

 Date: 28/11/2023 10:34:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for jenis_departemen
-- ----------------------------
DROP TABLE IF EXISTS `jenis_departemen`;
CREATE TABLE `jenis_departemen`  (
  `id_departemen` int NOT NULL,
  `nama_departemen` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_departemen`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jenis_departemen
-- ----------------------------
INSERT INTO `jenis_departemen` VALUES (1, 'HR');
INSERT INTO `jenis_departemen` VALUES (2, 'IT');
INSERT INTO `jenis_departemen` VALUES (3, 'Purchasing');
INSERT INTO `jenis_departemen` VALUES (4, 'Finance');
INSERT INTO `jenis_departemen` VALUES (5, 'Logistik');

-- ----------------------------
-- Table structure for karyawan
-- ----------------------------
DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE `karyawan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(17) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ttl` date NOT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pendidikan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_departemen` int NULL DEFAULT NULL,
  `level` int NULL DEFAULT NULL,
  `grade` int NULL DEFAULT NULL,
  `status` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of karyawan
-- ----------------------------
INSERT INTO `karyawan` VALUES (1, 'admin', '123', '100', 'Helmi', '2023-11-28', 'Jombang', 'S1', 1, 1, 1, 'Y');
INSERT INTO `karyawan` VALUES (2, 'user1', '1234', '101', 'Rifqi', '2023-11-07', 'Malang', 'S2', 2, 2, 2, 'Y');
INSERT INTO `karyawan` VALUES (3, 'user2', '12345', '102', 'Hari', '2023-11-16', 'Surabaya', 'S3', 3, 3, 3, 'Y');
INSERT INTO `karyawan` VALUES (4, 'user4', '123456', '103', 'Devi', '2023-10-11', 'Mojokerto', 'S2', 4, 4, 4, 'Y');
INSERT INTO `karyawan` VALUES (11, 'user', '123', '104', 'weri', '2023-11-15', 'jombang', 's5', 2, 3, 5, 'Y');
INSERT INTO `karyawan` VALUES (12, 'hrd', '123', '106', 'Heri', '2023-11-09', 'jombang', 'S2', 3, 4, 3, 'Y');

SET FOREIGN_KEY_CHECKS = 1;
