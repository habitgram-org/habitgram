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
        $rules = [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['nullable', 'string', 'min:5', 'max:255'],
            'color' => ['required', Rule::enum(HabitColor::class)],
            'icon' => ['required', Rule::enum(HabitIcon::class)],
            'type' => ['required', Rule::enum(HabitType::class)],
            'is_public' => ['required', 'string'],
            'count.target' => ['nullable', 'integer'],
            'count.unit_type' => ['nullable', 'integer', Rule::enum(UnitType::class)],
            'abstinence.goal_unit' => ['nullable', 'integer', Rule::enum(UnitType::class)],
            'abstinence.goal' => ['nullable', 'integer'],
        ];

        // Make count.unit_type required if type is Count
        if ($this->input('type') === HabitType::Count->value) {
            $rules['count.unit_type'] = ['required', 'integer', Rule::enum(UnitType::class)];
        }

        return $rules;
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
            'count' => $this->input('count.unit_type') !== null ? [
                'target' => $this->input('count.target'),
                'unit_type' => $this->input('count.unit_type'),
            ] : null,
            'abstinence' => $this->input('abstinence.goal_unit') !== null ? [
                'goal_unit' => $this->input('abstinence.goal_unit'),
                'goal' => $this->input('abstinence.goal'),
            ] : null,
        ]);
    }
}
