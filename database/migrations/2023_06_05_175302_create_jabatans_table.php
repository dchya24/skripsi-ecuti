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
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('rumpun_jabatan_id')->nullable();
            $table->unsignedBigInteger('subbagian_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rumpun_jabatan_id')->references('id')->on('rumpun_jabatan')
                    ->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('subbagian_id')->references('id')->on('sub_bagian')
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
        
        Schema::table('jabatan', function(Blueprint $table){
            $table->dropForeign('jabatan_rumpun_jabatan_id_foreign');
            $table->dropForeign('jabatan_subbagian_id_foreign');
        });
        Schema::dropIfExists('jabatan');
    }
};
