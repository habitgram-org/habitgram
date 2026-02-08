import { Badge } from '@/components/ui/badge';
import { Button, buttonVariants } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { cn } from '@/lib/utils';
import { Habit, PaginatedResponse } from '@/types';
import { Link } from '@inertiajs/react';
import {
    CheckCircle2,
    ChevronLeft,
    ChevronRight,
    Filter,
    Flame,
    MoreVertical,
    Plus,
    Search,
    Target,
    Trash2Icon,
} from 'lucide-react';
import { useState } from 'react';

// Types
type HabitType = 'daily' | 'count' | 'abstinence';

// interface Habit {
//     id: string;
//     title: string;
//     type: HabitType;
//     streak: number;
//     goal?: string; // e.g. "3 times" or "30 mins"
//     lastCompleted?: Date;
//     status: 'completed' | 'pending' | 'failed' | 'active'; // active for abstinence
//     color: string;
// }

export default function Index({
    response,
}: {
    response: PaginatedResponse<Habit>;
}) {
    const [currentPage, setCurrentPage] = useState(1);
    const [searchQuery, setSearchQuery] = useState('');
    const [typeFilter, setTypeFilter] = useState<string>('all');

    // Filter Logic
    // const filteredHabits = MOCK_HABITS.filter((habit) => {
    //     const matchesSearch = habit.title
    //         .toLowerCase()
    //         .includes(searchQuery.toLowerCase());
    //     const matchesType = typeFilter === 'all' || habit.type === typeFilter;
    //     return matchesSearch && matchesType;
    // });

    // Pagination Logic
    // const totalPages = Math.ceil(filteredHabits.length / itemsPerPage);
    // const currentHabits = filteredHabits.slice(
    //     startIndex,
    //     startIndex + itemsPerPage,
    // );

    const getTypeLabel = (type: HabitType) => {
        switch (type) {
            case 'daily':
                return 'Daily';
            case 'count':
                return 'Count';
            case 'abstinence':
                return 'Abstinence';
        }
    };

    const getStatusBadge = (habit: HabitCollection) => {
        if (habit.type === 'abstinence') {
            return (
                <Badge
                    variant="outline"
                    className="gap-1 border-emerald-200 bg-emerald-50 text-emerald-700"
                >
                    <CheckCircle2 className="size-3" />
                    Clean
                </Badge>
            );
        }

        if (habit.status === 'completed') {
            return (
                <Badge
                    variant="outline"
                    className="gap-1 border-emerald-200 bg-emerald-50 text-emerald-700"
                >
                    <CheckCircle2 className="size-3" />
                    Done
                </Badge>
            );
        }

        return (
            <Badge
                variant="outline"
                className="gap-1 border-slate-200 bg-slate-50 text-slate-600"
            >
                <Target className="size-3" />
                Pending
            </Badge>
        );
    };

    return (
        <AppLayout>
            <div className="mx-auto max-w-5xl space-y-6">
                {/* Header */}
                <div className="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 md:text-3xl">
                            My Habits
                        </h1>
                        <p className="mt-1 text-slate-500">
                            Manage and track your daily goals.
                        </p>
                    </div>

                    <Link
                        className={cn(
                            buttonVariants({
                                variant: 'default',
                                size: 'default',
                                className:
                                    'gap-2 bg-slate-900 text-white hover:bg-slate-800',
                            }),
                        )}
                        href={route('habits.create')}
                    >
                        <Plus className="size-4" />
                        New Habit
                    </Link>
                </div>

                {/* Filters & Search */}
                <div className="flex flex-col gap-4 rounded-xl border bg-white p-4 shadow-sm md:flex-row">
                    <div className="relative flex-1">
                        <Search className="absolute top-1/2 left-3 size-4 -translate-y-1/2 text-slate-400" />
                        <Input
                            placeholder="Search habits..."
                            className="border-slate-200 bg-slate-50 pl-9"
                            value={searchQuery}
                            onChange={(e) => {
                                setSearchQuery(e.target.value);
                                setCurrentPage(1); // Reset to page 1 on search
                            }}
                        />
                    </div>
                    <div className="flex w-full gap-2 md:w-auto">
                        <Select
                            value={typeFilter}
                            onValueChange={(val) => {
                                setTypeFilter(val);
                                setCurrentPage(1);
                            }}
                        >
                            <SelectTrigger className="w-full border-slate-200 bg-slate-50 md:w-[180px]">
                                <div className="flex items-center gap-2">
                                    <Filter className="size-4 text-slate-500" />
                                    <SelectValue placeholder="Filter by type" />
                                </div>
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="all">All Types</SelectItem>
                                <SelectItem value="daily">Daily</SelectItem>
                                <SelectItem value="count">
                                    Count Based
                                </SelectItem>
                                <SelectItem value="abstinence">
                                    Abstinence
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </div>

                {/* Habits Grid */}
                <div className="space-y-4">
                    {response.meta.total === 0 ? (
                        <div className="rounded-xl border border-dashed border-slate-300 bg-white py-20 text-center">
                            <div className="mx-auto mb-4 flex size-12 items-center justify-center rounded-full bg-slate-100">
                                <Search className="size-6 text-slate-400" />
                            </div>
                            <h3 className="text-lg font-medium text-slate-900">
                                No habits found
                            </h3>
                            <p className="mx-auto mt-1 max-w-sm text-slate-500">
                                We couldn't find any habits matching your
                                filters. Try adjusting your search or create a
                                new one.
                            </p>
                        </div>
                    ) : (
                        response.data.map((habit) => (
                            <Card
                                key={habit.id}
                                className="group p-4 transition-shadow hover:shadow-md"
                            >
                                <div className="flex items-center gap-4">
                                    <img
                                        src={habit.image}
                                        className="flex size-12 shrink-0 items-center justify-center rounded-xl text-white shadow-sm"
                                        alt=""
                                    />

                                    {/* Info */}
                                    <div className="min-w-0 flex-1">
                                        <div className="mb-1 flex items-center gap-2">
                                            <h3 className="truncate font-semibold text-slate-900">
                                                {habit.name}
                                            </h3>
                                            <Badge
                                                variant="secondary"
                                                className="h-5 border-0 bg-slate-100 px-1.5 text-[10px] font-normal text-slate-500"
                                            >
                                                {getTypeLabel(habit.type)}
                                            </Badge>
                                        </div>

                                        <div className="flex items-center gap-4 text-sm text-slate-500">
                                            <div className="flex items-center gap-1">
                                                <Flame className="size-3.5 text-orange-500" />
                                                <span className="font-medium text-slate-700">
                                                    {habit.streak ?? 999}
                                                </span>
                                            </div>
                                            {habit.goal && (
                                                <>
                                                    <span className="text-slate-300">
                                                        •
                                                    </span>
                                                    <span className="text-xs">
                                                        Goal: {habit.goal}
                                                    </span>
                                                </>
                                            )}
                                        </div>
                                    </div>

                                    {/* Right Side Actions */}
                                    <div className="flex items-center gap-3">
                                        {getStatusBadge(habit)}

                                        <DropdownMenu>
                                            <DropdownMenuTrigger asChild>
                                                <Button
                                                    variant="ghost"
                                                    size="icon"
                                                    className="text-slate-400 hover:text-slate-600"
                                                >
                                                    <MoreVertical className="size-4" />
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="end">
                                                <DropdownMenuLabel>
                                                    Actions
                                                </DropdownMenuLabel>
                                                <DropdownMenuItem>
                                                    Edit Habit
                                                </DropdownMenuItem>
                                                <DropdownMenuSeparator />
                                                <DropdownMenuItem className="text-red-600">
                                                    <Trash2Icon className="mr-2 size-4" />
                                                    Delete
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </div>
                                </div>
                            </Card>
                        ))
                    )}
                </div>

                {/* Pagination */}
                {response.meta.total > 1 && (
                    <div className="flex items-center justify-between border-t pt-4">
                        <p className="text-sm text-slate-500">
                            Showing{' '}
                            <span className="font-medium">
                                {response.meta.from}
                            </span>{' '}
                            to{' '}
                            <span className="font-medium">
                                {response.meta.to}
                            </span>{' '}
                            of{' '}
                            <span className="font-medium">
                                {response.meta.total}
                            </span>{' '}
                            results
                        </p>

                        <div className="flex items-center gap-2">
                            <Button
                                variant="outline"
                                size="sm"
                                onClick={() =>
                                    setCurrentPage((p) => Math.max(1, p - 1))
                                }
                                disabled={currentPage === 1}
                            >
                                <ChevronLeft className="mr-1 size-4" />
                                Previous
                            </Button>
                            <div className="flex items-center gap-1 px-2">
                                {Array.from(
                                    { length: response.meta.total },
                                    (_, i) => i + 1,
                                ).map((page) => (
                                    <button
                                        key={page}
                                        onClick={() => setCurrentPage(page)}
                                        className={cn(
                                            'size-8 rounded-md text-sm font-medium transition-colors',
                                            currentPage === page
                                                ? 'bg-slate-900 text-white'
                                                : 'text-slate-500 hover:bg-slate-100',
                                        )}
                                    >
                                        {page}
                                    </button>
                                ))}
                            </div>
                            <Button
                                variant="outline"
                                size="sm"
                                onClick={() =>
                                    setCurrentPage((p) =>
                                        Math.min(response.meta.total, p + 1),
                                    )
                                }
                                disabled={currentPage === response.meta.total}
                            >
                                Next
                                <ChevronRight className="ml-1 size-4" />
                            </Button>
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
