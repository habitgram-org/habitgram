import CountHabit from '@/components/habits/count-habit';
import AppLayout from '@/layouts/app-layout';
import type { CountHabit as CountHabitType, Habit } from '@/types';
import { Head } from '@inertiajs/react';
import { useEffect } from 'react';

export default function Show({ habit }: {habit: Habit}) {
    useEffect(function () {
        console.log(habit);
    }, []);

    return (
        <AppLayout>
            <Head title={habit.name + ' - ' + 'My Habits'}></Head>
            <div className="p-6">
                <h1 className="text-2xl">{habit.name}</h1>
                {habit.description !== undefined && (
                    <div className="mt-2 text-base text-black/50">
                        {habit.description}
                    </div>
                )}

                {habit.has_started ? (
                    <div>Started: {habit.started_at}</div>
                ) : (
                    <div>Starts: {habit.starts_at}</div> // Here would be better to implement countdown
                )}

                {habit.type === 'count' && (
                    <CountHabit habitId={habit.id} habit={habit.habitable as CountHabitType} />
                )}
                {/*two more...*/}
            </div>
        </AppLayout>
    );
}
