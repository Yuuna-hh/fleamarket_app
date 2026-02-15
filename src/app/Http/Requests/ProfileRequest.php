<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
            'name' => ['required', 'string', 'max:20'],
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string'],
            'building' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'profile_image.image' => 'プロフィール画像は.jpegまたは.png形式でアップロードしてください',
            'profile_image.mimes' => 'プロフィール画像は.jpegまたは.png形式でアップロードしてください',
            'profile_image.max' => 'プロフィール画像の容量は2MB以内にしてください',
            'profile_image.uploaded' => 'プロフィール画像の容量は2MB以内にしてください',
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号はハイフンありの8文字で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
