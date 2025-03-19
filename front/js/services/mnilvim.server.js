// function sendReshumaToServer(data) {
//     return fetch('http://localhost/project/hms-md/Back/controller/Reshumot.php/saveData', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify(data),
//         mode: 'cors' // Explicitly set CORS mode
//     })
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         return response.json();
//     })
//     .then(data => {
//         console.log('Success:', data);
//         return true;
//     })
//     .catch(error => {
//         console.error('There was a problem with the fetch operation:', error);
//         return false;
//     });
// }



// window.sendReshumaToServer = sendReshumaToServer;

 const apiUrl = 'http://localhost/project/hms-md/Back/controller/mnllvim.php';

// Create a new Mnllvim

// Create
export async function createMnllvim(MN_id, MN_pratim, MN_location) {
    debugger;
    const response = await fetch(`${apiUrl}/create`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ MN_id, MN_pratim, MN_location })
    });
    return response.json();
}

// Read
export async function readMnllvim(MN_id) {
    const response = await fetch(`${apiUrl}/read/${MN_id}`);
    return response.json();
}

// Update
export async function updateMnllvim(MN_id, MN_pratim, MN_location) {
    const response = await fetch(`${apiUrl}/update/${MN_id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ MN_pratim, MN_location })
    });
    return response.json();
}

// Delete
export async function deleteMnllvim(MN_id) {
    const response = await fetch(`${apiUrl}/delete/${MN_id}`, {
        method: 'DELETE'
    });
    return response.ok;
}

// List all
export async function listAllMnllvim() {
    const response = await fetch(`${apiUrl}/listAll`);
    return response.json();
}
