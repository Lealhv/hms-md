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
    const url = `http://localhost/project/hms-md/Back/config/database.php/controller/EndUserController.php/read?id=${userId}`;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        return data; // מחזיר את הנתונים
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
}
    window.fetchData = fetchData;
