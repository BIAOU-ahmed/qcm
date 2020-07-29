<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200727230042 extends AbstractMigration
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
        $this->addSql('ALTER TABLE question CHANGE qcm_id qcm_id INT DEFAULT NULL, CHANGE id_question_precedent id_question_precedent INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE reponse_eleve reponse_eleve TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE resultat CHANGE eleve_id eleve_id INT DEFAULT NULL, CHANGE qcm_id qcm_id INT DEFAULT NULL, CHANGE enseignant_id enseignant_id INT DEFAULT NULL, CHANGE realise_at realise_at DATETIME DEFAULT NULL, CHANGE note note NUMERIC(5, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE nb_qcm_realises nb_qcm_realises INT DEFAULT NULL, CHANGE moyenne_qcm moyenne_qcm NUMERIC(5, 2) DEFAULT NULL, CHANGE roles roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE nb_qcn_creer nb_qcn_creer INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE proposition CHANGE question_id question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE qcm CHANGE autheur_id autheur_id INT DEFAULT NULL, CHANGE theme_id theme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question CHANGE qcm_id qcm_id INT DEFAULT NULL, CHANGE id_question_precedent id_question_precedent INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE reponse_eleve reponse_eleve VARBINARY(255) NOT NULL');
        $this->addSql('ALTER TABLE resultat CHANGE enseignant_id enseignant_id INT DEFAULT NULL, CHANGE eleve_id eleve_id INT DEFAULT NULL, CHANGE qcm_id qcm_id INT DEFAULT NULL, CHANGE realise_at realise_at DATETIME DEFAULT \'NULL\', CHANGE note note NUMERIC(5, 2) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE nb_qcn_creer nb_qcn_creer INT DEFAULT NULL, CHANGE nb_qcm_realises nb_qcm_realises INT DEFAULT NULL, CHANGE moyenne_qcm moyenne_qcm NUMERIC(5, 2) DEFAULT \'NULL\', CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
