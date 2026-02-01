import { Card } from '@/components/ui/card';
import { Quote } from 'lucide-react';

interface Props {
    quote: { message: string; author: string };
}

export default function InspirationalQuoteCard({ quote }: Props) {
    return (
        <Card className="border-indigo-100 bg-gradient-to-r from-indigo-50 to-blue-50 p-6">
            <div className="flex gap-4">
                <div className="h-fit rounded-full bg-white p-2 shadow-sm">
                    <Quote className="size-5 text-indigo-500" />
                </div>
                <figure className="space-y-2">
                    <blockquote className="text-sm font-medium text-slate-700 italic">
                        "{quote.message}"
                    </blockquote>
                    <figcaption className="text-xs font-semibold text-slate-500">
                        — {quote.author}
                    </figcaption>
                </figure>
            </div>
        </Card>
    );
}
