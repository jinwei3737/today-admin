/*
 Navicat Premium Data Transfer

 Source Server         : 本地mysql
 Source Server Type    : MySQL
 Source Server Version : 50728
 Source Host           : localhost:3306
 Source Schema         : today-admin

 Target Server Type    : MySQL
 Target Server Version : 50728
 File Encoding         : 65001

 Date: 15/05/2021 14:34:09
*/

SET NAMES utf8mb4;
SET
FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`
(
    `id`         bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `queue`      text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `payload`    longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `exception`  longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `failed_at`  timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`
(
    `id`        int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `batch`     int(11) NOT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations`
VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations`
VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations`
VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations`
VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`
(
    `email`      varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `token`      varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp(0) NULL DEFAULT NULL,
    INDEX        `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`
(
    `id`         bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `parent_id`  bigint(20) UNSIGNED NOT NULL DEFAULT 0,
    `name`       varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
    `key`        varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '唯一识别Key',
    `uri`        varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '路由地址',
    `type`       tinyint(1) NOT NULL DEFAULT 1 COMMENT '1菜单 2按钮',
    `created_at` timestamp(0) NULL DEFAULT NULL,
    `updated_at` timestamp(0) NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `permissions_key_unique`(`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions`
VALUES (1, 0, '系统管理', 'system', '/system', 1, '2021-04-14 04:02:31', '2021-04-15 08:28:50');
INSERT INTO `permissions`
VALUES (2, 1, '用户管理', 'system.users', '/users', 1, '2021-04-14 04:02:31', '2021-05-15 06:12:18');
INSERT INTO `permissions`
VALUES (3, 2, '查看用户', 'system.user.detail', '/user/detail', 2, '2021-04-14 06:15:19', '2021-04-15 08:32:31');
INSERT INTO `permissions`
VALUES (4, 2, '添加用户', 'system.user.add', '/user/add', 2, '2021-04-14 06:15:19', '2021-04-15 08:32:31');
INSERT INTO `permissions`
VALUES (5, 2, '编辑用户', 'system.user.edit', '/user/edit', 2, '2021-04-16 10:09:21', '2021-04-16 10:09:24');
INSERT INTO `permissions`
VALUES (6, 2, '删除用户', 'system.user.delete', '/user/delete', 2, '2021-04-16 10:09:21', '2021-04-16 10:09:24');
INSERT INTO `permissions`
VALUES (7, 2, '删除用户角色', 'system.user.remove_role', '/user/remove_role', 2, '2021-04-16 10:09:21',
        '2021-04-16 10:09:24');
INSERT INTO `permissions`
VALUES (8, 2, '删除用户权限', 'system.user.remove_permission', '/user/remove_permission', 2, '2021-04-16 10:09:21',
        '2021-04-16 10:09:24');
INSERT INTO `permissions`
VALUES (9, 1, '角色管理', 'system.roles', '/roles', 1, '2021-04-29 07:50:48', '2021-04-29 07:50:48');
INSERT INTO `permissions`
VALUES (10, 9, '查看角色', 'system.role.detail', '/role/detail', 2, '2021-04-14 06:15:19', '2021-04-15 08:32:31');
INSERT INTO `permissions`
VALUES (11, 9, '添加角色', 'system.role.add', '/role/add', 2, '2021-04-14 06:15:19', '2021-04-15 08:32:31');
INSERT INTO `permissions`
VALUES (12, 9, '编辑角色', 'system.role.edit', '/role/edit', 2, '2021-04-16 10:09:21', '2021-04-16 10:09:24');
INSERT INTO `permissions`
VALUES (13, 9, '删除角色', 'system.role.delete', '/role/delete', 2, '2021-04-16 10:09:21', '2021-04-16 10:09:24');
INSERT INTO `permissions`
VALUES (14, 9, '删除角色权限', 'system.role.remove_permission', '/role/remove_permission', 2, '2021-04-16 10:09:21',
        '2021-04-16 10:09:24');
INSERT INTO `permissions`
VALUES (15, 1, '菜单管理', 'system.menus', '/menus', 1, '2021-04-29 09:51:00', '2021-04-29 09:51:00');
INSERT INTO `permissions`
VALUES (16, 15, '查看菜单', 'system.menu.detail', '/menu/detail', 2, '2021-04-14 06:15:19', '2021-04-15 08:32:31');
INSERT INTO `permissions`
VALUES (17, 15, '添加菜单', 'system.menu.add', '/menu/add', 2, '2021-04-14 06:15:19', '2021-04-15 08:32:31');
INSERT INTO `permissions`
VALUES (18, 15, '编辑菜单', 'system.menu.edit', '/menu/edit', 2, '2021-04-16 10:09:21', '2021-04-16 10:09:24');
INSERT INTO `permissions`
VALUES (19, 15, '删除菜单', 'system.menu.delete', '/menu/delete', 2, '2021-04-16 10:09:21', '2021-04-16 10:09:24');
INSERT INTO `permissions`
VALUES (20, 0, '订单管理', 'orders', '/orders', 1, '2021-04-30 08:52:34', '2021-04-30 08:52:34');
INSERT INTO `permissions`
VALUES (21, 20, '订单列表', 'order.list', '/order/list', 1, '2021-04-30 08:54:47', '2021-04-30 08:54:47');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`
(
    `id`             bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `tokenable_id`   bigint(20) UNSIGNED NOT NULL,
    `name`           varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `token`          varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NOT NULL,
    `abilities`      text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
    `last_used_at`   timestamp(0) NULL DEFAULT NULL,
    `created_at`     timestamp(0) NULL DEFAULT NULL,
    `updated_at`     timestamp(0) NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
    INDEX            `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`
(
    `role_id`       bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '角色ID',
    `permission_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '菜单ID'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色权限关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`
(
    `id`         bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
    `key`        varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '唯一识别Key',
    `created_at` timestamp(0) NULL DEFAULT NULL,
    `updated_at` timestamp(0) NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `roles_key_unique`(`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles`
VALUES (1, '开发者', 'developer', '2021-04-13 10:07:24', '2021-04-14 08:58:01');
INSERT INTO `roles`
VALUES (2, '管理员', 'admin', '2021-05-13 08:36:51', '2021-05-13 08:36:51');

-- ----------------------------
-- Table structure for user_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `user_has_permissions`;
CREATE TABLE `user_has_permissions`
(
    `user_id`       bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
    `permission_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '权限ID'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户权限关联表(不经过角色而获取的权限)' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_has_roles`;
CREATE TABLE `user_has_roles`
(
    `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
    `role_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '角色ID'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户角色关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_has_roles
-- ----------------------------
INSERT INTO `user_has_roles`
VALUES (1, 1);
INSERT INTO `user_has_roles`
VALUES (2, 2);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
    `id`                bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`              varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `email`             varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `avatar`            varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
    `email_verified_at` timestamp(0) NULL DEFAULT NULL,
    `password`          varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `remember_token`    varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
    `created_at`        timestamp(0) NULL DEFAULT NULL,
    `updated_at`        timestamp(0) NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users`
VALUES (1, 'Jin wei', '215838961@qq.com', '', '2021-04-30 08:52:34',
        '$2y$10$V7xeLzf/jhjP8y83FckIAeg6AeponaGWOtlACCZQ2REl.Ofnlr9v2', '', '2021-04-30 08:52:34',
        '2021-04-30 08:52:34');
INSERT INTO `users`
VALUES (2, 'Admin Test', 'test@qq.com', '', NULL, '$2y$10$PZOExHsoYOOdc25.SyeO6uGXRaB.sYFyzQvzgcLGx44YwyGRMs19K', NULL,
        '2021-05-13 05:20:58', '2021-05-13 06:39:39');

SET
FOREIGN_KEY_CHECKS = 1;
