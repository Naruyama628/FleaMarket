<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png'],
            'category' => ['required', 'array', 'min:1'],
            'category.*' => ['required', 'integer', 'exists:categories,id'],
            'condition' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:50'],
        ];
    }

    public function messages()
    {
        return [
            //
            'name.required' => '商品名を入力してください',
            'name.max' => '商品名を255文字以内で入力してください',

            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明を255文字以内で入力してください',

            'image.required' => '画像を入力してください',
            'image.image' => '画像ファイルを入力してください',
            'image.mimes' => '拡張子は.jpegまたは、.pngで入力してください',

            'category.required' => 'カテゴリーを入力してください',
            'category.min' => 'カテゴリーを1つ以上入力してください',

            'condition.required' => '商品の状態を入力してください',

            'price.required' => '商品価格を入力してください',
            'price.numeric' => '商品価格を数値で入力してください',
            'price.min' => '商品価格は￥50以上で入力してください',
        ];
    }
}
