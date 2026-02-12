import ErrorField from '@/components/error-field';
import { Button, buttonVariants } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { cn } from '@/lib/utils';
import { Form, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';

export default function ResetPassword({ token }: { token: string }) {
    return (
        <AuthLayout>
            <Card className="w-full max-w-md border-slate-200 shadow-sm">
                <CardHeader className="space-y-1">
                    <CardTitle className="text-center text-2xl font-bold text-slate-900">
                        Set new password
                    </CardTitle>
                    <CardDescription className="text-center text-slate-500">
                        Enter your new password.
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Form
                        method="POST"
                        action={route('password.update')}
                        className="space-y-4"
                        resetOnSuccess
                    >
                        {({ errors, processing }) => (
                            <>
                                <div className="space-y-2">
                                    <Label htmlFor="email">Email</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        name="email"
                                        placeholder="name@example.com"
                                        required
                                        className="bg-white"
                                    />
                                    {errors.email && (
                                        <ErrorField>{errors.email}</ErrorField>
                                    )}
                                </div>
                                <div className="space-y-2">
                                    <Label htmlFor="password">Password</Label>
                                    <Input
                                        id="password"
                                        type="password"
                                        name="password"
                                        required
                                        className="bg-white"
                                    />
                                    {errors.password && (
                                        <ErrorField>
                                            {errors.password}
                                        </ErrorField>
                                    )}
                                </div>
                                <div className="space-y-2">
                                    <Label htmlFor="password_confirmation">
                                        Confirm Password
                                    </Label>
                                    <Input
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        required
                                        className="bg-white"
                                    />
                                    {errors.password_confirmation && (
                                        <ErrorField>
                                            {errors.password_confirmation}
                                        </ErrorField>
                                    )}
                                </div>
                                <Input
                                    name="token"
                                    type="hidden"
                                    value={token}
                                />
                                <Button
                                    type="submit"
                                    className="w-full bg-slate-900 text-white hover:bg-slate-800"
                                    disabled={processing}
                                >
                                    {processing
                                        ? 'Setting new password...'
                                        : 'Set New Password'}
                                </Button>
                            </>
                        )}
                    </Form>
                </CardContent>
                <CardFooter className="flex justify-center border-t pt-6">
                    <Link
                        href={route('login')}
                        className={cn(
                            buttonVariants({
                                variant: 'link',
                                className:
                                    'gap-2 text-slate-500 hover:text-slate-900',
                            }),
                        )}
                    >
                        <ArrowLeft className="size-4" />
                        Back to Login
                    </Link>
                </CardFooter>
            </Card>
        </AuthLayout>
    );
}
