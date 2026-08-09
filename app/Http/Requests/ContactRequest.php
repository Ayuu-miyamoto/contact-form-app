<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //名前255文字以内
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],

            //苗字255文字以内
            'last_name' => [
                'required',
                'string',
                'max:255'
            ],

            //性別
            'gender' => [
                'required',
                'integer',
                'in:1,2,3'
            ],

            //メールアドレス255文字以内
            'email' => [
                'required',
                'string',
                'email',
                'max:255'
            ],  

            //電話番号11文字以内
            'tel' => [
                'required',
                'string',
                'regex:/^[0-9]{10,11}$/',
                'max:11'
            ],

            //住所255文字以内
            'address' => [
                'required',
                'string',
                'max:255'
            ],  

            //建物名255文字以内
            'building' => [
                'nullable',
                'string',
                'max:255'
            ],

            //詳細120文字以内
            'detail' => [
                'required',
                'string',
                'max:120'
            ],

            //カテゴリ
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id'
            ],  

            //タグ
            'tags_ids' => [
                'nullable',
                'array',
            ],
            
            'tags_ids.*' => [
                'exists:tags,id'
            ],  
        ];
    }   

            /**
             * バリテーションメッセージ
             */
            public function messages(): array
            {  
                return [
                    'first_name.required' => '名前は必須です。',
                    'first_name.max' => '名前は255文字以内で入力してください。',
                    'last_name.required' => '苗字は必須です。',
                    'last_name.max' => '苗字は255文字以内で入力してください。',
                    'gender.required' => '性別は必須です。',
                    'gender.in' => '性別は1（男性）、2（女性）、3（その他）のいずれかで選択してください。',
                    'email.required' => 'メールアドレスは必須です。',
                    'email.email' => 'メールアドレスの形式が正しくありません。',
                    'email.max' => 'メールアドレスは255文字以内で入力してください。',
                    'tel.required' => '電話番号は必須です。',
                    'tel.regex' => '電話番号は10桁または11桁の数字で入力してください。',
                    'tel.max' => '電話番号は11文字以内で入力してください。',
                    'address.required' => '住所は必須です。',
                    'address.max' => '住所は255文字以内で入力してください。',
                    'building.max' => '建物名は255文字以内で入力してください。',
                    'detail.required' => '詳細は必須です。',
                    'detail.max' => '詳細は120文字以内で入力してください。',
                    'category_id.required' => 'カテゴリは必須です。',
                    'category_id.exists' => '選択されたカテゴリは存在しません。',
                    'tags_ids.array' => 'タグは配列で指定してください。',
                    'tags_ids.exists' => '選択されたタグは存在しません。',
                ];
    }
}
