<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkTemplateGenerateRequest extends FormRequest
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
        // return [
        //     'categories' => 'required|array|min:1',
        //     'categories.*' => 'exists:product_categories,id',

        //     'subcategories' => 'nullable|array',
        //     'subcategories.*' => 'exists:product_sub_categories,id',

        //     'variant_mode' => 'required|in:simple,variant',

        //     'image_mode' => 'nullable|in:same,attribute',

        //     'brand_mode' => 'required|in:single,multiple',
        //     'brand_id' => 'nullable|exists:brands,id',

        //     'volume' => 'required|integer|min:1|max:5000',
        // ];

        return [

            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:product_categories,id',

            'subcategories' => 'required|array|min:1',
            'subcategories.*' => 'exists:product_sub_categories,id',

            'brand_mode' => 'required|in:single,multiple',

            'brand_id' => 'nullable|exists:brands,id',

            'volume' => 'required|integer|min:1|max:5000',
        ];
    }
}
