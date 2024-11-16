import AppLayout from "@/Layouts/AppLayout";
import { Head } from "@inertiajs/react";
import { DashboardProps } from "./types";
import ServicePresentationCard from "@/Components/Organisms/ServicePresentationCard";

export default function Dashboard(props: DashboardProps) {
    return (
        <AppLayout>
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-2xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                            {props.services?.map((service) => (
                                <ServicePresentationCard
                                    service={service}
                                    key={service.id}
                                />
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
