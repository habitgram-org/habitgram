import AppLayout from '@/layouts/app-layout';
import { User } from '@/types';

interface Props {
    user: User;
}

export default function Show({ user }: Props) {
    return (
        <AppLayout>
            <h1>
                Welcome, <span className="font-bold">{user.username}</span>!
            </h1>
        </AppLayout>
    );
}
