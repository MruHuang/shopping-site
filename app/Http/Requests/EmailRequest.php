<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
            'Email_addressee'=>'required|email',
            'mail_text'=>'required|string'

        ];
    }

    public function messages(){
        return[
            'required'=>'質為空白',
            'string'=>'未有信件內容',
            'email'=>'email不正確'
        ];
    }
}
