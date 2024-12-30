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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screening_id')->constrained()->onDelete('cascade');
            $table->string('row'); // 列 (例: A, B, C)
            $table->integer('number'); // 番号 (例: 1, 2, 3)
            $table->boolean('is_reserved')->default(false); // 予約済みかどうか
            $table->timestamps();

            // 複合ユニークキーを設定
            $table->unique(['screening_id', 'row', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
