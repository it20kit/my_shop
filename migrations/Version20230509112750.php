<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509112750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507B4584665A');
        $this->addSql('DROP INDEX IDX_2246507B4584665A ON basket');
        $this->addSql('ALTER TABLE basket DROP product_id');
        $this->addSql('ALTER TABLE product ADD basket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD1BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD1BE1FB52 ON product (basket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2246507B4584665A ON basket (product_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD1BE1FB52');
        $this->addSql('DROP INDEX IDX_D34A04AD1BE1FB52 ON product');
        $this->addSql('ALTER TABLE product DROP basket_id');
    }
}
