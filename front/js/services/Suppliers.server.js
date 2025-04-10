const apiUrl = 'http://localhost/project/hms-md/Back/controller/SuppliersController.php';

// פונקציה לקבלת כל הספקים
async function getAllSuppliers() {
    try {
        const response = await fetch(`${apiUrl}/suppliers`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const suppliers = await response.json();
        console.log(suppliers); // כאן תוכל להציג את הספקים או לעבד אותם
        return suppliers; // החזר את המערך של הספקים
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        return []; // החזר מערך ריק במקרה של שגיאה
    }
}

// פונקציה ליצירת ספק חדשa 
async function createSupplier(supplier) {
    try {
        const response = await fetch(`${apiUrl}/supplier`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(supplier)
        });

        // Check if the response is OK before trying to parse JSON
        if (!response.ok) {
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



// פונקציה לקבלת כל הספקים
async function getSupplierById(id) {
    debugger
    try {
        const response = await fetch(`${apiUrl}/supplier/${id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }
        debugger;
        const supplier = await response.json();
        return supplier;
    } catch (error) {
        console.error("Error fetching supplier:", error);
    }
}


window.getSupplierById = getSupplierById;
window.getAllSuppliers = getAllSuppliers;
window.createSupplier = createSupplier;