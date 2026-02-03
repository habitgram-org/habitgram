import { Card } from '@/components/ui/card';
import { EntryNote } from '@/types';
import { FileText } from 'lucide-react';

interface Props {
    notes: EntryNote[];
    emptyMessage?: string;
}

export default function HabitNotesTab({
    notes,
    emptyMessage = 'Add notes when tracking your progress to remember important details',
}: Props) {
    if (notes.length === 0) {
        return (
            <Card className="p-12">
                <div className="space-y-3 text-center">
                    <FileText className="mx-auto size-12 text-slate-300" />
                    <div className="space-y-1">
                        <h3 className="text-lg font-semibold text-slate-900">
                            No notes yet
                        </h3>
                        <p className="text-sm text-slate-500">{emptyMessage}</p>
                    </div>
                </div>
            </Card>
        );
    }

    return (
        <div className="space-y-4">
            {notes.map((note, index) => (
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
            ))}
        </div>
    );
}
