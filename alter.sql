ALTER TABLE `transactions` CHANGE `price` `price` BIGINT(191) NOT NULL;
ALTER TABLE `menus` CHANGE `price` `price` BIGINT(191) NOT NULL;
ALTER TABLE `users` ADD `id_owner` INT NULL AFTER `role`;
INSERT INTO `users` (`id`, `name`, `owner`, `email`, `phone`, `address`, `status`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (NULL, 'Developer', 'Unknown', 'admin@gmail.com', '250199', 'Unknown', '1', '0', NULL, NULL, '$2y$10$775PTMoCCGbpZuqLFkjKZ.HjzQ1gV4APQ4sAUPixQUJT3ThzttwNK', NULL, '2023-03-01 19:36:58', '2023-03-01 19:36:58');
