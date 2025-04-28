<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250427053226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matricula ADD estado VARCHAR(255) NOT NULL, ADD fecha_cambio_estado DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP fecha_inactivacion, CHANGE fecha fecha DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE esta_activa inscrito_en_sistema_publico TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matricula ADD fecha_inactivacion DATETIME DEFAULT NULL, DROP estado, DROP fecha_cambio_estado, CHANGE fecha fecha DATE DEFAULT NULL, CHANGE inscrito_en_sistema_publico esta_activa TINYINT(1) NOT NULL');
    }
}
