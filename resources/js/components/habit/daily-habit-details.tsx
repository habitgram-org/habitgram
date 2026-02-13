import HabitHeader from '@/components/habit/habit-header';
import HabitNotesTab from '@/components/habit/habit-notes-tab';
import LogActivityDialog from '@/components/habit/log-activity-dialog';
import InspirationalQuoteCard from '@/components/inspirational-quote-card';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import {
    Tooltip,
    TooltipContent,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { cn } from '@/lib/utils';
import { DailyHabit, Habit, SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import {
    Calendar,
    Check,
    ChevronDown,
    Clock,
    FileText,
    PenLine,
    Target,
    TrendingUp,
    Trophy,
} from 'lucide-react';
import { useState } from 'react';

interface Props {
    habit: Habit;
}

enum DayStatus {
    Completed = 'completed',
    Missed = 'missed',
    None = 'none',
}

export default function DailyHabitDetails({ habit }: Props) {
    const { quote } = usePage<SharedData>().props;
    const dailyHabit = habit.habitable as DailyHabit;

    const [isLogDialogOpen, setIsLogDialogOpen] = useState(false);

    const getStatusColor = (isFuture: boolean, status?: DayStatus) => {
        if (isFuture) {
            return 'bg-slate-100';
        }
        if (status === DayStatus.Completed) {
            return 'bg-emerald-500 hover:bg-emerald-600';
        }
        if (status === DayStatus.Missed) {
            return 'bg-red-500 hover:bg-red-600';
        }

        return 'bg-slate-100 hover:bg-slate-200'; // DayStatus.None
    };

    const startDate = new Date(dailyHabit.year, 0, 1);
    const offset = startDate.getDay() === 0 ? 6 : startDate.getDay() - 1;
    const placeholders = Array(offset).fill(null);

    return (
        <div className="min-h-screen bg-slate-50/50 p-4 md:p-6 lg:p-8">
            <div className="mx-auto max-w-5xl space-y-6">
                <HabitHeader
                    title={habit.name}
                    description={habit.description}
                    habitId={habit.id}
                    habitType={habit.type}
                    habitTypeIcon={<Clock className="size-3" />}
                    isPublic={habit.is_public}
                >
                    <Button
                        onClick={() => setIsLogDialogOpen(true)}
                        className={cn(
                            'gap-2',
                            dailyHabit.is_today_completed
                                ? 'bg-emerald-600 text-white hover:bg-emerald-700'
                                : '',
                        )}
                    >
                        {dailyHabit.is_today_completed ? (
                            <Check className="size-4" />
                        ) : (
                            <PenLine className="size-4" />
                        )}
                        {dailyHabit.is_today_completed
                            ? 'Today Completed'
                            : 'Log Today'}
                    </Button>
                </HabitHeader>

                <Card className="overflow-hidden p-6">
                    <div className="mb-6 flex items-center justify-between">
                        <p className="text-sm font-medium text-slate-500">
                            <span className="font-bold text-slate-900">
                                {dailyHabit.completed_days_in_year} days
                            </span>{' '}
                            completed in {dailyHabit.year}
                        </p>
                        <Button
                            variant="outline"
                            size="sm"
                            className="h-8 gap-1"
                        >
                            {dailyHabit.year}
                            <ChevronDown className="size-3 opacity-50" />
                        </Button>
                    </div>
                    <div className="relative overflow-x-auto pb-2">
                        <div className="flex min-w-[800px] gap-2">
                            <div className="grid h-[116px] grid-rows-7 gap-1 py-1 pr-2 text-[10px] font-medium text-slate-400">
                                <span>Mon</span>
                                <span></span>
                                <span>Wed</span>
                                <span></span>
                                <span>Fri</span>
                                <span></span>
                                <span></span>
                            </div>
                            <div className="flex-1">
                                <div className="mb-2 flex justify-between px-1 text-[10px] font-medium text-slate-400">
                                    <span>Jan</span>
                                    <span>Feb</span>
                                    <span>Mar</span>
                                    <span>Apr</span>
                                    <span>May</span>
                                    <span>Jun</span>
                                    <span>Jul</span>
                                    <span>Aug</span>
                                    <span>Sep</span>
                                    <span>Oct</span>
                                    <span>Nov</span>
                                    <span>Dec</span>
                                </div>

                                <div className="grid h-[116px] grid-flow-col grid-rows-7 gap-1">
                                    {placeholders.map((_, i) => (
                                        <div
                                            key={`placeholder-${i}`}
                                            className="size-3.5 bg-transparent"
                                        />
                                    ))}
                                    {dailyHabit.entries.map((day) => {
                                        return (
                                            <Tooltip>
                                                <TooltipTrigger>
                                                    <div
                                                        key={day.date}
                                                        className={cn(
                                                            'size-3.5 cursor-pointer rounded-sm transition-colors',
                                                            getStatusColor(
                                                                day.is_future,
                                                                day.is_succeeded &&
                                                                    day.is_succeeded
                                                                    ? DayStatus.Completed
                                                                    : DayStatus.Missed,
                                                            ),
                                                        )}
                                                    />
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    {day.date}
                                                </TooltipContent>
                                            </Tooltip>
                                        );
                                    })}
                                </div>
                            </div>
                        </div>

                        <div className="mt-6 flex items-center gap-4 pl-8 text-xs text-slate-500">
                            <span>Legend:</span>
                            <div className="flex items-center gap-1.5">
                                <div className="size-3 rounded-full bg-emerald-500" />
                                <span>Completed</span>
                            </div>
                            <div className="flex items-center gap-1.5">
                                <div className="size-3 rounded-full bg-red-500" />
                                <span>Missed</span>
                            </div>
                            <div className="flex items-center gap-1.5">
                                <div className="size-3 rounded-full bg-slate-100" />
                                <span>Future</span>
                            </div>
                        </div>
                    </div>
                </Card>

                <InspirationalQuoteCard quote={quote} />

                {/* Tabs & Content */}
                <Tabs defaultValue="overview" className="w-full">
                    <TabsList className="w-full">
                        <TabsTrigger value="overview" className="flex-1">
                            <TrendingUp className="mr-2 size-4" />
                            Overview
                        </TabsTrigger>
                        <TabsTrigger value="notes" className="flex-1">
                            <FileText className="mr-2 size-4" />
                            Notes ({habit.notes_count})
                        </TabsTrigger>
                    </TabsList>

                    <TabsContent value="overview" className="mt-6 space-y-6">
                        {/* Stats Grid */}
                        <div className="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                            <Card className="flex flex-col items-center justify-center space-y-3 p-6 text-center">
                                <div className="rounded-lg bg-amber-100 p-3 text-amber-600">
                                    <Trophy className="size-5" />
                                </div>
                                <div>
                                    <p className="text-xs font-medium tracking-wide text-slate-500 uppercase">
                                        Longest Streak
                                    </p>
                                    <p className="mt-1 text-3xl font-bold text-slate-900">
                                        {dailyHabit.longest_streak_days} days
                                    </p>
                                    <p className="mt-1 text-[10px] text-slate-400">
                                        {dailyHabit.max_streak_start} -{' '}
                                        {dailyHabit.max_streak_end}
                                    </p>
                                </div>
                            </Card>

                            <Card className="flex flex-col items-center justify-center space-y-3 p-6 text-center">
                                <div className="rounded-lg bg-emerald-100 p-3 text-emerald-600">
                                    <TrendingUp className="size-5" />
                                </div>
                                <div>
                                    <p className="text-xs font-medium tracking-wide text-slate-500 uppercase">
                                        Current Streak
                                    </p>
                                    <p className="mt-1 text-3xl font-bold text-slate-900">
                                        {dailyHabit.current_streak_days} days
                                    </p>
                                </div>
                            </Card>

                            <Card className="flex flex-col items-center justify-center space-y-3 p-6 text-center">
                                <div className="rounded-lg bg-blue-100 p-3 text-blue-600">
                                    <Calendar className="size-5" />
                                </div>
                                <div>
                                    <p className="text-xs font-medium tracking-wide text-slate-500 uppercase">
                                        Total Completions
                                    </p>
                                    <p className="mt-1 text-3xl font-bold text-slate-900">
                                        {dailyHabit.total_completions}
                                    </p>
                                </div>
                            </Card>

                            <Card className="flex flex-col items-center justify-center space-y-3 p-6 text-center">
                                <div className="rounded-lg bg-purple-100 p-3 text-purple-600">
                                    <Target className="size-5" />
                                </div>
                                <div>
                                    <p className="text-xs font-medium tracking-wide text-slate-500 uppercase">
                                        Completion Rate
                                    </p>
                                    <p className="mt-1 text-3xl font-bold text-slate-900">
                                        {dailyHabit.completion_rate}%
                                    </p>
                                </div>
                            </Card>
                        </div>

                        {/* Recent Thoughts */}
                        {habit.notes_count !== 0 && (
                            <Card className="p-6">
                                <h3 className="mb-4 text-base font-semibold text-slate-900">
                                    Recent Thoughts
                                </h3>
                                <div className="space-y-6">
                                    {habit.notes?.slice(0, 5).map((note) => (
                                        <div key={note.id} className="group">
                                            <p className="mb-1 text-sm font-medium text-slate-800">
                                                {note.note}
                                            </p>
                                            <p className="text-xs text-slate-400">
                                                {note.created_at}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </Card>
                        )}
                    </TabsContent>

                    <TabsContent value="notes" className="mt-6">
                        <HabitNotesTab notes={habit.notes} />
                    </TabsContent>
                </Tabs>

                <LogActivityDialog
                    open={isLogDialogOpen}
                    onOpenChange={setIsLogDialogOpen}
                    todayDate={dailyHabit.today_date}
                    action={route('habits.daily.entries.store', {
                        dailyHabit: dailyHabit.id,
                    })}
                />
            </div>
        </div>
    );
}
