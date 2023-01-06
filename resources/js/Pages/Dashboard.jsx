import React from "react";
import { Inertia } from "@inertiajs/inertia";

const Dashboard = () => {
    const handleLogout = () => {
        console.log("Logout Trigger");
        try {
            Inertia.post("/logout");
        } catch (error) {
            console.log(error);
        }
    };

    return (
        <>
            <div>
                <h1>Dashboard Page</h1>
            </div>
            <div>
                <button onClick={handleLogout}>Logout</button>
            </div>
        </>
    );
};

export default Dashboard;
