<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeoFieldsToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            // Add SEO fields if they don't already exist
            if (!Schema::hasColumn('pages', 'og_title')) {
                $table->string('og_title')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('pages', 'og_description')) {
                $table->text('og_description')->nullable()->after('og_title');
            }
            if (!Schema::hasColumn('pages', 'og_image')) {
                $table->string('og_image')->nullable()->after('og_description');
            }
            if (!Schema::hasColumn('pages', 'og_type')) {
                $table->string('og_type')->nullable()->after('og_image');
            }
            if (!Schema::hasColumn('pages', 'twitter_card')) {
                $table->string('twitter_card')->nullable()->after('og_type');
            }
            if (!Schema::hasColumn('pages', 'canonical_url')) {
                $table->string('canonical_url')->nullable()->after('twitter_card');
            }
            if (!Schema::hasColumn('pages', 'no_index')) {
                $table->boolean('no_index')->default(false)->after('canonical_url');
            }
            if (!Schema::hasColumn('pages', 'no_follow')) {
                $table->boolean('no_follow')->default(false)->after('no_index');
            }
            if (!Schema::hasColumn('pages', 'structured_data')) {
                $table->json('structured_data')->nullable()->after('no_follow');
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
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'og_title',
                'og_description',
                'og_image',
                'og_type',
                'twitter_card',
                'canonical_url',
                'no_index',
                'no_follow',
                'structured_data',
            ]);
        });
    }
}