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
        Schema::create('perizinan_cuti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('jenis_cuti_id')->unsigned();
            $table->text('alasan_cuti');
            $table->text('alamat_menjalankan_cuti');
            $table->integer('jumlah_hari');
            $table->date('mulai_cuti');
            $table->date('akhir_cuti');
            $table->string('no_telp');
            $table->string("bukti")->nullable();
            $table->unsignedBigInteger('atasan_langsung_id')->nullable();
            $table->integer('status_persetujuan_atasan_langsung')->nullable()
                ->comment("Status yang dipertimbangkan oleh atasan langsung: Status 1. Disetujui, 2. Perubahan, 3. Ditangguhkan, 4. Tidak Disetujui");
            $table->text('alasan_persetujuan_atasan_langsung');
            $table->unsignedBigInteger('pejabat_berwenang_id')->nullable();
            $table->integer('status_keputusan_pejabat_berwenan')->nullable()
                ->comment("Status yang dipertimbangkan oleh pejabat yang berwenang: Status 1. Disetujui, 2. Perubahan, 3. Ditangguhkan, 4. Tidak Disetujui");
            $table->text('alasan_keputusan_pejabat_berwenang');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('SET NULL')->onUpdate('CASCADE');                    
            $table->foreign('atasan_langsung_id')->references('id')->on('users')
            ->onDelete('SET NULL')->onUpdate('CASCADE');                    
            $table->foreign('pejabat_berwenang_id')->references('id')->on('users')
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
        Schema::table('perizinan_cuti', function(Blueprint $table){
            $table->dropForeign('perizinan_cuti_user_id_foreign');
            $table->dropForeign('perizinan_cuti_atasan_langsung_id_foreign');
            $table->dropForeign('perizinan_cuti_pejabat_berwenang_id_foreign');
        });
        Schema::dropIfExists('perizinan_cuti');
    }
};
