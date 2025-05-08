
// Function to list all suppliers
async function getAllSuppliers() {
	const suppliersApiUrl = 'https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/SuppliersController.php/suppliers';

    try {
        const response = await fetch(suppliersApiUrl);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const suppliers = await response.json();
        return suppliers; 
    } catch (error) {
        console.error('Failed to fetch suppliers:', error);
        return []; // החזר מערך ריק במקרה של שגיאה
    }
}

const api = 'https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/SuppliersController.php';

async function getSupplierById(id) {

    try {
        const response = await fetch(`${api}/supplier/${id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }
        const supplier = await response.json();
        return supplier;
    } catch (error) {
        console.error("Error fetching supplier:", error);
    }
}

window.getSupplierById = getSupplierById;
window.getAllSuppliers = getAllSuppliers;

// פונקציה ליצירת ספק חדש 
async function createSupplier(supplier) {
    try {
        const response = await fetch(`${api}/supplier`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(supplier)
        });
        // Check if the response is OK before trying to parse JSON
        if (!response.ok) {
            const errorText = await response.text(); // קרא את התגובה כהטקסט
            console.error(`HTTP error! status: ${response.status}`, errorText);
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        // Check if data contains an array of errors
        if (Array.isArray(data) && data.length > 0 && data.every(item => item.error)) {
            const errors = data.map(item => item.error);
            console.error('Error in createSupplier:', errors);
            return { status: response.status, errors, message: 'error' }; // Returning 'error' here
        }

        return { status: response.status, data };
    } catch (error) {
        console.error('Error in createSupplier:', error);
        // Return a structured error object instead of throwing
        return { status: 500, error: error.message };
    }
}

window.createSupplier = createSupplier;
