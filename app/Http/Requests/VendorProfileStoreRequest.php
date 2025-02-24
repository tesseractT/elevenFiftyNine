<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorProfileStoreRequest extends FormRequest
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
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'address' => ['required', 'string'],
            'description' => ['required', 'string'],
            'fb_link' => ['nullable', 'string', 'url'],
            'twitter_link' => ['nullable', 'string', 'url'],
            'insta_link' => ['nullable', 'string', 'url'],
        ];
    }
}
