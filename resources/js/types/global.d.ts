import { route as routeFn } from 'ziggy-js';

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            auth: { user: { id: number; name: string } | null };
            appName: string;
        };
        flashDataType: { newly_added_amount: number };
        errorValueType: string[];
    }
}

declare global {
    let route: typeof routeFn;
}
