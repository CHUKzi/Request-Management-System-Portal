<?php

namespace App\Http\Requests;

use App\Utils\CoreUtil;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidateRequest extends FormRequest
{
    protected $CoreUtil;
    public function __construct(CoreUtil $CoreUtil)
    {
        $this->CoreUtil = $CoreUtil;
    }
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
            'created_on' => ['required', 'date'],
            'location' => ['required', 'string'],
            'service' => ['required', 'string'],
            'status' => ['required', 'string', 'in:NEW,IN_PROGRESS,ON_HOLD,REJECTED,CANCELLED'],
            'priority' => ['required', 'string', 'in:HIGH,MEDIUM,LOW'],
            'department' => ['required', 'string'],
            'request_by' => ['required', 'string'],
            'assigned_to' => ['required', 'string'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->CoreUtil->sendResponse(false, null, 'Form errors encountered. Please review.', $validator->errors()));
    }
}
