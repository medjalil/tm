<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209115402 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02344C83E04B');
        $this->addSql('DROP INDEX IDX_2D5B02344C83E04B ON city');
        $this->addSql('ALTER TABLE city DROP legation_id');
        $this->addSql('ALTER TABLE legation DROP FOREIGN KEY FK_617F949398260155');
        $this->addSql('DROP INDEX IDX_617F949398260155 ON legation');
        $this->addSql('ALTER TABLE legation DROP region_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494C83E04B');
        $this->addSql('DROP INDEX IDX_8D93D6494C83E04B ON user');
        $this->addSql('ALTER TABLE user DROP legation_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city ADD legation_id INT NOT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02344C83E04B FOREIGN KEY (legation_id) REFERENCES legation (id)');
        $this->addSql('CREATE INDEX IDX_2D5B02344C83E04B ON city (legation_id)');
        $this->addSql('ALTER TABLE legation ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE legation ADD CONSTRAINT FK_617F949398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_617F949398260155 ON legation (region_id)');
        $this->addSql('ALTER TABLE `user` ADD legation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6494C83E04B FOREIGN KEY (legation_id) REFERENCES legation (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494C83E04B ON `user` (legation_id)');
    }
}
