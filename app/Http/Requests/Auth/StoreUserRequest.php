<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\DTOs\Auth\CreateNewUserDTO;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:5', 'max:255', Rule::unique(User::class)],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function getDTO(): CreateNewUserDTO
    {
        return CreateNewUserDTO::from([
            'username' => $this->input('username'),
            'email' => $this->input('email'),
            'password' => $this->input('password'),
        ]);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => mb_strtolower((string) $this->input('email')),
        ]);
    }
}
