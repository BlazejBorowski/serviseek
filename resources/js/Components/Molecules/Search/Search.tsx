import React from "react";
import { router } from "@inertiajs/react";
import { SearchProps } from "./types";

const Search = ({ initialSearchTerm = "" }: SearchProps) => {
    const params = new URLSearchParams(window.location.search);
    const rawFilteredBy = params.get("search") || initialSearchTerm;
    const filteredBy =
        rawFilteredBy.length > 20
            ? `${rawFilteredBy.substring(0, 17)}...`
            : rawFilteredBy;

    const handleSearch = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        const form = event.currentTarget as HTMLFormElement;
        const searchTerm = (
            form.elements.namedItem("search") as HTMLInputElement
        ).value;
        router.visit(`/services?search=${encodeURIComponent(searchTerm)}`);
    };

    const clearSearch = () => {
        router.visit("/services");
    };

    return (
        <div className="flex flex-col max-sm:m-auto">
            <form
                onSubmit={handleSearch}
                className="flex flex-wrap sm:space-x-2"
            >
                <input
                    name="search"
                    type="text"
                    placeholder="Search services..."
                    defaultValue={filteredBy}
                    maxLength={100}
                    className="px-2 py-1 w-full sm:w-auto sm:px-4 sm:py-2 border rounded"
                />
                <button
                    type="submit"
                    className="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mt-2 sm:mt-0"
                >
                    Search
                </button>
            </form>
            <div className="flex space-x-2 pt-2">
                <span className="text-sm font-semibold">Filtered by:</span>
                {filteredBy && (
                    <div className="flex items-center">
                        <span className="bg-gray-100 text-gray-800 text-xs font-semibold mr-2 py-0.5 px-2.5 rounded dark:bg-gray-700 dark:text-gray-300">
                            {filteredBy}
                        </span>
                        <button
                            onClick={clearSearch}
                            className="text-blue-500 hover:text-blue-700 text-xs font-bold"
                        >
                            Clear
                        </button>
                    </div>
                )}
            </div>
        </div>
    );
};

export default Search;