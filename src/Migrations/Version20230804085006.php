<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230804085006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ProductBundle (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE productbundle_product (productbundle_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_500FE108148AF624 (productbundle_id), INDEX IDX_500FE1084584665A (product_id), PRIMARY KEY(productbundle_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE productbundle_product ADD CONSTRAINT FK_500FE108148AF624 FOREIGN KEY (productbundle_id) REFERENCES ProductBundle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE productbundle_product ADD CONSTRAINT FK_500FE1084584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE productbundle_product DROP FOREIGN KEY FK_500FE108148AF624');
        $this->addSql('ALTER TABLE productbundle_product DROP FOREIGN KEY FK_500FE1084584665A');
        $this->addSql('DROP TABLE ProductBundle');
        $this->addSql('DROP TABLE productbundle_product');
    }
}
