import { InertiaLinkProps } from '@inertiajs/react';
import { LucideIcon } from 'lucide-react';

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
    currentRoute: string;
    [key: string]: unknown;
}

export interface User {
    id: string;
    username: string;
    email: string;
    avatar: string; // Base64 string
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface PaginatedResponse<T> {
    data: Array<T>;
    links: Array<PaginationLink>;
    meta: Meta;
}

interface PaginationLink {
    url: string | null;
    label: string;
    page: number | null;
    active: boolean;
}

interface Meta {
    current_page: number;
    first_page_url: string;
    from: number;
    to: number;
    total: number;
    last_page: number;
    last_page_url: string;
    next_page_url: string;
    path: strin;
    per_page: number;
    prev_page_url: string | null;
}

export interface Habit {
    id: string;
    name: string;
    type: HabitType;
    image?: string;
    habitable?: AbstinenceHabit | CountHabit | DailyHabit | null;
    description?: string | null;
    created_at?: string | null;
    starts_at?: string | null;
    ends_at?: string | null;
    started_at?: string | null;
    ended_at?: string | null;
    has_started?: boolean;
    is_public?: boolean;
    notes?: Array<HabitNote>;
    notes_count?: number;
}

enum HabitType {
    Abstinence = 'abstinence',
    Count = 'count',
    Daily = 'daily',
}

export interface AbstinenceHabit {
    id: string;
    relapses: Array<AbstinenceRelapse>;
    relapses_count: number;
    duration: number;
    created_at?: string;
    max_streak_days: number;
    max_streak_start: string;
    max_streak_end: string;
    goal?: string;
    goal_current?: string;
    goal_remaining?: string;
    goal_unit?: string;
    goal_progress?: number;
}

export interface AbstinenceRelapse {
    id: string;
    happened_at: string;
    reason: string;
    streak_days: number;
}

export interface AbstinenceHabitEntry {
    id: string;
    happened_at: string;
    reason: string;
    created_at?: string;
}

export interface CountHabit {
    id: string;
    total: number;
    unit: string;
    entries: Array<CountHabitEntry>;
    notes: Array<EntryNote>;
    created_at?: string;
    quick_amounts: Array<number>;
    notes_count: number;
    streak_days: number;
    average_per_day: number;
    goal?: number;
    progress?: number;
    remaining_amount?: number;
}

export interface CountHabitEntry {
    id: string;
    amount: number;
    note?: string;
    created_at?: string;
}

export interface DailyHabit {
    id: string;
    entries: Array<DailyHabitEntry>;
    longest_streak_days: number;
    current_streak_days: number;
    total_completions: number;
    completion_rate: number;
    today_date: string;
    max_streak_start: string;
    max_streak_end: string;
    is_today_completed: boolean;
    year: number;
    completed_days_in_year: number;
    created_at?: string;
}

export interface DailyHabitEntry {
    date: string;
    id?: string;
    is_succeeded?: boolean;
    is_future: boolean;
    note?: string;
    created_at?: string;
}

export interface EntryNote {
    note: string;
    created_at?: string;
}

export interface HabitNote {
    id: string;
    note: string;
    created_at?: string;
}
