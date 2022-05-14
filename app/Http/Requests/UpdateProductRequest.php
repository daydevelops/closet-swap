<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('edit',$this->product);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required|max:120',
            'description' => 'required|max:400',
            'gender'      => ['required',Rule::in(config('products.available_genders'))],
            'size'        => ['required',Rule::in(config('products.available_sizes'))],
            'tags'        => 'required|json',
            'status'      => ['required',Rule::in(config('products.available_statuses'))],
        ];
    }
}
