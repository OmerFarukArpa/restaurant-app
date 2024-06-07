<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
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
            'name' => 'required|min:5',
            'description' =>'required:min:10',
            'price' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bu alan zorunludur',
            'name.min' => 'En az 5 karakter giriniz',
            'description.required' => 'Bu alan zorunludur',
            'description.min' => 'En az 10 karakter giriniz',
            'price.required' => 'Bu alan zorunludur'
        ];
    }
}
