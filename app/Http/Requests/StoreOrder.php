<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrder extends FormRequest
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
        $apikeys = config('acl.apiKeys');
        $rules = [
            'bar_id' => ['required', 'int'],
            'order_num' => ['required', 'string', 'min:10', 'max:15', 'unique:orders'],
            'total' => ['required', 'numeric', 'gt:0'],
            'order_at' => ['required'],
            'inserted_for' => ['required', 'string', 'min:3'],
            'items' => ['required', 'array'],
            'payment_info' => ['required', 'array'],
            'apikey' => ['required', 'string', 'max:50', Rule::in($apikeys['web'], $apikeys['mobile'])],
        ];

        return $rules;
    }
}
