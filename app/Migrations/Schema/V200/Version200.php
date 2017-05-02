<?php
/* For licensing terms, see /license.txt */

namespace Application\Migrations\Schema\V200;

use Application\Migrations\AbstractMigrationChamilo;
use Doctrine\DBAL\Schema\Schema;
use \Doctrine\DBAL\Types\Type;

/**
 * Class Version200
 *
 * Migrate file to updated to Chamilo 2.0.0
 *
 * @package Application\Migrations\Schema\V200
 */
class Version200 extends AbstractMigrationChamilo
{
    /**
     * @param Schema $schema
     */
    public function preUp(Schema $schema)
    {

    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema)
    {
        // Use $schema->createTable
        $this->addSql('set sql_mode=""');
        $this->addSql('ALTER TABLE access_url_rel_user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE access_url_rel_session DROP PRIMARY KEY');

        $this->addSql('CREATE TABLE page__page (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, target_id INT DEFAULT NULL, route_name VARCHAR(255) NOT NULL, page_alias VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, position INT NOT NULL, enabled TINYINT(1) NOT NULL, decorate TINYINT(1) NOT NULL, edited TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, slug LONGTEXT DEFAULT NULL, url LONGTEXT DEFAULT NULL, custom_url LONGTEXT DEFAULT NULL, request_method VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, meta_keyword VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, javascript LONGTEXT DEFAULT NULL, stylesheet LONGTEXT DEFAULT NULL, raw_headers LONGTEXT DEFAULT NULL, template VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2FAE39EDF6BD1646 (site_id), INDEX IDX_2FAE39ED727ACA70 (parent_id), INDEX IDX_2FAE39ED158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE page__site (id INT AUTO_INCREMENT NOT NULL, enabled TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, relative_path VARCHAR(255) DEFAULT NULL, host VARCHAR(255) NOT NULL, enabled_from DATETIME DEFAULT NULL, enabled_to DATETIME DEFAULT NULL, is_default TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, locale VARCHAR(6) DEFAULT NULL, title VARCHAR(64) DEFAULT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page__snapshot (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, page_id INT DEFAULT NULL, route_name VARCHAR(255) NOT NULL, page_alias VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, position INT NOT NULL, enabled TINYINT(1) NOT NULL, decorate TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, url LONGTEXT DEFAULT NULL, parent_id INT DEFAULT NULL, target_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL COMMENT "(DC2Type:json)", publication_date_start DATETIME DEFAULT NULL, publication_date_end DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3963EF9AF6BD1646 (site_id), INDEX IDX_3963EF9AC4663E4 (page_id), INDEX idx_snapshot_dates_enabled (publication_date_start, publication_date_end, enabled), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE page__bloc (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, page_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(64) NOT NULL, settings LONGTEXT NOT NULL COMMENT "(DC2Type:json)", enabled TINYINT(1) DEFAULT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FCDC1A97727ACA70 (parent_id), INDEX IDX_FCDC1A97C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE timeline__timeline (id INT AUTO_INCREMENT NOT NULL, action_id INT DEFAULT NULL, subject_id INT DEFAULT NULL, context VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_FFBC6AD59D32F035 (action_id), INDEX IDX_FFBC6AD523EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE timeline__component (id INT AUTO_INCREMENT NOT NULL, model VARCHAR(255) NOT NULL, identifier LONGTEXT NOT NULL COMMENT "(DC2Type:array)", hash VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1B2F01CDD1B862B8 (hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE timeline__action (id INT AUTO_INCREMENT NOT NULL, verb VARCHAR(255) NOT NULL, status_current VARCHAR(255) NOT NULL, status_wanted VARCHAR(255) NOT NULL, duplicate_key VARCHAR(255) DEFAULT NULL, duplicate_priority INT DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE timeline__action_component (id INT AUTO_INCREMENT NOT NULL, action_id INT DEFAULT NULL, component_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, text VARCHAR(255) DEFAULT NULL, INDEX IDX_6ACD1B169D32F035 (action_id), INDEX IDX_6ACD1B16E2ABAFFF (component_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE classification__tag (id INT AUTO_INCREMENT NOT NULL, context VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CA57A1C7E25D857E (context), UNIQUE INDEX tag_context (slug, context), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE classification__collection (id INT AUTO_INCREMENT NOT NULL, context VARCHAR(255) DEFAULT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A406B56AE25D857E (context), INDEX IDX_A406B56AEA9FDD75 (media_id), UNIQUE INDEX tag_collection (slug, context), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE classification__context (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE classification__category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, context VARCHAR(255) DEFAULT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_43629B36727ACA70 (parent_id), INDEX IDX_43629B36E25D857E (context), INDEX IDX_43629B36EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE media__gallery_media (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, media_id INT DEFAULT NULL, position INT NOT NULL, enabled TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_80D4C5414E7AF8F (gallery_id), INDEX IDX_80D4C541EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE media__gallery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, context VARCHAR(64) NOT NULL, default_format VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE media__media (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, enabled TINYINT(1) NOT NULL, provider_name VARCHAR(255) NOT NULL, provider_status INT NOT NULL, provider_reference VARCHAR(255) NOT NULL, provider_metadata LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', width INT DEFAULT NULL, height INT DEFAULT NULL, length NUMERIC(10, 0) DEFAULT NULL, content_type VARCHAR(255) DEFAULT NULL, content_size INT DEFAULT NULL, copyright VARCHAR(255) DEFAULT NULL, author_name VARCHAR(255) DEFAULT NULL, context VARCHAR(64) DEFAULT NULL, cdn_is_flushable TINYINT(1) DEFAULT NULL, cdn_flush_identifier VARCHAR(64) DEFAULT NULL, cdn_flush_at DATETIME DEFAULT NULL, cdn_status INT DEFAULT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5C6DD74E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE faq_question_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, headline VARCHAR(255) NOT NULL, body LONGTEXT DEFAULT NULL, slug VARCHAR(50) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_C2D1A2C2AC5D3 (translatable_id), UNIQUE INDEX faq_question_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE faq_category_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, headline VARCHAR(255) NOT NULL, body LONGTEXT DEFAULT NULL, slug VARCHAR(50) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_5493B0FC2C2AC5D3 (translatable_id), UNIQUE INDEX faq_category_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE faq_category (id INT AUTO_INCREMENT NOT NULL, rank INT NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx (is_active), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE faq_question (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, rank INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, only_auth_users TINYINT(1) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_4A55B05912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE contact_category_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_3E770F302C2AC5D3 (translatable_id), UNIQUE INDEX contact_category_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('CREATE TABLE contact_category (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
        $this->addSql('ALTER TABLE page__bloc ADD CONSTRAINT FK_FCDC1A97727ACA70 FOREIGN KEY (parent_id) REFERENCES page__bloc (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE page__bloc ADD CONSTRAINT FK_FCDC1A97C4663E4 FOREIGN KEY (page_id) REFERENCES page__page (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE timeline__timeline ADD CONSTRAINT FK_FFBC6AD59D32F035 FOREIGN KEY (action_id) REFERENCES timeline__action (id);');
        $this->addSql('ALTER TABLE timeline__timeline ADD CONSTRAINT FK_FFBC6AD523EDC87 FOREIGN KEY (subject_id) REFERENCES timeline__component (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE timeline__action_component ADD CONSTRAINT FK_6ACD1B169D32F035 FOREIGN KEY (action_id) REFERENCES timeline__action (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE timeline__action_component ADD CONSTRAINT FK_6ACD1B16E2ABAFFF FOREIGN KEY (component_id) REFERENCES timeline__component (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE classification__tag ADD CONSTRAINT FK_CA57A1C7E25D857E FOREIGN KEY (context) REFERENCES classification__context (id);');
        $this->addSql('ALTER TABLE classification__collection ADD CONSTRAINT FK_A406B56AE25D857E FOREIGN KEY (context) REFERENCES classification__context (id);');
        $this->addSql('ALTER TABLE classification__collection ADD CONSTRAINT FK_A406B56AEA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) ON DELETE SET NULL;');
        $this->addSql('ALTER TABLE classification__category ADD CONSTRAINT FK_43629B36727ACA70 FOREIGN KEY (parent_id) REFERENCES classification__category (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE classification__category ADD CONSTRAINT FK_43629B36E25D857E FOREIGN KEY (context) REFERENCES classification__context (id);');
        $this->addSql('ALTER TABLE classification__category ADD CONSTRAINT FK_43629B36EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) ON DELETE SET NULL;');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C5414E7AF8F FOREIGN KEY (gallery_id) REFERENCES media__gallery (id);');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C541EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id);');
        $this->addSql('ALTER TABLE media__media ADD CONSTRAINT FK_5C6DD74E12469DE2 FOREIGN KEY (category_id) REFERENCES classification__category (id) ON DELETE SET NULL;');

        $this->addSql('ALTER TABLE faq_question_translation ADD CONSTRAINT FK_C2D1A2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES faq_question (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE faq_category_translation ADD CONSTRAINT FK_5493B0FC2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES faq_category (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE faq_question ADD CONSTRAINT FK_4A55B05912469DE2 FOREIGN KEY (category_id) REFERENCES faq_category (id);');
        $this->addSql('ALTER TABLE contact_category_translation ADD CONSTRAINT FK_3E770F302C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES contact_category (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE page__page ADD CONSTRAINT FK_2FAE39EDF6BD1646 FOREIGN KEY (site_id) REFERENCES page__site (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE page__page ADD CONSTRAINT FK_2FAE39ED727ACA70 FOREIGN KEY (parent_id) REFERENCES page__page (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE page__page ADD CONSTRAINT FK_2FAE39ED158E0B66 FOREIGN KEY (target_id) REFERENCES page__page (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE page__snapshot ADD CONSTRAINT FK_3963EF9AF6BD1646 FOREIGN KEY (site_id) REFERENCES page__site (id) ON DELETE CASCADE;');
        $this->addSql('ALTER TABLE page__snapshot ADD CONSTRAINT FK_3963EF9AC4663E4 FOREIGN KEY (page_id) REFERENCES page__page (id) ON DELETE CASCADE;');

        $this->addSql('ALTER TABLE fos_group ADD name VARCHAR(255) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT "(DC2Type:array)";');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4B019DDB5E237E06 ON fos_group (name);');

        $this->addSql('ALTER TABLE gradebook_evaluation ADD c_id INT DEFAULT NULL');
        $this->addSql("UPDATE gradebook_evaluation SET c_id = (SELECT id FROM course WHERE code = course_code)");
        $this->addSql('ALTER TABLE gradebook_evaluation DROP course_code');
        $this->addSql('ALTER TABLE gradebook_evaluation ADD CONSTRAINT FK_DDDED80491D79BD3 FOREIGN KEY (c_id) REFERENCES course (id);');
        $this->addSql('CREATE INDEX IDX_DDDED80491D79BD3 ON gradebook_evaluation (c_id)');
        $this->addSql('ALTER TABLE gradebook_evaluation RENAME INDEX fk_ddded80491d79bd3 TO IDX_DDDED80491D79BD3;');

        $this->addSql('ALTER TABLE gradebook_category ADD c_id INT DEFAULT NULL');
        $this->addSql('UPDATE gradebook_category SET c_id = (SELECT id FROM course WHERE code = course_code)');
        $this->addSql('ALTER TABLE gradebook_category DROP course_code');

        $this->addSql('ALTER TABLE gradebook_category ADD CONSTRAINT FK_96A4C70591D79BD3 FOREIGN KEY (c_id) REFERENCES course (id);');
        $this->addSql('CREATE INDEX IDX_96A4C70591D79BD3 ON gradebook_category (c_id);');

        $this->addSql('ALTER TABLE gradebook_link ADD c_id INT DEFAULT NULL');
        $this->addSql('UPDATE gradebook_link SET c_id = (SELECT id FROM course WHERE code = course_code)');
        $this->addSql('ALTER TABLE gradebook_link DROP course_code');
        $this->addSql('ALTER TABLE gradebook_link ADD CONSTRAINT FK_4F0F595F91D79BD3 FOREIGN KEY (c_id) REFERENCES course (id);');
        $this->addSql('CREATE INDEX IDX_4F0F595F91D79BD3 ON gradebook_link (c_id);');

        $this->addSql('ALTER TABLE access_url_rel_user ADD id INT AUTO_INCREMENT NOT NULL, CHANGE access_url_id access_url_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, ADD PRIMARY KEY (id);');
        $this->addSql('ALTER TABLE access_url ADD limit_courses INT DEFAULT NULL, ADD limit_active_courses INT DEFAULT NULL, ADD limit_sessions INT DEFAULT NULL, ADD limit_users INT DEFAULT NULL, ADD limit_teachers INT DEFAULT NULL, ADD limit_disk_space INT DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL;');

        $this->addSql('ALTER TABLE course_request CHANGE user_id user_id INT DEFAULT NULL;');
        $this->addSql('ALTER TABLE course_request ADD CONSTRAINT FK_33548A73A76ED395 FOREIGN KEY (user_id) REFERENCES user (id);');
        $this->addSql('CREATE INDEX IDX_33548A73A76ED395 ON course_request (user_id);');

        $this->addSql('ALTER TABLE search_engine_ref ADD c_id INT DEFAULT NULL');
        $this->addSql('UPDATE search_engine_ref SET c_id = (SELECT id FROM course WHERE code = course_code)');
        $this->addSql('ALTER TABLE search_engine_ref DROP course_code');

        $this->addSql('ALTER TABLE search_engine_ref ADD CONSTRAINT FK_473F037891D79BD3 FOREIGN KEY (c_id) REFERENCES course (id);');
        $this->addSql('CREATE INDEX IDX_473F037891D79BD3 ON search_engine_ref (c_id);');

        $this->addSql('ALTER TABLE course_category CHANGE parent_id parent_id INT DEFAULT NULL;');
        $this->addSql('ALTER TABLE course_category ADD CONSTRAINT FK_AFF87497727ACA70 FOREIGN KEY (parent_id) REFERENCES course_category (id);');
        $this->addSql('ALTER TABLE settings_current ADD CONSTRAINT FK_62F79C3B9436187B FOREIGN KEY (access_url) REFERENCES access_url (id);');

        $this->addSql('ALTER TABLE access_url_rel_session ADD id INT AUTO_INCREMENT NOT NULL, CHANGE access_url_id access_url_id INT DEFAULT NULL, CHANGE session_id session_id INT DEFAULT NULL, ADD PRIMARY KEY (id);');
        $this->addSql('ALTER TABLE access_url_rel_session ADD CONSTRAINT FK_6CBA5F5D613FECDF FOREIGN KEY (session_id) REFERENCES session (id);');
        $this->addSql('ALTER TABLE access_url_rel_session ADD CONSTRAINT FK_6CBA5F5D73444FD5 FOREIGN KEY (access_url_id) REFERENCES access_url (id);');
        $this->addSql('CREATE INDEX IDX_6CBA5F5D613FECDF ON access_url_rel_session (session_id);');
        $this->addSql('CREATE INDEX IDX_6CBA5F5D73444FD5 ON access_url_rel_session (access_url_id);');

        $this->addSql('ALTER TABLE c_tool ADD CONSTRAINT FK_8456658091D79BD3 FOREIGN KEY (c_id) REFERENCES course (id)');

        $this->addSql('CREATE INDEX notification_message_state_idx ON notification__message (state);');
        $this->addSql('CREATE INDEX notification_message_created_at_idx ON notification__message (created_at);');
        $this->addSql('DROP INDEX user_sco_course_sv ON track_stored_values;');
        $this->addSql('DROP INDEX user_sco_course_sv_stack ON track_stored_values_stack;');

        $this->addSql('UPDATE c_tool SET name = "blog" WHERE name = "blog_management" ');
        $this->addSql('UPDATE c_tool SET name = "agenda" WHERE name = "calendar_event" ');
        $this->addSql('UPDATE c_tool SET name = "maintenance" WHERE name = "course_maintenance" ');
        $this->addSql('UPDATE c_tool SET name = "assignment" WHERE name = "student_publication" ');
        $this->addSql('UPDATE c_tool SET name = "settings" WHERE name = "course_setting" ');

        $this->addSql('UPDATE session_category SET date_start = NULL WHERE date_start = "0000-00-00"');
        $this->addSql('UPDATE session_category SET date_end = NULL WHERE date_end = "0000-00-00"');

        $table = $schema->getTable('message');
        if (!$table->hasIndex('idx_message_user_receiver_status')) {
            $this->addSql('CREATE INDEX idx_message_user_receiver_status ON message (user_receiver_id, msg_status)');
        }

        if (!$table->hasIndex('idx_message_receiver_status_send_date')) {
            $this->addSql('CREATE INDEX idx_message_receiver_status_send_date ON message (user_receiver_id, msg_status, send_date)');
        }

        $table = $schema->getTable('track_e_course_access');
        if (!$table->hasIndex('user_course_session_date')) {
            $this->addSql(
                'CREATE INDEX user_course_session_date ON track_e_course_access (user_id, c_id, session_id, login_course_date)'
            );
        }

        $table = $schema->getTable('c_quiz_answer');
        if (!$table->hasIndex('c_id_auto')) {
            $this->addSql('CREATE INDEX c_id_auto ON c_quiz_answer (c_id, id_auto)');
        }

        $table = $schema->getTable('c_forum_post');
        if (!$table->hasIndex('c_id_visible_post_date')) {
            $this->addSql('CREATE INDEX c_id_visible_post_date ON c_forum_post (c_id, visible, post_date)');
        }

        $table = $schema->getTable('track_e_access');
        if (!$table->hasIndex('user_course_session_date')) {
            $this->addSql('CREATE INDEX user_course_session_date ON track_e_access (access_user_id, c_id, access_session_id, access_date)');
        }

         // Update iso
        $sql = "UPDATE course SET course_language = (SELECT isocode FROM language WHERE english_name = course_language);";
        $this->addSql($sql);

        $sql = "UPDATE sys_announcement SET lang = (SELECT isocode FROM language WHERE english_name = lang);";
        $this->addSql($sql);
        $this->addSql('ALTER TABLE c_tool_intro CHANGE id tool VARCHAR(255) NOT NULL');

        $this->addSql('ALTER TABLE user ADD facebook_id VARCHAR(255) DEFAULT NULL, ADD facebook_access_token VARCHAR(255) DEFAULT NULL, ADD google_id VARCHAR(255) DEFAULT NULL, ADD google_access_token VARCHAR(255) DEFAULT NULL, ADD github_id VARCHAR(255) DEFAULT NULL, ADD github_access_token VARCHAR(255) DEFAULT NULL;');
        $this->addSql('ALTER TABLE c_item_property CHANGE lastedit_user_id lastedit_user_id INT DEFAULT NULL');


        // Fixes missing options show_glossary_in_extra_tools
        $this->addSql("DELETE FROM settings_options WHERE variable = 'show_glossary_in_extra_tools'");

        $this->addSql("INSERT INTO settings_options (variable, value, display_text) VALUES ('show_glossary_in_extra_tools', 'none', 'None')");
        $this->addSql("INSERT INTO settings_options (variable, value, display_text) VALUES ('show_glossary_in_extra_tools', 'exercise', 'Exercise')");
        $this->addSql("INSERT INTO settings_options (variable, value, display_text) VALUES ('show_glossary_in_extra_tools', 'lp', 'Learning path')");
        $this->addSql("INSERT INTO settings_options (variable, value, display_text) VALUES ('show_glossary_in_extra_tools', 'exercise_and_lp', 'ExerciseAndLearningPath')");

        $this->addSql("ALTER TABLE c_quiz_question_category CHANGE description description LONGTEXT DEFAULT NULL;");

    }

    /**
     * We don't allow downgrades yet
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
