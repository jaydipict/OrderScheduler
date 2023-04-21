<?php declare(strict_types=1);

namespace OrderScheduler\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1621249829 extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1621249829;
    }

    public function update(Connection $connection): void
    {
        $connection->executeUpdate('
            CREATE TABLE IF NOT EXISTS `set_product` (
              `id` binary(16) NOT NULL,
              `product_id` binary(16) NOT NULL,
              `product_version_id` BINARY(16) NOT NULL,
              `active` bool DEFAULT NULL,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
              PRIMARY KEY (`id`),
               CONSTRAINT `fk.set_product.product_id__product_version_id` FOREIGN KEY (`product_id`, `product_version_id`)
                REFERENCES `product` (`id`, `version_id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
