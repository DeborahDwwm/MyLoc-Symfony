<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007142505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_E11EE94DBCF5E72D ON items (categorie_id)');
        $this->addSql('ALTER TABLE loans ADD items_id INT NOT NULL');
        $this->addSql('ALTER TABLE loans ADD CONSTRAINT FK_82C24DBC6BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id)');
        $this->addSql('CREATE INDEX IDX_82C24DBC6BB0AE84 ON loans (items_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DBCF5E72D');
        $this->addSql('DROP INDEX IDX_E11EE94DBCF5E72D ON items');
        $this->addSql('ALTER TABLE items DROP categorie_id');
        $this->addSql('ALTER TABLE loans DROP FOREIGN KEY FK_82C24DBC6BB0AE84');
        $this->addSql('DROP INDEX IDX_82C24DBC6BB0AE84 ON loans');
        $this->addSql('ALTER TABLE loans DROP items_id');
    }
}
