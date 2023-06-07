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
        Schema::create('sub_bagian', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('bagian_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('bagian_id')->references('id')->on('bagian')
            ->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_bagian', function(Blueprint $table){
            $table->dropForeign('jabatan_rumpun_jabatan_id_foreign');
        });
        Schema::dropIfExists('sub_bagian');
    }
};
