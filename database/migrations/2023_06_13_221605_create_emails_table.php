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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->integer('campaign_id')->unsigned()->index();
            $table->string('target')->index();
            $table->timestamps();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable()->index();
            $table->timestamp('hooked_at')->nullable()->index();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
