// Create
async function createReshumot(data) {
    try {
        const response = await fetch(
    "https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/ReshumotController.php/reshumot",
    {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    }
);


        const rawText = await response.text();
        try {
            const result = JSON.parse(rawText);
            return result;
        } catch (parseError) {
            console.error('Failed to parse response as JSON:', parseError);
            throw new Error(`Server returned invalid JSON. First 100 chars: ${rawText.substring(0, 100)}...`);
        }
    } catch (error) {
        console.error('Error in createReshumot:', error);
        throw error;
    }
}

// Update
async function updateReshumot(data, id) {
	console.log("data" , data)
    try {
        const response = await fetch(`https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/ReshumotController.php/reshumot/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _method: 'PUT', // כאן צריך להיות PUT ולא POST
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
async function deleteReshumot(id) {
    try {
        const response = await fetch(`https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/ReshumotController.php/reshumot/${id}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ _method: 'DELETE' })
        });

        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Error deleting reshumot:', error);
        throw error;
    }
}

window.deleteReshumot = deleteReshumot; // ודא שהפונקציה מיועדת ל-window





// List all
const listApiUrl = 'https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/ReshumotController.php/reshumots';
// Function to list all reshumot
async function listAllReshumot() {
    try {
        const response = await fetch(listApiUrl);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        return data; 
    } catch (error) {
        console.error('Failed to fetch data:', error);
        throw error;
    }
}

// Read
async function readReshumot(departmentNames) {
    try {
        const response = await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/ReshumotController.php/reshumots', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ departments: departmentNames }),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const rawText = await response.text();
        try {
            const result = JSON.parse(rawText);
            return result;
        } catch (parseError) {
            console.error('Failed to parse response as JSON:', parseError);
            throw new Error(`Server returned invalid JSON. First 100 chars: ${rawText.substring(0, 100)}...`);
        }
    } catch (error) {
        console.error('Error in readReshumot:', error);
        throw error;
    }
}

window.readReshumot = readReshumot; // ודא שהפונקציה מיועדת ל-window
window.listAllReshumot = listAllReshumot;
window.deleteReshumot = deleteReshumot;
window.createReshumot = createReshumot;
window.updateReshumot = updateReshumot;




