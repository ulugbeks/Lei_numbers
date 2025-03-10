<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnusedFieldsFromContactsTable extends Migration
{
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Удаляем лишние поля
            $table->dropColumn([
                'first_name',
                'last_name',
                'company_name'  // если это дублирует поле registration_id
            ]);
        });
    }

    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Восстанавливаем поля если нужен будет rollback
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
        });
    }
}