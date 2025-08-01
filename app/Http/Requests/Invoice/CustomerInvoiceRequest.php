<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class CustomerInvoiceRequest extends FormRequest
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
            // Invoice
            'customer_id' => ['required', 'string', 'exists:customers,id'],
            'proof' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:5120'],

            // Package
            'packages' => ['required', 'array'],
            'packages.*.id' => ['required', 'string', 'exists:packages,id'],
            'packages.*.quantity' => ['required', 'numeric', 'min:1'],

            // Package Add On
            'packages.*.package_addons' => ['nullable', 'array'],
            'packages.*.package_addons.*.id' => ['required', 'exists:package_addons,id'],
            'packages.*.package_addons.*.quantity' => ['required', 'integer'],
            // 'package_addons' => ['nullable', 'array'],
            // 'package_addons.*.id' => ['nullable', 'string', 'exists:package_addons,id'],
            // 'package_addons.*.quantity' => ['nullable', 'min:0'],

        ];
    }
}
