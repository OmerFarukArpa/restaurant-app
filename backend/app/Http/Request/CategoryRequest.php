<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category_name' => 'required|min:3',
            'category_image' => 'mimes:jpg,jpeg,png|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'category_name.required' => 'Bu alan zorunludur',
            'category_name.min' => 'En az 3 karakter giriniz',
            'category_image.mimes' => 'jpg, png, jpeg uzantılı resim yükleyiniz',
            'category_image.size' => 'En fazla 2MB boyutunda resim yükleyebilirsiniz',
        ];
    }
}
