<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509091531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket DROP product, DROP user');
        $this->addSql('ALTER TABLE user ADD basket_id INT DEFAULT NULL, DROP basket');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491BE1FB52 ON user (basket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6491BE1FB52');
        $this->addSql('DROP INDEX UNIQ_8D93D6491BE1FB52 ON `user`');
        $this->addSql('ALTER TABLE `user` ADD basket VARCHAR(255) NOT NULL, DROP basket_id');
        $this->addSql('ALTER TABLE basket ADD product JSON NOT NULL, ADD user VARCHAR(255) NOT NULL');
    }
}
