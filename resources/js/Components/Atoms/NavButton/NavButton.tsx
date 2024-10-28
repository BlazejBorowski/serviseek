import { ButtonHTMLAttributes } from "react";

type NavButtonProps = ButtonHTMLAttributes<HTMLButtonElement>;

export default function NavButton({ children, ...props }: NavButtonProps) {
    return (
        <button
            {...props}
            className="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-900 dark:hover:text-gray-400 dark:focus:bg-gray-900 dark:focus:text-gray-400"
        >
            {children}
        </button>
    );
}
