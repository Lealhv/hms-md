function getDepartmentsByUserId(userId) {
    // const url = `/path/to/your/api/user_department/${userId}`; // עדכן את הכתובת בהתאם לנתיב שלך
    const url = `https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/UserDepartmentsController.php/user_department/${userId}`;

    fetch(url, {
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
        // כאן תוכל לעבד את הנתונים שהתקבלו ולהציג אותם בפרונט
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}

// קריאה לדוגמה עם user_id
 window.getDepartmentsByUserId = getDepartmentsByUserId; // החלף את 1 עם ה-user_id שאתה רוצה לחפש
