ALTER TABLE `transactions` CHANGE `price` `price` BIGINT(191) NOT NULL;
ALTER TABLE `menus` CHANGE `price` `price` BIGINT(191) NOT NULL;
ALTER TABLE `menus` ADD `hpp` BIGINT(100) NULL AFTER `price`;
ALTER TABLE `sales` ADD `gross_profit` BIGINT(255) NULL AFTER `sales_group_id`, ADD `net_profit` BIGINT(255) NULL AFTER `gross_profit`;
