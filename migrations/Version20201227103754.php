<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201227103754 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salary ADD mission_id INT NOT NULL');
        $this->addSql('ALTER TABLE salary ADD CONSTRAINT FK_9413BB71BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('CREATE INDEX IDX_9413BB71BE6CAE90 ON salary (mission_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salary DROP FOREIGN KEY FK_9413BB71BE6CAE90');
        $this->addSql('DROP INDEX IDX_9413BB71BE6CAE90 ON salary');
        $this->addSql('ALTER TABLE salary DROP mission_id');
    }
}
