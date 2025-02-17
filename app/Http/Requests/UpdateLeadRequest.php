<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:leads,email,' . $this->lead->id,
            'phone' => 'nullable|string',
            'status' => 'required|in:In Progress,Bad Timing,Not Interested,Not Qualified',
        ];
    }

    public function messages(): array
    {
       
        return [
            'name.required' => 'The lead name is required.',
            'email.required' => 'The email address is required.',
            'email.unique' => 'This email is already assigned to another lead.',
            'status.required' => 'The status is required.',
            'status.in' => 'Invalid status. Choose from In Progress, Bad Timing, Not Interested, or Not Qualified.',
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
