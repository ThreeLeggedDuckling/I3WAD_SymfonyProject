<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241006192028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE advert (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, publish_date DATETIME NOT NULL, is_open TINYINT(1) NOT NULL, area VARCHAR(30) DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_54F1F40BF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE advert_tag (advert_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_4A8FB765D07ECCB6 (advert_id), INDEX IDX_4A8FB765BAD26311 (tag_id), PRIMARY KEY(advert_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campaign (id INT AUTO_INCREMENT NOT NULL, playing_group_id INT NOT NULL, master_id INT NOT NULL, name VARCHAR(75) DEFAULT NULL, game VARCHAR(100) NOT NULL, INDEX IDX_1F1512DDAA5A705F (playing_group_id), INDEX IDX_1F1512DD13B3DB11 (master_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, author_id INT DEFAULT NULL, answer_to_id INT DEFAULT NULL, publish_date DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_9474526CD07ECCB6 (advert_id), INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526CAB0FA336 (answer_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, campaign_id INT NOT NULL, author_id INT NOT NULL, name VARCHAR(100) NOT NULL, creation_date DATETIME NOT NULL, last_modified DATETIME DEFAULT NULL, format VARCHAR(10) DEFAULT NULL, type VARCHAR(35) DEFAULT NULL, adress LONGTEXT DEFAULT NULL, INDEX IDX_8C9F3610F639F774 (campaign_id), INDEX IDX_8C9F3610F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, campaign_id INT NOT NULL, scheduled DATETIME NOT NULL, run_time INT DEFAULT NULL, INDEX IDX_D044D5D4F639F774 (campaign_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_member (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_A36222A8A76ED395 (user_id), INDEX IDX_A36222A8FE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_admin (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_D8222611A76ED395 (user_id), INDEX IDX_D8222611FE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40BF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE advert_tag ADD CONSTRAINT FK_4A8FB765D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE advert_tag ADD CONSTRAINT FK_4A8FB765BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE campaign ADD CONSTRAINT FK_1F1512DDAA5A705F FOREIGN KEY (playing_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE campaign ADD CONSTRAINT FK_1F1512DD13B3DB11 FOREIGN KEY (master_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CAB0FA336 FOREIGN KEY (answer_to_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('ALTER TABLE group_member ADD CONSTRAINT FK_A36222A8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_member ADD CONSTRAINT FK_A36222A8FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_admin ADD CONSTRAINT FK_D8222611A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_admin ADD CONSTRAINT FK_D8222611FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40BF675F31B');
        $this->addSql('ALTER TABLE advert_tag DROP FOREIGN KEY FK_4A8FB765D07ECCB6');
        $this->addSql('ALTER TABLE advert_tag DROP FOREIGN KEY FK_4A8FB765BAD26311');
        $this->addSql('ALTER TABLE campaign DROP FOREIGN KEY FK_1F1512DDAA5A705F');
        $this->addSql('ALTER TABLE campaign DROP FOREIGN KEY FK_1F1512DD13B3DB11');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD07ECCB6');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CAB0FA336');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610F639F774');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610F675F31B');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4F639F774');
        $this->addSql('ALTER TABLE group_member DROP FOREIGN KEY FK_A36222A8A76ED395');
        $this->addSql('ALTER TABLE group_member DROP FOREIGN KEY FK_A36222A8FE54D947');
        $this->addSql('ALTER TABLE group_admin DROP FOREIGN KEY FK_D8222611A76ED395');
        $this->addSql('ALTER TABLE group_admin DROP FOREIGN KEY FK_D8222611FE54D947');
        $this->addSql('DROP TABLE advert');
        $this->addSql('DROP TABLE advert_tag');
        $this->addSql('DROP TABLE campaign');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE group_member');
        $this->addSql('DROP TABLE group_admin');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
