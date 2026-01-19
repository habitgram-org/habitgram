import { ReactNode } from 'react';

export default function AppLayout({ children }: { children: ReactNode }) {
    return <main className="container mx-auto">{children}</main>;
}
