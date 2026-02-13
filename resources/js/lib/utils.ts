import { InertiaLinkProps } from '@inertiajs/react';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function isSameUrl(
    url1: NonNullable<InertiaLinkProps['href']>,
    url2: NonNullable<InertiaLinkProps['href']>,
) {
    return resolveUrl(url1) === resolveUrl(url2);
}

export function resolveUrl(url: NonNullable<InertiaLinkProps['href']>): string {
    return typeof url === 'string' ? url : url.url;
}

// resources/js/utils/icons.ts
import {
    Apple,
    Ban,
    Banana,
    BookOpen,
    Brain,
    Briefcase,
    CakeSlice,
    CigaretteOff,
    Code,
    Coffee,
    DollarSign,
    Droplets,
    Dumbbell,
    Gamepad2,
    GraduationCap,
    Heart,
    Leaf,
    Moon,
    Music,
    Palette,
    Pi,
    PiggyBank,
    ShieldQuestion,
    ShoppingCart,
    ShowerHead,
    Smartphone,
    Smile,
    Sun,
    Target,
    Utensils,
    WineOff,
    type LucideIcon,
} from 'lucide-react';

export const iconMap = {
    Apple,
    GraduationCap,
    PiggyBank,
    ShowerHead,
    Target,
    BookOpen,
    Pi,
    CakeSlice,
    Dumbbell,
    Droplets,
    Heart,
    Smile,
    Coffee,
    Gamepad2,
    Music,
    ShoppingCart,
    Smartphone,
    Moon,
    Sun,
    Briefcase,
    Code,
    Palette,
    Brain,
    Utensils,
    Leaf,
    DollarSign,
    Banana,
    Ban,
    CigaretteOff,
    WineOff,
} as const satisfies Record<string, LucideIcon>;

// Type-safe icon names
export type IconName = keyof typeof iconMap;

// Utility function
export function getIcon(name: string | null): LucideIcon {
    return iconMap[name as IconName] || ShieldQuestion; // Fallback
}

// Get all available icon names
export function getAvailableIcons(): IconName[] {
    return Object.keys(iconMap) as IconName[];
}
