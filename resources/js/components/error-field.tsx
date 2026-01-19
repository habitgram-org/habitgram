import { FieldDescription } from '@/components/ui/field';

interface Props {
    message: string;
}

export default function ErrorField({ message }: Props) {
    return (
        <FieldDescription className="text-xs text-red-500">
            {message}
        </FieldDescription>
    );
}
