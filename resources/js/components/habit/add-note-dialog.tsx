import {
    Dialog,
    DialogTitle,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/react';

interface Props {
    open: boolean;
    onOpenChange: (open: boolean) => void;
}

export default function AddNoteDialog({open, onOpenChange}: Props) {
    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Add Note</DialogTitle>
                    <DialogDescription>
                        Record your thoughts or feelings.
                    </DialogDescription>
                </DialogHeader>
                <Form method="POST" action={'#'} onSuccess={() => onOpenChange(false)}>
                    <div className="space-y-4 py-4">
                        <Label htmlFor="note">Note</Label>
                        <Textarea
                            id="note"
                            name="note"
                            placeholder="How are you feeling?"
                        />
                    </div>
                    <DialogFooter>
                        <Button
                            type="button"
                            variant="ghost"
                            onClick={() => onOpenChange(false)}
                        >
                            Cancel
                        </Button>
                        <Button type="submit">Save Note</Button>
                    </DialogFooter>
                </Form>
            </DialogContent>
        </Dialog>
    );
};
