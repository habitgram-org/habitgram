import AbstinenceHabitDetails from '@/components/habit/abstinence-habit-details';
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/app-layout';
import { Habit } from '@/types';

interface Props {
    habit: Habit;
}

export default function Show({ habit }: Props) {
    return (
        <AppLayout>
            {/*<CountHabitDetails habit={habit} />*/}
            <AbstinenceHabitDetails habit={habit} />
            <Toaster />
        </AppLayout>
    );
}
