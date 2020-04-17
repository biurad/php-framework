<?php

/**
 * {project-name}
 *
 * author {author-name}
 */

declare(strict_types=1);

namespace App\Migrations;

use BiuradPHP\Database\Migration\Migration;

class CreateCacheTableMigration extends Migration
{
    /** Target migration database */
    protected const DATABASE = 'runtime';

    /**
     * Create tables, add columns or insert data here
     */
    public function up(): void
    {
        $this->table('caching')
            ->addColumn('id', 'text')
            ->setPrimaryKeys(['id'])
            ->addColumn('data', 'binary')
            ->addColumn('expire', 'integer')
            ->create()
        ;
    }

    /**
     * Drop created, columns and etc here
     */
    public function down(): void
    {
        $this->table('caching')->drop();
    }
}
