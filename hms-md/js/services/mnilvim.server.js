// Define API URL
const mnilvimApiUrl = 'https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/MnilvimController.php/mnilvim';

// Function to list all mnilvim
async function listMnilvim(id) {
    try {
        const response = await fetch(`${mnilvimApiUrl}/${id}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}

// Create

const addMnilvim = async (formData) => {
    try {
        const response = await fetch(mnilvimApiUrl, {
            method: 'POST',
            body: formData,
        });

        const rawText = await response.text();
        try {
            const result = JSON.parse(rawText);
			console.log("rawText", rawText)
            return result;
        } catch (parseError) {
            console.error('Failed to parse response as JSON:', parseError);
            throw new Error(`Server returned invalid JSON. First 100 chars: ${rawText.substring(0, 100)}...`);
        }
    } catch (error) {
        console.error('Error in addMnilvim:', error);
        throw error;
    }
};


// Update
async function updateMnilvim(data, id) {
    try {
        const response = await fetch(`${mnilvimApiUrl}/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _method: 'PUT',
                ...data
            })
        });

        const json = await response.json();
        return json;
    } catch (error) {
        console.error('שגיאה בעדכון:', error);
    }
}

// Delete
async function deleteMnilvim(id) {
    try {
        const response = await fetch(`${mnilvimApiUrl}/${id}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ _method: 'DELETE' })
        });

        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Error deleting mnilvim:', error);
        throw error;
    }
}

window.updateMnilvim = updateMnilvim;
window.addMnilvim = addMnilvim;
window.deleteMnilvim = deleteMnilvim;
window.listMnilvim = listMnilvim;
