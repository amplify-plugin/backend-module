<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar;

class AddTeamsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     * @throws Exception
     */
    public function up()
    {
        $teams = config('permission.teams');
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (! $teams) {
            return;
        }

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        if (empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        if (! Schema::hasColumn($tableNames['roles'], $columnNames['team_foreign_key'])) {
            Schema::table($tableNames['roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->default(0)->after('id')->index();
                if ($this->tableHasIndexes($tableNames['roles'], 'roles_name_guard_name_unique')) {
                    $table->dropUnique('roles_name_guard_name_unique');
                }
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            });
        }

        if (! Schema::hasColumn($tableNames['model_has_permissions'], $columnNames['team_foreign_key'])) {
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->default(0)->index();
                if ($this->tableHasIndexes($tableNames['model_has_permissions'], 'model_has_permissions_permission_id_foreign')) {
                    $table->dropForeign('model_has_permissions_permission_id_foreign');
                }

                if ($this->tableHasIndexes($tableNames['model_has_permissions'], 'PRIMARY')) {
                    $table->dropPrimary();
                }
                if (! $this->tableHasIndexes($tableNames['model_has_permissions'], 't_p_m_id_m_t_primary')) {
                    $table->primary([
                        $columnNames['team_foreign_key'],
                        PermissionRegistrar::$pivotPermission,
                        $columnNames['model_morph_key'],
                        'model_type',
                    ], 't_p_m_id_m_t_primary');
                }
                if (DB::getDriverName() !== 'sqlite') {
                    $table->foreign(PermissionRegistrar::$pivotPermission)
                        ->references('id')->on($tableNames['permissions'])->onDelete('cascade');
                }
            });
        }

        if (! Schema::hasColumn($tableNames['model_has_roles'], $columnNames['team_foreign_key'])) {
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->default(0)->index();
                if ($this->tableHasIndexes($tableNames['model_has_permissions'], 'model_has_roles_role_id_foreign')) {
                    $table->dropForeign('model_has_roles_role_id_foreign');
                }
                if ($this->tableHasIndexes($tableNames['model_has_roles'], 'PRIMARY')) {
                    $table->dropPrimary();
                }

                if (! $this->tableHasIndexes($tableNames['model_has_roles'], 't_r_m_id_m_t_primary')) {
                    $table->primary([
                        $columnNames['team_foreign_key'],
                        PermissionRegistrar::$pivotRole,
                        $columnNames['model_morph_key'],
                        'model_type'], 't_r_m_id_m_t_primary');
                }
                if (DB::getDriverName() !== 'sqlite') {
                    $table->foreign(PermissionRegistrar::$pivotRole)
                        ->references('id')->on($tableNames['roles'])->onDelete('cascade');
                }
            });
        }

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}

    private function tableHasIndexes(string $tableName, string $indexKey): bool
    {
        $tableKeys = DB::select("SHOW KEYS FROM $tableName");

        foreach (($tableKeys ?? []) as $key) {
            if ($indexKey == $key->Key_name) {
                return true;
            }
        }

        return false;
    }
}
