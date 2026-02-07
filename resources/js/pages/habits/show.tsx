import AbstinenceHabitDetails from '@/components/habit/abstinence-habit-details';
import CountHabitDetails from '@/components/habit/count-habit-details';
import DailyHabitDetails from '@/components/habit/daily-habit-details';
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/app-layout';
import { Habit } from '@/types';
import { Head } from '@inertiajs/react';

enum HabitType {
    Abstinence = 'abstinence',
    Count = 'count',
    Daily = 'daily',
}

interface Props {
    habit: Habit;
}

export default function Show({ habit }: Props) {
    let content = <AbstinenceHabitDetails habit={habit} />;
    if (habit.type === HabitType.Count) {
        content = <CountHabitDetails habit={habit} />;
    } else if (habit.type === HabitType.Daily) {
        content = <DailyHabitDetails habit={habit} />;
    }
    return (
        <>
            <Head title={habit.name} />
            <AppLayout>
                {content}

                <Toaster />
            </AppLayout>
        </>
    );
}
