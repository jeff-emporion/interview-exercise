<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220518072011 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (
          id INT UNSIGNED AUTO_INCREMENT NOT NULL,
          person_id INT UNSIGNED DEFAULT NULL,
          name VARCHAR(128) DEFAULT \'\' NOT NULL,
          INDEX IDX_4C62E638217BBB47 (person_id),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field (
          id INT UNSIGNED AUTO_INCREMENT NOT NULL,
          contact_id INT UNSIGNED DEFAULT NULL,
          value VARCHAR(128) DEFAULT \'\' NOT NULL,
          type VARCHAR(32) NOT NULL,
          name VARCHAR(32) NOT NULL,
          INDEX IDX_5BF54558E7A1254A (contact_id),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_address (
          id INT UNSIGNED NOT NULL,
          country VARCHAR(64) DEFAULT \'\' NOT NULL,
          city VARCHAR(64) DEFAULT \'\' NOT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_email (
          id INT UNSIGNED NOT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_note (
          id INT UNSIGNED NOT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_phone (
          id INT UNSIGNED NOT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (
          id INT UNSIGNED AUTO_INCREMENT NOT NULL,
          name VARCHAR(255) DEFAULT \'\' NOT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE
          contact
        ADD
          CONSTRAINT FK_4C62E638217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE
          field
        ADD
          CONSTRAINT FK_5BF54558E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE
          field_address
        ADD
          CONSTRAINT FK_E36A4A21BF396750 FOREIGN KEY (id) REFERENCES field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE
          field_email
        ADD
          CONSTRAINT FK_CC35EA8FBF396750 FOREIGN KEY (id) REFERENCES field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE
          field_note
        ADD
          CONSTRAINT FK_DC7193AEBF396750 FOREIGN KEY (id) REFERENCES field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE
          field_phone
        ADD
          CONSTRAINT FK_6FE80126BF396750 FOREIGN KEY (id) REFERENCES field (id) ON DELETE CASCADE');
    }
}
