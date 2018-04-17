<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412233737 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_characteristic (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, characteristic_id INT DEFAULT NULL, INDEX IDX_146D77C4584665A (product_id), INDEX IDX_146D77CDEE9D12B (characteristic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_characteristic (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, characteristic_id INT NOT NULL, INDEX IDX_B33FEA6D12469DE2 (category_id), INDEX IDX_B33FEA6DDEE9D12B (characteristic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_characteristic ADD CONSTRAINT FK_146D77C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_characteristic ADD CONSTRAINT FK_146D77CDEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristic (id)');
        $this->addSql('ALTER TABLE category_characteristic ADD CONSTRAINT FK_B33FEA6D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category_characteristic ADD CONSTRAINT FK_B33FEA6DDEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristic (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE product_characteristic');
        $this->addSql('DROP TABLE category_characteristic');
    }
}
