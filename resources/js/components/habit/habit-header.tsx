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

interface Props {
    title: string;
    habitType: string;
    habitTypeIcon: React.ReactNode;
    isPublic: boolean;
    onDelete: () => void;
}

export default function HabitHeader({
    title,
    habitType,
    habitTypeIcon,
    isPublic,
    onDelete,
}: Props) {
    return (
        <div className="flex items-start justify-between">
            <div className="space-y-1">
                <h1 className="text-2xl font-bold text-slate-900 md:text-3xl">
                    {title}
                </h1>
                <div className="flex items-center gap-2">
                    <Badge variant="secondary" className="gap-1">
                        {habitTypeIcon}
                        {habitType}
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
            <div className="flex gap-2">
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
                                    onDelete();
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
    );
}
