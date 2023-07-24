<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefreshTokenToSocialMediaAccountsTable extends Migration
{
    public function up()
    {
        Schema::table('social_media_accounts', function (Blueprint $table)
        {
            $table->text('refresh_token')->after('access_token')->nullable();
            $table->unsignedInteger('expires')->after('refresh_token')->nullable();
        });
    }

    public function down()
    {
        Schema::table('social_media_accounts', function (Blueprint $table)
        {
            $table->dropColumn('refresh_token');
            $table->dropColumn('expires');
        });
    }
}
