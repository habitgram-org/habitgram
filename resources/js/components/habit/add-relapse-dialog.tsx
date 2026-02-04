import ErrorField from '@/components/error-field';
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
import { Form } from '@inertiajs/react';
import { AlertCircle } from 'lucide-react';
import { toast } from 'sonner';

interface Props {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    action: string;
}

export default function AddRelapseDialog({
    open,
    onOpenChange,
    action,
}: Props) {
    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle className="flex items-center gap-2 text-red-600">
                        <AlertCircle className="size-5" />
                        Log Relapse
                    </DialogTitle>
                    <DialogDescription>
                        It happens. Logging it helps you understand your
                        triggers. This will reset your current timer.
                    </DialogDescription>
                </DialogHeader>
                <Form
                    method="POST"
                    action={action}
                    onError={(errors) => {
                        console.log(errors);
                    }}
                    onSuccess={() => {
                        onOpenChange(false);
                        toast.info("Timer reset. Don't give up!");
                    }}
                >
                    {({ errors }) => (
                        <>
                            <div className="space-y-4 py-4">
                                <Label htmlFor="reason">What happened?</Label>
                                <Textarea
                                    id="reason"
                                    name="reason"
                                    placeholder="I was feeling stressed because..."
                                />
                                {errors.reason && (
                                    <ErrorField>{errors.reason}</ErrorField>
                                )}
                            </div>

                            <DialogFooter>
                                <Button
                                    variant="ghost"
                                    type="button"
                                    onClick={() => onOpenChange(false)}
                                >
                                    Cancel
                                </Button>
                                <Button variant="destructive" type="submit">
                                    Reset Timer
                                </Button>
                            </DialogFooter>
                        </>
                    )}
                </Form>
            </DialogContent>
        </Dialog>
    );
}
