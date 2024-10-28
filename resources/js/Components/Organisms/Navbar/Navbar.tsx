import ApplicationLogo from "@/Components/Atoms/ApplicationLogo";
import NavLink from "@/Components/Atoms/NavLink";
import NavButton from "@/Components/Atoms/NavButton";
import NavigationLinks from "@/Components/Molecules/NavigationLinks";
import UserDropdownMenu from "@/Components/Molecules/UserDropdownMenu";
import MobileNavigationDropdown from "@/Components/Organisms/MobileNavigationDropdown";
import { Link, usePage } from "@inertiajs/react";
import { useState } from "react";

export default function Navbar() {
    const user = usePage().props.auth?.user;
    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <nav className="border-b border-gray-100 bg-white dark:border-gray-700 dark:bg-gray-800">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="flex h-16 justify-between">
                    <div className="flex">
                        <Link href="/" className="flex shrink-0 items-center">
                            <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                        </Link>
                        <NavigationLinks />
                    </div>

                    {user ? (
                        <div className="hidden sm:ms-6 sm:flex sm:items-center">
                            <UserDropdownMenu user={user} />
                        </div>
                    ) : (
                        <div className="flex items-center space-x-4">
                            <NavLink href={route("login")} active={false}>
                                Log In
                            </NavLink>
                            <NavLink href={route("register")} active={false}>
                                Register
                            </NavLink>
                        </div>
                    )}

                    <div className="-me-2 flex items-center sm:hidden">
                        <NavButton
                            onClick={() =>
                                setShowingNavigationDropdown((prev) => !prev)
                            }
                        >
                            <svg
                                className="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    className={
                                        !showingNavigationDropdown
                                            ? "inline-flex"
                                            : "hidden"
                                    }
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    className={
                                        showingNavigationDropdown
                                            ? "inline-flex"
                                            : "hidden"
                                    }
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </NavButton>
                    </div>
                </div>
            </div>

            <MobileNavigationDropdown
                showingNavigationDropdown={showingNavigationDropdown}
                setShowingNavigationDropdown={setShowingNavigationDropdown}
            />
        </nav>
    );
}
