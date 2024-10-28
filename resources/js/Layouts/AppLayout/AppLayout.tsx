import { PropsWithChildren, ReactNode } from "react";
import Navbar from "@/Components/Organisms/Navbar";
import Header from "@/Components/Organisms/Header";

export default function AppLayout({
    header,
    children,
}: PropsWithChildren<{ header?: ReactNode }>) {
    return (
        <div className="min-h-screen bg-gray-100 dark:bg-gray-900">
            <Navbar />

            <Header header={header} />

            <main>{children}</main>
        </div>
    );
}
