import { HeaderProps } from "./types";
import Search from "@/Components/Molecules/Search";

export default function Header(props: HeaderProps) {
    return (
        <header className="bg-white shadow dark:bg-gray-800">
            <div className="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center">
                    <Search />
                    {props.children}
                </div>
            </div>
        </header>
    );
}
