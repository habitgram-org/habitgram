import { Card } from '@/components/ui/card';
import { Progress } from '@/components/ui/progress';
import { Separator } from '@/components/ui/separator';
import { Calendar, Flame, TrendingUp } from 'lucide-react';
import { ReactNode } from 'react';

interface StatItem {
    icon: ReactNode;
    label: string;
    value: string | number;
    iconColor?: string;
}

interface GoalProgress {
    current: number;
    goal: number;
    unit: string;
    percentage?: number;
    remaining?: number;
}

interface Props {
    stats: StatItem[];
    goalProgress?: GoalProgress;
}

export default function HabitStatsCard({ stats, goalProgress }: Props) {
    return (
        <Card className="p-6">
            <div className="space-y-6">
                {/* Goal Progress */}
                {goalProgress && (
                    <>
                        <div className="space-y-3">
                            <div className="flex items-center justify-between">
                                <span className="text-sm font-medium text-slate-700">
                                    Goal Progress
                                </span>
                                <span className="text-sm font-semibold text-slate-900">
                                    {goalProgress.current} / {goalProgress.goal}{' '}
                                    {goalProgress.unit}
                                </span>
                            </div>
                            {goalProgress.percentage !== undefined && (
                                <Progress
                                    value={goalProgress.percentage}
                                    className="h-3"
                                />
                            )}
                            {goalProgress.percentage !== undefined &&
                                goalProgress.remaining !== undefined && (
                                    <p className="text-xs text-slate-500">
                                        {goalProgress.remaining}{' '}
                                        {goalProgress.unit} to go •{' '}
                                        {goalProgress.percentage}% complete
                                    </p>
                                )}
                        </div>

                        <Separator />
                    </>
                )}

                {/* Stats Grid */}
                <div className="grid grid-cols-2 gap-4 md:grid-cols-3">
                    {stats.map((stat, index) => (
                        <div
                            key={index}
                            className={`space-y-1 text-center ${
                                stats.length === 3 && index === 2
                                    ? 'col-span-2 md:col-span-1'
                                    : ''
                            }`}
                        >
                            <div className="flex items-center justify-center gap-2 text-slate-500">
                                {stat.icon}
                                <span className="text-xs font-medium">
                                    {stat.label}
                                </span>
                            </div>
                            <p className="text-2xl font-bold text-slate-900">
                                {stat.value}
                            </p>
                        </div>
                    ))}
                </div>
            </div>
        </Card>
    );
}

// Export commonly used stat icons for convenience
export const StatIcons = {
    Streak: <Flame className="size-4 text-orange-500" />,
    Average: <TrendingUp className="size-4 text-green-500" />,
    Calendar: <Calendar className="size-4 text-blue-500" />,
};
