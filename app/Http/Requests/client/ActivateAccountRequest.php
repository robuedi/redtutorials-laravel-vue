<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class ActivateAccountRequest extends FormRequest
{
    protected $redirect = '/register';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function validationData()
    {
        return $this->route()->parameters();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'           =>'required',
            'activation_code'   =>'required',
        ];
    }

    public function messages()
    {
        $fail_message = 'There have been problems in activating your account. Try again later and if it still doesn\'t work contact us at <a class="link" href="mailto:contact@redtutorial.com">contact@redtutorial.com</a>.';
        return [
            'user_id.required' => $fail_message,
            'activation_code.required' => $fail_message,
        ];
    }
}
