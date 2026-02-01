import CountHabitDetails from '@/components/habit/count-habit-details';
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/app-layout';
import { Habit, InspirationalQuote } from '@/types';

interface Props {
    habit: Habit;
    quote: InspirationalQuote;
}

export default function Show({ habit, quote }: Props) {
    return (
        <AppLayout>
            <CountHabitDetails habit={habit} quote={quote} />
            <Toaster />
        </AppLayout>
    );
}
