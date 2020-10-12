<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201011132917 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stripe_client (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT DEFAULT NULL, account_id VARCHAR(255) NOT NULL, stripe_publishable_key VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6F097969B1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stripe_client ADD CONSTRAINT FK_6F097969B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE restaurant ADD stripe_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FA6664FEB FOREIGN KEY (stripe_client_id) REFERENCES stripe_client (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB95123FA6664FEB ON restaurant (stripe_client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FA6664FEB');
        $this->addSql('DROP TABLE stripe_client');
        $this->addSql('DROP INDEX UNIQ_EB95123FA6664FEB ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP stripe_client_id');
    }
}
