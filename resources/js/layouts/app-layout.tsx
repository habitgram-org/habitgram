import SidebarMenu from '@/components/sidebar-menu';

export default function AppLayout({ children }: { children: React.ReactNode }) {
    return (
        <div className="flex min-h-screen bg-slate-50">
            <SidebarMenu />

            {/* Main Content Area */}
            <main className="min-h-screen flex-1 pb-16 md:ml-64 md:pb-0">
                {children}
            </main>
        </div>
    );
}
