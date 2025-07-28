<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'package_id' => ['required', 'string', 'exists:packages,id'],
            'invoice_id' => ['required', 'string', 'exists:invoices,id'],
            'note' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'location' => ['required', 'string'],
        ];
    }
}
