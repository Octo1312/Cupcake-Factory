<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260126090319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cupcake_colors (cupcake_id INT NOT NULL, colors_id INT NOT NULL, INDEX IDX_B55948E5CDD217C7 (cupcake_id), INDEX IDX_B55948E55C002039 (colors_id), PRIMARY KEY (cupcake_id, colors_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE cupcake_colors ADD CONSTRAINT FK_B55948E5CDD217C7 FOREIGN KEY (cupcake_id) REFERENCES cupcake (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cupcake_colors ADD CONSTRAINT FK_B55948E55C002039 FOREIGN KEY (colors_id) REFERENCES colors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors_cupcake ADD CONSTRAINT FK_925020725C002039 FOREIGN KEY (colors_id) REFERENCES colors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors_cupcake ADD CONSTRAINT FK_92502072CDD217C7 FOREIGN KEY (cupcake_id) REFERENCES cupcake (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CACDD217C7 FOREIGN KEY (cupcake_id) REFERENCES cupcake (id)');
        $this->addSql('ALTER TABLE cupcake ADD image_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP image, CHANGE price price INT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE cupcake ADD CONSTRAINT FK_5E582BFAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cupcake_colors DROP FOREIGN KEY FK_B55948E5CDD217C7');
        $this->addSql('ALTER TABLE cupcake_colors DROP FOREIGN KEY FK_B55948E55C002039');
        $this->addSql('DROP TABLE cupcake_colors');
        $this->addSql('ALTER TABLE colors_cupcake DROP FOREIGN KEY FK_925020725C002039');
        $this->addSql('ALTER TABLE colors_cupcake DROP FOREIGN KEY FK_92502072CDD217C7');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CAA76ED395');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CACDD217C7');
        $this->addSql('ALTER TABLE cupcake DROP FOREIGN KEY FK_5E582BFAA76ED395');
        $this->addSql('ALTER TABLE cupcake ADD image VARCHAR(255) NOT NULL, DROP image_name, DROP updated_at, CHANGE price price INT NOT NULL, CHANGE description description LONGTEXT NOT NULL');
    }
}
