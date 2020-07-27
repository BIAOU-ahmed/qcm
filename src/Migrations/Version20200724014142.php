<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200724014142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE appartenir (id_user_id INT NOT NULL, id_classe_id INT NOT NULL, INDEX IDX_A2A0D90C79F37AE5 (id_user_id), INDEX IDX_A2A0D90CF6B192E (id_classe_id), PRIMARY KEY(id_user_id, id_classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, diplome VARCHAR(255) NOT NULL, periode VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposition (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, libelle_proposition LONGTEXT NOT NULL, resultat_vrai_faux INT NOT NULL, INDEX IDX_C7CDC3531E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qcm (id INT AUTO_INCREMENT NOT NULL, autheur_id INT DEFAULT NULL, theme_id INT DEFAULT NULL, libelle_qcm LONGTEXT NOT NULL, INDEX IDX_D7A1FEF4C6E59929 (autheur_id), INDEX IDX_D7A1FEF459027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, qcm_id INT DEFAULT NULL, libelle_question LONGTEXT NOT NULL, time_question TIME NOT NULL, id_question_precedent INT DEFAULT NULL, INDEX IDX_B6F7494EFF6241A6 (qcm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id_resultat_id INT NOT NULL, id_proposition_id INT NOT NULL, reponse_eleve VARBINARY(255) NOT NULL, INDEX IDX_5FB6DEC7CA2124AB (id_resultat_id), INDEX IDX_5FB6DEC730DFD298 (id_proposition_id), PRIMARY KEY(id_resultat_id, id_proposition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat (id INT AUTO_INCREMENT NOT NULL, enseignant_id INT DEFAULT NULL, eleve_id INT DEFAULT NULL, qcm_id INT DEFAULT NULL, affectted_at DATETIME NOT NULL, realise_at DATETIME DEFAULT NULL, note NUMERIC(5, 2) DEFAULT NULL, INDEX IDX_E7DB5DE2E455FCC0 (enseignant_id), INDEX IDX_E7DB5DE2A6CC7B2 (eleve_id), INDEX IDX_E7DB5DE2FF6241A6 (qcm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nb_qcn_creer INT DEFAULT NULL, nb_qcm_realises INT DEFAULT NULL, moyenne_qcm NUMERIC(5, 2) DEFAULT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90CF6B192E FOREIGN KEY (id_classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC3531E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE qcm ADD CONSTRAINT FK_D7A1FEF4C6E59929 FOREIGN KEY (autheur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE qcm ADD CONSTRAINT FK_D7A1FEF459027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EFF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7CA2124AB FOREIGN KEY (id_resultat_id) REFERENCES resultat (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC730DFD298 FOREIGN KEY (id_proposition_id) REFERENCES proposition (id)');
        $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2FF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appartenir DROP FOREIGN KEY FK_A2A0D90CF6B192E');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC730DFD298');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EFF6241A6');
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2FF6241A6');
        $this->addSql('ALTER TABLE proposition DROP FOREIGN KEY FK_C7CDC3531E27F6BF');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7CA2124AB');
        $this->addSql('ALTER TABLE qcm DROP FOREIGN KEY FK_D7A1FEF459027487');
        $this->addSql('ALTER TABLE appartenir DROP FOREIGN KEY FK_A2A0D90C79F37AE5');
        $this->addSql('ALTER TABLE qcm DROP FOREIGN KEY FK_D7A1FEF4C6E59929');
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2E455FCC0');
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2A6CC7B2');
        $this->addSql('DROP TABLE appartenir');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE qcm');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE resultat');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
    }
}
