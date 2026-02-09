import DeleteHabitDialog from '@/components/habit/delete-habit-dialog';
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
import useDebounce from '@/hooks/useDebounce';
import AppLayout from '@/layouts/app-layout';
import { cn } from '@/lib/utils';
import { Habit, PaginatedResponse } from '@/types';
import { Link, router } from '@inertiajs/react';
import { upperFirst } from 'lodash-es';
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
import { useEffect, useState } from 'react';

export default function Index({
    response,
}: {
    response: PaginatedResponse<Habit>;
}) {
    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
    const [searchQuery, setSearchQuery] = useState('');
    const [typeFilter, setTypeFilter] = useState('');

    const debouncedSearchQuery = useDebounce(searchQuery, 300);

    useEffect(() => {
        router.get(
            route('index'),
            debouncedSearchQuery || typeFilter
                ? { search: debouncedSearchQuery, type: typeFilter }
                : {},
            { preserveState: true },
        );
    }, [debouncedSearchQuery, typeFilter]);

    function handleTypeFilterChange(val: string) {
        setTypeFilter(val);
    }

    const getStatusBadge = (habit: Habit) => {
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
                            onChange={(e) => setSearchQuery(e.target.value)}
                        />
                    </div>
                    <div className="flex w-full gap-2 md:w-auto">
                        <Select
                            value={typeFilter}
                            onValueChange={handleTypeFilterChange}
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
                                            <Link
                                                href={route(
                                                    'habits.show',
                                                    habit.id,
                                                )}
                                                className="truncate font-semibold text-slate-900"
                                            >
                                                {habit.name}
                                            </Link>
                                            <Badge
                                                variant="secondary"
                                                className="h-5 border-0 bg-slate-100 px-1.5 text-[10px] font-normal text-slate-500"
                                            >
                                                {upperFirst(habit.type)}
                                            </Badge>
                                        </div>

                                        <div className="flex items-center gap-4 text-sm text-slate-500">
                                            <div className="flex items-center gap-1">
                                                <Flame className="size-3.5 text-orange-500" />
                                                <span className="font-medium text-slate-700">
                                                    {habit.streak}
                                                </span>
                                            </div>
                                            {habit.habitable?.goal && (
                                                <>
                                                    <span className="text-slate-300">
                                                        •
                                                    </span>
                                                    <span className="text-xs">
                                                        Goal:{' '}
                                                        {habit.habitable.goal +
                                                            ' ' +
                                                            habit.habitable
                                                                .goal_unit}
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
                                                <DropdownMenuItem
                                                    variant="destructive"
                                                    onSelect={(e) => {
                                                        e.preventDefault();
                                                        setIsDeleteDialogOpen(
                                                            true,
                                                        );
                                                    }}
                                                    className="text-red-600"
                                                >
                                                    <Trash2Icon className="mr-2 size-4" />
                                                    Delete
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </div>
                                </div>
                                <DeleteHabitDialog
                                    open={isDeleteDialogOpen}
                                    onOpenChange={setIsDeleteDialogOpen}
                                    action={route('habits.destroy', habit.id)}
                                />
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
                            <Link
                                as="button"
                                href={response.links[0].url ?? '#'}
                                className={cn(
                                    buttonVariants({
                                        variant: 'outline',
                                        size: 'sm',
                                    }),
                                )}
                                disabled={response.meta.current_page === 1}
                            >
                                <ChevronLeft className="mr-1 size-4" />
                                Previous
                            </Link>

                            <div className="flex items-center gap-1 px-2">
                                {Array.from(
                                    { length: response.links.length - 2 },
                                    (_, i) => i + 1,
                                ).map((page) => (
                                    <Link
                                        href={response.links[page].url ?? '#'}
                                        key={page}
                                        className={cn(
                                            buttonVariants({
                                                variant: 'default',
                                                size: 'default',
                                            }),
                                            'size-8 rounded-md text-sm font-medium transition-colors',
                                            response.meta.current_page === page
                                                ? 'bg-slate-900 text-white'
                                                : 'bg-slate-50 text-slate-500 hover:bg-slate-100',
                                        )}
                                    >
                                        {page}
                                    </Link>
                                ))}
                            </div>

                            <Link
                                as="button"
                                href={
                                    response.links[response.links.length - 1]
                                        .url ?? '#'
                                }
                                className={cn(
                                    buttonVariants({
                                        variant: 'outline',
                                        size: 'sm',
                                    }),
                                )}
                                disabled={
                                    response.meta.current_page ===
                                    response.meta.last_page
                                }
                            >
                                Next
                                <ChevronRight className="ml-1 size-4" />
                            </Link>
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
