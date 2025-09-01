<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The list of tables to modify.
     *
     * @var string[]
     */
    protected $tables = [
        'products',
        'carts',
        'customers',
        'manufacturers',
        'salesperson',
        'shippings',
        'warehouses',
    ];

    public function up()
    {
        // 1) Create companies table if needed
        if (! Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name');
                $table->string('order_source')->nullable();
                $table->string('order_source_flag', 1);
                $table->string('order_hold_code')->nullable();
                $table->string('review_hold_code')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // 2) Seed (or update) default company so FK defaults resolve
        $defaultName = config('app.name', 'Default Company');
        $defaultCode = '1';

        DB::table('companies')->updateOrInsert(
            ['id' => 1],
            [
                'code' => $defaultCode,
                'name' => $defaultName,
                'order_source_flag' => '0',
                'active' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 3) Add company_id FK to each table
        foreach ($this->tables as $tbl) {
            if (! Schema::hasColumn($tbl, 'company_id')) {
                Schema::table($tbl, function (Blueprint $table) {
                    $table->foreignId('company_id')
                        ->default(1)
                        ->constrained('companies')
                        ->cascadeOnUpdate()
                        ->restrictOnDelete()
                        ->after('id');
                });
            }
        }
    }

    public function down()
    {
        // 1) Drop each FK+column
        foreach ($this->tables as $tbl) {
            if (Schema::hasColumn($tbl, 'company_id')) {
                Schema::table($tbl, function (Blueprint $table) {
                    // dropConstrainedForeignId will drop the FK and the column
                    $table->dropConstrainedForeignId('company_id');
                });
            }
        }

        // 2) Drop companies table
        Schema::dropIfExists('companies');
    }
};
