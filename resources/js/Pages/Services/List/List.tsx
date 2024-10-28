// import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
// import GuestLayout from "@/Layouts/GuestLayout";
import AppLayout from "@/Layouts/AppLayout";
import { Head } from "@inertiajs/react";
import { ServicesListProps } from "./types";

export default function List({ services }: ServicesListProps) {
    return (
        <AppLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Services
                </h2>
            }
        >
            <Head title="Services" />
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            {services.data.map((service) => (
                                <li key={service.id}>
                                    <strong>{service.name}:</strong>{" "}
                                    {service.description}
                                </li>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
