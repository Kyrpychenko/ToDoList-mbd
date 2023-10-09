<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todo_item_user_assignment', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('todo_item_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todo_item_user_assignment');
    }
};
