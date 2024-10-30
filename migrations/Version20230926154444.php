<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926154444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la table Rent';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE rent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE rent (id INT NOT NULL, rent_user_id INT NOT NULL, book_id INT NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2784DCC4642A8E5 ON rent (rent_user_id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC4642A8E5 FOREIGN KEY (rent_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE rent_id_seq CASCADE');
        $this->addSql('DROP TABLE rent');
    }
}
