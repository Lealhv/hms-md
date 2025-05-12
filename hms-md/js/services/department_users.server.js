function getDepartmentsByUserId(userId) {
    const url = `https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/UserDepartmentsController.php/user_department/${userId}`;

    return fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log('Departments:', data);
        return data; // החזרת הנתונים
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        return null; // החזרת null במקרה של שגיאה
    });
}

// קריאה לדוגמה עם user_id
window.getDepartmentsByUserId = getDepartmentsByUserId;
