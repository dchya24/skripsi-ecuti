<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCutiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'jenis_cuti_id' => "required",
            'alasan_cuti' => "required",
            'mulai_cuti' => 'required',
            'akhir_cuti' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ];
    }

    public function messages(){
        return [
            "jenis_cuti.required" => "Jenis Cuti tidak boleh kosong!",
            "alasan.required" => "Alasan tidak boleh kosong!",
            "start_date.required" => "Tanggal Mulai tidak boleh kosong!",
            "end_date.required" => "Tanggal Akhir tidak boleh kosong!",
            "alamat.required" => "Alasan Tidak boleh kosong!",
            "no_telp.required" => "Nomor Telepon tidak boleh kosong!"
        ];
    }
}
