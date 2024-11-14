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
        Schema::table('ch_messages', function(Blueprint $table) {
            $table->bigInteger('conversation_id');
        });

        // Create conversations
        Schema::create('ch_conversations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('batch_id');
            $table->string('name');
            $table->boolean('status')->comment('1: Open, 0: Closed');
            $table->timestamps();
        });

        // Create conversation_users
        Schema::create('ch_conversation_users', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('conversation_id');
            $table->bigInteger('user_id');
            $table->timestamp('last_read');
            $table->integer('unread_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
