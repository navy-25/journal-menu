-- ALTER TABLE `transactions` CHANGE `price` `price` BIGINT(191) NOT NULL;
-- ALTER TABLE `menus` CHANGE `price` `price` BIGINT(191) NOT NULL;
-- ALTER TABLE `menus` ADD `hpp` BIGINT(100) NULL AFTER `price`;
-- ALTER TABLE `sales` ADD `gross_profit` BIGINT(255) NULL AFTER `sales_group_id`, ADD `net_profit` BIGINT(255) NULL AFTER `gross_profit`;

-- ALTER TABLE `menus` ADD `id_user` INT(10) NULL AFTER `id`;
-- ALTER TABLE `notes` ADD `id_user` INT(10) NULL AFTER `id`;
-- ALTER TABLE `sales` ADD `id_user` INT(10) NULL AFTER `id`;
-- ALTER TABLE `sales_groups` ADD `id_user` INT(10) NULL AFTER `id`;
-- ALTER TABLE `stocks` ADD `id_user` INT(10) NULL AFTER `id`;
-- ALTER TABLE `transactions` ADD `id_user` INT(10) NULL AFTER `id`;
-- INSERT INTO `users` (`id`, `name`, `owner`, `email`, `phone`, `address`, `status`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (NULL, 'Developer', 'Unknown', 'admin@gmail.com', '250199', 'Unknown', '1', '0', NULL, '$2y$10$775PTMoCCGbpZuqLFkjKZ.HjzQ1gV4APQ4sAUPixQUJT3ThzttwNK', NULL, '2023-03-01 19:36:58', '2023-03-01 19:36:58');

-- ALTER TABLE `menus` ADD `is_promo` INT(10) NOT NULL DEFAULT '0' AFTER `hpp`, ADD `price_promo` BIGINT(255) NOT NULL DEFAULT '0' AFTER `is_promo`;
-- ALTER TABLE `menus` ADD `status` INT(10) NOT NULL DEFAULT '1' AFTER `price_promo`;
-- ALTER TABLE `sales` ADD `is_promo` INT(10) NOT NULL DEFAULT '0' AFTER `sales_group_id`;
