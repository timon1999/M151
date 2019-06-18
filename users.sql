CREATE DATABASE contact;

USE contact;

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

  CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user` bigint(20) COLLATE utf8_unicode_ci NOT NULL
  );
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE USER 'Contactuser'@'localhost' IDENTIFIED BY 'wYwFJq5IkxDR8ueK';
GRANT SELECT, INSERT, UPDATE ON `contact`.* TO 'Contactuser'@'localhost';