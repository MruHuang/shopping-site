<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackOrderFiveRequest extends FormRequest
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
        'fiveNumber'=>'required|digits:5'
        ];
    }
    public function messages(){
        return[
            'fiveNumber.required'=>'匯款後五碼的欄位是必要的',
            'fiveNumber.digits'=>'匯款後五碼的欄位需要輸入5個數字'
        ];
    }
}
