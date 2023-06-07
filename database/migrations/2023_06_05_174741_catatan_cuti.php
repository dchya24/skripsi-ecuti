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
        Schema::create('catatan_cuti', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('jumlah_cuti_tahunan');
            $table->integer('sisa_cuti_tahunan');
            $table->integer('cuti_tahunan_terpakai');
            $table->integer('jumlah_cuti_besar');
            $table->integer('jumlah_cuti_sakit');
            $table->integer('jumlah_alasan_penting');
            $table->date('tahun');
            $table->timestamps();
            $table->softDeletes();
                                
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::table('catatan_cuti', function(Blueprint $table){
            $table->dropForeign('catatan_cuti_user_id_foreign');
        });
        Schema::dropIfExists('catatan_cuti');
    }
};
