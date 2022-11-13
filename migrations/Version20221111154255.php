<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221111154255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etalage (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, amateur_id INTEGER DEFAULT NULL, description VARCHAR(255) NOT NULL, publie BOOLEAN NOT NULL, CONSTRAINT FK_5F822C0D45D8B0B5 FOREIGN KEY (amateur_id) REFERENCES amateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5F822C0D45D8B0B5 ON etalage (amateur_id)');
        $this->addSql('CREATE TABLE etalage_livre (etalage_id INTEGER NOT NULL, livre_id INTEGER NOT NULL, PRIMARY KEY(etalage_id, livre_id), CONSTRAINT FK_BE4465E3541EDF9E FOREIGN KEY (etalage_id) REFERENCES etalage (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BE4465E337D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BE4465E3541EDF9E ON etalage_livre (etalage_id)');
        $this->addSql('CREATE INDEX IDX_BE4465E337D925CB ON etalage_livre (livre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE etalage');
        $this->addSql('DROP TABLE etalage_livre');
    }
}
