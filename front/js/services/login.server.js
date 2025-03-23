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
async function fetchData(passId) {
    const url = `http://localhost/project/hms-md/Back/controller/EndUserController.php/user/${passId}`;

    try {
        const response = await fetch(`${url}`);
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.status} ${response.statusText}`);
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        throw error;
    }
}

// async function listAllReshumot() {
//     const apiUrl = 'http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumots';
//     console.log('Calling API to list all Reshumot...');
//     try {
//         const response = await fetch(`${apiUrl}`);
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         const data = await response.json();
//         console.log('Received data:', data);
//         return data;
//     } catch (error) {
//         console.error('Failed to fetch data:', error);
//     }
// }


// window.listAllReshumot = listAllReshumot;


async function fetchWithTimeout(url, options, timeout = 5000) {
    return Promise.race([
        fetch(url, options),
        new Promise((_, reject) => setTimeout(() => reject(new Error('Request timed out')), timeout))
    ]);
}

async function getAll() {
    debugger
    fetch('http://localhost/project/hms-md/Back/controller/EndUserController.php/users')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => console.log(data))
        .catch(error => console.error('There was a problem with the fetch operation:', error));
}


window.fetchData = fetchData;
window.getAll = getAll;

