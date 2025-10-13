<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }


}
