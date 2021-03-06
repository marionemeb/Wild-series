<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191214210311 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actor_program DROP FOREIGN KEY FK_B01827EE10DAF24A');
        $this->addSql('ALTER TABLE actor_program DROP FOREIGN KEY FK_B01827EE3EB8070A');
        $this->addSql('ALTER TABLE actor_program ADD CONSTRAINT FK_B01827EE10DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actor_program ADD CONSTRAINT FK_B01827EE3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE episode CHANGE season_id season_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON DEFAULT NULL, CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE bio bio LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actor_program DROP FOREIGN KEY FK_B01827EE10DAF24A');
        $this->addSql('ALTER TABLE actor_program DROP FOREIGN KEY FK_B01827EE3EB8070A');
        $this->addSql('ALTER TABLE actor_program ADD CONSTRAINT FK_B01827EE10DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id)');
        $this->addSql('ALTER TABLE actor_program ADD CONSTRAINT FK_B01827EE3EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE episode CHANGE season_id season_id INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE username username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bio bio LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
