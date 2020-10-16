<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201015181200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biker ADD biker_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE biker ADD CONSTRAINT FK_81FDC08A82150208 FOREIGN KEY (biker_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81FDC08A82150208 ON biker (biker_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biker DROP FOREIGN KEY FK_81FDC08A82150208');
        $this->addSql('DROP INDEX UNIQ_81FDC08A82150208 ON biker');
        $this->addSql('ALTER TABLE biker DROP biker_id');
    }
}
