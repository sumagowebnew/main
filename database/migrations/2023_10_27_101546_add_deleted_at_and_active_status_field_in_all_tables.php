<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            $columns = 'Tables_in_' . env('DB_DATABASE');//This is just to read the object by its key, DB_DATABASE is database name.
            $tables = DB::select('SHOW TABLES');
    
            foreach ( $tables as $table ) {
                //todo add it to laravel jobs, process it will queue as it will take time.
                if (! Schema::hasColumn($table->$columns, 'is_active'))
                {
                    Schema::table($table->$columns, function (Blueprint $table) {
                        $table->tinyInteger('is_active')->default(1);
                    });
                }

                if (! Schema::hasColumn($table->$columns, 'deleted_at'))
                {
                    Schema::table($table->$columns, function (Blueprint $table) {
                        $table->softDeletes('deleted_at');
                    });
                }
            }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $columns = 'Tables_in_' . env('DB_DATABASE');//This is just to read the object by its key, DB_DATABASE is database name.
        $tables = DB::select('SHOW TABLES');

        foreach ( $tables as $table ) {
            //todo add it to laravel jobs, process it will queue as it will take time.
            Schema::table($table->$columns, function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};
