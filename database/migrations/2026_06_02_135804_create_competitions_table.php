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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('poster')->nullable();
            $table->longText('rules')->nullable();
            $table->longText('requirements')->nullable();
            $table->text('prize')->nullable();
            $table->unsignedInteger('quota')->default(0);
            $table->dateTime('registration_start');
            $table->dateTime('registration_end');
            $table->date('event_date')->nullable();
            $table->enum('status', ['draft', 'open', 'closed', 'ongoing', 'finished'])->default('draft');
            $table->timestamps();

            $table->index(['status', 'registration_start', 'registration_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
