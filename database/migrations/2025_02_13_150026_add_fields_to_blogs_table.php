<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->text('content')->nullable()->after('title');
            $table->string('image')->nullable()->after('content');
            $table->timestamp('published_at')->nullable()->after('image');
            $table->boolean('status')->default(0)->after('published_at');
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['title', 'content', 'image', 'published_at', 'status']);
        });
    }
};
