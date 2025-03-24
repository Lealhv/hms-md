
// Create
// In reshumot.server.js, around line 22
async function createReshumot(data) {
    debugger
    try {
        const response = await fetch('http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        // Check if response is OK
        if (!response.ok) {
            const text = await response.text();
            console.error("Server error response:", text);
            throw new Error(`Server error: ${response.status}`);
        }

        // Try to parse as JSON
        let responseText = await response.text();
        try {
            return JSON.parse(responseText);
        } catch (e) {
            console.error("Error parsing JSON:", e);
            console.error("Raw response:", responseText);
            throw new Error("Invalid JSON response");
        }
    } catch (error) {
        console.error("Error in createReshumot:", error);
        throw error;
    }
}



// // Read
// export async function readReshumot(Rsh_id) {
//     const response = await fetch(`${apiUrl}/read/${Rsh_id}`);
//     return response.json();
// }

// Update
async function updateReshumot(data) {
    debugger
    const apiUrl = 'http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumot';

    console.log(`מעדכן רשומה עם ID: ${data.Rsh_id}`); // לוג לפני הקריאה ל-API

    const response = await fetch(`${apiUrl}/${data.Rsh_id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    console.log(`סטטוס התגובה: ${response.status}`); // לוג של סטטוס התגובה

    const a = await response.json();
    console.log("!!!!!!!!");
    console.log(a.data); // לוג של הנתונים שהתקבלו
    return a;
}


// Delete
async function deleteReshumot(Rsh_id) {
    const apiUrl = 'http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumot';
    const response = await fetch(`${apiUrl}/${Rsh_id}`, {
        method: 'DELETE'
    });
    return response.ok;
}

// List allexport
async function listAllReshumot() {
    const apiUrl = 'http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumots';
    console.log('Calling API to list all Reshumot...');
    try {
        const response = await fetch(`${apiUrl}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Received data:', data);
        return data;
    } catch (error) {
        console.error('Failed to fetch data:', error);
    }
}


window.listAllReshumot = listAllReshumot;
window.deleteReshumot = deleteReshumot;
window.createReshumot = createReshumot;
window.updateReshumot = updateReshumot;