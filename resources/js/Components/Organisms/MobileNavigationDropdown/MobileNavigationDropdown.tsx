import { Link, usePage } from "@inertiajs/react";
import { MobileNavigationDropdownProps } from "./types";
import ResponsiveNavLink from "@/Components/Atoms/ResponsiveNavLink";
import ApplicationLogo from "@/Components/Atoms/ApplicationLogo";
import { useEffect } from "react";

export default function MobileNavigationDropdown(
    props: MobileNavigationDropdownProps
) {
    const user = usePage().props.auth?.user;

    useEffect(() => {
        if (props.showingNavigationDropdown) {
            document.body.style.overflow = "hidden";
        } else {
            document.body.style.overflow = "auto";
        }

        return () => {
            document.body.style.overflow = "auto";
        };
    }, [props.showingNavigationDropdown]);

    return (
        <div
            className={
                (props.showingNavigationDropdown ? "fixed" : "hidden") +
                " sm:hidden w-screen h-screen dark:bg-gray-800 top-0"
            }
        >
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="flex h-16 justify-between">
                    <div className="flex">
                        <div className="flex shrink-0 items-center">
                            <Link href="/">
                                <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </Link>
                        </div>
                    </div>
                    <div className="-me-2 flex items-center sm:hidden">
                        <button
                            onClick={() =>
                                props.setShowingNavigationDropdown(false)
                            }
                            className="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-900 dark:hover:text-gray-400 dark:focus:bg-gray-900 dark:focus:text-gray-400"
                        >
                            <svg
                                className="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    className="inline-flex"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div className="border-t border-gray-200 pb-1 pt-4 dark:border-gray-600">
                {user && (
                    <div className="px-4">
                        <div className="text-base font-medium text-gray-800 dark:text-gray-200">
                            {user?.name}
                        </div>
                        <div className="text-sm font-medium text-gray-500">
                            {user?.email}
                        </div>
                    </div>
                )}

                <div className="mt-3 space-y-1">
                    <ResponsiveNavLink href={route("profile.edit")}>
                        Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        method="post"
                        href={route("logout")}
                        as="button"
                    >
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    );
}
