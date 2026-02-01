import { Badge } from '@/app/components/ui/badge';
import { Button } from '@/app/components/ui/button';
import { Card } from '@/app/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/app/components/ui/dialog';
import { Input } from '@/app/components/ui/input';
import { Label } from '@/app/components/ui/label';
import { Progress } from '@/app/components/ui/progress';
import { Separator } from '@/app/components/ui/separator';
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/app/components/ui/tabs';
import { Textarea } from '@/app/components/ui/textarea';
import {
    Calendar,
    FileText,
    Flame,
    Globe,
    Lock,
    MoreVertical,
    Plus,
    Quote,
    Target,
    TrendingUp,
    Zap,
} from 'lucide-react';
import { useState } from 'react';
import { toast } from 'sonner';

export function CountHabitDetails() {
    const [count, setCount] = useState(247);
    const [customAmount, setCustomAmount] = useState('1');
    const [noteText, setNoteText] = useState('');
    const [isDialogOpen, setIsDialogOpen] = useState(false);
    const [notes, setNotes] = useState<NoteEntry[]>([
        {
            id: '1',
            amount: 25,
            note: 'Finished chapters 10-12. Really enjoying the character development!',
            timestamp: new Date(Date.now() - 2 * 60 * 60 * 1000),
        },
        {
            id: '2',
            amount: 30,
            note: 'Great reading session. The plot is getting intense.',
            timestamp: new Date(Date.now() - 26 * 60 * 60 * 1000),
        },
        {
            id: '3',
            amount: 15,
            note: '',
            timestamp: new Date(Date.now() - 50 * 60 * 60 * 1000),
        },
    ]);
    const goal = 500;
    const unit = 'pages';
    const habitName = 'Reading Challenge';
    const streak = 12;
    const isPublic = true;
    const progress = (count / goal) * 100;

    const openAddProgressDialog = (defaultAmount: number) => {
        setCustomAmount(defaultAmount.toString());
        setNoteText('');
        setIsDialogOpen(true);
    };

    const handleAddProgress = () => {
        const amount = parseInt(customAmount);
        if (!isNaN(amount) && amount > 0) {
            setCount((prev) => Math.max(0, prev + amount));

            // Add note entry
            const newNote: NoteEntry = {
                id: Date.now().toString(),
                amount,
                note: noteText.trim(),
                timestamp: new Date(),
            };
            setNotes((prev) => [newNote, ...prev]);

            setCustomAmount('1');
            setNoteText('');
            setIsDialogOpen(false);
            toast.success(`Added +${amount} ${unit}`);
        }
    };

    // Logic to get top 3 frequent amounts
    const getQuickAddAmounts = () => {
        const frequency: Record<number, number> = {};
        notes.forEach((note) => {
            if (note.amount > 0) {
                frequency[note.amount] = (frequency[note.amount] || 0) + 1;
            }
        });

        // Convert to array and sort by frequency
        return Object.entries(frequency)
            .sort(([, a], [, b]) => b - a)
            .slice(0, 3)
            .map(([amount]) => parseInt(amount));
    };

    const quickAmounts = getQuickAddAmounts();

    const handleQuickAdd = (amount: number) => {
        setCount((prev) => prev + amount);
        const newNote: NoteEntry = {
            id: Date.now().toString(),
            amount,
            note: '',
            timestamp: new Date(),
        };
        setNotes((prev) => [newNote, ...prev]);
        toast.success(`Added +${amount} ${unit}`);
    };

    const formatTimestamp = (date: Date) => {
        const now = new Date();
        const diffMs = now.getTime() - date.getTime();
        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));

        if (diffHours < 1) {
            const diffMins = Math.floor(diffMs / (1000 * 60));
            return diffMins <= 1 ? 'Just now' : `${diffMins} minutes ago`;
        } else if (diffHours < 24) {
            return `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`;
        } else if (diffHours < 48) {
            return 'Yesterday';
        } else {
            return date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
            });
        }
    };

    return (
        <div className="min-h-screen bg-gradient-to-b from-slate-50 to-white p-4 md:p-6 lg:p-8">
            <div className="mx-auto max-w-2xl space-y-6">
                {/* Header */}
                <div className="flex items-start justify-between">
                    <div className="space-y-1">
                        <h1 className="text-2xl font-bold text-slate-900 md:text-3xl">
                            {habitName}
                        </h1>
                        <div className="flex items-center gap-2">
                            <Badge variant="secondary" className="gap-1">
                                <Target className="size-3" />
                                Count Habit
                            </Badge>
                            <Badge variant="outline" className="gap-1">
                                {isPublic ? (
                                    <Globe className="size-3" />
                                ) : (
                                    <Lock className="size-3" />
                                )}
                                {isPublic ? 'Public' : 'Private'}
                            </Badge>
                        </div>
                    </div>
                    <div className="flex gap-2">
                        <Button variant="ghost" size="icon">
                            <MoreVertical className="size-5" />
                        </Button>
                    </div>
                </div>

                {/* Main Count Display */}
                <Card className="border-emerald-100 bg-gradient-to-br from-emerald-50 to-teal-50 p-8 md:p-12">
                    <div className="space-y-4 text-center">
                        <div className="space-y-2">
                            <div className="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-7xl font-bold text-transparent md:text-8xl lg:text-9xl">
                                {count}
                            </div>
                            <p className="text-xl font-medium text-slate-600 md:text-2xl">
                                {unit}
                            </p>
                        </div>

                        <div className="flex items-center justify-center gap-3 pt-4">
                            <Button
                                size="lg"
                                onClick={() => openAddProgressDialog(1)}
                                className="h-14 rounded-full bg-gradient-to-r from-emerald-600 to-teal-600 px-8 hover:from-emerald-700 hover:to-teal-700"
                            >
                                <Plus className="mr-2 size-5" />
                                Add Progress
                            </Button>
                        </div>
                    </div>
                </Card>

                {/* Quick Add Buttons */}
                {quickAmounts.length > 0 && (
                    <div className="flex flex-col items-center gap-3">
                        <div className="flex items-center gap-2 text-sm font-medium text-slate-500">
                            <Zap className="size-4 fill-amber-500 text-amber-500" />
                            Quick Add
                        </div>
                        <div className="no-scrollbar flex max-w-full gap-3 overflow-x-auto px-2 pb-2">
                            {quickAmounts.map((amount) => (
                                <Button
                                    key={amount}
                                    variant="outline"
                                    onClick={() => handleQuickAdd(amount)}
                                    className="rounded-full border-slate-200 transition-all hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-600"
                                >
                                    +{amount}
                                </Button>
                            ))}
                        </div>
                    </div>
                )}

                {/* Tabs for Overview and Notes */}
                <Tabs defaultValue="overview" className="w-full">
                    <TabsList className="w-full">
                        <TabsTrigger value="overview" className="flex-1">
                            <TrendingUp className="mr-2 size-4" />
                            Overview
                        </TabsTrigger>
                        <TabsTrigger value="notes" className="flex-1">
                            <FileText className="mr-2 size-4" />
                            Notes ({notes.filter((n) => n.note).length})
                        </TabsTrigger>
                    </TabsList>

                    <TabsContent value="overview" className="mt-6 space-y-6">
                        {/* Progress & Stats */}
                        <Card className="p-6">
                            <div className="space-y-6">
                                {/* Goal Progress */}
                                <div className="space-y-3">
                                    <div className="flex items-center justify-between">
                                        <span className="text-sm font-medium text-slate-700">
                                            Goal Progress
                                        </span>
                                        <span className="text-sm font-semibold text-slate-900">
                                            {count} / {goal} {unit}
                                        </span>
                                    </div>
                                    <Progress
                                        value={progress}
                                        className="h-3"
                                    />
                                    <p className="text-xs text-slate-500">
                                        {goal - count} {unit} to go •{' '}
                                        {Math.round(progress)}% complete
                                    </p>
                                </div>

                                <Separator />

                                {/* Stats Grid */}
                                <div className="grid grid-cols-2 gap-4 md:grid-cols-3">
                                    <div className="space-y-1 text-center">
                                        <div className="flex items-center justify-center gap-2 text-slate-500">
                                            <Flame className="size-4 text-orange-500" />
                                            <span className="text-xs font-medium">
                                                Streak
                                            </span>
                                        </div>
                                        <p className="text-2xl font-bold text-slate-900">
                                            {streak} days
                                        </p>
                                    </div>

                                    <div className="space-y-1 text-center">
                                        <div className="flex items-center justify-center gap-2 text-slate-500">
                                            <TrendingUp className="size-4 text-green-500" />
                                            <span className="text-xs font-medium">
                                                Avg/Day
                                            </span>
                                        </div>
                                        <p className="text-2xl font-bold text-slate-900">
                                            {Math.round(count / streak)}
                                        </p>
                                    </div>

                                    <div className="col-span-2 space-y-1 text-center md:col-span-1">
                                        <div className="flex items-center justify-center gap-2 text-slate-500">
                                            <Calendar className="size-4 text-blue-500" />
                                            <span className="text-xs font-medium">
                                                Started
                                            </span>
                                        </div>
                                        <p className="text-2xl font-bold text-slate-900">
                                            Jan 14
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </Card>

                        {/* Inspirational Quote */}
                        <Card className="border-indigo-100 bg-gradient-to-r from-indigo-50 to-blue-50 p-6">
                            <div className="flex gap-4">
                                <div className="h-fit rounded-full bg-white p-2 shadow-sm">
                                    <Quote className="size-5 text-indigo-500" />
                                </div>
                                <figure className="space-y-2">
                                    <blockquote className="text-sm font-medium text-slate-700 italic">
                                        "Success is the sum of small efforts,
                                        repeated day in and day out."
                                    </blockquote>
                                    <figcaption className="text-xs font-semibold text-slate-500">
                                        Robert Collier
                                    </figcaption>
                                </figure>
                            </div>
                        </Card>

                        {/* Recent Activity */}
                        <Card className="p-6">
                            <h2 className="mb-4 text-lg font-semibold text-slate-900">
                                Recent Activity
                            </h2>
                            <div className="divide-y divide-slate-100">
                                {notes.slice(0, 5).map((activity) => (
                                    <div
                                        key={activity.id}
                                        className="flex items-center justify-between py-3"
                                    >
                                        <div className="space-y-1">
                                            <p className="text-sm font-medium text-slate-900">
                                                +{activity.amount} {unit}
                                            </p>
                                            <p className="text-xs text-slate-500">
                                                {formatTimestamp(
                                                    activity.timestamp,
                                                )}
                                            </p>
                                        </div>
                                        {activity.note && (
                                            <Badge
                                                variant="outline"
                                                className="gap-1"
                                            >
                                                <FileText className="size-3" />
                                                Note
                                            </Badge>
                                        )}
                                    </div>
                                ))}
                            </div>
                        </Card>
                    </TabsContent>

                    <TabsContent value="notes" className="mt-6 space-y-4">
                        {notes.filter((n) => n.note).length === 0 ? (
                            <Card className="p-12">
                                <div className="space-y-3 text-center">
                                    <FileText className="mx-auto size-12 text-slate-300" />
                                    <div className="space-y-1">
                                        <h3 className="text-lg font-semibold text-slate-900">
                                            No notes yet
                                        </h3>
                                        <p className="text-sm text-slate-500">
                                            Add notes when tracking your
                                            progress to remember important
                                            details
                                        </p>
                                    </div>
                                </div>
                            </Card>
                        ) : (
                            notes.map(
                                (entry) =>
                                    entry.note && (
                                        <Card key={entry.id} className="p-6">
                                            <div className="space-y-3">
                                                <div className="flex items-start justify-between">
                                                    <div className="space-y-1">
                                                        <div className="flex items-center gap-2">
                                                            <Badge variant="secondary">
                                                                +{entry.amount}{' '}
                                                                {unit}
                                                            </Badge>
                                                            <span className="text-xs text-slate-500">
                                                                {formatTimestamp(
                                                                    entry.timestamp,
                                                                )}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p className="text-sm leading-relaxed text-slate-700">
                                                    {entry.note}
                                                </p>
                                            </div>
                                        </Card>
                                    ),
                            )
                        )}
                    </TabsContent>
                </Tabs>
            </div>

            {/* Custom Amount Dialog */}
            <Dialog open={isDialogOpen} onOpenChange={setIsDialogOpen}>
                <DialogContent className="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>Add Custom Amount</DialogTitle>
                        <DialogDescription>
                            Enter the amount of {unit} you want to add to your
                            progress.
                        </DialogDescription>
                    </DialogHeader>
                    <div className="space-y-4">
                        <Label htmlFor="amount">Amount</Label>
                        <Input
                            id="amount"
                            value={customAmount}
                            onChange={(e) => setCustomAmount(e.target.value)}
                            placeholder="Enter amount"
                            type="number"
                        />
                        <Label htmlFor="note">Note (optional)</Label>
                        <Textarea
                            id="note"
                            value={noteText}
                            onChange={(e) => setNoteText(e.target.value)}
                            placeholder="Add a note about your progress"
                            className="resize-none"
                        />
                    </div>
                    <DialogFooter>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => setIsDialogOpen(false)}
                        >
                            Cancel
                        </Button>
                        <Button type="button" onClick={handleAddProgress}>
                            Add
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
    );
}
