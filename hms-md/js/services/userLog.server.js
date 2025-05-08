async function updateUser(id, userData) {
    const url = `https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/controller/UserLogController.php/log/${id}`;

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                _method: 'PUT', // כאן צריך להיות PATCH
                ...userData
            }),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        // Success handling
        return data;
    } catch (error) {
        console.error('שגיאה בעדכון:', error);
    }
}

window.updateUser = updateUser;

