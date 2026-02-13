import { cn, getIcon } from '@/lib/utils';

interface Props {
    color: string | null;
    iconName: string | null;
}

export default function HabitIcon({ color, iconName }: Props) {
    function getHabitIcon(iconName: string | null) {
        const Icon = getIcon(iconName);
        return <Icon className="size-6 text-white" />;
    }

    return (
        <div
            className={cn(
                'flex size-12 shrink-0 items-center justify-center rounded-xl shadow-sm',
                color ?? 'bg-black',
            )}
        >
            {getHabitIcon(iconName)}
        </div>
    );
}
