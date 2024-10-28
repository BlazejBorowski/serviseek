import NavLink from "@/Components/Atoms/NavLink";

export default function NavigationLinks() {
    return (
        <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <NavLink
                href={route("dashboard")}
                active={route().current("dashboard")}
            >
                Dashboard
            </NavLink>
            <NavLink
                href={route("services.index")}
                active={route().current("services.index")}
            >
                Services
            </NavLink>
        </div>
    );
}
