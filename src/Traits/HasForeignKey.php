<?php

namespace Amplify\System\Backend\Traits;

use Illuminate\Support\Facades\Schema;

trait HasForeignKey
{
    public function hasForeignKey(string $table, string $column): bool
    {
        $dbName = config('database.connections.mysql.database');
        $fkColumns = Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableForeignKeys($table, $dbName);

        return collect($fkColumns)->map(function ($fkColumn) {
            return $fkColumn->getColumns();
        })->flatten()->contains($column);
    }
}
