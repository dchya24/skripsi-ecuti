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
            $table->bigInteger('user_id')->unsigned();
            $table->integer('jenis_cuti_id')->unsigned();
            $table->text('alasan_cuti');
            $table->text('alamat_menjalankan_cuti');
            $table->integer('jumlah_hari');
            $table->date('mulai_cuti');
            $table->date('akhir_cuti');
            $table->string('no_telp');
            $table->string("bukti")->nullable();
            $table->bigInteger('atasan_langsung_id')->unsigned();
            $table->integer('status_persetujuan_atasan_langsung')
                ->comment("Status yang dipertimbangkan oleh atasan langsung: Status 1. Disetujui, 2. Perubahan, 3. Ditangguhkan, 4. Tidak Disetujui");
            $table->text('alasan_persetujuan_atasan_langsung');
            $table->bigInteger('pejabat_berwenang_id')->unsigned();
            $table->integer('status_persetujuan_pejabat_berwenan')
                ->comment("Status yang dipertimbangkan oleh pejabat yang berwenang: Status 1. Disetujui, 2. Perubahan, 3. Ditangguhkan, 4. Tidak Disetujui");
            $table->text('alasan_persetujuan_atasan_langsung');
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
        Schema::dropIfExists('perizinan_cutis');
    }
};
