<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unique(['title', 'source'], 'title_source_unique');

            if (Schema::hasColumn('articles', 'mongo_id')) {
                $table->dropColumn('mongo_id');
            }

            $table->addColumn('string', 'mongo_id', ['length' => 255])->nullable();

            if (Schema::hasColumn('articles', 'published_at')) {
                $table->dropColumn('published_at');
            }

            $table->addColumn('datetime', 'published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropUnique('title_source_unique');
            $table->dropColumn('mongo_id', 'published_at');
        });
    }
};
