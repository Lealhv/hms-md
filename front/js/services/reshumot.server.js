
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
async function updateReshumot(Rsh_id, data) {
    const apiUrl = 'http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumot';

    const response = await fetch(`${apiUrl}/${Rsh_id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return response.json();
}

// // Delete
// export async function deleteReshumot(Rsh_id) {
//     const response = await fetch(`${apiUrl}/delete/${Rsh_id}`, {
//         method: 'DELETE'
//     });
//     return response.ok;
// }

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

window.createReshumot = createReshumot;
window.updateReshumot = updateReshumot;