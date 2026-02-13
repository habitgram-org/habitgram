import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Globe, Lock, MoreVertical, Trash2Icon } from 'lucide-react';
import { ReactNode, useState } from 'react';

interface Props {
    title: string;
    description?: string | null;
    habitType: string;
    habitId: string;
    habitTypeIcon: ReactNode;
    isPublic?: boolean;
    children?: ReactNode;
}

import DeleteHabitDialog from '@/components/habit/delete-habit-dialog';
import { upperFirst } from 'lodash-es';

export default function HabitHeader({
    title,
    description,
    habitType,
    habitId,
    habitTypeIcon,
    isPublic,
    children,
}: Props) {
    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);

    return (
        <>
            <div className="flex items-start justify-between">
                <div>
                    <div className="flex items-center gap-2">
                        <h1 className="text-2xl font-bold text-slate-900 md:text-3xl">
                            {title}
                        </h1>

                        <div className="space-x-2">
                            <Badge variant="secondary" className="gap-1">
                                {habitTypeIcon}
                                {upperFirst(habitType)}
                            </Badge>

                            <Badge variant="outline" className="gap-1">
                                {isPublic ? (
                                    <Globe className="size-3" />
                                ) : (
                                    <Lock className="size-3" />
                                )}
                                {isPublic ? 'Public' : 'Private'}
                            </Badge>
                        </div>
                    </div>

                    {description && (
                        <p className="max-w-sm text-slate-500">{description}</p>
                    )}
                </div>
                <div className="flex items-center gap-2">
                    {children}

                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="ghost" size="icon">
                                <MoreVertical className="size-5" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent>
                            <DropdownMenuGroup>
                                <DropdownMenuItem
                                    variant="destructive"
                                    onSelect={(e) => {
                                        e.preventDefault();
                                        setIsDeleteDialogOpen(true);
                                    }}
                                >
                                    <Trash2Icon className="mr-2 size-4" />
                                    Delete
                                </DropdownMenuItem>
                            </DropdownMenuGroup>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>

            <DeleteHabitDialog
                open={isDeleteDialogOpen}
                onOpenChange={setIsDeleteDialogOpen}
                action={route('habits.destroy', { habit: habitId })}
            />
        </>
    );
}
