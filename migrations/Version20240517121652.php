<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240517121652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonne (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(150) NOT NULL, is_valid TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE abonne_newsletter (abonne_id INT NOT NULL, newsletter_id INT NOT NULL, INDEX IDX_E0109069C325A696 (abonne_id), INDEX IDX_E010906922DB1917 (newsletter_id), PRIMARY KEY(abonne_id, newsletter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(10) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, INDEX IDX_D4E6F8167B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, theme_id INT DEFAULT NULL, question VARCHAR(255) NOT NULL, answer LONGTEXT NOT NULL, INDEX IDX_E8FF75CC59027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(100) NOT NULL, creation_date DATETIME NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_adress_id INT NOT NULL, command_id INT DEFAULT NULL, payment_id INT DEFAULT NULL, retrait_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, zip_code VARCHAR(10) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, payment_date DATETIME DEFAULT NULL, is_paid TINYINT(1) NOT NULL, total_price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_F529939884667448 (user_adress_id), INDEX IDX_F529939833E1689A (command_id), INDEX IDX_F52993984C3A3BB (payment_id), INDEX IDX_F52993987EF8457A (retrait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_product (order_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_2530ADE68D9F6D38 (order_id), INDEX IDX_2530ADE64584665A (product_id), PRIMARY KEY(order_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, payment_type VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, source VARCHAR(200) NOT NULL, alt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, categoriser_id INT DEFAULT NULL, designation VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT NOT NULL, INDEX IDX_D34A04AD30456DDF (categoriser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_tag (product_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E3A6E39C4584665A (product_id), INDEX IDX_E3A6E39CBAD26311 (tag_id), PRIMARY KEY(product_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_picture (product_id INT NOT NULL, picture_id INT NOT NULL, INDEX IDX_C70254394584665A (product_id), INDEX IDX_C7025439EE45BDBF (picture_id), PRIMARY KEY(product_id, picture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retrait (id INT AUTO_INCREMENT NOT NULL, type_retrait VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, evaluer_id INT DEFAULT NULL, rating INT NOT NULL, message LONGTEXT DEFAULT NULL, INDEX IDX_794381C667B3B43D (users_id), INDEX IDX_794381C655A18BD3 (evaluer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_product (user_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_8B471AA7A76ED395 (user_id), INDEX IDX_8B471AA74584665A (product_id), PRIMARY KEY(user_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonne_newsletter ADD CONSTRAINT FK_E0109069C325A696 FOREIGN KEY (abonne_id) REFERENCES abonne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE abonne_newsletter ADD CONSTRAINT FK_E010906922DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F8167B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939884667448 FOREIGN KEY (user_adress_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939833E1689A FOREIGN KEY (command_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993987EF8457A FOREIGN KEY (retrait_id) REFERENCES retrait (id)');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE68D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE64584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD30456DDF FOREIGN KEY (categoriser_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_picture ADD CONSTRAINT FK_C70254394584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_picture ADD CONSTRAINT FK_C7025439EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C667B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C655A18BD3 FOREIGN KEY (evaluer_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA74584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonne_newsletter DROP FOREIGN KEY FK_E0109069C325A696');
        $this->addSql('ALTER TABLE abonne_newsletter DROP FOREIGN KEY FK_E010906922DB1917');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F8167B3B43D');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC59027487');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939884667448');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939833E1689A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984C3A3BB');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993987EF8457A');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE68D9F6D38');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE64584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD30456DDF');
        $this->addSql('ALTER TABLE product_tag DROP FOREIGN KEY FK_E3A6E39C4584665A');
        $this->addSql('ALTER TABLE product_tag DROP FOREIGN KEY FK_E3A6E39CBAD26311');
        $this->addSql('ALTER TABLE product_picture DROP FOREIGN KEY FK_C70254394584665A');
        $this->addSql('ALTER TABLE product_picture DROP FOREIGN KEY FK_C7025439EE45BDBF');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C667B3B43D');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C655A18BD3');
        $this->addSql('ALTER TABLE user_product DROP FOREIGN KEY FK_8B471AA7A76ED395');
        $this->addSql('ALTER TABLE user_product DROP FOREIGN KEY FK_8B471AA74584665A');
        $this->addSql('DROP TABLE abonne');
        $this->addSql('DROP TABLE abonne_newsletter');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE faq');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_product');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_tag');
        $this->addSql('DROP TABLE product_picture');
        $this->addSql('DROP TABLE retrait');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_product');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
