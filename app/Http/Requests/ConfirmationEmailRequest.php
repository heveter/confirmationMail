<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmationEmailRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            'code' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
