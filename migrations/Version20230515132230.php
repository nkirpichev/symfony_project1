<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515132230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visiteur_region ADD id INT AUTO_INCREMENT NOT NULL, ADD date_visite DATE NOT NULL, CHANGE visiteur_id visiteur_id INT DEFAULT NULL, CHANGE region_id region_id INT DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE visiteur_region ADD CONSTRAINT FK_25720CBA7F72333D FOREIGN KEY (visiteur_id) REFERENCES visiteur (id)');
        $this->addSql('ALTER TABLE visiteur_region ADD CONSTRAINT FK_25720CBA98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_25720CBA7F72333D ON visiteur_region (visiteur_id)');
        $this->addSql('CREATE INDEX IDX_25720CBA98260155 ON visiteur_region (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visiteur_region MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE visiteur_region DROP FOREIGN KEY FK_25720CBA7F72333D');
        $this->addSql('ALTER TABLE visiteur_region DROP FOREIGN KEY FK_25720CBA98260155');
        $this->addSql('DROP INDEX IDX_25720CBA7F72333D ON visiteur_region');
        $this->addSql('DROP INDEX IDX_25720CBA98260155 ON visiteur_region');
        $this->addSql('DROP INDEX `primary` ON visiteur_region');
        $this->addSql('ALTER TABLE visiteur_region DROP id, DROP date_visite, CHANGE visiteur_id visiteur_id INT NOT NULL, CHANGE region_id region_id INT NOT NULL');
    }
}
