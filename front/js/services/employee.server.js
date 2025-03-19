function sendReshumaToServer(data) {
    return fetch('http://localhost/project/hms-md/Back/controller/Reshumot.php/saveData', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
        mode: 'cors' // Explicitly set CORS mode
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Success:', data);
        return true;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        return false;
    });
}

window.sendReshumaToServer = sendReshumaToServer;
