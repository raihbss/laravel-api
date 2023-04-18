<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this -> user();

        return $user != null && $user -> tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'customerId' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'status' => ['required', Rule::in(['B', 'P', 'V', 'b', 'p', 'v'])],
            'billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
            'paidDate' => ['date_format:Y-m-d H:i:s', 'nullable']
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach($this -> toArray() as $obj){
            $obj['customer_id'] = $obj['customerId'] ?? null;
            $obj['billed_date'] = $obj['billedDate'] ?? null;
            $obj['paid_date'] = $obj['paidDate'] ?? null;

            $data = $obj;
        }

        $this -> merge($data);
    }
}

/*

[
    {
        "customerId": "1",
        "amount": "23",
        "status": "B",
        "billedDate": "2021-09-23 14:29:49",
        "paidDate": null
    },
    {
        "customerId": "2",
        "amount": "4500",
        "status": "V",
        "billedDate": "2022-09-23 13:45:49",
        "paidDate": null
    },
    {
        "customerId": "3",
        "amount": "6700",
        "status": "P",
        "billedDate": "2023-01-23 08:01:30",
        "paidDate": "2023-01-23 08:02:05"
    }
]

*/
