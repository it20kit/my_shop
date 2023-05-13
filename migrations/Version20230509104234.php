<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509104234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_basket DROP FOREIGN KEY FK_403A11DF1BE1FB52');
        $this->addSql('ALTER TABLE product_basket DROP FOREIGN KEY FK_403A11DF4584665A');
        $this->addSql('DROP TABLE product_basket');
        $this->addSql('ALTER TABLE basket ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_2246507B4584665A ON basket (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_basket (product_id INT NOT NULL, basket_id INT NOT NULL, INDEX IDX_403A11DF1BE1FB52 (basket_id), INDEX IDX_403A11DF4584665A (product_id), PRIMARY KEY(product_id, basket_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_basket ADD CONSTRAINT FK_403A11DF1BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_basket ADD CONSTRAINT FK_403A11DF4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507B4584665A');
        $this->addSql('DROP INDEX IDX_2246507B4584665A ON basket');
        $this->addSql('ALTER TABLE basket DROP product_id');
    }
}
