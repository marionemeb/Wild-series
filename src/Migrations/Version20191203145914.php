<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191203145914 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED778412469DE2');
        $this->addSql('ALTER TABLE program ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA4EC001D1');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA93EB8070A');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA93EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE actor_program DROP FOREIGN KEY FK_B01827EE10DAF24A');
        $this->addSql('ALTER TABLE actor_program DROP FOREIGN KEY FK_B01827EE3EB8070A');
        $this->addSql('ALTER TABLE actor_program ADD CONSTRAINT FK_B01827EE10DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actor_program ADD CONSTRAINT FK_B01827EE3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C362B62A0');
        $this->addSql('ALTER TABLE comment CHANGE episode_id episode_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actor_program DROP FOREIGN KEY FK_B01827EE10DAF24A');
        $this->addSql('ALTER TABLE actor_program DROP FOREIGN KEY FK_B01827EE3EB8070A');
        $this->addSql('ALTER TABLE actor_program ADD CONSTRAINT FK_B01827EE10DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actor_program ADD CONSTRAINT FK_B01827EE3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C362B62A0');
        $this->addSql('ALTER TABLE comment CHANGE episode_id episode_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA4EC001D1');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED778412469DE2');
        $this->addSql('ALTER TABLE program DROP slug');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA93EB8070A');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA93EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
