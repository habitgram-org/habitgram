import { InertiaLinkProps } from '@inertiajs/react';
import { LucideIcon } from 'lucide-react';

import { route as routeFn } from 'ziggy-js';

declare global {
    let route: typeof routeFn;
}

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: string;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    two_factor_enabled?: boolean;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Habit {
    id: string;
    name: string;
    type: HabitType;
    habitable: AbstinenceHabit | CountHabit | DailyHabit;
    description?: string;
    created_at?: string;
    starts_at?: string;
    ends_at?: string;
    started_at?: string;
    ended_at?: string;
    has_started: boolean;
}

enum HabitType {
    Abstinence = 'abstinence',
    Count = 'count',
    Daily = 'daily',
}

export interface AbstinenceHabit {
    id: string;
    created_at?: string;
}

export interface CountHabit {
    id: string;
    total: number;
    measurement_type_unit: string;
    entries: Array<CountHabitEntry>;
    created_at?: string;
}

export interface CountHabitEntry {
    id: string;
    value: number;
    by: string;
    notes: Array<HabitEntryNote>;
    created_at?: string;
}

export interface DailyHabit {
    id: string;
    created_at?: string;
}

export interface DailyHabitEntry {
    id: string;
}

export interface HabitEntryNote {
    id: string;
    content: string;
    created_at?: string;
}
