<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// class BulkTemplateGenerateRequest extends FormRequest
// {
//     /**
//      * Determine if the user is authorized to make this request.
//      */
//     public function authorize(): bool
//     {
//         return true;
//     }

//     /**
//      * Get the validation rules that apply to the request.
//      *
//      * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
//      */
//     public function rules(): array
//     {
//         return [

//             'categories' => 'required|array|min:1',
//             'categories.*' => 'exists:product_categories,id',

//             'subcategories' => 'required|array|min:1',
//             'subcategories.*' => 'exists:product_sub_categories,id',

//             'brand_mode' => 'required|in:single,multiple',

//             'brand_id' => 'nullable|exists:brands,id',

//             'volume' => 'required|integer|min:1|max:5000',
//         ];
//     }
// }

class BulkTemplateGenerateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
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

    protected function failedValidation(
        \Illuminate\Contracts\Validation\Validator $validator
    ) {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(

            response()->json([

                'success' => false,

                'message' => 'Validation failed.',

                'errors' => $validator->errors(),

            ], 422)
        );
    }
}
