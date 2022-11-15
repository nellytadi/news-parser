<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115183053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE source ADD main_wrapper VARCHAR(255) NOT NULL, ADD wrapper VARCHAR(255) NOT NULL, ADD title_selector VARCHAR(255) NOT NULL, ADD description_selector VARCHAR(255) NOT NULL, ADD image_selector VARCHAR(255) NOT NULL, ADD url_selector VARCHAR(255) NOT NULL, ADD date_selector VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE source DROP main_wrapper, DROP wrapper, DROP title_selector, DROP description_selector, DROP image_selector, DROP url_selector, DROP date_selector');
    }
}
