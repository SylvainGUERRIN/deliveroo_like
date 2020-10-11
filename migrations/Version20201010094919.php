<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201010094919 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_restaurant (order_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_584FEF6A8D9F6D38 (order_id), INDEX IDX_584FEF6AB1E7706E (restaurant_id), PRIMARY KEY(order_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, city_id INT DEFAULT NULL, address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, number VARCHAR(20) DEFAULT NULL, opens_at TIME NOT NULL, closes_at TIME NOT NULL, enabled TINYINT(1) NOT NULL, published TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_EB95123F7E3C61F9 (owner_id), INDEX IDX_EB95123F8BAC62AF (city_id), INDEX IDX_EB95123FF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant_category (restaurant_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_26E9D72EB1E7706E (restaurant_id), INDEX IDX_26E9D72E12469DE2 (category_id), PRIMARY KEY(restaurant_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_restaurant ADD CONSTRAINT FK_584FEF6A8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_restaurant ADD CONSTRAINT FK_584FEF6AB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE restaurant_category ADD CONSTRAINT FK_26E9D72EB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_category ADD CONSTRAINT FK_26E9D72E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dis_like ADD target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dis_like ADD CONSTRAINT FK_957FC0C4158E0B66 FOREIGN KEY (target_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_957FC0C4158E0B66 ON dis_like (target_id)');
        $this->addSql('ALTER TABLE `like` ADD target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3158E0B66 FOREIGN KEY (target_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_AC6340B3158E0B66 ON `like` (target_id)');
        $this->addSql('ALTER TABLE menu ADD restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_7D053A93B1E7706E ON menu (restaurant_id)');
        $this->addSql('ALTER TABLE user ADD restaurant_id INT DEFAULT NULL, ADD managed_restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64920D60862 FOREIGN KEY (managed_restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649B1E7706E ON user (restaurant_id)');
        $this->addSql('CREATE INDEX IDX_8D93D64920D60862 ON user (managed_restaurant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dis_like DROP FOREIGN KEY FK_957FC0C4158E0B66');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3158E0B66');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93B1E7706E');
        $this->addSql('ALTER TABLE order_restaurant DROP FOREIGN KEY FK_584FEF6AB1E7706E');
        $this->addSql('ALTER TABLE restaurant_category DROP FOREIGN KEY FK_26E9D72EB1E7706E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B1E7706E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64920D60862');
        $this->addSql('DROP TABLE order_restaurant');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE restaurant_category');
        $this->addSql('DROP INDEX IDX_957FC0C4158E0B66 ON dis_like');
        $this->addSql('ALTER TABLE dis_like DROP target_id');
        $this->addSql('DROP INDEX IDX_AC6340B3158E0B66 ON `like`');
        $this->addSql('ALTER TABLE `like` DROP target_id');
        $this->addSql('DROP INDEX IDX_7D053A93B1E7706E ON menu');
        $this->addSql('ALTER TABLE menu DROP restaurant_id');
        $this->addSql('DROP INDEX UNIQ_8D93D649B1E7706E ON user');
        $this->addSql('DROP INDEX IDX_8D93D64920D60862 ON user');
        $this->addSql('ALTER TABLE user DROP restaurant_id, DROP managed_restaurant_id');
    }
}
