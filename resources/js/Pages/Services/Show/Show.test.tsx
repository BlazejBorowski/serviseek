import { render, screen } from "@testing-library/react";
import ServiceShow from ".";
import "@testing-library/jest-dom";

test("renders service show", () => {
    render(
        <ServiceShow
            service={{
                id: 1,
                name: "Example Service",
                description: "Example description",
                category: null,
                main_email: null,
                emails: null,
                main_phone: null,
                phones: null,
                tags: null,
                main_image: {
                    url: "https://example.com/image.jpg",
                    created_at: "",
                    updated_at: "",
                },
                images: null,
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }}
        />
    );
    expect(screen.getByText("Example Service")).toBeInTheDocument();
    expect(screen.getByText("Example description")).toBeInTheDocument();
    expect(screen.getByAltText("Example Service")).toHaveAttribute(
        "src",
        "https://example.com/image.jpg"
    );
});
