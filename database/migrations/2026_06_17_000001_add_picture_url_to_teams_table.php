<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Добавляем поле для хранения ссылки на изображение (логотип команды),
     * загруженное в объектное хранилище Yandex Object Storage.
     */
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('picture_url')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('picture_url');
        });
    }
};
