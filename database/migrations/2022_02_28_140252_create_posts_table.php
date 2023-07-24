<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('social_media_account_id')->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('type');
            $table->text('caption')->nullable();
            $table->integer('likes')->nullable();
            $table->unsignedBigInteger('external_id')->nullable()
                ->unique();

            $table->timestamp('posted_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
