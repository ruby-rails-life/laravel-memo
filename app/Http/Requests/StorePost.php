<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Post;

class StorePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //$this->user()->can('admin', Post::class);
        return true;
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'new title',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'title' => 'required|kana|unique:posts',
        'content'=>'required',
        'category_id' => 'required',
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
        // 'title.required' => 'タイトルを正しく入力してください。',
        // 'content.required' => '本文を正しく入力してください。',
        // 'category_id.required' => 'カテゴリーを選択してください。',
        ];
    }

    /**
     * バリデータインスタンスの設定
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
   {
        $validator->after(function ($validator) {
            // if (true) {
            //     $validator->errors()->add('title', 'Something is wrong with this field!');
            // }
        });
    }
}
