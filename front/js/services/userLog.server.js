
function updateUser(id, userData) {
    const url =`http://localhost/project/hms-md/Back/controller/UserLogController.php/log/${id} `;
    debugger
  console.log("start")
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
        console.log('User updated successfully:', data);
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
window.updateUser = updateUser;
