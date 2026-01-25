<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260125160518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentary (id INT AUTO_INCREMENT NOT NULL, texte LONGTEXT NOT NULL, user_id INT DEFAULT NULL, cupcake_id INT DEFAULT NULL, INDEX IDX_1CAC12CAA76ED395 (user_id), INDEX IDX_1CAC12CACDD217C7 (cupcake_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CACDD217C7 FOREIGN KEY (cupcake_id) REFERENCES cupcake (id)');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('ALTER TABLE colors_cupcake ADD CONSTRAINT FK_925020725C002039 FOREIGN KEY (colors_id) REFERENCES colors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors_cupcake ADD CONSTRAINT FK_92502072CDD217C7 FOREIGN KEY (cupcake_id) REFERENCES cupcake (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cupcake ADD CONSTRAINT FK_5E582BFAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, texte VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, user_id INT DEFAULT NULL, cupcake_id INT DEFAULT NULL, INDEX IDX_67F068BCA76ED395 (user_id), INDEX IDX_67F068BCCDD217C7 (cupcake_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CAA76ED395');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CACDD217C7');
        $this->addSql('DROP TABLE commentary');
        $this->addSql('ALTER TABLE colors_cupcake DROP FOREIGN KEY FK_925020725C002039');
        $this->addSql('ALTER TABLE colors_cupcake DROP FOREIGN KEY FK_92502072CDD217C7');
        $this->addSql('ALTER TABLE cupcake DROP FOREIGN KEY FK_5E582BFAA76ED395');
    }
}
