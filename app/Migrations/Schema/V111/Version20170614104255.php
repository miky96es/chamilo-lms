<?php
/* For licensing terms, see /license.txt */

namespace Application\Migrations\Schema\V111;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add viewed_at column in gradebook_certificate table
 * It's for save timestamp about when the certificate is viewed
 */
class Version20170614104255 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $gradebookCertificate = $schema->getTable('gradebook_certificate');
        if (!$gradebookCertificate->hasColumn('viewed_at')) {
            $gradebookCertificate->addColumn('viewed_at', 'datetime', array('default' => 'null'));
        }

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $gradebookCertificate = $schema->getTable('gradebook_certificate');
        if ($gradebookCertificate->hasColumn('viewed_at')) {
            $gradebookCertificate->dropColumn('viewed_at');
        }
    }
}
