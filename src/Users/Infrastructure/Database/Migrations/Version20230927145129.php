<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230927145129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO users (id, email, created_at, updated_at, password_change_required) VALUES ('01HBBHW05WPHBPYH9XGEV4ZE68', 'admin@example.com', '2023-09-27 16:49:42', null, 1)");
        $this->addSql("INSERT INTO users_password_history (id, user_id, password, created_at) VALUES ('01HBBHW0SN5FHT3Q0NPAJXR13C', '01HBBHW05WPHBPYH9XGEV4ZE68', 'c807606b679a2f5caec820aaaa6d12ff5d60f4abcde86b5c3069af55c1536860cadafca67fc73de69df49f25b068c4414cd76ee39bfb47a19d47f161b58d4ad0', '2023-09-27 16:49:42');");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM users_password_history WHERE id = '01HBBHW0SN5FHT3Q0NPAJXR13C'");
        $this->addSql("DELETE FROM users WHERE id = '01HBBHW05WPHBPYH9XGEV4ZE68'");
    }
}
