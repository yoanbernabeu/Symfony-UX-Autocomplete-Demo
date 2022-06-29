<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629183501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE choix_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE multiple_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE simple_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE choix (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE multiple (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE multiple_choix (multiple_id INT NOT NULL, choix_id INT NOT NULL, PRIMARY KEY(multiple_id, choix_id))');
        $this->addSql('CREATE INDEX IDX_D9CDBEADAEDC4C7D ON multiple_choix (multiple_id)');
        $this->addSql('CREATE INDEX IDX_D9CDBEADD9144651 ON multiple_choix (choix_id)');
        $this->addSql('CREATE TABLE simple (id INT NOT NULL, choix_id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C17B3D02D9144651 ON simple (choix_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE multiple_choix ADD CONSTRAINT FK_D9CDBEADAEDC4C7D FOREIGN KEY (multiple_id) REFERENCES multiple (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multiple_choix ADD CONSTRAINT FK_D9CDBEADD9144651 FOREIGN KEY (choix_id) REFERENCES choix (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE simple ADD CONSTRAINT FK_C17B3D02D9144651 FOREIGN KEY (choix_id) REFERENCES choix (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE multiple_choix DROP CONSTRAINT FK_D9CDBEADD9144651');
        $this->addSql('ALTER TABLE simple DROP CONSTRAINT FK_C17B3D02D9144651');
        $this->addSql('ALTER TABLE multiple_choix DROP CONSTRAINT FK_D9CDBEADAEDC4C7D');
        $this->addSql('DROP SEQUENCE choix_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE multiple_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE simple_id_seq CASCADE');
        $this->addSql('DROP TABLE choix');
        $this->addSql('DROP TABLE multiple');
        $this->addSql('DROP TABLE multiple_choix');
        $this->addSql('DROP TABLE simple');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
