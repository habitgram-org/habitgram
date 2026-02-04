<?php

declare(strict_types=1);

namespace App\Http\Requests\Habit\Abstinence\Note;

use App\DTOs\Habit\Abstinence\Note\CreateHabitNoteDTO;
use Illuminate\Foundation\Http\FormRequest;

final class StoreHabitNoteRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'note' => ['required', 'string', 'min:5', 'max:200'],
        ];
    }

    public function getDTO(): CreateHabitNoteDTO
    {
        return CreateHabitNoteDTO::from([
            'note' => $this->get('note'),
        ]);
    }
}
