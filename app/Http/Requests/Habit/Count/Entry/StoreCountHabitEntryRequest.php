<?php

declare(strict_types=1);

namespace App\Http\Requests\Habit\Count\Entry;

use App\DTOs\Habit\Count\Entry\CreateCountHabitEntryDTO;
use Illuminate\Foundation\Http\FormRequest;

final class StoreCountHabitEntryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'integer', 'gt:0', 'max:10000'],
            'note' => ['sometimes', 'string', 'min:5', 'max:200'],
        ];
    }

    public function getDTO(): CreateCountHabitEntryDTO
    {
        return CreateCountHabitEntryDTO::from([
            'amount' => $this->get('amount'),
            'note' => $this->get('note'),
        ]);
    }
}
