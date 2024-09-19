<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240919092944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE advert (id INT AUTO_INCREMENT NOT NULL, publish_date DATETIME NOT NULL, is_open TINYINT(1) NOT NULL, modality VARCHAR(30) DEFAULT NULL, area VARCHAR(30) DEFAULT NULL, level VARCHAR(30) DEFAULT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campain (id INT AUTO_INCREMENT NOT NULL, playing_group_id INT NOT NULL, name VARCHAR(75) DEFAULT NULL, game VARCHAR(100) NOT NULL, INDEX IDX_B9277B3FAA5A705F (playing_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, publish_date DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_9474526CD07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, campain_id INT NOT NULL, name VARCHAR(100) NOT NULL, creation_date DATETIME NOT NULL, last_modified DATETIME DEFAULT NULL, format VARCHAR(10) DEFAULT NULL, type VARCHAR(35) DEFAULT NULL, address LONGTEXT DEFAULT NULL, INDEX IDX_8C9F361020B77272 (campain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, campain_id INT NOT NULL, scheduled DATETIME NOT NULL, run_time INT DEFAULT NULL, INDEX IDX_D044D5D420B77272 (campain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campain ADD CONSTRAINT FK_B9277B3FAA5A705F FOREIGN KEY (playing_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361020B77272 FOREIGN KEY (campain_id) REFERENCES campain (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D420B77272 FOREIGN KEY (campain_id) REFERENCES campain (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campain DROP FOREIGN KEY FK_B9277B3FAA5A705F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD07ECCB6');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361020B77272');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D420B77272');
        $this->addSql('DROP TABLE advert');
        $this->addSql('DROP TABLE campain');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
