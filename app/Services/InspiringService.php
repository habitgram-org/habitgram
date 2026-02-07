<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

final class InspiringService
{
    /**
     * @return Collection<int, array{string, string}>
     */
    public static function quotes(): Collection
    {
        return new Collection([
            ['Success is the sum of small efforts, repeated day in and day out.', 'Robert Collier'],
            ['A journey of a thousand miles begins with a single step.', 'Laozi'],
            ['Our character is basically a composite of our habits. Because they are consistent, often unconscious patterns, they constantly, daily, express our character.', 'Stephen Covey'],
            ['You’ll never change your life until you change something you do daily. The secret of your success is found in your daily routine.', 'John C. Maxwell'],
            ['Do small things with great love.', 'Mother Teresa'],
            ['It is easier to prevent bad habits than to break them.', 'Benjamin Franklin'],
            ['Successful people are simply those with successful habits.', 'Brian Tracy'],
            ['If you believe you can change – if you make it a habit – the change becomes real.', 'Charles Duhigg'],
            ['Small habits, when repeated consistently, lead to remarkable results.', 'James Clear'],
            ['Every action you take is a vote for the person you want to become', 'James Clear'],
            ['You\'ll never change your life until you change something you do daily. The secret of your success is found in your daily routine.', 'Sean Covey'],
            ['Motivation is what gets you started, habit is what keeps you going.', 'Jim Rohn'],
            ['Discipline is doing what you hate to do, but do it like you love it.', 'Mike Tyson'],
            ['The ability to apply discipline, the ability to do what needs to be done no matter how he feels inside, in my opinion, is the definition of a true professional.', 'Mike Tyson']
        ]);
    }
}
