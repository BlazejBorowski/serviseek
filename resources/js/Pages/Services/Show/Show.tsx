import AppLayout from "@/Layouts/AppLayout";
import { Head } from "@inertiajs/react";
import { ServiceShowProps } from "./types";
import { useMemo, useState } from "react";
import Tabs from "@/Components/Molecules/Tabs";
import { ServiceTag } from "@/Services/types";

const tabs = [
    { id: "info", name: "Info" },
    { id: "images", name: "Images" },
    { id: "reviews", name: "Reviews" },
];

export default function ServiceShow({ service }: ServiceShowProps) {
    const [activeTab, setActiveTab] = useState("info");
    const [isExpanded, setIsExpanded] = useState(false);

    const serviceName: string | null = service.name;
    const serviceCategoryName: string | null | undefined =
        service.category?.name;
    const serviceMainImageUrl: string | null | undefined =
        service.main_image?.url;
    const serviceEmail: string | null | undefined =
        service.main_email?.email?.value;
    const serviceMainPhone: string | null | undefined =
        service.main_phone?.number;
    const serviceTags: ServiceTag[] | null | undefined = service.tags;
    const serviceDescription: string | null | undefined = service.description;

    const toggleDescription = () => setIsExpanded(!isExpanded);

    const formattedDescription = useMemo(() => {
        if (!service.description) return "";
        return service.description.length > 500 && !isExpanded
            ? `${service.description.substring(0, 500)}...`
            : service.description;
    }, [service.description, isExpanded]);

    return (
        <AppLayout>
            <Head title={serviceName || "Service"} />
            <div className="py-12">
                <div className="mx-auto max-w-7xl px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="flex flex-col items-center mb-4 text-center">
                                <div className="text-xs font-semibold px-2.5 py-0.5 rounded border">
                                    <p>
                                        {serviceCategoryName || "No category"}
                                    </p>
                                </div>
                                <h1>{serviceName}</h1>
                                <p>3.9k likes, 1.5k observations, 56 reviews</p>
                            </div>
                            <div className="md:flex md:justify-between">
                                <div className="mb-4 md:mb-0">
                                    <div className="w-full aspect-square bg-gray-200 dark:bg-gray-900 rounded-lg overflow-hidden">
                                        <img
                                            src={
                                                serviceMainImageUrl || undefined
                                            }
                                            alt={serviceName || undefined}
                                            className="object-cover w-full h-full"
                                            loading="lazy"
                                        />
                                    </div>
                                </div>
                                <div className="flex flex-col justify-between w-full">
                                    <div>
                                        <p>{serviceEmail}</p>
                                        <p>{serviceMainPhone}</p>
                                    </div>
                                    <div className="flex gap-2 flex-wrap">
                                        {serviceTags?.map((tag, index) => (
                                            <div key={index}>#{tag.name}</div>
                                        ))}
                                    </div>
                                </div>
                            </div>
                            <div
                                className="py-4 px-6 m-4 bg-white rounded-lg shadow-lg relative"
                                style={{ minHeight: "100px" }}
                            >
                                <p className="text-gray-700 text-justify">
                                    {formattedDescription}
                                </p>
                                {serviceDescription &&
                                    serviceDescription?.length > 500 && (
                                        <button
                                            onClick={toggleDescription}
                                            className="text-blue-500 hover:text-blue-700 transition duration-300 ease-in-out"
                                        >
                                            {isExpanded
                                                ? "Zwiń"
                                                : "Przeczytaj więcej"}
                                        </button>
                                    )}
                            </div>
                            <Tabs
                                tabs={tabs}
                                activeTab={activeTab}
                                setActiveTab={setActiveTab}
                            />
                            <div className="p-6 text-gray-900 dark:text-gray-100">
                                {activeTab === "images" && (
                                    <>{/* ImagesBoxList component */}</>
                                )}
                                {activeTab === "reviews" && (
                                    <>{/* Reviews component */}</>
                                )}
                                {activeTab === "info" && (
                                    <>{/* ServiceInfo component */}</>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
