<?php

use Phalcon\Db\Adapter\Pdo as Adapter;
use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phwoolcon\Cli\Command\Migrate;

return [
    'up' => function (Adapter $db, Migrate $migrate) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS `cron` (
              `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              `name` varchar(255)  NOT NULL DEFAULT '',
              `expression` varchar(255)  NOT NULL DEFAULT '',
              `class` varchar(255)  NOT NULL DEFAULT '',
              `method` varchar(255)  NOT NULL DEFAULT '',
              `type` varchar(30)  NOT NULL DEFAULT '',
              `status` varchar(30)  NOT NULL DEFAULT '',
              `created_at` int(10) UNSIGNED NOT NULL DEFAULT '0',
              `updated_at` int(10) UNSIGNED NOT NULL DEFAULT '0',
              `run_at` int(10) UNSIGNED NULL DEFAULT '0',
              `ms` int(10) UNSIGNED NOT NULL DEFAULT '0',
              `error` text  NOT NULL,
              PRIMARY KEY (`id`),
              KEY `name` (`name`,`created_at`),
              KEY `cron_status_index` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    },
    'down' => function (Adapter $db, Migrate $migrate) {
        $db->execute("DROP TABLE IF EXISTS `cron`;");
    },
];
