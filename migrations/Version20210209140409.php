<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209140409 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE school DROP FOREIGN KEY FK_F99EDABB4C83E04B');
        $this->addSql('DROP INDEX IDX_F99EDABB4C83E04B ON school');
        $this->addSql('ALTER TABLE school DROP legation_id');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D54C83E04B');
        $this->addSql('DROP INDEX IDX_B0F6A6D54C83E04B ON teacher');
        $this->addSql('ALTER TABLE teacher DROP legation_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE school ADD legation_id INT NOT NULL');
        $this->addSql('ALTER TABLE school ADD CONSTRAINT FK_F99EDABB4C83E04B FOREIGN KEY (legation_id) REFERENCES legation (id)');
        $this->addSql('CREATE INDEX IDX_F99EDABB4C83E04B ON school (legation_id)');
        $this->addSql('ALTER TABLE teacher ADD legation_id INT NOT NULL');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D54C83E04B FOREIGN KEY (legation_id) REFERENCES legation (id)');
        $this->addSql('CREATE INDEX IDX_B0F6A6D54C83E04B ON teacher (legation_id)');
    }
}
