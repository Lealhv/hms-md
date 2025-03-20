const apiUrl = 'http://localhost/project/hms-md/Back/controller/mnilvim.php';

// Create
export async function createMnilvim(MN_id, MN_pratim, MN_location) {
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
        console.error('Error creating Mnilvim:', error);
        throw error; // אפשר לזרוק את השגיאה כדי לטפל בה במקום אחר
    }
}

// Read
export async function readMnilvim(MN_id) {
    try {
        const response = await fetch(`${apiUrl}/read/${MN_id}`);
        if (!response.ok) {
            throw new Error(`Error: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error reading Mnilvim:', error);
        throw error;
    }
}

// Update
export async function updateMnilvim(MN_id, MN_pratim, MN_location) {
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
        console.error('Error updating Mnilvim:', error);
        throw error;
    }
}

// Delete
export async function deleteMnilvim(MN_id) {
    try {
        const response = await fetch(`${apiUrl}/delete/${MN_id}`, {
            method: 'DELETE'
        });
        return response.ok;
    } catch (error) {
        console.error('Error deleting Mnilvim:', error);
        throw error;
    }
}

// List all
export async function listAllMnilvim() {
    try {
        const response = await fetch(`${apiUrl}/listAll`);
        if (!response.ok) {
            throw new Error(`Error: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error listing all Mnilvim:', error);
        throw error;
    }
}
