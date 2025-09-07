<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250907134832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE estado_civil (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante ADD observacion VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE representante ADD estado_civil_id INT DEFAULT NULL, ADD observacion VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE representante ADD CONSTRAINT FK_DE2D59575376D93 FOREIGN KEY (estado_civil_id) REFERENCES estado_civil (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DE2D59575376D93 ON representante (estado_civil_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE representante DROP FOREIGN KEY FK_DE2D59575376D93
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE estado_civil
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DE2D59575376D93 ON representante
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE representante DROP estado_civil_id, DROP observacion
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante DROP observacion
        SQL);
    }
}
