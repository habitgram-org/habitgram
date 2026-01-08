import type { CountHabit } from '@/types';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import {
    Table, TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { ButtonGroup } from '@/components/ui/button-group';
import { Button } from '@/components/ui/button';
import {PlusIcon } from 'lucide-react';
import { router } from '@inertiajs/react'
import { FormEvent } from 'react';


interface Props {
    habit: CountHabit;
    habitId: string;
}

export default function CountHabit({ habit, habitId }: Props) {
    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        router.post('/habits/' + habitId + '/entries', {value: 1, type: 'count'}); // TODO: use Ziggy
    }

    return (
        <div className="">
            <h1 className="mt-6 text-center text-4xl font-bold">
                {habit.total}
            </h1>

            <form onSubmit={handleSubmit}>
                <ButtonGroup
                    orientation="horizontal"
                    className="mx-auto mt-2 mb-6 h-fit"
                >
                    <Button type="submit" variant="outline" size="icon">
                        <PlusIcon />
                    </Button>
                </ButtonGroup>
            </form>

            {/*Some toast*/}

            <Tabs defaultValue="entries">
                <TabsList>
                    <TabsTrigger value="entries">Entries</TabsTrigger>
                    <TabsTrigger value="notes">Notes</TabsTrigger>
                </TabsList>
                <TabsContent value="entries">
                    <Table>
                        <TableCaption>A list of your entries</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Value</TableHead>
                                <TableHead>Created at</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {habit.entries.map((e) => (
                                <TableRow key={e.id}>
                                    <TableCell className="font-medium">
                                        {e.value}
                                    </TableCell>
                                    <TableCell>{e.created_at}</TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </TabsContent>
                <TabsContent value="notes">
                    <Table>
                        <TableCaption>A list of your notes</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Content</TableHead>
                                <TableHead>Created at</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody></TableBody>
                    </Table>
                </TabsContent>
            </Tabs>
        </div>
    );
}
