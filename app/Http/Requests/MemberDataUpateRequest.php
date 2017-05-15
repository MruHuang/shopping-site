<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberDataUpateRequest extends FormRequest
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
            'member_name'=>'required|string',
            'member_account'=>'required|string',
            // 'member_password'=>'string',
            //'new_member_password'=>'same:new_member_password_again',
            // 'new_member_password_again'=>'string',
            'member_phone'=>'required|numeric',
            'member_add'=>'required|string',
            'member_Email'=>'required|email',
            'member_birthday'=>'required|date',
            'member_lineid'=>'required|string',
        ];
    }
    public function messages(){
        return[
            'required'=>'不可為空白',
            'string'=>'必須為字串',
            'email'=>'email輸入不正確',
            'integer'=>'必須為整數',
            'same'=>'密碼再次確認不正確'
        ];
    }
}
