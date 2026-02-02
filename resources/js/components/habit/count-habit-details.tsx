import InspirationalQuoteCard from '@/components/inspirational-quote-card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Progress } from '@/components/ui/progress';
import { Separator } from '@/components/ui/separator';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Textarea } from '@/components/ui/textarea';
import { CountHabit, Habit, SharedData } from '@/types';
import { Form, useForm, usePage } from '@inertiajs/react';
import {
    Calendar,
    FileText,
    Flame,
    Globe,
    Lock,
    MoreVertical,
    Plus,
    Target,
    Trash2Icon,
    TrendingUp,
    Zap,
} from 'lucide-react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';

interface Props {
    habit: Habit;
}

export default function CountHabitDetails({ habit }: Props) {
    const { delete: destroy } = useForm();
    const [isDialogOpen, setIsDialogOpen] = useState(false);
    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
    const { flash } = usePage();
    const { quote } = usePage<SharedData>().props;
    const unit = (habit.habitable as CountHabit).unit;
    const total = (habit.habitable as CountHabit).total;
    const goal = (habit.habitable as CountHabit).goal;
    const progress = (habit.habitable as CountHabit).progress;
    const remaining_amount = (habit.habitable as CountHabit).remaining_amount;
    const quickAmounts = (habit.habitable as CountHabit).quick_amounts;
    const notes_count = (habit.habitable as CountHabit).notes_count;
    const entries = (habit.habitable as CountHabit).entries;
    const notes = (habit.habitable as CountHabit).notes;
    const streak = (habit.habitable as CountHabit).streak_days;
    const average_per_day = (habit.habitable as CountHabit).average_per_day;

    function handleDelete() {
        setIsDeleteDialogOpen(false);
        destroy(route('habits.destroy', { habit: habit.id }));
    }

    useEffect(() => {
        if (flash?.newly_added_amount) {
            toast.success(`Added +${flash.newly_added_amount} ${unit}`);
        }
    }, [flash, unit]);

    return (
        <div className="min-h-screen bg-gradient-to-b from-slate-50 to-white p-4 md:p-6 lg:p-8">
            <div className="mx-auto max-w-2xl space-y-6">
                {/* Header */}
                <div className="flex items-start justify-between">
                    <div className="space-y-1">
                        <h1 className="text-2xl font-bold text-slate-900 md:text-3xl">
                            {habit.name}
                        </h1>
                        <div className="flex items-center gap-2">
                            <Badge variant="secondary" className="gap-1">
                                <Target className="size-3" />
                                Count Habit
                            </Badge>
                            <Badge variant="outline" className="gap-1">
                                {habit.is_public ? (
                                    <Globe className="size-3" />
                                ) : (
                                    <Lock className="size-3" />
                                )}
                                {habit.is_public ? 'Public' : 'Private'}
                            </Badge>
                        </div>
                    </div>
                    <div className="flex gap-2">
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="ghost" size="icon">
                                    <MoreVertical className="size-5" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuGroup>
                                    <DropdownMenuItem
                                        variant="destructive"
                                        onSelect={(e) => {
                                            e.preventDefault();
                                            setIsDeleteDialogOpen(true);
                                        }}
                                    >
                                        <Trash2Icon className="mr-2 size-4" />
                                        Delete
                                    </DropdownMenuItem>
                                </DropdownMenuGroup>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </div>

                <Dialog
                    open={isDeleteDialogOpen}
                    onOpenChange={setIsDeleteDialogOpen}
                >
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>Are you absolutely sure?</DialogTitle>
                            <DialogDescription>
                                This action cannot be undone. This will
                                permanently delete this habit.
                            </DialogDescription>
                        </DialogHeader>
                        <DialogFooter>
                            <Button
                                type="button"
                                variant="outline"
                                onClick={() => setIsDeleteDialogOpen(false)}
                            >
                                Cancel
                            </Button>
                            <Button
                                type="button"
                                onClick={handleDelete}
                                variant="destructive"
                            >
                                Delete
                            </Button>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>

                {/* Main Count Display */}
                <Card className="border-emerald-100 bg-gradient-to-br from-emerald-50 to-teal-50 p-8 md:p-12">
                    <div className="space-y-4 text-center">
                        <div className="space-y-2">
                            <div className="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-7xl font-bold text-transparent md:text-8xl lg:text-9xl">
                                {total}
                            </div>
                            <p className="text-xl font-medium text-slate-600 md:text-2xl">
                                {unit}
                            </p>
                        </div>

                        <div className="flex items-center justify-center gap-3 pt-4">
                            <Button
                                size="lg"
                                onClick={() => setIsDialogOpen(true)}
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
                                <Form
                                    key={amount}
                                    method="POST"
                                    action={route(
                                        'habits.count.entries.store',
                                        { countHabit: habit.habitable.id },
                                    )}
                                    options={{ preserveScroll: true }}
                                    onSuccess={() =>
                                        toast.success(
                                            `Added +${amount} ${unit}`,
                                        )
                                    }
                                >
                                    <Input
                                        type="hidden"
                                        name="amount"
                                        defaultValue={amount}
                                    />
                                    <Button
                                        type="submit"
                                        variant="outline"
                                        className="cursor-pointer rounded-full border-slate-200 transition-all hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-600"
                                    >
                                        +{amount}
                                    </Button>
                                </Form>
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
                            Notes ({notes_count})
                        </TabsTrigger>
                    </TabsList>

                    <TabsContent value="overview" className="mt-6 space-y-6">
                        {/* Progress & Stats */}
                        <Card className="p-6">
                            <div className="space-y-6">
                                {/* Goal Progress */}
                                {goal && (
                                    <div className="space-y-3">
                                        <div className="flex items-center justify-between">
                                            <span className="text-sm font-medium text-slate-700">
                                                Goal Progress
                                            </span>
                                            <span className="text-sm font-semibold text-slate-900">
                                                {total} / {goal} {unit}
                                            </span>
                                        </div>
                                        {progress !== undefined && (
                                            <Progress
                                                value={progress}
                                                className="h-3"
                                            />
                                        )}
                                        {progress !== undefined && (
                                            <p className="text-xs text-slate-500">
                                                {remaining_amount} {unit} to go
                                                • {progress}% complete
                                            </p>
                                        )}
                                    </div>
                                )}

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
                                            {average_per_day}
                                        </p>
                                    </div>

                                    <div className="col-span-2 space-y-1 text-center md:col-span-1">
                                        <div className="flex items-center justify-center gap-2 text-slate-500">
                                            <Calendar className="size-4 text-blue-500" />
                                            <span className="text-xs font-medium">
                                                Started
                                            </span>
                                        </div>
                                        {habit.started_at && (
                                            <p className="text-2xl font-bold text-slate-900">
                                                {habit.started_at}
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </Card>

                        <InspirationalQuoteCard quote={quote} />

                        {/* Recent Activity */}
                        <Card className="p-6">
                            <h2 className="text-lg font-semibold text-slate-900">
                                Recent Activity
                            </h2>
                            <div className="divide-y divide-slate-100">
                                {entries.map((entry) => (
                                    <div
                                        key={entry.id}
                                        className="flex items-center justify-between py-3"
                                    >
                                        <div className="space-y-1">
                                            <p className="text-sm font-medium text-slate-900">
                                                +{entry.amount} {unit}
                                            </p>
                                            <p className="text-xs text-slate-500">
                                                {entry.created_at}
                                            </p>
                                        </div>
                                        {entry.note && (
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
                        {notes_count === 0 ? (
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
                            notes.map((note, index) => (
                                <Card key={index} className="p-6">
                                    <div className="space-y-3">
                                        <div className="flex items-start justify-between">
                                            <div className="space-y-1">
                                                <div className="flex items-center gap-2">
                                                    <span className="text-xs text-slate-500">
                                                        {note.created_at}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <p className="text-sm leading-relaxed text-slate-700">
                                            {note.note}
                                        </p>
                                    </div>
                                </Card>
                            ))
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
                    <Form
                        className="space-y-4"
                        method="POST"
                        action={route('habits.count.entries.store', {
                            countHabit: habit.habitable.id,
                        })}
                        options={{ preserveScroll: true }}
                        onSuccess={() => {
                            setIsDialogOpen(false);
                        }}
                    >
                        <div className="space-y-4">
                            <Label htmlFor="amount">Amount</Label>
                            <Input
                                id="amount"
                                name="amount"
                                placeholder="Enter amount"
                                type="number"
                            />
                            <Label htmlFor="note">Note (optional)</Label>
                            <Textarea
                                id="note"
                                name="note"
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
                            <Button type="submit">Add</Button>
                        </DialogFooter>
                    </Form>
                </DialogContent>
            </Dialog>
        </div>
    );
}
