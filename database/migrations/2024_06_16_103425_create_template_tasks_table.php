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
        Schema::create('template_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); //題名
            $table->text('description')->nullable(); //テキスト
            $table->integer('days_offset'); //タスクを何日前・後までやるか
            $table->timestamps(); //作成日時と更新日時
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_tasks');
    }
};
