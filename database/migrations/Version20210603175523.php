<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20210603175523 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, role_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_39986E434E7AF8F (gallery_id), INDEX IDX_39986E43D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE background (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) DEFAULT NULL, colors LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, number INT DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, stitch_count INT DEFAULT NULL, fancy TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_665648E993CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, order_item_id INT DEFAULT NULL, user_id INT DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9474526C8D9F6D38 (order_id), INDEX IDX_9474526CE415FB15 (order_item_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, folder_id INT DEFAULT NULL, background_id INT DEFAULT NULL, order_id INT DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, color_count INT DEFAULT NULL, stitch_count INT DEFAULT NULL, diameter DOUBLE PRECISION DEFAULT NULL, svg VARCHAR(255) DEFAULT NULL, bytes LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_8C9F3610162CB942 (folder_id), INDEX IDX_8C9F3610C93D69EA (background_id), INDEX IDX_8C9F36108D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE folder (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_ECA209CD727ACA70 (parent_id), INDEX IDX_ECA209CD7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_472B783AD60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, album_id INT DEFAULT NULL, user_id INT DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_C53D045F1137ABCF (album_id), INDEX IDX_C53D045FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE machine (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, role_id INT DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, current_stitch INT DEFAULT NULL, stitch_count INT DEFAULT NULL, current_design INT DEFAULT NULL, design_count INT DEFAULT NULL, stitches LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', width DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, horizontal_offset DOUBLE PRECISION DEFAULT NULL, vertical_offset DOUBLE PRECISION DEFAULT NULL, seconds_passed INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_1505DF8493CB796C (file_id), INDEX IDX_1505DF84D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_item (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content VARCHAR(255) DEFAULT NULL, alert TINYINT(1) NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_CAC6D395D60322AC (role_id), INDEX IDX_CAC6D395A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, approved_by INT DEFAULT NULL, temp_user_id INT DEFAULT NULL, reported_by INT DEFAULT NULL, user_id INT DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, payment_type VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, album_publicity TINYINT(1) NOT NULL, joint TINYINT(1) NOT NULL, help_needed TINYINT(1) NOT NULL, deadline DATETIME DEFAULT NULL, estimated_completion_date DATETIME DEFAULT NULL, marked_as_spam TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_F52993984EA3CB3D (approved_by), INDEX IDX_F52993981FA4E70A (temp_user_id), INDEX IDX_F5299398144F5BA4 (reported_by), INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_image (id INT AUTO_INCREMENT NOT NULL, order_item_id INT DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_46A370A2E415FB15 (order_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, folder_id INT DEFAULT NULL, dst_file_id INT DEFAULT NULL, test_album_id INT DEFAULT NULL, marked_as_spam_by INT DEFAULT NULL, order_id INT DEFAULT NULL, quantity INT DEFAULT NULL, deadline DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, size VARCHAR(255) DEFAULT NULL, font VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, state VARCHAR(255) NOT NULL, original_design TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_52EA1F09162CB942 (folder_id), INDEX IDX_52EA1F09B91ABF6C (dst_file_id), INDEX IDX_52EA1F098454A099 (test_album_id), INDEX IDX_52EA1F09582FBFC6 (marked_as_spam_by), INDEX IDX_52EA1F098D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting (id INT AUTO_INCREMENT NOT NULL, setting VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slide (id INT AUTO_INCREMENT NOT NULL, image_path VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, number INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temporary_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, project_folder_id INT DEFAULT NULL, role_id INT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, internal_id VARCHAR(255) DEFAULT NULL, in_club TINYINT(1) NOT NULL, activated TINYINT(1) NOT NULL, activate_token VARCHAR(255) DEFAULT NULL, allow_emails TINYINT(1) NOT NULL, notifications_disabled TINYINT(1) NOT NULL, sticky_role TINYINT(1) NOT NULL, remember_token VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8D93D649710FC95 (project_folder_id), INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E434E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE color ADD CONSTRAINT FK_665648E993CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CE415FB15 FOREIGN KEY (order_item_id) REFERENCES order_item (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610C93D69EA FOREIGN KEY (background_id) REFERENCES background (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36108D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CD727ACA70 FOREIGN KEY (parent_id) REFERENCES folder (id)');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CD7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783AD60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF8493CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF84D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE news_item ADD CONSTRAINT FK_CAC6D395D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE news_item ADD CONSTRAINT FK_CAC6D395A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984EA3CB3D FOREIGN KEY (approved_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981FA4E70A FOREIGN KEY (temp_user_id) REFERENCES temporary_user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398144F5BA4 FOREIGN KEY (reported_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_image ADD CONSTRAINT FK_46A370A2E415FB15 FOREIGN KEY (order_item_id) REFERENCES order_item (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09B91ABF6C FOREIGN KEY (dst_file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098454A099 FOREIGN KEY (test_album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09582FBFC6 FOREIGN KEY (marked_as_spam_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649710FC95 FOREIGN KEY (project_folder_id) REFERENCES folder (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F1137ABCF');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098454A099');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610C93D69EA');
        $this->addSql('ALTER TABLE color DROP FOREIGN KEY FK_665648E993CB796C');
        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF8493CB796C');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09B91ABF6C');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610162CB942');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CD727ACA70');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09162CB942');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649710FC95');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E434E7AF8F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8D9F6D38');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36108D9F6D38');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098D9F6D38');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CE415FB15');
        $this->addSql('ALTER TABLE order_image DROP FOREIGN KEY FK_46A370A2E415FB15');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43D60322AC');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783AD60322AC');
        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF84D60322AC');
        $this->addSql('ALTER TABLE news_item DROP FOREIGN KEY FK_CAC6D395D60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993981FA4E70A');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CD7E3C61F9');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA76ED395');
        $this->addSql('ALTER TABLE news_item DROP FOREIGN KEY FK_CAC6D395A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984EA3CB3D');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398144F5BA4');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09582FBFC6');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE background');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE folder');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE machine');
        $this->addSql('DROP TABLE news_item');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_image');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE slide');
        $this->addSql('DROP TABLE temporary_user');
        $this->addSql('DROP TABLE user');
    }
}
