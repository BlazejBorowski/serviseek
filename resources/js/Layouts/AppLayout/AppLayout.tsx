import Navbar from "@/Components/Organisms/Navbar";
import Header from "@/Components/Organisms/Header";
import { AppLayoutProps } from "./types";

export default function AppLayout(props: AppLayoutProps) {
    return (
        <div className="min-h-screen bg-gray-100 dark:bg-gray-900">
            <Navbar />

            {props.header === false ? null : <Header />}

            <main>{props.children}</main>
        </div>
    );
}
