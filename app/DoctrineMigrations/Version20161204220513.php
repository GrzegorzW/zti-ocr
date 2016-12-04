<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161204220513 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE answers CHANGE id id VARCHAR(128) NOT NULL, CHANGE challenge_id challenge_id VARCHAR(128) DEFAULT NULL');
        $this->addSql('ALTER TABLE challenges CHANGE id id VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE images CHANGE id id VARCHAR(128) NOT NULL, CHANGE challenge_id challenge_id VARCHAR(128) DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE id id VARCHAR(128) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE answers CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE challenge_id challenge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE challenges CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE images CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE challenge_id challenge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
