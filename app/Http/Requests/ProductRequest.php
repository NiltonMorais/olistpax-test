<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->product && $this->product->id ? $this->product->id : 'null';

        return [
            'name' => "required|string|min:3|unique:products,name,{$id}",
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }
}
