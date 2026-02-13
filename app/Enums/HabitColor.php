<?php

declare(strict_types=1);

namespace App\Enums;

enum HabitColor: string
{
    case Black = 'bg-black';
    case Yellow = 'bg-yellow-500';
    case Orange = 'bg-orange-500';
    case Sky = 'bg-sky-500';
    case Slate = 'bg-slate-500';
    case Emerald = 'bg-emerald-500';
    case Teal = 'bg-teal-500';
    case Cyan = 'bg-cyan-500';
    case Blue = 'bg-blue-500';
    case Indigo = 'bg-indigo-500';
    case Violet = 'bg-violet-500';
    case Purple = 'bg-purple-500';
    case Pink = 'bg-pink-500';
    case Rose = 'bg-rose-500';

    /**
     * @return array<int, array<string, int|string>>
     */
    public static function toArray(): array
    {
        return array_map(fn ($color) => ['name' => $color->name, 'value' => $color->value], self::cases());
    }
}
