<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007144944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items ADD users_id INT NOT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_E11EE94D67B3B43D ON items (users_id)');
        $this->addSql('ALTER TABLE loans ADD users_id INT NOT NULL');
        $this->addSql('ALTER TABLE loans ADD CONSTRAINT FK_82C24DBC67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_82C24DBC67B3B43D ON loans (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loans DROP FOREIGN KEY FK_82C24DBC67B3B43D');
        $this->addSql('DROP INDEX IDX_82C24DBC67B3B43D ON loans');
        $this->addSql('ALTER TABLE loans DROP users_id');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D67B3B43D');
        $this->addSql('DROP INDEX IDX_E11EE94D67B3B43D ON items');
        $this->addSql('ALTER TABLE items DROP users_id');
    }
}
