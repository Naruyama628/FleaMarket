<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'image' => ['required', 'image', 'mimes:jpeg,png'],
            'name' => ['required', 'string','max:20'],
            'postal_code' => ['required', 'regex:/^[0-9]{3}-[0-9]{4}$/'],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            //
            'image.required' => 'プロフィール画像を入力してください',
            'image.image' => '画像ファイルを入力してください',
            'image.mimes' => '拡張子は.jpegまたは、.pngで入力してください',

            'name.required' => 'お名前を入力してください',
            'name.string' => 'お名前を文字列で入力してください',
            'name.max' => 'お名前を20文字以内で入力してください',

            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号は「012-3456」の形式で入力してください',
            
            'address.required' => '住所を入力してください',
        ];
    }
}
