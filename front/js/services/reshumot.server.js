// Define the API URL at the top of the file
const apiUrl = 'http://localhost/project/hms-md/Back/controller/ReshumotController.php';

// Create
async function createReshumot(data) {
    console.log('Sending data to the API:', data);
    const response = await fetch(`${apiUrl}/reshumot`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    // Check if the response is not empty
    if (response.ok) {
        const text = await response.text();
        console.log('Raw response text:', text);

        // If the text is not empty, try to parse it as JSON
        if (text) {
            try {
                const result = JSON.parse(text);
                console.log('Request succeeded:', result);
                return result;
            } catch (error) {
                console.error('Error parsing JSON:', error);
                throw new Error('Invalid JSON response');
            }
        } else {
            console.error('Response is empty');
            throw new Error('Response is empty');
        }
    } else {
        console.error('Request failed:', response.status, response.statusText);
        throw new Error(`Request failed with status ${response.status}`);
    }
}

// Read
async function readReshumot(Rsh_id) {
    const response = await fetch(`${apiUrl}${Rsh_id}`);
    return response.json();
}

// Update
async function updateReshumot(Rsh_id, data) {
    const response = await fetch(`${apiUrl}/reshumot/${Rsh_id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return response.json();
}

// Delete
async function deleteReshumot(Rsh_id) {
    const response = await fetch(`${apiUrl}/delete/${Rsh_id}`, {
        method: 'DELETE'
    });
    return response.ok;
}

// List all
async function listAllReshumot() {
    console.log('Calling API to list all Reshumot...');
    try {
        const response = await fetch(`${apiUrl}/reshumots`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Received data:', data);
        return data;
    } catch (error) {
        console.error('Failed to fetch data:', error);
        throw error;
    }
}

// Expose all functions to the window object
window.createReshumot = createReshumot;
window.readReshumot = readReshumot;
window.updateReshumot = updateReshumot;
window.deleteReshumot = deleteReshumot;
window.listAllReshumot = listAllReshumot;
