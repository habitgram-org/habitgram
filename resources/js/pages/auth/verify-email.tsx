import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';
import { InfoIcon } from 'lucide-react';

export default function VerifyEmail() {
    return (
        <div className="mx-auto flex h-screen max-w-md items-center px-10">
            <div>
                <Alert>
                    <InfoIcon />
                    <AlertTitle>Verify email</AlertTitle>
                    <AlertDescription>
                        Please verify your email address by clicking on the link
                        we just emailed to you.
                    </AlertDescription>
                </Alert>

                <Button variant="default" className="mt-4">
                    <Link
                        href={route('verification.send')}
                        method="post"
                        as="button"
                    >
                        Resend verification email
                    </Link>
                </Button>

                <Button variant="link" className="mt-4 block">
                    <Link
                        href={route('logout')}
                        method="post"
                        as="button"
                        className="underline"
                    >
                        Log out
                    </Link>
                </Button>
            </div>
        </div>
    );
}
