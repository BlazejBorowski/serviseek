import Dropdown from "@/Components/Organisms/Dropdown";
import AvatarDropdownButton from "@/Components/Atoms/AvatarDropdownButton";

type UserDropdownMenuProps = {
    user: { name: string };
};

export default function UserDropdownMenu({ user }: UserDropdownMenuProps) {
    return (
        <Dropdown>
            <Dropdown.Trigger>
                <span className="inline-flex rounded-md">
                    <AvatarDropdownButton name={user.name}>
                        <svg
                            className="-me-0.5 ms-2 h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fillRule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 0 01-1.414 0l-4-4a1 0 010-1.414z"
                                clipRule="evenodd"
                            />
                        </svg>
                    </AvatarDropdownButton>
                </span>
            </Dropdown.Trigger>

            <Dropdown.Content>
                <Dropdown.Link href={route("profile.edit")}>
                    Profile
                </Dropdown.Link>
                <Dropdown.Link href={route("logout")} method="post" as="button">
                    Log Out
                </Dropdown.Link>
            </Dropdown.Content>
        </Dropdown>
    );
}
