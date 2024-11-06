<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241028010616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE distrito (id INT AUTO_INCREMENT NOT NULL, zona_id INT NOT NULL, denominacion VARCHAR(255) NOT NULL, INDEX IDX_BE2719FD104EA8FC (zona_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estudiante (id INT AUTO_INCREMENT NOT NULL, nacionalidad_id INT DEFAULT NULL, expediente_id INT DEFAULT NULL, uniforme_talla_id INT DEFAULT NULL, identificacion VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, nombres VARCHAR(255) NOT NULL, sexo VARCHAR(255) NOT NULL, fecha_nacimiento DATE NOT NULL, telefono VARCHAR(255) DEFAULT NULL, correo VARCHAR(255) DEFAULT NULL, tiene_discapacidad TINYINT(1) NOT NULL, lugar_residencia VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3B3F3FAD84291D2B (identificacion), INDEX IDX_3B3F3FADAB8DC0F8 (nacionalidad_id), UNIQUE INDEX UNIQ_3B3F3FAD4BF37E4E (expediente_id), INDEX IDX_3B3F3FADDC47B5C3 (uniforme_talla_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estudiante_representante (id INT AUTO_INCREMENT NOT NULL, estudiante_id INT NOT NULL, representante_id INT NOT NULL, parentesco_id INT NOT NULL, es_principal TINYINT(1) NOT NULL, INDEX IDX_16A02FED59590C39 (estudiante_id), INDEX IDX_16A02FED2FD20D28 (representante_id), INDEX IDX_16A02FED5BA311FC (parentesco_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expediente (id INT AUTO_INCREMENT NOT NULL, estudiante_id INT NOT NULL, observacion VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D59CA41359590C39 (estudiante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grado_escolar (id INT AUTO_INCREMENT NOT NULL, nivel_id INT NOT NULL, descripcion VARCHAR(255) NOT NULL, secuencia INT DEFAULT NULL, INDEX IDX_98C04955DA3426AE (nivel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grado_escolar_requisito (id INT AUTO_INCREMENT NOT NULL, grado_escolar_id INT NOT NULL, requisito_id INT NOT NULL, es_obligatorio TINYINT(1) NOT NULL, INDEX IDX_4B461A34B6E91F0F (grado_escolar_id), INDEX IDX_4B461A34FA50198E (requisito_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institucion (id INT AUTO_INCREMENT NOT NULL, distrito_id INT NOT NULL, denominacion VARCHAR(255) NOT NULL, INDEX IDX_F751F7C3E557397E (distrito_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jornada (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matricula (id INT AUTO_INCREMENT NOT NULL, estudiante_id INT NOT NULL, jornada_id INT NOT NULL, modalidad_id INT NOT NULL, paralelo_id INT NOT NULL, grado_escolar_id INT NOT NULL, periodo_lectivo_id INT NOT NULL, fecha DATE DEFAULT NULL, estado VARCHAR(255) DEFAULT NULL, observacion LONGTEXT DEFAULT NULL, INDEX IDX_15DF188559590C39 (estudiante_id), INDEX IDX_15DF188526E992D9 (jornada_id), INDEX IDX_15DF18851E092B9F (modalidad_id), INDEX IDX_15DF1885DB3C1E64 (paralelo_id), INDEX IDX_15DF1885B6E91F0F (grado_escolar_id), INDEX IDX_15DF1885D871B602 (periodo_lectivo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modalidad (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nacionalidad (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nivel (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paralelo (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parentesco (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periodo_lectivo (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE representante (id INT AUTO_INCREMENT NOT NULL, identificacion VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, nombres VARCHAR(255) NOT NULL, lugar_residencia VARCHAR(255) DEFAULT NULL, telefono VARCHAR(255) DEFAULT NULL, correo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_DE2D59584291D2B (identificacion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE requisito (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uniforme_talla (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zona (id INT AUTO_INCREMENT NOT NULL, denominacion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE distrito ADD CONSTRAINT FK_BE2719FD104EA8FC FOREIGN KEY (zona_id) REFERENCES zona (id)');
        $this->addSql('ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FADAB8DC0F8 FOREIGN KEY (nacionalidad_id) REFERENCES nacionalidad (id)');
        $this->addSql('ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FAD4BF37E4E FOREIGN KEY (expediente_id) REFERENCES expediente (id)');
        $this->addSql('ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FADDC47B5C3 FOREIGN KEY (uniforme_talla_id) REFERENCES uniforme_talla (id)');
        $this->addSql('ALTER TABLE estudiante_representante ADD CONSTRAINT FK_16A02FED59590C39 FOREIGN KEY (estudiante_id) REFERENCES estudiante (id)');
        $this->addSql('ALTER TABLE estudiante_representante ADD CONSTRAINT FK_16A02FED2FD20D28 FOREIGN KEY (representante_id) REFERENCES representante (id)');
        $this->addSql('ALTER TABLE estudiante_representante ADD CONSTRAINT FK_16A02FED5BA311FC FOREIGN KEY (parentesco_id) REFERENCES parentesco (id)');
        $this->addSql('ALTER TABLE expediente ADD CONSTRAINT FK_D59CA41359590C39 FOREIGN KEY (estudiante_id) REFERENCES estudiante (id)');
        $this->addSql('ALTER TABLE grado_escolar ADD CONSTRAINT FK_98C04955DA3426AE FOREIGN KEY (nivel_id) REFERENCES nivel (id)');
        $this->addSql('ALTER TABLE grado_escolar_requisito ADD CONSTRAINT FK_4B461A34B6E91F0F FOREIGN KEY (grado_escolar_id) REFERENCES grado_escolar (id)');
        $this->addSql('ALTER TABLE grado_escolar_requisito ADD CONSTRAINT FK_4B461A34FA50198E FOREIGN KEY (requisito_id) REFERENCES requisito (id)');
        $this->addSql('ALTER TABLE institucion ADD CONSTRAINT FK_F751F7C3E557397E FOREIGN KEY (distrito_id) REFERENCES distrito (id)');
        $this->addSql('ALTER TABLE matricula ADD CONSTRAINT FK_15DF188559590C39 FOREIGN KEY (estudiante_id) REFERENCES estudiante (id)');
        $this->addSql('ALTER TABLE matricula ADD CONSTRAINT FK_15DF188526E992D9 FOREIGN KEY (jornada_id) REFERENCES jornada (id)');
        $this->addSql('ALTER TABLE matricula ADD CONSTRAINT FK_15DF18851E092B9F FOREIGN KEY (modalidad_id) REFERENCES modalidad (id)');
        $this->addSql('ALTER TABLE matricula ADD CONSTRAINT FK_15DF1885DB3C1E64 FOREIGN KEY (paralelo_id) REFERENCES paralelo (id)');
        $this->addSql('ALTER TABLE matricula ADD CONSTRAINT FK_15DF1885B6E91F0F FOREIGN KEY (grado_escolar_id) REFERENCES grado_escolar (id)');
        $this->addSql('ALTER TABLE matricula ADD CONSTRAINT FK_15DF1885D871B602 FOREIGN KEY (periodo_lectivo_id) REFERENCES periodo_lectivo (id)');
        $this->addSql('ALTER TABLE expediente_requisito ADD CONSTRAINT FK_34CEF95F4BF37E4E FOREIGN KEY (expediente_id) REFERENCES expediente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expediente_requisito ADD CONSTRAINT FK_34CEF95FFA50198E FOREIGN KEY (requisito_id) REFERENCES requisito (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expediente_requisito DROP FOREIGN KEY FK_34CEF95F4BF37E4E');
        $this->addSql('ALTER TABLE expediente_requisito DROP FOREIGN KEY FK_34CEF95FFA50198E');
        $this->addSql('ALTER TABLE distrito DROP FOREIGN KEY FK_BE2719FD104EA8FC');
        $this->addSql('ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FADAB8DC0F8');
        $this->addSql('ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FAD4BF37E4E');
        $this->addSql('ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FADDC47B5C3');
        $this->addSql('ALTER TABLE estudiante_representante DROP FOREIGN KEY FK_16A02FED59590C39');
        $this->addSql('ALTER TABLE estudiante_representante DROP FOREIGN KEY FK_16A02FED2FD20D28');
        $this->addSql('ALTER TABLE estudiante_representante DROP FOREIGN KEY FK_16A02FED5BA311FC');
        $this->addSql('ALTER TABLE expediente DROP FOREIGN KEY FK_D59CA41359590C39');
        $this->addSql('ALTER TABLE grado_escolar DROP FOREIGN KEY FK_98C04955DA3426AE');
        $this->addSql('ALTER TABLE grado_escolar_requisito DROP FOREIGN KEY FK_4B461A34B6E91F0F');
        $this->addSql('ALTER TABLE grado_escolar_requisito DROP FOREIGN KEY FK_4B461A34FA50198E');
        $this->addSql('ALTER TABLE institucion DROP FOREIGN KEY FK_F751F7C3E557397E');
        $this->addSql('ALTER TABLE matricula DROP FOREIGN KEY FK_15DF188559590C39');
        $this->addSql('ALTER TABLE matricula DROP FOREIGN KEY FK_15DF188526E992D9');
        $this->addSql('ALTER TABLE matricula DROP FOREIGN KEY FK_15DF18851E092B9F');
        $this->addSql('ALTER TABLE matricula DROP FOREIGN KEY FK_15DF1885DB3C1E64');
        $this->addSql('ALTER TABLE matricula DROP FOREIGN KEY FK_15DF1885B6E91F0F');
        $this->addSql('ALTER TABLE matricula DROP FOREIGN KEY FK_15DF1885D871B602');
        $this->addSql('DROP TABLE distrito');
        $this->addSql('DROP TABLE estudiante');
        $this->addSql('DROP TABLE estudiante_representante');
        $this->addSql('DROP TABLE expediente');
        $this->addSql('DROP TABLE grado_escolar');
        $this->addSql('DROP TABLE grado_escolar_requisito');
        $this->addSql('DROP TABLE institucion');
        $this->addSql('DROP TABLE jornada');
        $this->addSql('DROP TABLE matricula');
        $this->addSql('DROP TABLE modalidad');
        $this->addSql('DROP TABLE nacionalidad');
        $this->addSql('DROP TABLE nivel');
        $this->addSql('DROP TABLE paralelo');
        $this->addSql('DROP TABLE parentesco');
        $this->addSql('DROP TABLE periodo_lectivo');
        $this->addSql('DROP TABLE representante');
        $this->addSql('DROP TABLE requisito');
        $this->addSql('DROP TABLE uniforme_talla');
        $this->addSql('DROP TABLE zona');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
