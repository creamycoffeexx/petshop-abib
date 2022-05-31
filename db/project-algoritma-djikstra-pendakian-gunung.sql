/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : project-algoritma-djikstra-pendakian-gunung

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 14/08/2021 17:59:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for graph
-- ----------------------------
DROP TABLE IF EXISTS `graph`;
CREATE TABLE `graph`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` int(2) NULL DEFAULT NULL,
  `end` int(2) NULL DEFAULT NULL,
  `distance` decimal(10, 2) NULL DEFAULT NULL,
  `time` int(10) NULL DEFAULT NULL,
  `diinsertPada` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `diupadtePada` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `start`(`start`, `end`) USING BTREE,
  INDEX `simpulMulai`(`start`) USING BTREE,
  INDEX `simpulAkhir`(`end`) USING BTREE,
  CONSTRAINT `graph_ibfk_1` FOREIGN KEY (`start`) REFERENCES `node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `graph_ibfk_2` FOREIGN KEY (`end`) REFERENCES `node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of graph
-- ----------------------------
INSERT INTO `graph` VALUES (80, 406, 407, 1.64, 1411, '2021-08-12 18:40:48', '2021-08-13 20:20:03');
INSERT INTO `graph` VALUES (81, 407, 408, 0.36, 4, '2021-08-12 18:41:10', '2021-08-13 20:21:14');
INSERT INTO `graph` VALUES (82, 408, 410, 1.58, 5, '2021-08-12 18:41:19', '2021-08-13 20:21:17');
INSERT INTO `graph` VALUES (83, 410, 409, 0.73, 4, '2021-08-12 18:41:34', '2021-08-13 20:21:27');
INSERT INTO `graph` VALUES (84, 409, 413, 0.60, 3, '2021-08-12 18:41:45', '2021-08-13 20:21:25');
INSERT INTO `graph` VALUES (85, 406, 411, 0.47, 111, '2021-08-12 18:43:10', '2021-08-13 20:19:39');
INSERT INTO `graph` VALUES (86, 411, 412, 1.08, 1, '2021-08-12 18:43:18', '2021-08-13 20:21:09');
INSERT INTO `graph` VALUES (87, 412, 405, 1.02, 3, '2021-08-12 18:43:30', '2021-08-13 20:21:11');
INSERT INTO `graph` VALUES (88, 405, 422, 1.99, 33, '2021-08-12 18:43:38', '2021-08-13 20:21:31');
INSERT INTO `graph` VALUES (89, 408, 412, 0.70, 66, '2021-08-12 18:50:59', '2021-08-13 20:21:20');
INSERT INTO `graph` VALUES (90, 406, 410, 3.24, 12, '2021-08-13 20:17:52', NULL);
INSERT INTO `graph` VALUES (91, 412, 413, 0.97, 15, '2021-08-14 17:20:28', NULL);

-- ----------------------------
-- Table structure for node
-- ----------------------------
DROP TABLE IF EXISTS `node`;
CREATE TABLE `node`  (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `type` enum('object','-') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `lat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `lng` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `picture` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `inserted_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 425 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of node
-- ----------------------------
INSERT INTO `node` VALUES (405, 'Semeru', 'object', '-6.39925655614941', '106.81332186452494', 'Gunung Semeru atau Gunung Meru adalah sebuah gunung berapi kerucut di Jawa Timur, Indonesia. Gunung Semeru merupakan gunung tertinggi di Pulau Jawa, dengan puncaknya Mahameru, 3.676 meter dari permukaan laut', '0913da84afb03000b08e7a8be97998a0.jpg', '2021-08-06 21:32:03', '2021-08-12 19:24:24');
INSERT INTO `node` VALUES (406, 'A', '-', '-6.37076692939587', '106.81376817991708', '-', '-', '2021-08-06 21:32:17', '2021-08-14 16:24:47');
INSERT INTO `node` VALUES (407, 'B', '-', '-6.369231515298239', '106.79900530150132', '-', '-', '2021-08-06 21:32:24', NULL);
INSERT INTO `node` VALUES (408, 'C', '-', '-6.38032051377904', '106.79900530150132', '-', '-', '2021-08-06 21:32:32', NULL);
INSERT INTO `node` VALUES (409, 'D', '-', '-6.389703325061745', '106.79059389402033', '-', '-', '2021-08-06 21:32:39', NULL);
INSERT INTO `node` VALUES (410, 'E', '-', '-6.379467522412696', '106.78475740721541', '-', '-', '2021-08-06 21:32:54', NULL);
INSERT INTO `node` VALUES (411, 'A1', '-', '-6.385267835709172', '106.8141115026703', '-', '-', '2021-08-06 21:34:28', NULL);
INSERT INTO `node` VALUES (412, 'A2', '-', '-6.390897488716703', '106.80449846555297', '-', '-', '2021-08-06 21:34:37', NULL);
INSERT INTO `node` VALUES (413, 'Gunung 3', 'object', '-6.3943093694861375', '106.79581240406992', 'Berikut adalah form rumah sakit rujukan covid 19. silahkan lengkapi data-data dibawah ini dengan lengkap dan benar', '3be042b0f2af337c7564da80d99537aa.png', '2021-08-06 22:58:26', '2021-08-12 18:00:43');
INSERT INTO `node` VALUES (422, 'gunung4', 'object', '-6.425015270333219', '106.7970140337319', 'asd', '016b8e142dc7d16f9c8bdde0e9fc53b8.jpg', '2021-08-12 18:14:04', NULL);
INSERT INTO `node` VALUES (423, 'Bromo', 'object', '-6.391238677830003', '106.8261964677979', 'Gunung Bromo atau dalam bahasa Tengger dieja \"Brama\", adalah sebuah gunung berapi aktif di Jawa Timur, Indonesia. Gunung ini memiliki ketinggian 2.329 meter di atas permukaan laut dan berada dalam empat wilayah kabupaten, yakni Kabupaten Probolinggo, Kabupaten Pasuruan, Kabupaten Lumajang, dan Kabupaten Malang.', 'dd7eced7021812e50f45614f8a2436de.jpg', '2021-08-12 19:21:37', NULL);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `inserted_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (2, 'admin', 'admin', '2021-08-05 17:23:01', '2021-08-06 22:55:29');

SET FOREIGN_KEY_CHECKS = 1;
