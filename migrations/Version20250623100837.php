<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250623120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des tables wish et category, ajout colonne image et relation wish-category';
    }

    public function up(Schema $schema): void
    {
        // Création table wish
        $this->addSql(<<<'SQL'
            CREATE TABLE wish (
                id INT AUTO_INCREMENT NOT NULL,
                title VARCHAR(250) NOT NULL,
                description LONGTEXT DEFAULT NULL,
                author VARCHAR(50) NOT NULL,
                is_published TINYINT(1) DEFAULT 0 NOT NULL,
                date_created DATETIME NOT NULL,
                date_updated DATETIME DEFAULT NULL,
                image VARCHAR(255) DEFAULT NULL,
                category_id INT NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);

        // Création table category
        $this->addSql(<<<'SQL'
            CREATE TABLE category (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(50) NOT NULL,
                UNIQUE INDEX UNIQ_64C19C15E237E06 (name),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);

        // Ajout contrainte FK wish -> category
        $this->addSql(<<<'SQL'
            ALTER TABLE wish
            ADD CONSTRAINT FK_D7D174C912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);

        // Ajout index sur category_id dans wish
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D7D174C912469DE2 ON wish (category_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // Suppression FK et index
        $this->addSql(<<<'SQL'
            ALTER TABLE wish DROP FOREIGN KEY FK_D7D174C912469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D7D174C912469DE2 ON wish
        SQL);

        // Suppression tables
        $this->addSql('DROP TABLE wish');
        $this->addSql('DROP TABLE category');
    }
}
