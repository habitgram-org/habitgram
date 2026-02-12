import AppLayout from '@/layouts/app-layout';
import { User } from '@/types';

interface Props {
    user: User;
}

export default function Show({ user }: Props) {
    return (
        <AppLayout>
            <h1>{user.username + "'s" + ' profile page!'}</h1>
        </AppLayout>
    );
}
