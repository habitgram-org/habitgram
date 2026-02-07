import { cn } from '@/lib/utils';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import { Heart, Home, Menu, User } from 'lucide-react';
import { ElementType, useState } from 'react';
import { Button } from './ui/button';

interface NavItem {
    icon: ElementType;
    label: string;
    isActive?: boolean;
}

export default function SidebarMenu() {
    const [activeTab, setActiveTab] = useState('Home');
    const { auth } = usePage<SharedData>().props;

    const navItems: NavItem[] = [
        { icon: Home, label: 'Home', isActive: true },
        { icon: Heart, label: 'Activity' },
        { icon: User, label: 'Profile' },
    ];

    return (
        <>
            {/* Desktop Sidebar */}
            <aside className="fixed inset-y-0 left-0 z-50 hidden w-64 flex-col border-r bg-white md:flex">
                <div className="p-6">
                    <h1 className="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-2xl font-bold text-transparent">
                        Habitgram
                    </h1>
                </div>

                <nav className="flex-1 space-y-2 px-4">
                    {navItems.map((item) => (
                        <Button
                            key={item.label}
                            variant={
                                activeTab === item.label ? 'secondary' : 'ghost'
                            }
                            className={cn(
                                'h-12 w-full justify-start gap-3 text-base font-medium',
                                activeTab === item.label
                                    ? 'bg-slate-100 font-semibold'
                                    : 'text-slate-600 hover:text-slate-900',
                            )}
                            onClick={() => setActiveTab(item.label)}
                        >
                            {item.label === 'Profile' ? (
                                <div
                                    className={cn(
                                        'size-6 shrink-0 overflow-hidden rounded-full border border-slate-200',
                                        activeTab === item.label
                                            ? 'ring-2 ring-slate-900 ring-offset-2'
                                            : '',
                                    )}
                                >
                                    <img
                                        src={auth.user.avatar}
                                        alt="Profile"
                                        className="h-full w-full object-cover"
                                    />
                                </div>
                            ) : (
                                <item.icon
                                    className={cn(
                                        'size-6',
                                        activeTab === item.label
                                            ? 'text-slate-900'
                                            : 'text-slate-500',
                                    )}
                                />
                            )}
                            {item.label}
                        </Button>
                    ))}
                </nav>

                <div className="border-t p-4">
                    <Button
                        variant="ghost"
                        className="h-12 w-full justify-start gap-3 text-slate-600"
                    >
                        <Menu className="size-6" />
                        More
                    </Button>
                </div>
            </aside>

            {/* Mobile Bottom Nav */}
            <div className="pb-safe fixed right-0 bottom-0 left-0 z-50 flex items-center justify-between border-t bg-white px-4 py-2 md:hidden">
                {navItems.map((item) => (
                    <Button
                        key={item.label}
                        variant="ghost"
                        size="icon"
                        className={cn(
                            'flex h-auto flex-col items-center justify-center gap-1 py-1',
                            activeTab === item.label
                                ? 'text-slate-900'
                                : 'text-slate-500',
                        )}
                        onClick={() => setActiveTab(item.label)}
                    >
                        {item.label === 'Profile' ? (
                            <div
                                className={cn(
                                    'size-6 shrink-0 overflow-hidden rounded-full border border-slate-200',
                                    activeTab === item.label
                                        ? 'ring-2 ring-slate-900 ring-offset-2'
                                        : '',
                                )}
                            >
                                <img
                                    src={auth.user.avatar}
                                    alt="Profile"
                                    className="h-full w-full object-cover"
                                />
                            </div>
                        ) : (
                            <item.icon
                                className={cn(
                                    'size-6',
                                    activeTab === item.label && 'fill-current',
                                )}
                            />
                        )}
                        <span className="sr-only">{item.label}</span>
                    </Button>
                ))}
            </div>
        </>
    );
}
