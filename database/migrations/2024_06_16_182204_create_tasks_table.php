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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable(); // テキスト
            $table->date('start_date'); // タスク開始日
            $table->date('end_date'); // タスク終了日
            $table->boolean('completed'); //タスクが完了したかどうか
            $table->boolean('is_template_task'); // テンプレートタスクかどうか
            $table->unsignedBigInteger('template_task_id')->nullable(); // テンプレートタスクID
            $table->timestamps();

            // 外部キー制約
            $table->foreign('template_task_id')->references('id')->on('template_tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
