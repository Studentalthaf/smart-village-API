<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\HeadOfFamily;


class HeadOfFamilyUpdateRequest extends FormRequest
{

     public function rules(): array
    {
        // Cari HeadOfFamily berdasarkan ID
        $headOfFamily = HeadOfFamily::find($this->route('head-of-families'));
        $userId = optional($headOfFamily)->user_id;
        
        // Validasi email hanya jika dikirim dan berbeda dengan yang sekarang
        $emailRules = 'nullable|string|email|max:255';
        if ($userId && $this->filled('email') && $headOfFamily->user->email !== $this->email) {
            $emailRules .= '|unique:users,email,' . $userId;
        }
        
        return [
            'name' => 'required|string|max:255',
            'email' => $emailRules,
            'password' => 'nullable|string|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'identity_number' => 'required|integer',
            'gender' => 'required|string|in:male,female',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string',
            'occupation' => 'required|string',
            'marital_status' => 'required|string|in:married,single',
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
            'profile_picture' => 'Foto Profil',
            'identity_number' => 'Nomor Identitas',
            'gender' => 'Jenis Kelamin',
            'date_of_birth' => 'Tanggal Lahir',
            'phone_number' => 'Nomor Telepon',
            'occupation' => 'Pekerjaan',
            'marital_status' => 'Status Perkawinan',
        ];
    }
}
