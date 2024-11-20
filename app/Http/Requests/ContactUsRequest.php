<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
        if ($this->getMethod() == 'POST') {
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'description' => 'required',
            ];
        } else {
            $rules = [
                'reply' => 'required',
                'status' => 'required',
            ];
        }
        return $rules;
    }

    /**
     * Get the validation messages of rules that applied to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email field requires an email',
            'subject.required' => 'Subject field is required',
            'description.required' => 'Description is required',
        ];
    }
}
