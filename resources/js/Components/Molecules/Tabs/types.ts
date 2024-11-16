export type Tab = {
    id: string;
    name: string;
};

export type TabsProps = {
    tabs: Tab[];
    activeTab: string;
    setActiveTab: (tab: string) => void;
};
