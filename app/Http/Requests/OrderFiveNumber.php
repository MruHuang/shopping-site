<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderFiveNumber extends FormRequest
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
            'member_password'=>'required|string|same:member_password_again',
            'member_password_again'=>'required|string',
            'member_phone'=>'required|numeric',
            'member_add'=>'required|string',
            'member_Email'=>'required|email',
            'member_birthday'=>'required|date',
            'member_lineid'=>'required|string',
            'recommender_name'=>'required|string',
            'recommender_phone'=>'required|numeric',
            'agree'=>'accepted'
        ];
    }

    public function messages(){
        /*return[
            'required'=>':attribute 的欄位是必要的。',
            'string'=>'必須為字串',
            'email'=>':attribute 的欄位格式不符合E-mail',
            'integer'=>':attribute 的欄位必須為數字',
            'same'=>'密碼再次確認不正確',
            'date'=>':attribute 的欄位不符合時間格式',
            'numeric'=>':attribute 的欄位不符合手機格式',
            'accepted'=>'請閱讀同意書後，點選同意'
        ];*/
        return[
            'member_name.required'=>'會員名稱的欄位是必要的。',
            'member_account.required'=>'會員帳號的欄位是必要的。',
            'member_password.required'=>'會員密碼的欄位是必要的。',
            'member_password_again.required'=>'密碼再確認的欄位是必要的。',
            'member_phone.required'=>'會員手機的欄位是必要的。',
            'member_add.required'=>'會員通訊地址的欄位是必要的。',
            'member_Email.required'=>'會員信箱的欄位是必要的。',
            'member_birthday.required'=>'會員生日的欄位是必要的。',
            'member_lineid.required'=>'會員Line-ID的欄位是必要的。',
            'recommender_name.required'=>'推薦人的欄位是必要的。',
            'recommender_phone.required'=>'推薦任手機的欄位是必要的。',
            'email'=>'會員信箱的欄位格式不符合E-mail',
            'same'=>'密碼再次確認不正確',
            'date'=>'會員生日的欄位不符合時間格式',
            'member_phone.numeric'=>'會員手機的欄位不符合手機格式',
            'recommender_phone.numeric'=>'推薦人手機的欄位不符合手機格式',
            'accepted'=>'請閱讀同意書後，點選同意'
        ];
    }
}
