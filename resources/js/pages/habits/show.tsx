import DailyHabitDetails from '@/components/habit/daily-habit-details';
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/app-layout';
import { Habit } from '@/types';

interface Props {
    habit: Habit;
}

export default function Show({ habit }: Props) {
    return (
        <AppLayout>
            <DailyHabitDetails habit={habit} />

            <Toaster />
        </AppLayout>
    );
}
