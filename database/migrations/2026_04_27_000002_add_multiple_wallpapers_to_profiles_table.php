<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->renameColumn('wallpaper', 'wallpaper_1');
            $table->string('wallpaper_2')->nullable()->after('wallpaper_1');
            $table->string('wallpaper_3')->nullable()->after('wallpaper_2');
            $table->string('wallpaper_4')->nullable()->after('wallpaper_3');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->renameColumn('wallpaper_1', 'wallpaper');
            $table->dropColumn(['wallpaper_2', 'wallpaper_3', 'wallpaper_4']);
        });
    }
};
