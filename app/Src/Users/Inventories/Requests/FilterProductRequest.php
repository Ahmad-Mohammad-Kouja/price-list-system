<?php

namespace App\Src\Users\Inventories\Requests;

use App\Domain\Inventories\Enum\PriceListSortingEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Str;

class FilterProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if ($this->filled('country_code')) {
            $this->merge([
                'country_code' => Str::upper($this->get('country_code')),
            ]);
        }

        if ($this->filled('currency_code')) {
            $this->merge([
                'currency_code' => Str::upper($this->get('currency_code')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'country_code' => ['nullable', 'string', 'size:3'],
            'currency_code' => ['nullable', 'string', 'size:3'],
            'date' => ['nullable', 'date_format:Y-m-d'],
            'order' => ['nullable', Rule::enum(PriceListSortingEnum::class)],
        ];
    }
}
