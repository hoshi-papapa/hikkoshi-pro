<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_user_id'); //メインユーザーID
            $table->string('nickname'); //ニックネーム
            $table->string('user_image_path')->nullable(); //ユーザー画像パス
            $table->timestamps(); //作成日時と更新日時

            // 外部キー制約
            $table->foreign('main_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_users');
    }
};
