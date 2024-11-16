import FollowButton from "@/Components/Atoms/FollowButton";
import { ServicePresentationCardProps } from "./types";
import CommentButton from "@/Components/Atoms/CommentButton";
import ShareButton from "@/Components/Atoms/ShareButton";
import { router } from "@inertiajs/react";

export default function ServicePresentationCard({
    service,
}: ServicePresentationCardProps & { banner?: string }) {
    return (
        <div className="flex flex-col items-center bg-white rounded-lg shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700 max-w-lg mx-auto transition-shadow duration-300">
            <div
                className="flex flex-col md:flex-row p-4 w-full max-w-2xl hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-lg cursor-pointer"
                onClick={() => router.visit(`/services/${service.id}`)}
            >
                <div className="w-full md:w-1/3 h-40 bg-gray-200 dark:bg-gray-900 rounded-lg overflow-hidden mb-4 md:mb-0">
                    <img
                        src={service.main_image?.url || undefined}
                        alt={service.name || undefined}
                        className="object-cover w-full h-full"
                        loading="lazy"
                    />
                </div>
                <div className="flex flex-col w-full md:w-2/3 md:pl-4">
                    <h2 className="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {service.name}
                    </h2>
                    <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {service.description}
                    </p>
                    <p className="text-sm mt-2 text-gray-600 dark:text-gray-400">
                        <strong>Phone:</strong>{" "}
                        {service.main_phone?.number || "N/A"}
                    </p>
                    <p className="text-sm text-gray-600 dark:text-gray-400">
                        <strong>Email:</strong>{" "}
                        {service.main_email?.email?.value || "N/A"}
                    </p>
                    <p className="text-sm text-gray-600 dark:text-gray-400 mt-2">
                        <strong>Category:</strong>{" "}
                        {service.category?.name || "Brak kategorii"}
                    </p>
                </div>
            </div>
            <div className="flex flex-wrap mt-2 px-6 justify-start w-full">
                {service.tags?.map((tag, index) => (
                    <span
                        key={index}
                        onClick={() =>
                            router.visit(`/services?tag=${tag.name}`)
                        }
                        className="mr-2 mb-2 px-3 py-1 bg-stone-100 text-stone-800 text-xs font-semibold rounded-md dark:bg-stone-800 dark:text-stone-100 cursor-pointer hover:bg-stone-200 dark:hover:bg-stone-700"
                    >
                        #{tag.name}
                    </span>
                ))}
            </div>
            <div className="flex items-center justify-around mt-4 w-full px-6 border-t border-gray-200 dark:border-gray-700">
                <FollowButton />
                <CommentButton />
                <ShareButton />
            </div>
        </div>
    );
}
