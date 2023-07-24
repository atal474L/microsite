<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media_accounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('social_media_id')->constrained('social_medias')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->string('name');
            $table->unsignedBigInteger('profile_id')->unique()->nullable();
            $table->string('access_token')->nullable();

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
        Schema::dropIfExists('social_media_accounts');
    }
}
