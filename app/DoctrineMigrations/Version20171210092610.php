<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171210092610 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE answers (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', challenge_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, content VARCHAR(255) NOT NULL, device_brand VARCHAR(255) NOT NULL, device_model VARCHAR(255) NOT NULL, device_os VARCHAR(255) NOT NULL, device_osversion VARCHAR(255) NOT NULL, time_result DOUBLE PRECISION NOT NULL, INDEX IDX_50D0C60698A21AC6 (challenge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', filesystem VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, mime_type VARCHAR(64) NOT NULL, size INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1483A5E9A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_1483A5E9C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenges (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', image_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, correct_answer LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_7B5A7E03DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C60698A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenges (id)');
        $this->addSql('ALTER TABLE challenges ADD CONSTRAINT FK_7B5A7E03DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE challenges DROP FOREIGN KEY FK_7B5A7E03DA5256D');
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C60698A21AC6');
        $this->addSql('DROP TABLE answers');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE challenges');
        $this->addSql('DROP TABLE refresh_tokens');
    }
}
