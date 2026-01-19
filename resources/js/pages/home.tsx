import AppLayout from '@/layouts/app-layout';

interface Props {
    username: string;
}

export default function Home({ username }: Props) {
    return (
        <AppLayout>
            <h1>
                Welcome, <span className="font-bold">{username}</span>!
            </h1>
        </AppLayout>
    );
}
