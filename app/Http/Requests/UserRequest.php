<?php

namespace App\Http\Requests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'qs' => ['required', 'array', 'size:40'],
            'qs.*' => ['integer'],
            'name' => ['required', 'string', 'max:200'],
            'age' => ['required', 'integer', 'min:1'],
            'time' => ['required', 'integer', 'min:1'],
            'gender' => ['required', Rule::in(User::GENDERS)],
            'email' => ['required', 'email:filter'],
            'country_id' => ['required', 'exists:countries,id'],
            'university_id' => ['required', 'exists:universities,id'],
            'education_id' => ['required', 'exists:education,id'],
            'sphere_id' => ['required', 'exists:spheres,id'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('qs')) {
            $this->merge([
                'qs' => json_decode($this->input('qs'), true),
            ]);
        }
    }
}
