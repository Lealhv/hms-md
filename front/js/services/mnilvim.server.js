const apiUrl = 'http://localhost/project/hms-md/Back/controller/mnllvim.php';

// Create
export async function createMnllvim(MN_id, MN_pratim, MN_location) {
    try {
        const response = await fetch(`${apiUrl}/create`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ MN_id, MN_pratim, MN_location })
        });
        if (!response.ok) {
            throw new Error(`Error: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error creating Mnllvim:', error);
        throw error; // אפשר לזרוק את השגיאה כדי לטפל בה במקום אחר
    }
}

// Read
export async function readMnllvim(MN_id) {
    try {
        const response = await fetch(`${apiUrl}/read/${MN_id}`);
        if (!response.ok) {
            throw new Error(`Error: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error reading Mnllvim:', error);
        throw error;
    }
}

// Update
export async function updateMnllvim(MN_id, MN_pratim, MN_location) {
    try {
        const response = await fetch(`${apiUrl}/update/${MN_id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ MN_pratim, MN_location })
        });
        if (!response.ok) {
            throw new Error(`Error: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error updating Mnllvim:', error);
        throw error;
    }
}

// Delete
export async function deleteMnllvim(MN_id) {
    try {
        const response = await fetch(`${apiUrl}/delete/${MN_id}`, {
            method: 'DELETE'
        });
        return response.ok;
    } catch (error) {
        console.error('Error deleting Mnllvim:', error);
        throw error;
    }
}

// List all
export async function listAllMnllvim() {
    try {
        const response = await fetch(`${apiUrl}/listAll`);
        if (!response.ok) {
            throw new Error(`Error: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error listing all Mnllvim:', error);
        throw error;
    }
}
