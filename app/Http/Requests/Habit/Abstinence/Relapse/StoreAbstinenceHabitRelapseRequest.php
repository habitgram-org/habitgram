<?php

declare(strict_types=1);

namespace App\Http\Requests\Habit\Abstinence\Relapse;

use App\DTOs\Habit\Abstinence\Relapse\CreateAbstinenceHabitRelapseDTO;
use Illuminate\Foundation\Http\FormRequest;

final class StoreAbstinenceHabitRelapseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reason' => ['required', 'string', 'min:5', 'max:200'],
        ];
    }

    public function getDTO(): CreateAbstinenceHabitRelapseDTO
    {
        return CreateAbstinenceHabitRelapseDTO::from([
            'reason' => $this->get('reason'),
        ]);
    }
}
