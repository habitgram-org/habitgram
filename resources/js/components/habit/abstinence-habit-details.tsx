import DeleteHabitDialog from '@/components/habit/delete-habit-dialog';
import HabitHeader from '@/components/habit/habit-header';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Habit, SharedData } from '@/types';
import { useForm, usePage } from '@inertiajs/react';
import { FileText, ShieldCheckIcon, Target } from 'lucide-react';
import { useState } from 'react';
import AddNoteDialog from '@/components/habit/add-note-dialog';

interface Props {
    habit: Habit;
}

interface NoteEntry {
    id: string;
    note: string;
    timestamp: Date;
}

interface RelapseEntry {
    id: string;
    timestamp: Date;
    reason: string;
    duration: number; // duration of the streak in milliseconds
}

type TimeViewMode = 'detailed' | 'seconds' | 'hours' | 'days';

export default function AbstinenceHabitDetails({ habit }: Props) {
    const { quote } = usePage<SharedData>().props;
    const { delete: destroy } = useForm();
    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
    const [isNoteDialogOpen, setIsNoteDialogOpen] = useState(false);

    // Initialize with a date in the past for demo purposes (e.g., 5 days, 4 hours ago)
    // const [startDate, setStartDate] = useState<Date>(
    //     new Date(Date.now() - 416.5 * 24 * 60 * 60 * 1000 - 4 * 60 * 60 * 1000),
    // );
    // const [currentDuration, setCurrentDuration] = useState<number>(0);
    // const [timeViewMode, setTimeViewMode] = useState<TimeViewMode>('detailed');

    // Dialog states
    // const [isRelapseDialogOpen, setIsRelapseDialogOpen] = useState(false);
    // const [isNoteDialogOpen, setIsNoteDialogOpen] = useState(false);
    // const [relapseReason, setRelapseReason] = useState('');
    // const [noteText, setNoteText] = useState('');

    // const [notes, setNotes] = useState<NoteEntry[]>([
    //     {
    //         id: '1',
    //         note: 'Felt a strong urge today after lunch, but went for a walk instead.',
    //         timestamp: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000),
    //     },
    //     {
    //         id: '2',
    //         note: 'One week milestone! Feeling cleaner and more energetic.',
    //         timestamp: new Date(Date.now() - 7 * 24 * 60 * 60 * 1000),
    //     },
    // ]);
    //
    // const [relapses, setRelapses] = useState<RelapseEntry[]>([
    //     {
    //         id: 'r1',
    //         timestamp: new Date(Date.now() - 14 * 24 * 60 * 60 * 1000),
    //         reason: 'Stressful day at work',
    //         duration: 7 * 24 * 60 * 60 * 1000, // Lasted 7 days before this
    //     },
    // ]);

    // Update timer
    // useEffect(() => {
    //     const updateTimer = () => {
    //         const now = new Date();
    //         setCurrentDuration(now.getTime() - startDate.getTime());
    //     };
    //
    //     updateTimer(); // Initial call
    //     const interval = setInterval(updateTimer, 1000); // Update every second
    //
    //     return () => clearInterval(interval);
    // }, [startDate]);

    // const formatDuration = (ms: number) => {
    //     const seconds = Math.floor((ms / 1000) % 60);
    //     const minutes = Math.floor((ms / (1000 * 60)) % 60);
    //     const hours = Math.floor((ms / (1000 * 60 * 60)) % 24);
    //     const days = Math.floor(ms / (1000 * 60 * 60 * 24));
    //
    //     return { days, hours, minutes, seconds };
    // };
    //
    // const time = formatDuration(currentDuration);
    //
    // const toggleTimeView = () => {
    //     const modes: TimeViewMode[] = ['detailed', 'seconds', 'hours', 'days'];
    //     const currentIndex = modes.indexOf(timeViewMode);
    //     const nextIndex = (currentIndex + 1) % modes.length;
    //     setTimeViewMode(modes[nextIndex]);
    // };
    //
    // const renderTimerContent = () => {
    //     switch (timeViewMode) {
    //         case 'seconds':
    //             return (
    //                 <div className="flex animate-in flex-col items-center duration-300 fade-in zoom-in">
    //                     <span className="text-5xl font-bold text-emerald-600 tabular-nums md:text-7xl lg:text-8xl">
    //                         {Math.floor(
    //                             currentDuration / 1000,
    //                         ).toLocaleString()}
    //                     </span>
    //                     <span className="mt-2 text-sm font-medium text-slate-500 md:text-base">
    //                         TOTAL SECONDS
    //                     </span>
    //                 </div>
    //             );
    //         case 'hours':
    //             return (
    //                 <div className="flex animate-in flex-col items-center duration-300 fade-in zoom-in">
    //                     <span className="text-5xl font-bold text-emerald-600 tabular-nums md:text-7xl lg:text-8xl">
    //                         {(currentDuration / (1000 * 60 * 60)).toFixed(0)}
    //                     </span>
    //                     <span className="mt-2 text-sm font-medium text-slate-500 md:text-base">
    //                         TOTAL HOURS
    //                     </span>
    //                 </div>
    //             );
    //         case 'days':
    //             return (
    //                 <div className="flex animate-in flex-col items-center duration-300 fade-in zoom-in">
    //                     <span className="text-5xl font-bold text-emerald-600 tabular-nums md:text-7xl lg:text-8xl">
    //                         {(currentDuration / (1000 * 60 * 60 * 24)).toFixed(
    //                             0,
    //                         )}
    //                     </span>
    //                     <span className="mt-2 text-sm font-medium text-slate-500 md:text-base">
    //                         TOTAL DAYS
    //                     </span>
    //                 </div>
    //             );
    //         case 'detailed':
    //         default:
    //             return (
    //                 <div className="mx-auto grid max-w-lg animate-in grid-cols-4 gap-2 duration-300 fade-in zoom-in md:gap-4">
    //                     <div className="flex flex-col items-center">
    //                         <span className="text-4xl font-bold text-emerald-600 tabular-nums md:text-5xl lg:text-6xl">
    //                             {time.days}
    //                         </span>
    //                         <span className="text-xs font-medium text-slate-500 md:text-sm">
    //                             DAYS
    //                         </span>
    //                     </div>
    //                     <div className="flex flex-col items-center">
    //                         <span className="text-4xl font-bold text-slate-700 tabular-nums md:text-5xl lg:text-6xl">
    //                             {time.hours}
    //                         </span>
    //                         <span className="text-xs font-medium text-slate-500 md:text-sm">
    //                             HRS
    //                         </span>
    //                     </div>
    //                     <div className="flex flex-col items-center">
    //                         <span className="text-4xl font-bold text-slate-700 tabular-nums md:text-5xl lg:text-6xl">
    //                             {time.minutes}
    //                         </span>
    //                         <span className="text-xs font-medium text-slate-500 md:text-sm">
    //                             MINS
    //                         </span>
    //                     </div>
    //                     <div className="flex flex-col items-center">
    //                         <span className="text-4xl font-bold text-slate-400 tabular-nums md:text-5xl lg:text-6xl">
    //                             {time.seconds}
    //                         </span>
    //                         <span className="text-xs font-medium text-slate-500 md:text-sm">
    //                             SECS
    //                         </span>
    //                     </div>
    //                 </div>
    //             );
    //     }
    // };
    //
    // const handleRelapse = () => {
    //     const now = new Date();
    //     const duration = now.getTime() - startDate.getTime();
    //
    //     const newRelapse: RelapseEntry = {
    //         id: Date.now().toString(),
    //         timestamp: now,
    //         reason: relapseReason,
    //         duration: duration,
    //     };
    //
    //     setRelapses((prev) => [newRelapse, ...prev]);
    //     setStartDate(now); // Reset timer
    //     setRelapseReason('');
    //     setIsRelapseDialogOpen(false);
    //     toast.info("Timer reset. Don't give up!");
    // };
    //
    // const handleAddNote = () => {
    //     if (!noteText.trim()) return;
    //
    //     const newNote: NoteEntry = {
    //         id: Date.now().toString(),
    //         note: noteText.trim(),
    //         timestamp: new Date(),
    //     };
    //
    //     setNotes((prev) => [newNote, ...prev]);
    //     setNoteText('');
    //     setIsNoteDialogOpen(false);
    //     toast.success('Note added');
    // };
    //
    // const formatTimestamp = (date: Date) => {
    //     return date.toLocaleDateString('en-US', {
    //         month: 'short',
    //         day: 'numeric',
    //         hour: '2-digit',
    //         minute: '2-digit',
    //     });
    // };
    //
    // const formatRelapseDate = (date: Date) => {
    //     return date.toLocaleDateString('en-US', {
    //         month: 'short',
    //         day: 'numeric',
    //         year: 'numeric',
    //     });
    // };
    //
    // // Calculate stats
    // let maxStreakVal = currentDuration;
    // let maxStreakStart = startDate;
    // let maxStreakEnd = new Date(); // Now
    //
    // relapses.forEach((r) => {
    //     if (r.duration > maxStreakVal) {
    //         maxStreakVal = r.duration;
    //         maxStreakEnd = r.timestamp;
    //         maxStreakStart = new Date(r.timestamp.getTime() - r.duration);
    //     }
    // });
    //
    // const maxStreakDays = Math.floor(maxStreakVal / (1000 * 60 * 60 * 24));
    // const totalRelapses = relapses.length;
    //
    // // Calculate savings (mock data: $10/day for smoking)
    // const daysClean = Math.floor(currentDuration / (1000 * 60 * 60 * 24));
    // const moneySaved = (daysClean * 10).toFixed(0);
    // const moneyLost = (totalRelapses * 10).toFixed(0); // Assuming flat $10 cost per relapse event

    function handleDelete() {
        setIsDeleteDialogOpen(false);
        destroy(route('habits.destroy', { habit: habit.id }));
    }

    return (
        <div className="min-h-screen bg-gradient-to-b from-slate-50 to-white p-4 md:p-6 lg:p-8">
            <div className="mx-auto max-w-2xl space-y-6">
                <HabitHeader
                    title={habit.name}
                    habitType="Abstinence Habit"
                    habitTypeIcon={<ShieldCheckIcon className="size-3" />}
                    isPublic={habit.is_public}
                    onDelete={() => setIsDeleteDialogOpen(true)}
                />

                <DeleteHabitDialog
                    open={isDeleteDialogOpen}
                    onOpenChange={setIsDeleteDialogOpen}
                    onConfirm={handleDelete}
                />

                {/* Main Timer Display */}
                {/*    <Card className="group relative overflow-hidden border-blue-100 bg-gradient-to-br from-emerald-50 to-teal-50 p-8 transition-all hover:shadow-md md:p-12">*/}
                {/*        <div className="pointer-events-none absolute top-0 right-0 p-4 opacity-5">*/}
                {/*            <Clock className="size-48" />*/}
                {/*        </div>*/}

                {/*        /!* View Toggle Hint *!/*/}
                {/*        <div*/}
                {/*            className="absolute top-4 right-4 flex cursor-pointer items-center gap-1 text-xs font-medium text-slate-400 opacity-0 transition-opacity group-hover:opacity-100"*/}
                {/*            onClick={toggleTimeView}*/}
                {/*        >*/}
                {/*            <MousePointerClick className="size-3" />*/}
                {/*            Click to cycle view*/}
                {/*        </div>*/}

                {/*        <div className="relative z-10 space-y-8 text-center">*/}
                {/*            <div*/}
                {/*                className="cursor-pointer space-y-2 select-none"*/}
                {/*                onClick={toggleTimeView}*/}
                {/*            >*/}
                {/*                <p className="text-sm font-medium tracking-widest text-slate-500 uppercase">*/}
                {/*                    {timeViewMode === 'detailed'*/}
                {/*                        ? 'Clean Time'*/}
                {/*                        : `Clean Time (${timeViewMode})`}*/}
                {/*                </p>*/}

                {/*                <div className="flex min-h-[100px] items-center justify-center">*/}
                {/*                    {renderTimerContent()}*/}
                {/*                </div>*/}
                {/*            </div>*/}

                {/*            <div className="flex items-center justify-center gap-3">*/}
                {/*                <Button*/}
                {/*                    variant="outline"*/}
                {/*                    onClick={() => setIsRelapseDialogOpen(true)}*/}
                {/*                    className="rounded-full border-red-200 text-red-600 hover:border-red-300 hover:bg-red-50 hover:text-red-700"*/}
                {/*                >*/}
                {/*                    <RefreshCw className="mr-2 size-4" />*/}
                {/*                    Reset / Relapse*/}
                {/*                </Button>*/}
                                <Button
                                    variant="outline"
                                    onClick={() => setIsNoteDialogOpen(true)}
                                    className="rounded-full"
                                >
                                    <FileText className="mr-2 size-4" />
                                    Add Note
                                </Button>
                {/*            </div>*/}
                {/*        </div>*/}
                {/*    </Card>*/}

                {/*    /!* Tabs *!/*/}
                {/*    <Tabs defaultValue="overview" className="w-full">*/}
                {/*        <TabsList className="w-full">*/}
                {/*            <TabsTrigger value="overview" className="flex-1">*/}
                {/*                <TrendingUp className="mr-2 size-4" />*/}
                {/*                Overview*/}
                {/*            </TabsTrigger>*/}
                {/*            <TabsTrigger value="history" className="flex-1">*/}
                {/*                <History className="mr-2 size-4" />*/}
                {/*                Relapses ({relapses.length})*/}
                {/*            </TabsTrigger>*/}
                {/*            <TabsTrigger value="notes" className="flex-1">*/}
                {/*                <FileText className="mr-2 size-4" />*/}
                {/*                Notes ({notes.length})*/}
                {/*            </TabsTrigger>*/}
                {/*        </TabsList>*/}

                {/*        <TabsContent value="overview" className="mt-6 space-y-6">*/}
                {/*            /!* Stats Grid *!/*/}
                {/*            <div className="grid grid-cols-2 gap-4">*/}
                {/*                <Card className="flex flex-col items-center justify-center space-y-2 p-6 text-center">*/}
                {/*                    <div className="rounded-full bg-amber-100 p-3 text-amber-600">*/}
                {/*                        <Trophy className="size-6" />*/}
                {/*                    </div>*/}
                {/*                    <div>*/}
                {/*                        <p className="text-sm font-medium text-slate-500">*/}
                {/*                            Longest Streak*/}
                {/*                        </p>*/}
                {/*                        <p className="text-2xl font-bold text-slate-900">*/}
                {/*                            {maxStreakDays} days*/}
                {/*                        </p>*/}
                {/*                        <p className="mt-1 text-xs text-slate-400">*/}
                {/*                            {maxStreakStart.toLocaleDateString(*/}
                {/*                                'en-US',*/}
                {/*                                { month: 'short', day: 'numeric' },*/}
                {/*                            )}{' '}*/}
                {/*                            -{' '}*/}
                {/*                            {maxStreakEnd.toLocaleDateString(*/}
                {/*                                'en-US',*/}
                {/*                                { month: 'short', day: 'numeric' },*/}
                {/*                            )}*/}
                {/*                        </p>*/}
                {/*                    </div>*/}
                {/*                </Card>*/}
                {/*                <Card className="flex items-center justify-center p-6 text-center">*/}
                {/*                    <div className="flex w-full items-center justify-center gap-4">*/}
                {/*                        <div className="flex flex-col items-center">*/}
                {/*                            <div className="mb-2 rounded-full bg-emerald-100 p-2 text-emerald-600">*/}
                {/*                                <span className="text-lg font-bold">*/}
                {/*                                    $*/}
                {/*                                </span>*/}
                {/*                            </div>*/}
                {/*                            <p className="text-xs font-medium text-slate-500 uppercase">*/}
                {/*                                Saved*/}
                {/*                            </p>*/}
                {/*                            <p className="text-lg font-bold text-emerald-600">*/}
                {/*                                +${moneySaved}*/}
                {/*                            </p>*/}
                {/*                        </div>*/}
                {/*                        <Separator*/}
                {/*                            orientation="vertical"*/}
                {/*                            className="h-12 bg-slate-100"*/}
                {/*                        />*/}
                {/*                        <div className="flex flex-col items-center">*/}
                {/*                            <div className="mb-2 rounded-full bg-red-100 p-2 text-red-600">*/}
                {/*                                <span className="text-lg font-bold">*/}
                {/*                                    $*/}
                {/*                                </span>*/}
                {/*                            </div>*/}
                {/*                            <p className="text-xs font-medium text-slate-500 uppercase">*/}
                {/*                                Lost*/}
                {/*                            </p>*/}
                {/*                            <p className="text-lg font-bold text-red-600">*/}
                {/*                                -${moneyLost}*/}
                {/*                            </p>*/}
                {/*                        </div>*/}
                {/*                    </div>*/}
                {/*                </Card>*/}
                {/*            </div>*/}

                {/*            <InspirationalQuoteCard quote={quote} />*/}

                {/*            /!* Recent Activity / Notes Preview *!/*/}
                {/*            <Card className="p-6">*/}
                {/*                <h2 className="mb-4 text-lg font-semibold text-slate-900">*/}
                {/*                    Recent Thoughts*/}
                {/*                </h2>*/}
                {/*                <div className="divide-y divide-slate-100">*/}
                {/*                    {notes.slice(0, 3).map((note) => (*/}
                {/*                        <div key={note.id} className="py-3">*/}
                {/*                            <p className="text-sm text-slate-700">*/}
                {/*                                {note.note}*/}
                {/*                            </p>*/}
                {/*                            <p className="mt-1 text-xs text-slate-400">*/}
                {/*                                {formatTimestamp(note.timestamp)}*/}
                {/*                            </p>*/}
                {/*                        </div>*/}
                {/*                    ))}*/}
                {/*                    {notes.length === 0 && (*/}
                {/*                        <p className="text-sm text-slate-500 italic">*/}
                {/*                            No notes yet.*/}
                {/*                        </p>*/}
                {/*                    )}*/}
                {/*                </div>*/}
                {/*            </Card>*/}
                {/*        </TabsContent>*/}

                {/*        <TabsContent value="history" className="mt-6">*/}
                {/*            <Card className="p-6">*/}
                {/*                <div className="mb-4 flex items-center justify-between">*/}
                {/*                    <h2 className="text-lg font-semibold text-slate-900">*/}
                {/*                        Relapse History*/}
                {/*                    </h2>*/}
                {/*                    <Badge variant="outline">*/}
                {/*                        {totalRelapses} total*/}
                {/*                    </Badge>*/}
                {/*                </div>*/}

                {/*                {relapses.length === 0 ? (*/}
                {/*                    <div className="py-8 text-center">*/}
                {/*                        <Trophy className="mx-auto mb-3 size-12 text-emerald-300" />*/}
                {/*                        <h3 className="font-medium text-slate-900">*/}
                {/*                            Clean Sheet!*/}
                {/*                        </h3>*/}
                {/*                        <p className="text-sm text-slate-500">*/}
                {/*                            No relapses recorded yet. Keep it up!*/}
                {/*                        </p>*/}
                {/*                    </div>*/}
                {/*                ) : (*/}
                {/*                    <div className="space-y-6">*/}
                {/*                        {relapses.map((relapse, index) => (*/}
                {/*                            <div*/}
                {/*                                key={relapse.id}*/}
                {/*                                className="relative border-l-2 border-slate-100 pb-6 pl-6 last:border-0 last:pb-0"*/}
                {/*                            >*/}
                {/*                                <div className="absolute top-0 left-[-5px] size-2.5 rounded-full bg-red-400" />*/}
                {/*                                <div className="space-y-1">*/}
                {/*                                    <div className="flex items-center justify-between">*/}
                {/*                                        <p className="text-sm font-medium text-slate-900">*/}
                {/*                                            {formatRelapseDate(*/}
                {/*                                                relapse.timestamp,*/}
                {/*                                            )}*/}
                {/*                                        </p>*/}
                {/*                                        <span className="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-500">*/}
                {/*                                            {Math.floor(*/}
                {/*                                                relapse.duration /*/}
                {/*                                                    (1000 **/}
                {/*                                                        60 **/}
                {/*                                                        60 **/}
                {/*                                                        24),*/}
                {/*                                            )}{' '}*/}
                {/*                                            day streak*/}
                {/*                                        </span>*/}
                {/*                                    </div>*/}
                {/*                                    <p className="text-sm text-slate-600">*/}
                {/*                                        {relapse.reason ||*/}
                {/*                                            'No reason recorded'}*/}
                {/*                                    </p>*/}
                {/*                                </div>*/}
                {/*                            </div>*/}
                {/*                        ))}*/}
                {/*                    </div>*/}
                {/*                )}*/}
                {/*            </Card>*/}
                {/*        </TabsContent>*/}

                {/*        <TabsContent value="notes" className="mt-6 space-y-4">*/}
                {/*            {notes.length === 0 ? (*/}
                {/*                <Card className="p-12 text-center">*/}
                {/*                    <FileText className="mx-auto mb-3 size-12 text-slate-300" />*/}
                {/*                    <p className="text-slate-500">*/}
                {/*                        Write down your thoughts and triggers.*/}
                {/*                    </p>*/}
                {/*                </Card>*/}
                {/*            ) : (*/}
                {/*                notes.map((note) => (*/}
                {/*                    <Card key={note.id} className="p-6">*/}
                {/*                        <p className="mb-2 text-sm leading-relaxed text-slate-800">*/}
                {/*                            {note.note}*/}
                {/*                        </p>*/}
                {/*                        <p className="text-xs text-slate-400">*/}
                {/*                            {formatTimestamp(note.timestamp)}*/}
                {/*                        </p>*/}
                {/*                    </Card>*/}
                {/*                ))*/}
                {/*            )}*/}
                {/*        </TabsContent>*/}
                {/*    </Tabs>*/}
                {/*</div>*/}

                {/*/!* Relapse Dialog *!/*/}
                {/*<Dialog*/}
                {/*    open={isRelapseDialogOpen}*/}
                {/*    onOpenChange={setIsRelapseDialogOpen}*/}
                {/*>*/}
                {/*    <DialogContent>*/}
                {/*        <DialogHeader>*/}
                {/*            <DialogTitle className="flex items-center gap-2 text-red-600">*/}
                {/*                <AlertCircle className="size-5" />*/}
                {/*                Log Relapse*/}
                {/*            </DialogTitle>*/}
                {/*            <DialogDescription>*/}
                {/*                It happens. Logging it helps you understand your*/}
                {/*                triggers. This will reset your current timer.*/}
                {/*            </DialogDescription>*/}
                {/*        </DialogHeader>*/}
                {/*        <div className="space-y-4 py-4">*/}
                {/*            <Label htmlFor="reason">*/}
                {/*                What happened? (Optional)*/}
                {/*            </Label>*/}
                {/*            <Textarea*/}
                {/*                id="reason"*/}
                {/*                placeholder="I was feeling stressed because..."*/}
                {/*                value={relapseReason}*/}
                {/*                onChange={(e) => setRelapseReason(e.target.value)}*/}
                {/*            />*/}
                {/*        </div>*/}
                {/*        <DialogFooter>*/}
                {/*            <Button*/}
                {/*                variant="ghost"*/}
                {/*                onClick={() => setIsRelapseDialogOpen(false)}*/}
                {/*            >*/}
                {/*                Cancel*/}
                {/*            </Button>*/}
                {/*            <Button variant="destructive" onClick={handleRelapse}>*/}
                {/*                Reset Timer*/}
                {/*            </Button>*/}
                {/*        </DialogFooter>*/}
                {/*    </DialogContent>*/}
                {/*</Dialog>*/}
                <AddNoteDialog open={isNoteDialogOpen} onOpenChange={setIsNoteDialogOpen}/>
            </div>
        </div>
    );
}
