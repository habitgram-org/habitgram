<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\HabitType;
use App\Models\Abstinence\AbstinenceHabit;
use App\Models\Abstinence\AbstinenceHabitRelapse;
use App\Models\Count\CountHabit;
use App\Models\Count\CountHabitEntry;
use App\Models\Daily\DailyHabit;
use App\Models\Daily\DailyHabitEntry;
use App\Models\Habit;
use App\Models\HabitParticipant;
use App\Models\User;
use Illuminate\Console\Command;
use LogicException;
use Random\RandomException;

use function Laravel\Prompts\select;

final class GenerateFakeHabits extends Command
{
    protected $signature = 'generate-fake-habits';

    protected $description = 'Generate random fake habits';

    /**
     * @throws RandomException
     */
    public function handle(): int
    {
        $type = select('Which type?', HabitType::values());

        /** @var class-string<AbstinenceHabit|CountHabit|DailyHabit> $habitable */
        $habitable = match ($type) {
            HabitType::Abstinence->value => AbstinenceHabit::class,
            HabitType::Count->value => CountHabit::class,
            HabitType::Daily->value => DailyHabit::class,
            default => throw new LogicException(
                'Invalid habit type. Supported habit types: '.implode(',', HabitType::values())
            )
        };

        /** @var class-string<AbstinenceHabitRelapse|CountHabitEntry|DailyHabitEntry> $entryable */
        $entryable = match ($type) {
            HabitType::Abstinence->value => AbstinenceHabitRelapse::class,
            HabitType::Count->value => CountHabitEntry::class,
            HabitType::Daily->value => DailyHabitEntry::class,
            default => throw new LogicException(
                'Invalid habit type. Supported habit types: '.implode(',', HabitType::values())
            )
        };

        $user = User::factory();
        $habit = Habit::factory()
            ->for($habitable::factory(), 'habitable')
            ->create();
        $participant = HabitParticipant::factory()
            ->state([
                'habit_id' => $habit->id,
                'user_id' => $user,
                'is_leader' => true,
            ])
            ->create();
        $entryable::factory()
            ->count(random_int(1, 100))
            ->state([
                'habit_participant_id' => $participant->id,
                match ($habitable) {
                    AbstinenceHabit::class => 'abstinence_habit_id',
                    CountHabit::class => 'count_habit_id',
                    DailyHabit::class => 'daily_habit_id',
                    default => throw new LogicException(
                        'Invalid habit type. Supported habit types: '.implode(',', HabitType::values())
                    )
                } => $habit->habitable_id,
            ])
            ->create();

        $this->info('Fake habits were successfully generated.');

        return Command::SUCCESS;
    }
}
