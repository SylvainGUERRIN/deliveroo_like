<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201012072614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE biker (id INT AUTO_INCREMENT NOT NULL, city_work_with_id INT DEFAULT NULL, enterprise_code VARCHAR(255) NOT NULL, right_to_create_enterprise TINYINT(1) NOT NULL, birthday_date DATETIME NOT NULL, sponsorship VARCHAR(255) NOT NULL, iban VARCHAR(255) NOT NULL, transportation VARCHAR(255) NOT NULL, INDEX IDX_81FDC08AB5CFFB25 (city_work_with_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE biker ADD CONSTRAINT FK_81FDC08AB5CFFB25 FOREIGN KEY (city_work_with_id) REFERENCES city (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE biker');
    }
}
