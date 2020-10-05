<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004085314 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment_menu (comment_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_5B33987FF8697D13 (comment_id), INDEX IDX_5B33987FCCD7E912 (menu_id), PRIMARY KEY(comment_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment_menu ADD CONSTRAINT FK_5B33987FF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment_menu ADD CONSTRAINT FK_5B33987FCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_item ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_F0FE2527CCD7E912 ON cart_item (menu_id)');
        $this->addSql('ALTER TABLE menu ADD category_id INT DEFAULT NULL, ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A933DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_7D053A9312469DE2 ON menu (category_id)');
        $this->addSql('CREATE INDEX IDX_7D053A933DA5256D ON menu (image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comment_menu');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527CCD7E912');
        $this->addSql('DROP INDEX IDX_F0FE2527CCD7E912 ON cart_item');
        $this->addSql('ALTER TABLE cart_item DROP menu_id');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9312469DE2');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A933DA5256D');
        $this->addSql('DROP INDEX IDX_7D053A9312469DE2 ON menu');
        $this->addSql('DROP INDEX IDX_7D053A933DA5256D ON menu');
        $this->addSql('ALTER TABLE menu DROP category_id, DROP image_id');
    }
}
