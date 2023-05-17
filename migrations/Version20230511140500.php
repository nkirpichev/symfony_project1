<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230511140500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_medicament ADD rapportvisite_id INT DEFAULT NULL, ADD medicaments_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport_medicament ADD CONSTRAINT FK_3323BE4B3BC579BB FOREIGN KEY (rapportvisite_id) REFERENCES rapport_visite (id)');
        $this->addSql('ALTER TABLE rapport_medicament ADD CONSTRAINT FK_3323BE4BC403D7FB FOREIGN KEY (medicaments_id) REFERENCES medicament (id)');
        $this->addSql('CREATE INDEX IDX_3323BE4B3BC579BB ON rapport_medicament (rapportvisite_id)');
        $this->addSql('CREATE INDEX IDX_3323BE4BC403D7FB ON rapport_medicament (medicaments_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_medicament DROP FOREIGN KEY FK_3323BE4B3BC579BB');
        $this->addSql('ALTER TABLE rapport_medicament DROP FOREIGN KEY FK_3323BE4BC403D7FB');
        $this->addSql('DROP INDEX IDX_3323BE4B3BC579BB ON rapport_medicament');
        $this->addSql('DROP INDEX IDX_3323BE4BC403D7FB ON rapport_medicament');
        $this->addSql('ALTER TABLE rapport_medicament DROP rapportvisite_id, DROP medicaments_id');
    }
}
