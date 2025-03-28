
function updateUser(id, userData) {
    const url =`http://localhost/project/hms-md/Back/controller/UserLogController.php/log/${id} `;
 
    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(userData),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
window.updateUser = updateUser;
