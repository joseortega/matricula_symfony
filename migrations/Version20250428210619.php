<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250428210619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE circuito (id INT AUTO_INCREMENT NOT NULL, distrito_id INT NOT NULL, codigo VARCHAR(255) NOT NULL, denominacion VARCHAR(255) NOT NULL, INDEX IDX_30A9B06AE557397E (distrito_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE circuito ADD CONSTRAINT FK_30A9B06AE557397E FOREIGN KEY (distrito_id) REFERENCES distrito (id)');
        $this->addSql('ALTER TABLE distrito ADD codigo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE institucion DROP FOREIGN KEY FK_F751F7C3E557397E');
        $this->addSql('DROP INDEX IDX_F751F7C3E557397E ON institucion');
        $this->addSql('ALTER TABLE institucion ADD codigo VARCHAR(255) NOT NULL, ADD ruc VARCHAR(255) NOT NULL, ADD telefono VARCHAR(255) DEFAULT NULL, ADD correo VARCHAR(255) DEFAULT NULL, ADD direccion VARCHAR(255) DEFAULT NULL, CHANGE distrito_id circuito_id INT NOT NULL');
        $this->addSql('ALTER TABLE institucion ADD CONSTRAINT FK_F751F7C368CE3E02 FOREIGN KEY (circuito_id) REFERENCES circuito (id)');
        $this->addSql('CREATE INDEX IDX_F751F7C368CE3E02 ON institucion (circuito_id)');
        $this->addSql('ALTER TABLE zona ADD codigo VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE institucion DROP FOREIGN KEY FK_F751F7C368CE3E02');
        $this->addSql('ALTER TABLE circuito DROP FOREIGN KEY FK_30A9B06AE557397E');
        $this->addSql('DROP TABLE circuito');
        $this->addSql('ALTER TABLE distrito DROP codigo');
        $this->addSql('DROP INDEX IDX_F751F7C368CE3E02 ON institucion');
        $this->addSql('ALTER TABLE institucion DROP codigo, DROP ruc, DROP telefono, DROP correo, DROP direccion, CHANGE circuito_id distrito_id INT NOT NULL');
        $this->addSql('ALTER TABLE institucion ADD CONSTRAINT FK_F751F7C3E557397E FOREIGN KEY (distrito_id) REFERENCES distrito (id)');
        $this->addSql('CREATE INDEX IDX_F751F7C3E557397E ON institucion (distrito_id)');
        $this->addSql('ALTER TABLE zona DROP codigo');
    }
}
