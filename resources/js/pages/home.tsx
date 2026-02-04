import {
    Empty,
    EmptyContent,
    EmptyDescription,
    EmptyHeader,
    EmptyTitle,
} from '@/components/ui/empty';
import AppLayout from '@/layouts/app-layout';

export default function Home() {
    return (
        <AppLayout>
            <div className="mx-auto flex h-screen flex-col items-center justify-center border-2">
                <Empty>
                    <EmptyHeader>
                        <EmptyTitle>No Habits Yet</EmptyTitle>
                        <EmptyDescription>
                            You haven&apos;t created any habits yet. Get started
                            by creating your first habit.
                        </EmptyDescription>
                    </EmptyHeader>
                    <EmptyContent></EmptyContent>
                </Empty>{' '}
            </div>
        </AppLayout>
    );
}
