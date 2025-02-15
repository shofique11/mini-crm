<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
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
            // 'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:leads,email',
            // 'phone' => 'nullable|string|max:20',
            // 'status' => 'required|in:In Progress,Bad Timing,Not Interested,Not Qualified',
            // 'counselor_id' => 'required|exists:users,id',
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'name.required' => 'The lead name is required.',
    //         'email.required' => 'The email address is required.',
    //         'email.email' => 'Please enter a valid email address.',
    //         'email.unique' => 'This email is already assigned to another lead.',
    //         'phone.string' => 'The phone number must be a string.',
    //         'status.required' => 'The status is required.',
    //         'status.in' => 'The status must be one of the following: In Progress, Bad Timing, Not Interested, Not Qualified.',
    //         'counselor_id.required' => 'A counselor must be assigned to the lead.',
    //         'counselor_id.exists' => 'The selected counselor does not exist.',
    //     ];
    // }
}
