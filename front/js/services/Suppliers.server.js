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

// פונקציה ליצירת ספק חדש
async function createSupplier(supplierName) {
    try {
        const response = await fetch('http://localhost/project/hms-md/Back/controller/SuppliersController.php/supplier', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ SP_name: supplierName })
        });
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const result = await response.json();
        console.log(result); // כאן תוכל להציג את התגובה מהשרת
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
}

window.getAllSuppliers = getAllSuppliers;