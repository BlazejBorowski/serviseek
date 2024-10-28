import { HeaderProps } from "./types";

export default function Header({ header }: HeaderProps) {
    if (!header) return null;

    return (
        <header className="bg-white shadow dark:bg-gray-800">
            <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {header}
            </div>
        </header>
    );
}