import { ReactNode } from "react";

type AvatarDropdownButtonProps = {
    name: string;
    children: ReactNode;
};

export default function AvatarDropdownButton({
    name,
    children,
}: AvatarDropdownButtonProps) {
    return (
        <button
            type="button"
            className="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300"
        >
            {name}
            {children}
        </button>
    );
}
