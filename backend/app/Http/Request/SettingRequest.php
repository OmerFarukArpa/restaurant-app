<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name' => 'required|min:3',
            'company_name' => 'required|min:4',
            'email' => 'required|email',
            'image' => 'mimes:jpg,jpeg,png|max:2048',
            'info' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bu alan zorunludur',
            'name.min' => 'En az 3 karakter giriniz',
            'company_name.required' => 'Bu alan zorunludur',
            'company_name.min' => 'En az 4 karakter giriniz',
            'image.mimes' => 'jpg, png, jpeg uzantılı resim yükleyiniz',
            'image.size' => 'En fazla 2MB boyutunda resim yükleyebilirsiniz',
            'email.required' => 'Bu alan zorunludur',
            'email.email' => 'Email türünde girişler yapın',
            'info.required' => 'Bu alan zorunludur',
        ];
    }
}
