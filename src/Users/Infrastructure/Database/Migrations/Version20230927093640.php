<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230927093640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (id VARCHAR(26) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, password_change_required TINYINT(1) DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_password_history (id VARCHAR(26) NOT NULL, user_id VARCHAR(26) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_1F542EE1A76ED395 (user_id), UNIQUE INDEX UNIQ_1F542EE1A76ED39535C246D5 (user_id, password), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_password_history ADD CONSTRAINT FK_1F542EE1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_password_history DROP FOREIGN KEY FK_1F542EE1A76ED395');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_password_history');
    }
}
