<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531131220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode CHANGE duration duration INT NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE program ADD updated_at DATETIME DEFAULT NULL, CHANGE title title VARCHAR(255) NOT NULL, CHANGE synopsis synopsis VARCHAR(255) NOT NULL, CHANGE poster poster VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode CHANGE duration duration INT DEFAULT NULL, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE program DROP updated_at, CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE synopsis synopsis VARCHAR(255) DEFAULT NULL, CHANGE poster poster VARCHAR(255) DEFAULT NULL, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
    }
}
