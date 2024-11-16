import { Tab, TabsProps } from "./types";

const Tabs = ({ tabs, activeTab, setActiveTab }: TabsProps) => {
    return (
        <div className="flex flex-wrap justify-center gap-1 mb-4">
            {tabs.map((tab: Tab) => (
                <button
                    key={tab.id}
                    className={`flex-grow text-center px-2 py-2 text-xs sm:text-sm md:text-base font-bold ${
                        activeTab === tab.id ? "bg-gray-300" : "bg-gray-200"
                    }`}
                    onClick={() => setActiveTab(tab.id)}
                >
                    {tab.name}
                </button>
            ))}
        </div>
    );
};

export default Tabs;
