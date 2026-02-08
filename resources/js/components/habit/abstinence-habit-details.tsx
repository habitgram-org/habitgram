import AddNoteDialog from '@/components/habit/add-note-dialog';
import AddRelapseDialog from '@/components/habit/add-relapse-dialog';
import HabitHeader from '@/components/habit/habit-header';
import HabitNotesTab from '@/components/habit/habit-notes-tab';
import InspirationalQuoteCard from '@/components/inspirational-quote-card';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Progress } from '@/components/ui/progress';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { AbstinenceHabit, Habit, SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import {
    Clock,
    FileText,
    History,
    MousePointerClick,
    RefreshCw,
    ShieldCheckIcon,
    TrendingUp,
    Trophy,
} from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import { NumericFormat } from 'react-number-format';

interface Props {
    habit: Habit;
}

type TimeViewMode = 'detailed' | 'days' | 'hours' | 'minutes' | 'seconds';

export default function AbstinenceHabitDetails({ habit }: Props) {
    const { quote } = usePage<SharedData>().props;
    const abstinenceHabit = habit.habitable as AbstinenceHabit;
    const initialDuration = abstinenceHabit.duration;
    const [isNoteDialogOpen, setIsNoteDialogOpen] = useState(false);
    const [timeViewMode, setTimeViewMode] = useState<TimeViewMode>('detailed');
    const [isRelapseDialogOpen, setIsRelapseDialogOpen] = useState(false);
    const [currentDuration, setCurrentDuration] = useState(initialDuration);
    const time = formatDuration(currentDuration);
    const startTimeRef = useRef<number | null>(null);

    useEffect(() => {
        if (startTimeRef.current === null) {
            startTimeRef.current = Date.now() - initialDuration;
        }
    }, []);

    useEffect(() => {
        startTimeRef.current = Date.now() - initialDuration;
    }, [initialDuration]);

    useEffect(() => {
        const interval = setInterval(() => {
            if (startTimeRef.current !== null) {
                const elapsed = Date.now() - startTimeRef.current;
                setCurrentDuration(elapsed);
            }
        }, 1000);

        return () => clearInterval(interval);
    }, []);
    function formatDuration(ms: number) {
        const seconds = Math.floor((ms / 1000) % 60);
        const minutes = Math.floor((ms / (1000 * 60)) % 60);
        const hours = Math.floor((ms / (1000 * 60 * 60)) % 24);
        const days = Math.floor(ms / (1000 * 60 * 60 * 24));

        return { days, hours, minutes, seconds };
    }

    function toggleTimeView() {
        const modes: TimeViewMode[] = [
            'detailed',
            'seconds',
            'minutes',
            'hours',
            'days',
        ];
        const currentIndex = modes.indexOf(timeViewMode);
        const nextIndex = (currentIndex + 1) % modes.length;
        setTimeViewMode(modes[nextIndex]);
    }

    function renderTimerContent() {
        switch (timeViewMode) {
            case 'seconds':
                return (
                    <div className="flex animate-in flex-col items-center duration-300 fade-in zoom-in">
                        <span className="text-5xl font-bold text-emerald-600 tabular-nums md:text-7xl lg:text-8xl">
                            <NumericFormat
                                disabled={true}
                                className="text-center"
                                value={Math.trunc(currentDuration / 1000)}
                                thousandSeparator={' '}
                            />
                        </span>
                        <span className="mt-2 text-sm font-medium text-slate-500 md:text-base">
                            TOTAL SECONDS
                        </span>
                    </div>
                );
            case 'minutes':
                return (
                    <div className="flex animate-in flex-col items-center duration-300 fade-in zoom-in">
                        <span className="text-5xl font-bold text-emerald-600 tabular-nums md:text-7xl lg:text-8xl">
                            <NumericFormat
                                disabled={true}
                                className="text-center"
                                value={Math.trunc(
                                    currentDuration / (1000 * 60),
                                )}
                                thousandSeparator={' '}
                            />
                        </span>
                        <span className="mt-2 text-sm font-medium text-slate-500 md:text-base">
                            TOTAL MINUTES
                        </span>
                    </div>
                );
            case 'hours':
                return (
                    <div className="flex animate-in flex-col items-center duration-300 fade-in zoom-in">
                        <span className="text-5xl font-bold text-emerald-600 tabular-nums md:text-7xl lg:text-8xl">
                            <NumericFormat
                                disabled={true}
                                className="text-center"
                                value={Math.trunc(
                                    currentDuration / (1000 * 60 * 60),
                                )}
                                thousandSeparator={' '}
                            />
                        </span>
                        <span className="mt-2 text-sm font-medium text-slate-500 md:text-base">
                            TOTAL HOURS
                        </span>
                    </div>
                );
            case 'days':
                return (
                    <div className="flex animate-in flex-col items-center duration-300 fade-in zoom-in">
                        <span className="text-5xl font-bold text-emerald-600 tabular-nums md:text-7xl lg:text-8xl">
                            {Math.trunc(
                                currentDuration / (1000 * 60 * 60 * 24),
                            )}
                        </span>
                        <span className="mt-2 text-sm font-medium text-slate-500 md:text-base">
                            TOTAL DAYS
                        </span>
                    </div>
                );
            case 'detailed':
            default:
                return (
                    <div className="mx-auto grid max-w-lg animate-in grid-cols-4 gap-2 duration-300 fade-in zoom-in md:gap-4">
                        <div className="flex flex-col items-center">
                            <span className="text-4xl font-bold text-emerald-600 tabular-nums md:text-5xl lg:text-6xl">
                                {time.days.toString().padStart(2, '0')}
                            </span>
                            <span className="text-xs font-medium text-slate-500 md:text-sm">
                                DAYS
                            </span>
                        </div>
                        <div className="flex flex-col items-center">
                            <span className="text-4xl font-bold text-slate-700 tabular-nums md:text-5xl lg:text-6xl">
                                {time.hours.toString().padStart(2, '0')}
                            </span>
                            <span className="text-xs font-medium text-slate-500 md:text-sm">
                                HRS
                            </span>
                        </div>
                        <div className="flex flex-col items-center">
                            <span className="text-4xl font-bold text-slate-700 tabular-nums md:text-5xl lg:text-6xl">
                                {time.minutes.toString().padStart(2, '0')}
                            </span>
                            <span className="text-xs font-medium text-slate-500 md:text-sm">
                                MINS
                            </span>
                        </div>
                        <div className="flex flex-col items-center">
                            <span className="text-4xl font-bold text-slate-400 tabular-nums md:text-5xl lg:text-6xl">
                                {time.seconds.toString().padStart(2, '0')}
                            </span>
                            <span className="text-xs font-medium text-slate-500 md:text-sm">
                                SECS
                            </span>
                        </div>
                    </div>
                );
        }
    }

    return (
        <div className="min-h-screen bg-gradient-to-b from-slate-50 to-white p-4 md:p-6 lg:p-8">
            <div className="mx-auto max-w-2xl space-y-6">
                <HabitHeader
                    title={habit.name}
                    habitId={habit.id}
                    habitType="Abstinence Habit"
                    habitTypeIcon={<ShieldCheckIcon className="size-3" />}
                    isPublic={habit.is_public}
                />

                {/*Main Timer Display*/}
                <Card className="group relative overflow-hidden border-blue-100 bg-gradient-to-br from-emerald-50 to-teal-50 p-8 transition-all hover:shadow-md md:p-12">
                    <div className="pointer-events-none absolute top-0 right-0 p-4 opacity-5">
                        <Clock className="size-48" />
                    </div>

                    {/* View Toggle Hint */}
                    <div
                        onClick={toggleTimeView}
                        className="absolute top-4 right-4 flex cursor-pointer items-center gap-1 text-xs font-medium text-slate-400 opacity-0 transition-opacity group-hover:opacity-100"
                    >
                        <MousePointerClick className="size-3" />
                        Click to cycle view
                    </div>

                    <div className="relative z-10 space-y-8 text-center">
                        <div className="space-y-2 select-none">
                            <p className="text-sm font-medium tracking-widest text-slate-500 uppercase">
                                {timeViewMode === 'detailed'
                                    ? 'Clean Time'
                                    : `Clean Time (${timeViewMode})`}
                            </p>

                            <div className="flex min-h-[100px] items-center justify-center">
                                {renderTimerContent()}
                            </div>
                        </div>

                        <div className="flex items-center justify-center gap-3">
                            <Button
                                variant="outline"
                                onClick={() => setIsRelapseDialogOpen(true)}
                                className="rounded-full border-red-200 text-red-600 hover:border-red-300 hover:bg-red-50 hover:text-red-700"
                            >
                                <RefreshCw className="mr-2 size-4" />
                                Reset / Relapse
                            </Button>
                            <Button
                                variant="outline"
                                onClick={() => setIsNoteDialogOpen(true)}
                                className="rounded-full"
                            >
                                <FileText className="mr-2 size-4" />
                                Add Note
                            </Button>
                        </div>
                    </div>
                </Card>

                <Tabs defaultValue="overview" className="w-full">
                    <TabsList className="w-full">
                        <TabsTrigger value="overview" className="flex-1">
                            <TrendingUp className="mr-2 size-4" />
                            Overview
                        </TabsTrigger>
                        <TabsTrigger value="history" className="flex-1">
                            <History className="mr-2 size-4" />
                            Relapses ({abstinenceHabit.relapses_count}){' '}
                        </TabsTrigger>
                        <TabsTrigger value="notes" className="flex-1">
                            <FileText className="mr-2 size-4" />
                            Notes ({habit.notes_count})
                        </TabsTrigger>
                    </TabsList>

                    <TabsContent value="overview" className="mt-6 space-y-6">
                        {abstinenceHabit.goal && (
                            <Card className="space-y-3 p-6">
                                <div className="flex items-center justify-between">
                                    <span className="text-sm font-medium text-slate-700">
                                        Goal Progress
                                    </span>
                                    <span className="text-sm font-semibold text-slate-900">
                                        {abstinenceHabit.goal_current} /{' '}
                                        {abstinenceHabit.goal}{' '}
                                        {abstinenceHabit.goal_unit}
                                    </span>
                                </div>
                                {abstinenceHabit.goal_progress !==
                                    undefined && (
                                    <Progress
                                        value={abstinenceHabit.goal_progress}
                                        className="h-3"
                                    />
                                )}
                                {abstinenceHabit.goal_progress !== undefined &&
                                    abstinenceHabit.goal_remaining !==
                                        undefined && (
                                        <p className="text-xs text-slate-500">
                                            {abstinenceHabit.goal_remaining}{' '}
                                            {abstinenceHabit.goal_unit} to go •{' '}
                                            {abstinenceHabit.goal_progress}%
                                            complete
                                        </p>
                                    )}
                            </Card>
                        )}
                        {/* Stats Grid */}
                        <div className="grid grid-cols-1 gap-4">
                            <Card className="flex flex-col items-center justify-center space-y-2 p-6 text-center">
                                <div className="rounded-full bg-amber-100 p-3 text-amber-600">
                                    <Trophy className="size-6" />
                                </div>
                                <div>
                                    <p className="text-sm font-medium text-slate-500">
                                        Longest Streak
                                    </p>
                                    <p className="text-2xl font-bold text-slate-900">
                                        {abstinenceHabit.max_streak_days} days
                                    </p>
                                    <p className="mt-1 text-sm text-slate-400">
                                        {abstinenceHabit.max_streak_start} -{' '}
                                        {abstinenceHabit.max_streak_end}
                                    </p>
                                </div>
                            </Card>
                        </div>{' '}
                    </TabsContent>

                    <TabsContent value="notes" className="mt-6">
                        <HabitNotesTab notes={habit.notes} />
                    </TabsContent>

                    <TabsContent value="history" className="mt-6">
                        <Card className="p-6">
                            <div className="flex items-center justify-between">
                                <h2 className="text-lg font-semibold text-slate-900">
                                    Relapse History
                                </h2>
                            </div>
                            {abstinenceHabit.relapses_count === 0 ? (
                                <div className="py-8 text-center">
                                    <Trophy className="mx-auto mb-3 size-12 text-emerald-300" />
                                    <h3 className="font-medium text-slate-900">
                                        Clean Sheet!
                                    </h3>
                                    <p className="text-sm text-slate-500">
                                        No relapses recorded yet. Keep it up!
                                    </p>
                                </div>
                            ) : (
                                <div className="space-y-6">
                                    {abstinenceHabit.relapses.map((relapse) => (
                                        <div
                                            key={relapse.id}
                                            className="relative border-l-2 border-slate-100 pb-6 pl-6 last:border-0 last:pb-0"
                                        >
                                            <div className="absolute top-1.5 left-[-5px] size-2.5 rounded-full bg-red-400" />
                                            <div className="space-y-1">
                                                <div className="flex justify-between">
                                                    <p className="text-sm font-medium text-slate-900">
                                                        {relapse.happened_at},
                                                    </p>
                                                    <span className="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-500">
                                                        {relapse.streak_days}{' '}
                                                        day streak
                                                    </span>
                                                </div>
                                                <p className="text-sm text-slate-600">
                                                    {relapse.reason ||
                                                        'No reason recorded'}
                                                </p>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </Card>
                    </TabsContent>
                </Tabs>

                <InspirationalQuoteCard quote={quote} />

                <AddRelapseDialog
                    open={isRelapseDialogOpen}
                    onOpenChange={setIsRelapseDialogOpen}
                    action={route('habits.abstinence.relapses.store', {
                        abstinenceHabit: abstinenceHabit.id,
                    })}
                />

                <AddNoteDialog
                    open={isNoteDialogOpen}
                    onOpenChange={setIsNoteDialogOpen}
                    habitId={habit.id}
                />
            </div>
        </div>
    );
}
