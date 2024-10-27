import { Service } from "@/Services/types";
import { PaginatedData } from "@/types/Core/pagination";

export interface DashboardProps {
    services: PaginatedData<Service>;
}
