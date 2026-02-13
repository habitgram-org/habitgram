<?php

declare(strict_types=1);

namespace App\Http\Requests\Habit;

use App\DTOs\Habit\CreateHabitDTO;
use App\Enums\HabitColor;
use App\Enums\HabitIcon;
use App\Enums\HabitType;
use App\Enums\UnitType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreHabitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['nullable', 'string', 'min:5', 'max:255'],
            'color' => ['required', Rule::enum(HabitColor::class)],
            'icon' => ['required', Rule::enum(HabitIcon::class)],
            'type' => ['required', Rule::enum(HabitType::class)],
            'is_public' => ['required', 'string'],
            'count.target' => ['nullable', 'integer'],
            'count.unit_type' => ['nullable', Rule::enum(UnitType::class)],
            'abstinence.unit_type' => ['nullable', Rule::enum(UnitType::class)],
            'abstinence.goal' => ['nullable', 'integer'],
        ];
    }

    public function getDTO(): CreateHabitDTO
    {
        return CreateHabitDTO::from([
            'title' => $this->input('title'),
            'description' => $this->input('description'),
            'color' => HabitColor::from($this->input('color')),
            'icon' => HabitIcon::from($this->input('icon')),
            'type' => HabitType::from($this->input('type')),
            'is_public' => $this->boolean('is_public'),
            'count' => [
                'target' => $this->input('count.target'),
                'unit_type' => $this->input('count.unit_type'),
            ],
            'abstinence' => [
                'unit_type' => $this->input('abstinence.unit_type'),
                'goal' => $this->input('abstinence.goal'),
            ],
        ]);
    }
}
