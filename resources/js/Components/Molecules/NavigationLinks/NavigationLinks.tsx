import NavLink from "@/Components/Atoms/NavLink";
import { usePage } from "@inertiajs/react";

export default function NavigationLinks() {
    const servicesListEnabled =
        (usePage().props.servicesListEnabled as boolean | undefined) ?? false;

    return (
        <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <NavLink
                href={route("dashboard")}
                active={route().current("dashboard")}
            >
                Dashboard
            </NavLink>
            {servicesListEnabled && (
                <NavLink
                    href={route("services.index")}
                    active={route().current("services.index")}
                >
                    Services
                </NavLink>
            )}
        </div>
    );
}
