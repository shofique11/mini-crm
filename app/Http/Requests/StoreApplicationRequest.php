<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'lead_id' => 'required|integer|unique:applications',
            'counselor_id' => 'required|integer',
            'status' => 'required|in:In Progress,Approved,Rejected',
            'lead_id' => 'required|exists:leads,id',
            'counselor_id' => 'required|exists:users,id',
        ];
    }
    public function messages(): array
    {
        return [
            'lead_id.required' => 'The lead id is required.',
            'lead_id.unique' => 'This lead is already assigned to another counselor.',
            'counselor_id.required' => 'The counselor is required.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be one of the following: In Progress, Approved, Rejected.',
            'lead_id.exists' => 'The selected lead does not exist.',
            'counselor_id.exists' => 'The selected counselor does not exist.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'message' => 'Validation error',
            'errors' => $validator->errors()
        ], 422));
    }
}
