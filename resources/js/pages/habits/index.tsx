import {
    Item,
    ItemActions,
    ItemContent,
    ItemDescription,
    ItemTitle,
} from '@/components/ui/item';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';

import { Button } from '@/components/ui/button';
import { Habit } from '@/types';

export default function Index({ habits }: { habits: Array<Habit> }) {
    return (
        <AppLayout>
            <Head title="My Habits" />

            <div className="flex w-full max-w-md flex-col gap-6 p-6">
                {habits.map((h) => {
                    return (
                        <Item key={h.id} variant="outline">
                            <ItemContent>
                                <ItemTitle>{h.name}</ItemTitle>
                                <ItemDescription>
                                    {h.description}
                                </ItemDescription>
                            </ItemContent>
                            <ItemActions>
                                <Button variant="outline" asChild>
                                    <Link href={route('habits.show', h.id)}>
                                        View
                                    </Link>
                                </Button>
                            </ItemActions>
                        </Item>
                    );
                })}
            </div>
        </AppLayout>
    );
}
