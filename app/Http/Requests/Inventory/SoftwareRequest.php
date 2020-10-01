<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class SoftwareRequest extends FormRequest
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
        return [
            'software_name' => 'max:255',
            'software_serial' => 'max:255',
            'software_maxdevice' => 'numeric',
            'software_invoiceno' => 'max:255',
        ];
    }
}
