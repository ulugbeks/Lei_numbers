<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTitleFieldToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First check if the column doesn't exist
        if (!Schema::hasColumn('pages', 'title')) {
            // Add the column
            Schema::table('pages', function (Blueprint $table) {
                $table->string('title')->after('name')->nullable();
            });
            
            // Now run the update AFTER the column has been created and the schema changes committed
            // We need to do this as a separate operation
            DB::statement('UPDATE pages SET title = name');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
}