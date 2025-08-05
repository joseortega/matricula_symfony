<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250803123343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE expediente CHANGE fecha_ingreso fecha_ingreso DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', CHANGE fecha_retiro fecha_retiro DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE periodo_lectivo CHANGE fecha_inicio fecha_inicio DATE NOT NULL COMMENT '(DC2Type:date_immutable)', CHANGE fecha_fin fecha_fin DATE NOT NULL COMMENT '(DC2Type:date_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE periodo_lectivo CHANGE fecha_inicio fecha_inicio DATE NOT NULL, CHANGE fecha_fin fecha_fin DATE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expediente CHANGE fecha_ingreso fecha_ingreso DATETIME DEFAULT NULL, CHANGE fecha_retiro fecha_retiro DATETIME DEFAULT NULL
        SQL);
    }
}
