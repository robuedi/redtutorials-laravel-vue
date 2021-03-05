<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class ActivateAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'           =>'required|int',
            'activation_code'   =>'required|string|min:4',
        ];
    }

    public function messages()
    {
        $fail_message = 'There have been problems in activating your account. Try again later and if it still doesn\'t work contact us at <a class="link" href="mailto:contact@redtutorial.com">contact@redtutorial.com</a>.';
        return [
            'user_id' => $fail_message,
            'activation_code' => $fail_message,
        ];
    }
}
