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
import { Form, Link, usePage } from '@inertiajs/react';
import { ArrowLeft, CheckCircle2, Mail } from 'lucide-react';

export default function ForgotPassword() {
    const { flash } = usePage();

    return (
        <AuthLayout>
            <Card className="w-full max-w-md border-slate-200 shadow-sm">
                <CardHeader className="space-y-1">
                    <div className="mb-4 flex justify-center">
                        <div className="flex size-12 items-center justify-center rounded-full bg-slate-100">
                            {flash?.status ? (
                                <CheckCircle2 className="size-6 text-emerald-600" />
                            ) : (
                                <Mail className="size-6 text-slate-600" />
                            )}
                        </div>
                    </div>
                    <CardTitle className="text-center text-2xl font-bold text-slate-900">
                        {flash?.status
                            ? 'Check your email'
                            : 'Reset your password'}
                    </CardTitle>
                    <CardDescription className="text-center text-slate-500">
                        {flash?.status
                            ? flash.status
                            : "Enter your email address and we'll send you a link to reset your password."}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Form
                        method="POST"
                        action={route('password.email')}
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
                                <Button
                                    type="submit"
                                    className="w-full bg-slate-900 text-white hover:bg-slate-800"
                                    disabled={processing}
                                >
                                    {processing
                                        ? 'Sending link...'
                                        : 'Send Reset Link'}
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
