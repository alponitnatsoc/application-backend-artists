<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181003064513 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE song (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, length INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album (token VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, cover VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(token)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_artist (album_token VARCHAR(255) NOT NULL, artist_token VARCHAR(255) NOT NULL, INDEX IDX_D322AB30298FEB1D (album_token), INDEX IDX_D322AB303F3B9168 (artist_token), PRIMARY KEY(album_token, artist_token)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_songs (album_token VARCHAR(255) NOT NULL, song_id INT NOT NULL, INDEX IDX_CC54FBBD298FEB1D (album_token), INDEX IDX_CC54FBBDA0BDB2F3 (song_id), PRIMARY KEY(album_token, song_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (token VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(token)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB30298FEB1D FOREIGN KEY (album_token) REFERENCES album (token) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB303F3B9168 FOREIGN KEY (artist_token) REFERENCES artist (token) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_songs ADD CONSTRAINT FK_CC54FBBD298FEB1D FOREIGN KEY (album_token) REFERENCES album (token) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_songs ADD CONSTRAINT FK_CC54FBBDA0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE album_songs DROP FOREIGN KEY FK_CC54FBBDA0BDB2F3');
        $this->addSql('ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB30298FEB1D');
        $this->addSql('ALTER TABLE album_songs DROP FOREIGN KEY FK_CC54FBBD298FEB1D');
        $this->addSql('ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB303F3B9168');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_artist');
        $this->addSql('DROP TABLE album_songs');
        $this->addSql('DROP TABLE artist');
    }
}
