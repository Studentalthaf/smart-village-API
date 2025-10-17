<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class FamilyMemberStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'identity_number' => 'required|integer|digits:16',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string',
            'occupation' => 'required|string',
            'marital_status' => 'required|in:single,married',
            'relation' => 'required|in:child,wife,husband' 
        ];
    }

    public function attributes()
    {
        return [
            'head_of_family_id' => 'Kepala Keluarga',
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
            'relation' => 'Hubungan'
        ];
    }
}