CREATE TABLE `brand` (
  `st_favicon` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'favicon.png',
  `st_whitelogo` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'whitelogo.png',
  `st_darklogo` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'darklogo.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

INSERT INTO `brand` (st_favicon, st_whitelogo, st_darklogo) VALUES ('/uploads/site/st_favicon.png', '/uploads/site/st_whitelogo.png', '/uploads/site/st_darklogo.png');

CREATE TABLE `links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `link` text COLLATE utf8mb3_spanish_ci,
  `short` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

CREATE TABLE `settings` (
  `st_sitename` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `st_facebook` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `st_twitter` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `st_instagram` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `st_youtube` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `st_keywords` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `st_description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

INSERT INTO `settings` (st_sitename, st_facebook, st_twitter, st_instagram, st_youtube, st_keywords, st_description) VALUES ('PiruShort', 'https://facebook.com/', 'https://twitter.com/', 'https://www.instagram.com/', 'https://www.youtube.com/', 'phpstart, php, css, js, html, bootstrap', 'PiruShort by Pirulug');

CREATE TABLE `telemetry` (
  `id` int NOT NULL AUTO_INCREMENT,
  `short_link` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb3_spanish_ci NOT NULL,
  `country` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `city` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `device` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `operating_system` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `browser` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `access_time` datetime NOT NULL,
  `referer` varchar(512) COLLATE utf8mb3_spanish_ci DEFAULT 'Direct',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `user_role` tinyint(1) NOT NULL DEFAULT '2',
  `user_status` tinyint(1) NOT NULL DEFAULT '1',
  `user_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

INSERT INTO `users` (user_id, user_name, user_email, user_password, user_role, user_status, user_updated, user_created) VALUES ('1', 'superadmin', 'superadmin@admin.com', 'SFU0SkJ0YUlCc1dURVZFZCt5blNKQT09', '0', '1', '2024-07-07 17:52:46', '2024-07-07 17:16:51');
INSERT INTO `users` (user_id, user_name, user_email, user_password, user_role, user_status, user_updated, user_created) VALUES ('2', 'admin', 'admin@admin.com', 'S0VNV1lxa25wNW11N2JvS1lyS1BGUT09', '1', '1', '2024-07-07 21:56:58', '2024-07-07 15:41:13');
INSERT INTO `users` (user_id, user_name, user_email, user_password, user_role, user_status, user_updated, user_created) VALUES ('3', 'user', 'user@user.com', 'QzJNRnVNVHJwb0lCWGFadTBFYlNjQT09', '2', '1', '2024-07-07 21:58:40', '2024-07-07 19:24:50');

