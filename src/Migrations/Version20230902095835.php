<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230902095835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Page (id INT AUTO_INCREMENT NOT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE PageTranslation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, content LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D29B35C0989D9B62 (slug), INDEX IDX_D29B35C02C2AC5D3 (translatable_id), UNIQUE INDEX PageTranslation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE PageTranslation ADD CONSTRAINT FK_D29B35C02C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES Page (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE PageTranslation DROP FOREIGN KEY FK_D29B35C02C2AC5D3');
        $this->addSql('DROP TABLE Page');
        $this->addSql('DROP TABLE PageTranslation');
    }
}
