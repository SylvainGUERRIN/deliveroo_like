<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014175718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, biker_id INT DEFAULT NULL, client VARCHAR(255) NOT NULL, deliverability_time TIME NOT NULL, INDEX IDX_169E6FB982150208 (biker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_price (id INT AUTO_INCREMENT NOT NULL, course_id INT DEFAULT NULL, at_restaurant TINYINT(1) NOT NULL, distance DOUBLE PRECISION NOT NULL, get_at_client TINYINT(1) NOT NULL, costs TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_23632531591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB982150208 FOREIGN KEY (biker_id) REFERENCES biker (id)');
        $this->addSql('ALTER TABLE course_price ADD CONSTRAINT FK_23632531591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_price DROP FOREIGN KEY FK_23632531591CC992');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_price');
    }
}
