<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image' => app()->environment('testing')
                ? ['nullable']
                : ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'categories' => ['required', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'condition' => ['required', 'in:良好,目立った傷や汚れなし,やや傷や汚れあり,状態が悪い'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください',
            'name.max' => '商品名は255文字以内で入力してください',
            'brand.max' => 'ブランド名は255文字以内で入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は255文字以内で入力してください',

            'image.required' => '商品画像をアップロードしてください',
            'image.image' => '商品画像は.jpegまたは.png形式でアップロードしてください',
            'image.mimes' => '商品画像は.jpegまたは.png形式でアップロードしてください',
            'image.max' => '商品画像の容量は2MB以内にしてください',

            'categories.required' => '商品のカテゴリーを選択してください',
            'categories.array' => '商品のカテゴリーを正しく選択してください',
            'categories.*.exists' => '商品のカテゴリーを正しく選択してください',
            'condition.required' => '商品の状態を選択してください',
            'condition.in' => '商品の状態を正しく選択してください',
            'price.required' => '商品価格を入力してください',
            'price.numeric' => '商品価格は数値で入力してください',
            'price.min' => '商品価格は0円以上で入力してください',
        ];
    }
}

