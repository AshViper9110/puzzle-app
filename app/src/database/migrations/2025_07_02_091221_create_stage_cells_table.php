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
        Schema::create('stage_cells', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stage_id');  // ステージ識別用
            $table->integer('x');                    // X座標
            $table->integer('y');                    // Y座標
            $table->enum('type', ['ground', 'box', 'goal']);  // セルの種類
            $table->timestamps();

            // 外部キー制約（任意、必要ならステージテーブルも作成）
            // $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stage_cells');
    }
};

