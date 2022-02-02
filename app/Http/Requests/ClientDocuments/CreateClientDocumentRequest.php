<?php

namespace App\Http\Requests\ClientDocuments;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientDocumentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|nullable',
            'document' => 'required',
            'signed' => 'boolean|nullable'
        ];
    }
}
