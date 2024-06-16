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
        Schema::create('subuser_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_user_id'); // サブユーザーID
            $table->unsignedBigInteger('task_id'); // タスクID
            $table->timestamps();

            // 外部キー制約
            $table->foreign('sub_user_id')->references('id')->on('sub_users')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subuser_tasks');
    }
};
