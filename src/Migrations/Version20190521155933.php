<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190521155933 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE invoice_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_196443995E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174412469DE2 FOREIGN KEY (category_id) REFERENCES invoice_category (id)');
        $this->addSql('CREATE INDEX IDX_9065174412469DE2 ON invoice (category_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E095E237E06 ON customer (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7B61A1F65E237E06 ON payment_method (name)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_9065174412469DE2');
        $this->addSql('DROP TABLE invoice_category');
        $this->addSql('DROP INDEX UNIQ_81398E095E237E06 ON customer');
        $this->addSql('DROP INDEX IDX_9065174412469DE2 ON invoice');
        $this->addSql('ALTER TABLE invoice DROP category_id');
        $this->addSql('DROP INDEX UNIQ_7B61A1F65E237E06 ON payment_method');
    }
}
