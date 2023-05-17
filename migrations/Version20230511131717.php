<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230511131717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, rapport_medicament_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_9A9C723AC2AF5566 (rapport_medicament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_medicament (id INT AUTO_INCREMENT NOT NULL, nombre INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_visite (id INT AUTO_INCREMENT NOT NULL, visiteur_id INT DEFAULT NULL, rapport_medicament_id INT DEFAULT NULL, date_visite DATE NOT NULL, INDEX IDX_D1D741717F72333D (visiteur_id), INDEX IDX_D1D74171C2AF5566 (rapport_medicament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medicament ADD CONSTRAINT FK_9A9C723AC2AF5566 FOREIGN KEY (rapport_medicament_id) REFERENCES rapport_medicament (id)');
        $this->addSql('ALTER TABLE rapport_visite ADD CONSTRAINT FK_D1D741717F72333D FOREIGN KEY (visiteur_id) REFERENCES visiteur (id)');
        $this->addSql('ALTER TABLE rapport_visite ADD CONSTRAINT FK_D1D74171C2AF5566 FOREIGN KEY (rapport_medicament_id) REFERENCES rapport_medicament (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicament DROP FOREIGN KEY FK_9A9C723AC2AF5566');
        $this->addSql('ALTER TABLE rapport_visite DROP FOREIGN KEY FK_D1D741717F72333D');
        $this->addSql('ALTER TABLE rapport_visite DROP FOREIGN KEY FK_D1D74171C2AF5566');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE rapport_medicament');
        $this->addSql('DROP TABLE rapport_visite');
    }
}
