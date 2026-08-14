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
     * お問い合せ入力フォームのバリデーションを取得する
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
                    'first_name.required' => '名を入力してください',
                    'last_name.required' => '姓を入力してください',
                    'gender.required' => '性別を選択してください',
                    'email.required' => 'メールアドレスを入力してください',
                    'email.email' => 'メールアドレスはメール形式で入力してください',
                    'tel.required' => '電話番号を入力してください',
                    'address.required' => '住所を入力してください',
                    'building.max' => '建物名は255文字以内で入力してください。',
                    'detail.required' => 'お問い合わせ内容を入力してください',
                    'detail.max' => 'お問い合わせ内容は120文字以内で入力してください',
                    'category_id.required' => 'お問い合わせの種類を選択してください',
                ];
    }
}
