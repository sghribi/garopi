<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150804102518 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE article_media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article_media (id INT NOT NULL, article_id INT DEFAULT NULL, media_id INT DEFAULT NULL, position INT NOT NULL, createdAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updatedAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, createdFromIp VARCHAR(45) DEFAULT NULL, updatedFromIp VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1D9BD31D7294869C ON article_media (article_id)');
        $this->addSql('CREATE INDEX IDX_1D9BD31DEA9FDD75 ON article_media (media_id)');
        $this->addSql('ALTER TABLE article_media ADD CONSTRAINT FK_1D9BD31D7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_media ADD CONSTRAINT FK_1D9BD31DEA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE article_media_id_seq CASCADE');
        $this->addSql('DROP TABLE article_media');
    }
}
