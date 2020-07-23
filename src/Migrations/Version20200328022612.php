<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200328022612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE proposition CHANGE question_id question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE qcm CHANGE autheur_id autheur_id INT DEFAULT NULL, CHANGE theme_id theme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question CHANGE qcm_id qcm_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2DB4E6DF8');
        $this->addSql('DROP INDEX IDX_E7DB5DE2DB4E6DF8 ON resultat');
        $this->addSql('ALTER TABLE resultat ADD enseignant_id INT DEFAULT NULL, DROP enseigant_id, CHANGE eleve_id eleve_id INT DEFAULT NULL, CHANGE qcm_id qcm_id INT DEFAULT NULL, CHANGE realise_at realise_at DATETIME DEFAULT NULL, CHANGE note note NUMERIC(5, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E7DB5DE2E455FCC0 ON resultat (enseignant_id)');
        $this->addSql('ALTER TABLE user CHANGE nb_qcm_realises nb_qcm_realises INT DEFAULT NULL, CHANGE moyenne_qcm moyenne_qcm NUMERIC(5, 2) DEFAULT NULL, CHANGE roles roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE nb_qcn_creer nb_qcn_creer INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE proposition CHANGE question_id question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE qcm CHANGE autheur_id autheur_id INT DEFAULT NULL, CHANGE theme_id theme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question CHANGE qcm_id qcm_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2E455FCC0');
        $this->addSql('DROP INDEX IDX_E7DB5DE2E455FCC0 ON resultat');
        $this->addSql('ALTER TABLE resultat ADD enseigant_id INT DEFAULT NULL, DROP enseignant_id, CHANGE eleve_id eleve_id INT DEFAULT NULL, CHANGE qcm_id qcm_id INT DEFAULT NULL, CHANGE realise_at realise_at DATETIME DEFAULT \'NULL\', CHANGE note note NUMERIC(5, 2) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2DB4E6DF8 FOREIGN KEY (enseigant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E7DB5DE2DB4E6DF8 ON resultat (enseigant_id)');
        $this->addSql('ALTER TABLE user CHANGE nb_qcn_creer nb_qcn_creer INT DEFAULT NULL, CHANGE nb_qcm_realises nb_qcm_realises INT DEFAULT NULL, CHANGE moyenne_qcm moyenne_qcm NUMERIC(5, 2) DEFAULT \'NULL\', CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
