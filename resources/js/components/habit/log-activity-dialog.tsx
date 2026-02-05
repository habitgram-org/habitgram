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
import { cn } from '@/lib/utils';
import { useForm } from '@inertiajs/react';
import { Check, History, X } from 'lucide-react';
import { FormEvent } from 'react';

interface Props {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    action: string;
    todayDate: string;
}

enum LogStatus {
    Completed = 'completed',
    Missed = 'missed',
    None = 'none',
}

export default function LogActivityDialog({
    open,
    onOpenChange,
    action,
    todayDate,
}: Props) {
    const { data, setData, post } = useForm({
        log_status: '',
    });

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        post(action);
    }

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>Log Activity</DialogTitle>
                    <DialogDescription>{todayDate}</DialogDescription>
                </DialogHeader>

                <form onSubmit={handleSubmit}>
                    <div className="space-y-6 py-2">
                        <div className="space-y-3">
                            <Label>Status</Label>
                            <div className="grid grid-cols-3 gap-3">
                                <button
                                    type="button"
                                    onClick={() =>
                                        setData(
                                            'log_status',
                                            LogStatus.Completed,
                                        )
                                    }
                                    className={cn(
                                        'flex flex-col items-center justify-center gap-2 rounded-xl border-2 p-4 transition-all',
                                        data.log_status === LogStatus.Completed
                                            ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                                            : 'border-slate-100 hover:border-emerald-200 hover:bg-slate-50',
                                    )}
                                >
                                    <div
                                        className={cn(
                                            'flex size-8 items-center justify-center rounded-full',
                                            data.log_status ===
                                                LogStatus.Completed
                                                ? 'bg-emerald-500 text-white'
                                                : 'bg-slate-100 text-slate-400',
                                        )}
                                    >
                                        <Check className="size-5" />
                                    </div>
                                    <span className="text-sm font-medium">
                                        Complete
                                    </span>
                                </button>

                                <button
                                    type="button"
                                    onClick={() =>
                                        setData('log_status', LogStatus.Missed)
                                    }
                                    className={cn(
                                        'flex flex-col items-center justify-center gap-2 rounded-xl border-2 p-4 transition-all',
                                        data.log_status === LogStatus.Missed
                                            ? 'border-red-500 bg-red-50 text-red-700'
                                            : 'border-slate-100 hover:border-red-200 hover:bg-slate-50',
                                    )}
                                >
                                    <div
                                        className={cn(
                                            'flex size-8 items-center justify-center rounded-full',
                                            data.log_status === LogStatus.Missed
                                                ? 'bg-red-500 text-white'
                                                : 'bg-slate-100 text-slate-400',
                                        )}
                                    >
                                        <X className="size-5" />
                                    </div>
                                    <span className="text-sm font-medium">
                                        Missed
                                    </span>
                                </button>

                                <button
                                    type="button"
                                    onClick={() =>
                                        setData('log_status', LogStatus.None)
                                    }
                                    className={cn(
                                        'flex flex-col items-center justify-center gap-2 rounded-xl border-2 p-4 transition-all',
                                        data.log_status === LogStatus.None
                                            ? 'border-slate-400 bg-slate-50 text-slate-700'
                                            : 'border-slate-100 hover:border-slate-200 hover:bg-slate-50',
                                    )}
                                >
                                    <div
                                        className={cn(
                                            'flex size-8 items-center justify-center rounded-full',
                                            data.log_status === LogStatus.None
                                                ? 'bg-slate-400 text-white'
                                                : 'bg-slate-100 text-slate-400',
                                        )}
                                    >
                                        <History className="size-5" />
                                    </div>
                                    <span className="text-sm font-medium">
                                        Clear
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div className="space-y-3">
                            <Label htmlFor="note">Note (Optional)</Label>
                            <Textarea
                                id="note"
                                placeholder="How did it go?"
                                className="resize-none"
                            />
                        </div>
                    </div>

                    <DialogFooter>
                        <Button
                            variant="ghost"
                            onClick={() => onOpenChange(false)}
                        >
                            Cancel
                        </Button>
                        <Button type="submit">Save Entry</Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}
