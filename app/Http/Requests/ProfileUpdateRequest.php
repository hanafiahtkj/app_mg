<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required',
            'tanggal_berdiri' => 'required',
            'alamat' => 'required',
            'kode_pos' => 'required',
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'telp' => 'required',
            'fax' => 'required',
            'sektor' => 'required',
            'kbli_siup' => 'required',
            'kbli_tdp' => 'required',
            'status_kepemilikan_id' => 'required',
            'status_pemodalan_id' => 'required',
            'pemilik' => 'required',
            'alamat_pemilik' => 'required',
            'kode_pos_pemilik' => 'required',
            'email_pemilik' => 'required',
            'telp_pemilik' => 'required',
            'fax_pemilik' => 'required',
            'logo' => 'nullable|mimes:jpg,bmp,png',
        ];
    }
}
