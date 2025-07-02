<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Personal Information
            $table->string('username')->unique()->nullable()->after('id');
            $table->string('first_name')->nullable()->after('name');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('middle_name');
            $table->string('suffix')->nullable()->after('last_name');
            
            // Company Information
            $table->string('company_name')->nullable()->after('email');
            
            // Contact Information
            $table->string('phone_country_code')->nullable()->after('company_name');
            $table->string('phone')->nullable()->after('phone_country_code');
            
            // Address Information
            $table->string('address_line_1')->nullable()->after('phone');
            $table->string('address_line_2')->nullable()->after('address_line_1');
            $table->string('city')->nullable()->after('address_line_2');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
            $table->string('postal_code')->nullable()->after('country');
            
            // Terms and Privacy
            $table->boolean('terms_accepted')->default(false)->after('remember_token');
            $table->boolean('privacy_accepted')->default(false)->after('terms_accepted');
            $table->timestamp('terms_accepted_at')->nullable()->after('privacy_accepted');
            $table->timestamp('privacy_accepted_at')->nullable()->after('terms_accepted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'first_name',
                'middle_name',
                'last_name',
                'suffix',
                'company_name',
                'phone_country_code',
                'phone',
                'address_line_1',
                'address_line_2',
                'city',
                'state',
                'country',
                'postal_code',
                'terms_accepted',
                'privacy_accepted',
                'terms_accepted_at',
                'privacy_accepted_at'
            ]);
        });
    }
};