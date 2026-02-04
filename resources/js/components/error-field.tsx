import { FieldDescription } from '@/components/ui/field';
import { ReactNode } from 'react';

interface Props {
    children: ReactNode;
}

export default function ErrorField({ children }: Props) {
    return (
        <FieldDescription className="text-xs text-red-500">
            {children}
        </FieldDescription>
    );
}
