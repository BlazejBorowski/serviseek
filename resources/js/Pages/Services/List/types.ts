import { Service } from "@/Services/types";
import { PaginatedData } from "@/types/Core/pagination";

export interface ServicesListProps {
    services: PaginatedData<Service>;
}
