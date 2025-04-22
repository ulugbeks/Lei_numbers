<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndSelectedPlanToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Add the type column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'type')) {
                $table->string('type')->nullable()->after('id');
            }
            
            // Add the selected_plan column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'selected_plan')) {
                $table->string('selected_plan')->nullable()->after('zip_code');
            }
            
            // Add lei column if it doesn't exist (for renewals and transfers)
            if (!Schema::hasColumn('contacts', 'lei')) {
                $table->string('lei')->nullable()->after('type');
            }
            
            // Add renewal_period column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'renewal_period')) {
                $table->integer('renewal_period')->nullable()->after('selected_plan');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['type', 'selected_plan', 'lei', 'renewal_period']);
        });
    }
}