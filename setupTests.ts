import "@testing-library/jest-dom";

// @ts-expect-error zxc
global.route = jest.fn((name: string) => ({
    current: (routeName: string) => routeName === name,
}));

jest.mock("@inertiajs/react", () => ({
    ...jest.requireActual("@inertiajs/react"),
    Head: () => null,
    usePage: () => ({
        props: {
            auth: {
                user: {
                    id: 1,
                    name: "Mock User",
                    email: "mockuser@example.com",
                },
            },
        },
    }),
}));
