<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210110073617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, address VARCHAR(191) NOT NULL, country VARCHAR(191) NOT NULL, city VARCHAR(191) DEFAULT NULL, INDEX IDX_D4E6F81217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(191) NOT NULL, lastname VARCHAR(191) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, type_id INT NOT NULL, phone_number VARCHAR(191) NOT NULL, INDEX IDX_444F97DD217BBB47 (person_id), INDEX IDX_444F97DDC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DD217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DDC54C8C93 FOREIGN KEY (type_id) REFERENCES phone_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81217BBB47');
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DD217BBB47');
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DDC54C8C93');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE phone');
        $this->addSql('DROP TABLE phone_type');
    }
}
