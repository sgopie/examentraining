<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260504072938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subjects (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, niveau VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_subjects (user_id INT NOT NULL, subjects_id INT NOT NULL, INDEX IDX_4BA87D17A76ED395 (user_id), INDEX IDX_4BA87D1794AF957A (subjects_id), PRIMARY KEY (user_id, subjects_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE user_subjects ADD CONSTRAINT FK_4BA87D17A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_subjects ADD CONSTRAINT FK_4BA87D1794AF957A FOREIGN KEY (subjects_id) REFERENCES subjects (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_subjects DROP FOREIGN KEY FK_4BA87D17A76ED395');
        $this->addSql('ALTER TABLE user_subjects DROP FOREIGN KEY FK_4BA87D1794AF957A');
        $this->addSql('DROP TABLE subjects');
        $this->addSql('DROP TABLE user_subjects');
    }
}
