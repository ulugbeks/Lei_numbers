<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('full_name')->after('id');
            $table->string('company_name')->after('full_name');
            $table->string('registration_id')->after('company_name');
            $table->string('country')->after('registration_id');
            $table->string('email')->after('country');
            $table->string('phone')->after('email');
            $table->string('plan')->after('phone');
            $table->decimal('total_price', 10, 2)->after('plan');
            $table->enum('payment_status', ['pending', 'paid'])->default('pending')->after('total_price');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'full_name', 'company_name', 'registration_id',
                'country', 'email', 'phone', 'plan', 'total_price', 'payment_status'
            ]);
        });
    }
};
