import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import {
    MagnifyingGlassIcon,
    ChevronUpDownIcon,
} from "@heroicons/react/24/outline";
import { PencilIcon, UserPlusIcon } from "@heroicons/react/24/solid";
import {
    Card,
    CardHeader,
    Input,
    Typography,
    Button,
    CardBody,
    Chip,
    CardFooter,
    Tabs,
    TabsHeader,
    Tab,
    Avatar,
    IconButton,
    Tooltip,
} from "@material-tailwind/react";

export default function Index({ auth, classes }) {
    const TABLE_HEAD = ["Name", "Class Type And Category", "Grade/Grades", "Class Fees", "Class Year", "Class Start Date", "Status", "Action"];

    const TABLE_ROWS = [{
            image: "https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-3.jpg",
            name: "John Michael",
            slug: "John Michael",
            class_type: "Online",
            class_category: "Class",
            grade: "01",
            class_fees: "750",
            class_fees_date: "2024-09-10",
            class_year: "2024",
            class_start_date: "2024-10-05",
            status: "",
        },

    ];

}