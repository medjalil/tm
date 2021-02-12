<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209211213 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE legation ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE legation ADD CONSTRAINT FK_617F949398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_617F949398260155 ON legation (region_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE legation DROP FOREIGN KEY FK_617F949398260155');
        $this->addSql('DROP INDEX IDX_617F949398260155 ON legation');
        $this->addSql('ALTER TABLE legation DROP region_id');
    }
}
