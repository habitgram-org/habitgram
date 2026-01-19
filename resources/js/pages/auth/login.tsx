import { LoginForm } from '@/components/login-form';
import AuthLayout from '@/layouts/auth-layout';

export default function Login() {
    return (
        <AuthLayout>
            <div className="flex min-h-svh flex-col items-center justify-center gap-6 bg-muted p-6 md:p-10">
                <div className="flex w-full max-w-sm flex-col items-center gap-6">
                    <div className="flex items-center gap-2 self-center text-xl font-semibold">
                        {import.meta.env.VITE_APP_NAME}
                    </div>
                    <LoginForm />
                </div>
            </div>{' '}
        </AuthLayout>
    );
}
