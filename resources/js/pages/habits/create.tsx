import { Button, buttonVariants } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import {
    Field,
    FieldContent,
    FieldDescription,
    FieldGroup,
    FieldLabel,
    FieldTitle,
} from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { cn, getIcon } from '@/lib/utils';
import { Link, useForm } from '@inertiajs/react';
import {
    Activity,
    ArrowLeft,
    Calendar,
    Check,
    Clock,
    Target,
} from 'lucide-react';
import { BaseSyntheticEvent, FormEvent, useEffect } from 'react';

import ErrorField from '@/components/error-field';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { HabitColor } from '@/types';

interface Props {
    colors: Array<HabitColor>;
    icons: Array<string>;
    countUnitTypes: Array<{ name: string; value: number }>;
    abstinenceUnitTypes: Array<{ name: string; value: number }>;
}

enum HabitType {
    Daily = 'daily',
    Count = 'count',
    Abstinence = 'abstinence',
}

export default function CreateHabitPage({
    colors,
    icons,
    countUnitTypes,
    abstinenceUnitTypes,
}: Props) {
    const { data, setData, post, errors } = useForm<{
        title: string;
        description: string;
        color: string;
        icon: string;
        type: HabitType;
        is_public: string;
        count: {
            target: number | null;
            unit_type: number | null;
        };
        abstinence: {
            goal: number | null;
            goal_unit: number | null;
        };
    }>({
        title: '',
        description: '',
        color: 'bg-black',
        icon: '',
        type: HabitType.Daily,
        is_public: 'off',
        count: {
            target: null,
            unit_type: null,
        },
        abstinence: {
            goal_unit: null,
            goal: null,
        },
    });

    useEffect(() => {
        console.log(errors);
    }, [errors]);

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        post(route('habits.store'));
    }

    return (
        <AppLayout>
            <div className="mx-auto max-w-2xl space-y-8">
                {/* Header */}
                <div className="flex items-center gap-4">
                    <Link
                        href={route('index')}
                        className={cn(
                            buttonVariants({
                                variant: 'ghost',
                                size: 'icon',
                                className:
                                    '-ml-2 text-slate-500 hover:text-slate-900',
                            }),
                        )}
                    >
                        <ArrowLeft className="size-6" />
                    </Link>
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 md:text-3xl">
                            Create Habit
                        </h1>
                        <p className="text-slate-500">
                            Define your new goal and how you want to track it.
                        </p>
                    </div>
                </div>

                <form onSubmit={handleSubmit} className="space-y-8">
                    {/* Main Form */}
                    <div className="space-y-8">
                        {/* 1. Basic Info */}
                        <section className="space-y-4">
                            <h2 className="flex items-center gap-2 text-lg font-semibold text-slate-900">
                                <span className="flex size-6 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">
                                    1
                                </span>
                                Basic Details
                            </h2>
                            <Card className="space-y-6 p-6">
                                <div className="space-y-2">
                                    <Label
                                        htmlFor="title"
                                        className="text-base"
                                    >
                                        Habit Title
                                    </Label>
                                    <Input
                                        id="title"
                                        value={data.title}
                                        onChange={(e) =>
                                            setData('title', e.target.value)
                                        }
                                        placeholder="e.g. Read 30 minutes"
                                        className="text-lg"
                                        autoFocus
                                    />
                                    {errors.title && (
                                        <ErrorField>{errors.title}</ErrorField>
                                    )}
                                </div>

                                <div className="space-y-2">
                                    <Label htmlFor="description">
                                        Description (Optional)
                                    </Label>
                                    <Textarea
                                        id="description"
                                        value={data.description}
                                        onChange={(e) =>
                                            setData(
                                                'description',
                                                e.target.value,
                                            )
                                        }
                                        placeholder="Why is this habit important to you?"
                                        className="min-h-25 resize-none"
                                    />
                                    {errors.description && (
                                        <ErrorField>
                                            {errors.description}
                                        </ErrorField>
                                    )}
                                </div>
                            </Card>
                        </section>

                        {/* 2. Appearance */}
                        <section className="space-y-4">
                            <h2 className="flex items-center gap-2 text-lg font-semibold text-slate-900">
                                <span className="flex size-6 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">
                                    2
                                </span>
                                Appearance
                            </h2>
                            <Card className="space-y-6 p-6">
                                <div className="space-y-3">
                                    <Label>Pick a Color</Label>
                                    <div className="flex flex-wrap gap-3">
                                        {colors.map((color) => (
                                            <button
                                                key={color.value}
                                                type="button"
                                                onClick={() =>
                                                    setData(
                                                        'color',
                                                        color.value,
                                                    )
                                                }
                                                className={cn(
                                                    'size-8 cursor-pointer rounded-full transition-transform hover:scale-110 focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:outline-none',
                                                    color.value,
                                                    data.color ===
                                                        color.value &&
                                                        'scale-110 ring-2 ring-slate-900 ring-offset-2',
                                                )}
                                                aria-label={`Select ${color.name}`}
                                            >
                                                {data.color === color.value && (
                                                    <Check className="mx-auto size-4 text-white" />
                                                )}
                                            </button>
                                        ))}
                                    </div>
                                    {errors.color && (
                                        <ErrorField>{errors.color}</ErrorField>
                                    )}
                                </div>

                                <div className="space-y-3">
                                    <Label>Choose an Icon</Label>
                                    <div className="grid grid-cols-5 gap-3 sm:grid-cols-8 md:grid-cols-10">
                                        {icons.map((item, index) => {
                                            const IconComponent = getIcon(item);
                                            const isSelected =
                                                data.icon === item;
                                            return (
                                                <button
                                                    key={index}
                                                    type="button"
                                                    onClick={() =>
                                                        setData('icon', item)
                                                    }
                                                    className={cn(
                                                        'flex size-10 cursor-pointer items-center justify-center rounded-lg border transition-all',
                                                        isSelected
                                                            ? `border-slate-900 ${data.color} text-white`
                                                            : 'border-slate-200 bg-white text-slate-500 hover:border-slate-300 hover:bg-slate-50',
                                                    )}
                                                >
                                                    <IconComponent className="size-5" />
                                                </button>
                                            );
                                        })}
                                    </div>
                                    {errors.icon && (
                                        <ErrorField>{errors.icon}</ErrorField>
                                    )}
                                </div>
                            </Card>
                        </section>

                        {/* 3. Habit Type */}
                        <section className="space-y-4">
                            <h2 className="flex items-center gap-2 text-lg font-semibold text-slate-900">
                                <span className="flex size-6 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">
                                    3
                                </span>
                                Tracking Method
                            </h2>
                            <div className="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <button
                                    type="button"
                                    onClick={() =>
                                        setData('type', HabitType.Daily)
                                    }
                                    className={cn(
                                        'relative rounded-xl border-2 p-4 text-left transition-all hover:bg-slate-50',
                                        data.type === HabitType.Daily
                                            ? 'border-slate-900 bg-slate-50 ring-1 ring-slate-900/5'
                                            : 'border-slate-200',
                                    )}
                                >
                                    <div className="mb-3 flex size-10 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                                        <Calendar className="size-5" />
                                    </div>
                                    <h3 className="font-semibold text-slate-900">
                                        Daily
                                    </h3>
                                    <p className="mt-1 text-sm text-slate-500">
                                        Simple Yes/No completion. Good for
                                        building consistency.
                                    </p>
                                    {data.type === 'daily' && (
                                        <div className="absolute top-4 right-4 size-2.5 rounded-full bg-slate-900" />
                                    )}
                                </button>

                                <button
                                    type="button"
                                    onClick={() =>
                                        setData('type', HabitType.Count)
                                    }
                                    className={cn(
                                        'relative rounded-xl border-2 p-4 text-left transition-all hover:bg-slate-50',
                                        data.type === HabitType.Count
                                            ? 'border-slate-900 bg-slate-50 ring-1 ring-slate-900/5'
                                            : 'border-slate-200',
                                    )}
                                >
                                    <div className="mb-3 flex size-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                        <Activity className="size-5" />
                                    </div>
                                    <h3 className="font-semibold text-slate-900">
                                        Count Based
                                    </h3>
                                    <p className="mt-1 text-sm text-slate-500">
                                        Track numbers (steps, pages, cups). Good
                                        for gradual progress.
                                    </p>
                                    {data.type === 'count' && (
                                        <div className="absolute top-4 right-4 size-2.5 rounded-full bg-slate-900" />
                                    )}
                                </button>

                                <button
                                    type="button"
                                    onClick={() =>
                                        setData('type', HabitType.Abstinence)
                                    }
                                    className={cn(
                                        'relative rounded-xl border-2 p-4 text-left transition-all hover:bg-slate-50',
                                        data.type === HabitType.Abstinence
                                            ? 'border-slate-900 bg-slate-50 ring-1 ring-slate-900/5'
                                            : 'border-slate-200',
                                    )}
                                >
                                    <div className="mb-3 flex size-10 items-center justify-center rounded-lg bg-rose-100 text-rose-600">
                                        <Clock className="size-5" />
                                    </div>
                                    <h3 className="font-semibold text-slate-900">
                                        Abstinence
                                    </h3>
                                    <p className="mt-1 text-sm text-slate-500">
                                        Quit a bad habit. Tracks time since last
                                        relapse.
                                    </p>
                                    {data.type === 'abstinence' && (
                                        <div className="absolute top-4 right-4 size-2.5 rounded-full bg-slate-900" />
                                    )}
                                </button>
                            </div>

                            {/* Dynamic Type Settings */}
                            {data.type !== HabitType.Daily && (
                                <Card className="border-slate-200 bg-slate-50/50 p-6">
                                    {data.type === HabitType.Count && (
                                        <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                            <div className="grid gap-2">
                                                <Label>Daily Target</Label>
                                                <Input
                                                    type="number"
                                                    value={data.count.target}
                                                    onChange={(e) =>
                                                        setData(
                                                            'count.target',
                                                            e.target.value,
                                                        )
                                                    }
                                                    placeholder="e.g. 10"
                                                    className="bg-white"
                                                />
                                            </div>
                                            <div className="grid gap-2">
                                                <Label>Unit of Measure</Label>
                                                <Select
                                                    defaultValue={countUnitTypes[0].value.toString()}
                                                    onValueChange={(value) =>
                                                        setData(
                                                            'count.unit_type',
                                                            parseInt(value),
                                                        )
                                                    }
                                                >
                                                    <SelectTrigger className="bg-white">
                                                        <SelectValue />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        {countUnitTypes.map(
                                                            (item) => (
                                                                <SelectItem
                                                                    key={
                                                                        item.value
                                                                    }
                                                                    value={item.value.toString()}
                                                                >
                                                                    {item.name}
                                                                </SelectItem>
                                                            ),
                                                        )}
                                                    </SelectContent>
                                                </Select>
                                            </div>
                                        </div>
                                    )}

                                    {data.type === HabitType.Abstinence && (
                                        <div className="space-y-6">
                                            <div className="mb-4 flex items-start gap-4">
                                                <div className="rounded-md bg-rose-100 p-2 text-rose-600">
                                                    <Target className="size-5" />
                                                </div>
                                                <div>
                                                    <h4 className="font-medium text-slate-900">
                                                        Abstinence Goal
                                                        (Optional)
                                                    </h4>
                                                    <p className="mt-1 text-sm text-slate-500">
                                                        Set a specific milestone
                                                        to reach. You can update
                                                        this later.
                                                    </p>
                                                </div>
                                            </div>

                                            <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                                <div className="grid gap-2">
                                                    <Label htmlFor="goal-amount">
                                                        Goal Amount
                                                    </Label>
                                                    <Input
                                                        id="goal-amount"
                                                        type="number"
                                                        value={
                                                            data.abstinence.goal
                                                        }
                                                        onChange={(e) =>
                                                            setData(
                                                                'abstinence.goal',
                                                                e.target.value,
                                                            )
                                                        }
                                                        placeholder="e.g. 30"
                                                        className="bg-white"
                                                    />
                                                    {errors.abstinence
                                                        ?.goal && (
                                                        <ErrorField>
                                                            {
                                                                errors
                                                                    .abstinence
                                                                    .goal
                                                            }
                                                        </ErrorField>
                                                    )}
                                                </div>
                                                <div className="grid gap-2">
                                                    <Label htmlFor="goal-unit">
                                                        Time Unit
                                                    </Label>
                                                    <Select
                                                        defaultValue={abstinenceUnitTypes[0].value.toString()}
                                                        onValueChange={(
                                                            value,
                                                        ) =>
                                                            setData(
                                                                'abstinence.goal_unit',
                                                                parseInt(value),
                                                            )
                                                        }
                                                    >
                                                        <SelectTrigger className="bg-white">
                                                            <SelectValue />
                                                        </SelectTrigger>
                                                        <SelectContent>
                                                            {abstinenceUnitTypes.map(
                                                                (item) => (
                                                                    <SelectItem
                                                                        key={
                                                                            item.value
                                                                        }
                                                                        value={item.value.toString()}
                                                                    >
                                                                        {
                                                                            item.name
                                                                        }
                                                                    </SelectItem>
                                                                ),
                                                            )}
                                                        </SelectContent>
                                                    </Select>
                                                    {errors.abstinence
                                                        ?.goal_unit && (
                                                        <ErrorField>
                                                            {
                                                                errors
                                                                    .abstinence
                                                                    .goal_unit
                                                            }
                                                        </ErrorField>
                                                    )}
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                </Card>
                            )}
                        </section>

                        {/* 4. Advanced Settings */}
                        <section className="space-y-4">
                            <h2 className="flex items-center gap-2 text-lg font-semibold text-slate-900">
                                <span className="flex size-6 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">
                                    4
                                </span>
                                Settings
                            </h2>
                            <FieldGroup className="w-full">
                                <FieldLabel htmlFor="switch-notifications">
                                    <Field orientation="horizontal">
                                        <FieldContent>
                                            <FieldTitle>
                                                Social Visibility
                                            </FieldTitle>
                                            <FieldDescription>
                                                Allow friends to see your
                                                progress.
                                            </FieldDescription>
                                        </FieldContent>
                                        <Switch
                                            onClick={(e: BaseSyntheticEvent) =>
                                                setData(
                                                    'is_public',
                                                    e.target.value,
                                                )
                                            }
                                            id="switch-notifications"
                                        />
                                    </Field>
                                </FieldLabel>
                            </FieldGroup>{' '}
                        </section>
                    </div>

                    {/* Footer Actions */}
                    <div className="rounded-md border bg-white p-4">
                        <div className="mx-auto flex max-w-2xl items-center justify-between gap-4">
                            <Link
                                href={route('index')}
                                className={cn(
                                    buttonVariants({
                                        variant: 'ghost',
                                        className: 'text-slate-500',
                                    }),
                                )}
                            >
                                Cancel
                            </Link>
                            <div className="flex items-center gap-2">
                                <Button
                                    type="submit"
                                    className="min-w-[120px] bg-slate-900 text-white hover:bg-slate-800"
                                >
                                    Create Habit
                                </Button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
