<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250729094915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE circuito (id INT AUTO_INCREMENT NOT NULL, distrito_id INT NOT NULL, codigo VARCHAR(20) NOT NULL, denominacion VARCHAR(150) NOT NULL, INDEX IDX_30A9B06AE557397E (distrito_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE distrito (id INT AUTO_INCREMENT NOT NULL, zona_id INT NOT NULL, codigo VARCHAR(20) NOT NULL, denominacion VARCHAR(150) NOT NULL, INDEX IDX_BE2719FD104EA8FC (zona_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE estado_matricula (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(100) NOT NULL, detalle VARCHAR(255) NOT NULL, codigo_sistema VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_CB9570F33800E79D (codigo_sistema), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE estudiante (id INT AUTO_INCREMENT NOT NULL, pais_nacionalidad_id INT NOT NULL, uniforme_talla_id INT DEFAULT NULL, identificacion VARCHAR(30) NOT NULL, apellidos VARCHAR(100) NOT NULL, nombres VARCHAR(100) NOT NULL, sexo VARCHAR(10) NOT NULL, fecha_nacimiento DATE NOT NULL, direccion VARCHAR(255) NOT NULL, telefono VARCHAR(20) DEFAULT NULL, correo VARCHAR(255) DEFAULT NULL, tiene_discapacidad TINYINT(1) NOT NULL, creado_en DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', actualizado_en DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', UNIQUE INDEX UNIQ_3B3F3FAD84291D2B (identificacion), INDEX IDX_3B3F3FAD6E72F3DA (pais_nacionalidad_id), INDEX IDX_3B3F3FADDC47B5C3 (uniforme_talla_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE estudiante_representante (id INT AUTO_INCREMENT NOT NULL, estudiante_id INT NOT NULL, representante_id INT NOT NULL, parentesco_id INT NOT NULL, principal TINYINT(1) NOT NULL, creado_en DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', actualizado_en DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_16A02FED59590C39 (estudiante_id), INDEX IDX_16A02FED2FD20D28 (representante_id), INDEX IDX_16A02FED5BA311FC (parentesco_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE expediente (id INT AUTO_INCREMENT NOT NULL, estudiante_id INT NOT NULL, fecha_ingreso DATETIME DEFAULT NULL, completo TINYINT(1) NOT NULL, retirado TINYINT(1) NOT NULL, fecha_retiro DATETIME DEFAULT NULL, observacion LONGTEXT DEFAULT NULL, creado_en DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', actualizado_en DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', UNIQUE INDEX UNIQ_D59CA41359590C39 (estudiante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE expediente_requisito (expediente_id INT NOT NULL, requisito_id INT NOT NULL, INDEX IDX_34CEF95F4BF37E4E (expediente_id), INDEX IDX_34CEF95FFA50198E (requisito_id), PRIMARY KEY(expediente_id, requisito_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE grado_escolar (id INT AUTO_INCREMENT NOT NULL, nivel_id INT NOT NULL, descripcion VARCHAR(100) NOT NULL, secuencia INT DEFAULT NULL, INDEX IDX_98C04955DA3426AE (nivel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE grado_escolar_requisito (id INT AUTO_INCREMENT NOT NULL, grado_escolar_id INT NOT NULL, requisito_id INT NOT NULL, obligatorio TINYINT(1) NOT NULL, INDEX IDX_4B461A34B6E91F0F (grado_escolar_id), INDEX IDX_4B461A34FA50198E (requisito_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE institucion (id INT AUTO_INCREMENT NOT NULL, circuito_id INT NOT NULL, codigo VARCHAR(20) NOT NULL, denominacion VARCHAR(150) NOT NULL, ruc VARCHAR(20) NOT NULL, telefono VARCHAR(20) DEFAULT NULL, correo VARCHAR(255) DEFAULT NULL, direccion VARCHAR(255) DEFAULT NULL, INDEX IDX_F751F7C368CE3E02 (circuito_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE jornada (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE matricula (id INT AUTO_INCREMENT NOT NULL, estudiante_id INT NOT NULL, jornada_id INT NOT NULL, modalidad_id INT NOT NULL, paralelo_id INT NOT NULL, grado_escolar_id INT NOT NULL, periodo_lectivo_id INT NOT NULL, estado_matricula_id INT NOT NULL, inscripcion_automatica TINYINT(1) NOT NULL, fecha_inscripcion DATE DEFAULT NULL COMMENT '(DC2Type:date_immutable)', inscrito_sistema_publico TINYINT(1) NOT NULL, legalizada TINYINT(1) NOT NULL, fecha_legalizacion DATE DEFAULT NULL COMMENT '(DC2Type:date_immutable)', fecha_cambio_estado DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', promovida TINYINT(1) NOT NULL, observacion LONGTEXT DEFAULT NULL, creado_en DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', actualizado_en DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_15DF188559590C39 (estudiante_id), INDEX IDX_15DF188526E992D9 (jornada_id), INDEX IDX_15DF18851E092B9F (modalidad_id), INDEX IDX_15DF1885DB3C1E64 (paralelo_id), INDEX IDX_15DF1885B6E91F0F (grado_escolar_id), INDEX IDX_15DF1885D871B602 (periodo_lectivo_id), INDEX IDX_15DF18857E99164F (estado_matricula_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE migration (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE modalidad (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE nivel (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pais (id INT AUTO_INCREMENT NOT NULL, codigo_numerico INT NOT NULL, codigo_alpha2 VARCHAR(2) NOT NULL, codigo_alpha3 VARCHAR(3) NOT NULL, nombre_comun VARCHAR(100) NOT NULL, nacionalidad VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE paralelo (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE parentesco (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE periodo_lectivo (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(100) NOT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE NOT NULL, habilitado_para_matricula TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE representante (id INT AUTO_INCREMENT NOT NULL, pais_nacionalidad_id INT NOT NULL, identificacion VARCHAR(30) NOT NULL, apellidos VARCHAR(100) NOT NULL, nombres VARCHAR(100) NOT NULL, sexo VARCHAR(10) NOT NULL, fecha_nacimiento DATE DEFAULT NULL, direccion VARCHAR(255) NOT NULL, telefono VARCHAR(20) DEFAULT NULL, correo VARCHAR(255) DEFAULT NULL, creado_en DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', actualizado_en DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', UNIQUE INDEX UNIQ_DE2D59584291D2B (identificacion), INDEX IDX_DE2D5956E72F3DA (pais_nacionalidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE requisito (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE uniforme_talla (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zona (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(20) NOT NULL, denominacion VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE circuito ADD CONSTRAINT FK_30A9B06AE557397E FOREIGN KEY (distrito_id) REFERENCES distrito (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE distrito ADD CONSTRAINT FK_BE2719FD104EA8FC FOREIGN KEY (zona_id) REFERENCES zona (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FAD6E72F3DA FOREIGN KEY (pais_nacionalidad_id) REFERENCES pais (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FADDC47B5C3 FOREIGN KEY (uniforme_talla_id) REFERENCES uniforme_talla (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante_representante ADD CONSTRAINT FK_16A02FED59590C39 FOREIGN KEY (estudiante_id) REFERENCES estudiante (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante_representante ADD CONSTRAINT FK_16A02FED2FD20D28 FOREIGN KEY (representante_id) REFERENCES representante (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante_representante ADD CONSTRAINT FK_16A02FED5BA311FC FOREIGN KEY (parentesco_id) REFERENCES parentesco (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expediente ADD CONSTRAINT FK_D59CA41359590C39 FOREIGN KEY (estudiante_id) REFERENCES estudiante (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expediente_requisito ADD CONSTRAINT FK_34CEF95F4BF37E4E FOREIGN KEY (expediente_id) REFERENCES expediente (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expediente_requisito ADD CONSTRAINT FK_34CEF95FFA50198E FOREIGN KEY (requisito_id) REFERENCES requisito (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE grado_escolar ADD CONSTRAINT FK_98C04955DA3426AE FOREIGN KEY (nivel_id) REFERENCES nivel (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE grado_escolar_requisito ADD CONSTRAINT FK_4B461A34B6E91F0F FOREIGN KEY (grado_escolar_id) REFERENCES grado_escolar (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE grado_escolar_requisito ADD CONSTRAINT FK_4B461A34FA50198E FOREIGN KEY (requisito_id) REFERENCES requisito (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE institucion ADD CONSTRAINT FK_F751F7C368CE3E02 FOREIGN KEY (circuito_id) REFERENCES circuito (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula ADD CONSTRAINT FK_15DF188559590C39 FOREIGN KEY (estudiante_id) REFERENCES estudiante (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula ADD CONSTRAINT FK_15DF188526E992D9 FOREIGN KEY (jornada_id) REFERENCES jornada (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula ADD CONSTRAINT FK_15DF18851E092B9F FOREIGN KEY (modalidad_id) REFERENCES modalidad (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula ADD CONSTRAINT FK_15DF1885DB3C1E64 FOREIGN KEY (paralelo_id) REFERENCES paralelo (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula ADD CONSTRAINT FK_15DF1885B6E91F0F FOREIGN KEY (grado_escolar_id) REFERENCES grado_escolar (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula ADD CONSTRAINT FK_15DF1885D871B602 FOREIGN KEY (periodo_lectivo_id) REFERENCES periodo_lectivo (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula ADD CONSTRAINT FK_15DF18857E99164F FOREIGN KEY (estado_matricula_id) REFERENCES estado_matricula (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE representante ADD CONSTRAINT FK_DE2D5956E72F3DA FOREIGN KEY (pais_nacionalidad_id) REFERENCES pais (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE circuito DROP FOREIGN KEY FK_30A9B06AE557397E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE distrito DROP FOREIGN KEY FK_BE2719FD104EA8FC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FAD6E72F3DA
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FADDC47B5C3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante_representante DROP FOREIGN KEY FK_16A02FED59590C39
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante_representante DROP FOREIGN KEY FK_16A02FED2FD20D28
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE estudiante_representante DROP FOREIGN KEY FK_16A02FED5BA311FC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expediente DROP FOREIGN KEY FK_D59CA41359590C39
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expediente_requisito DROP FOREIGN KEY FK_34CEF95F4BF37E4E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE expediente_requisito DROP FOREIGN KEY FK_34CEF95FFA50198E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE grado_escolar DROP FOREIGN KEY FK_98C04955DA3426AE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE grado_escolar_requisito DROP FOREIGN KEY FK_4B461A34B6E91F0F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE grado_escolar_requisito DROP FOREIGN KEY FK_4B461A34FA50198E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE institucion DROP FOREIGN KEY FK_F751F7C368CE3E02
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula DROP FOREIGN KEY FK_15DF188559590C39
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula DROP FOREIGN KEY FK_15DF188526E992D9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula DROP FOREIGN KEY FK_15DF18851E092B9F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula DROP FOREIGN KEY FK_15DF1885DB3C1E64
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula DROP FOREIGN KEY FK_15DF1885B6E91F0F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula DROP FOREIGN KEY FK_15DF1885D871B602
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matricula DROP FOREIGN KEY FK_15DF18857E99164F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE representante DROP FOREIGN KEY FK_DE2D5956E72F3DA
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE circuito
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE distrito
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE estado_matricula
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE estudiante
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE estudiante_representante
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE expediente
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE expediente_requisito
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE grado_escolar
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE grado_escolar_requisito
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE institucion
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE jornada
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE matricula
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE migration
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE modalidad
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE nivel
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pais
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE paralelo
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE parentesco
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE periodo_lectivo
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE representante
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE requisito
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE uniforme_talla
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE zona
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
