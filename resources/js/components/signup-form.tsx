import ErrorField from '@/components/error-field';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Field,
    FieldDescription,
    FieldGroup,
    FieldLabel,
} from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { cn } from '@/lib/utils';
import { Form, Link } from '@inertiajs/react';
import { ComponentProps } from 'react';

export function SignupForm({ className, ...props }: ComponentProps<'div'>) {
    return (
        <div className={cn('flex flex-col gap-6', className)} {...props}>
            <Card>
                <CardHeader className="text-center">
                    <CardTitle className="text-xl">
                        Create your account
                    </CardTitle>
                    <CardDescription>
                        Enter your email below to create your account
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Form action={route('signup.store')} method="post">
                        {({ errors }) => (
                            <FieldGroup>
                                <Field>
                                    <FieldLabel htmlFor="username">
                                        Username
                                    </FieldLabel>
                                    <Input
                                        id="username"
                                        name="username"
                                        type="text"
                                        placeholder="@johndoe"
                                        required
                                    />
                                    {errors.username && (
                                        <ErrorField>
                                            {errors.username}
                                        </ErrorField>
                                    )}
                                </Field>
                                <Field>
                                    <FieldLabel htmlFor="email">
                                        Email
                                    </FieldLabel>
                                    <Input
                                        id="email"
                                        name="email"
                                        type="email"
                                        placeholder="john@example.com"
                                        required
                                    />
                                    {errors.email && (
                                        <ErrorField>{errors.email}</ErrorField>
                                    )}
                                </Field>
                                <Field>
                                    <Field className="grid grid-cols-2 gap-4">
                                        <Field>
                                            <FieldLabel htmlFor="password">
                                                Password
                                            </FieldLabel>
                                            <Input
                                                id="password"
                                                name="password"
                                                type="password"
                                                required
                                            />
                                            {errors.password && (
                                                <ErrorField>
                                                    {errors.password}
                                                </ErrorField>
                                            )}
                                        </Field>
                                        <Field>
                                            <FieldLabel htmlFor="confirm-password">
                                                Confirm Password
                                            </FieldLabel>
                                            <Input
                                                id="confirm-password"
                                                name="password_confirmation"
                                                type="password"
                                                required
                                            />
                                            {errors.password_confirmation && (
                                                <ErrorField>
                                                    {
                                                        errors.password_confirmation
                                                    }
                                                </ErrorField>
                                            )}
                                        </Field>
                                    </Field>
                                    <FieldDescription>
                                        Must be at least 12 characters long.
                                    </FieldDescription>
                                </Field>
                                <Field>
                                    <Button type="submit">
                                        Create Account
                                    </Button>
                                    <FieldDescription className="text-center">
                                        Already have an account?{' '}
                                        <Link href={route('index')}>
                                            Sign in
                                        </Link>
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
