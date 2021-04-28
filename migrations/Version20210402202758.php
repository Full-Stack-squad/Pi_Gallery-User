<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210402202758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours CHANGE idU idU INT DEFAULT NULL');
        $this->addSql('ALTER TABLE feedback CHANGE id_abonne id_abonne INT DEFAULT NULL, CHANGE id_membre id_membre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo CHANGE idU idU INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours CHANGE idU idU INT NOT NULL');
        $this->addSql('ALTER TABLE feedback CHANGE id_abonne id_abonne INT NOT NULL, CHANGE id_membre id_membre INT NOT NULL');
        $this->addSql('ALTER TABLE photo CHANGE idU idU INT NOT NULL');
    }
}
