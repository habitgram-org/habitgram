import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Field,
    FieldDescription,
    FieldGroup,
    FieldLabel,
} from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { cn } from '@/lib/utils';
import { Form } from '@inertiajs/react';
import { ComponentProps } from 'react';

export function LoginForm({ className, ...props }: ComponentProps<'div'>) {
    return (
        <div className={cn('flex flex-col gap-6', className)} {...props}>
            <Card>
                <CardHeader className="text-center">
                    <CardTitle className="text-xl">Welcome back</CardTitle>
                </CardHeader>
                <CardContent>
                    <Form action={route('login')} method="post">
                        {({ errors }) => (
                            <FieldGroup>
                                <Field>
                                    <FieldLabel htmlFor="email">
                                        Email
                                    </FieldLabel>
                                    <Input
                                        id="email"
                                        type="email"
                                        name="email"
                                        placeholder="john@example.com"
                                        required
                                    />
                                    {errors['email'] && (
                                        <FieldDescription className="text-xs text-red-500">
                                            {errors['email']}
                                        </FieldDescription>
                                    )}
                                </Field>
                                <Field>
                                    <div className="flex items-center">
                                        <FieldLabel htmlFor="password">
                                            Password
                                        </FieldLabel>
                                        <a
                                            href="#"
                                            className="ml-auto text-sm underline-offset-4 hover:underline"
                                        >
                                            Forgot your password?
                                        </a>
                                    </div>
                                    <Input
                                        id="password"
                                        name="password"
                                        type="password"
                                        required
                                    />
                                    {errors['password'] && (
                                        <FieldDescription className="text-xs text-red-500">
                                            {errors['password']}
                                        </FieldDescription>
                                    )}
                                </Field>
                                <Field>
                                    <Button type="submit">Login</Button>
                                    <FieldDescription className="text-center">
                                        Don&apos;t have an account?{' '}
                                        <a href={route('signup.create')}>
                                            Sign up
                                        </a>
                                    </FieldDescription>
                                </Field>
                            </FieldGroup>
                        )}
                    </Form>
                </CardContent>
            </Card>
            <FieldDescription className="px-6 text-center">
                By clicking continue, you agree to our{' '}
                <a href="#">Terms of Service</a> and{' '}
                <a href="#">Privacy Policy</a>.
            </FieldDescription>
        </div>
    );
}
