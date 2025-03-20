// פונקציה לשליחת בקשת GET לשרת PHP
// function fetchData(userId) {
//     const url = `http://localhost/project/hms-md/Back/config/database.php/controller/EndUserController.php/read?id=${userId}`; // כתובת ה-URL עם המשתנה

//     fetch(url)
//         .then(response => {
//             debugger
//             if (!response.ok) {
//                 throw new Error('Network response was not ok');
//             }
//             return response.json(); // המרת התגובה ל-JSON
//         })
//         .then(data => {
//             console.log(data); // הצגת הנתונים שהתקבלו
//         })
//         .catch(error => {
//             console.error('There was a problem with the fetch operation:', error);
//         });
// }

async function fetchData(userId) {
    const url = `http://localhost/project/hms-md/Back/controller/EndUserController.php/user/${userId}`;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.status} ${response.statusText}`);
        }
        
        // Log the raw response text to see what's being returned
        const responseText = await response.text();
        console.log('Raw response:', responseText);
        
        // Only try to parse as JSON if there's content
        if (responseText.trim()) {
            return JSON.parse(responseText);
        } else {
            throw new Error('Empty response received from server');
        }
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        throw error; // Re-throw to allow handling by the caller
    }
}

    window.fetchData = fetchData;
