<?php
//
//declare(strict_types=1);
//
//namespace DoctrineMigrations;
//
//use Doctrine\DBAL\Schema\Schema;
//use Doctrine\Migrations\AbstractMigration;
//
///**
// * Auto-generated Migration: Please modify to your needs!
// */
//final class Version20250623100441 extends AbstractMigration
//{
//    public function getDescription(): string
//    {
//        return '';
//    }
//
//    public function up(Schema $schema): void
//    {
//        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql(<<<'SQL'
//            ALTER TABLE wish CHANGE image image VARCHAR(255) NOT NULL
//        SQL);
//        $this->addSql(<<<'SQL'
//            ALTER TABLE wish ADD CONSTRAINT FK_D7D174C912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
//        SQL);
//        $this->addSql(<<<'SQL'
//            CREATE INDEX IDX_D7D174C912469DE2 ON wish (category_id)
//        SQL);
//    }
//
//    public function down(Schema $schema): void
//    {
//        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql(<<<'SQL'
//            ALTER TABLE wish DROP FOREIGN KEY FK_D7D174C912469DE2
//        SQL);
//        $this->addSql(<<<'SQL'
//            DROP INDEX IDX_D7D174C912469DE2 ON wish
//        SQL);
//        $this->addSql(<<<'SQL'
//            ALTER TABLE wish CHANGE image image VARCHAR(255) DEFAULT NULL
//        SQL);
//    }
//}
