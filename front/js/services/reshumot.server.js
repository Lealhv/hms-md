
// Create
// async function createReshumot(data) {
//     console.log('Sending data to the API:', data);
//     const response = await fetch(`${apiUrl}/create`, {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify(data)
//     });

//     // Check if the response is not empty
//     if (response.ok) {
//         const text = await response.text();
//         console.log('Raw response text:', text);

//         // If the text is not empty, try to parse it as JSON
//         if (text) {
//             try {
//                 const result = JSON.parse(text);
//                 console.log('Request succeeded:', result);
//                 return result;
//             } catch (error) {
//                 console.error('Error parsing JSON:', error);
//                 throw new Error('Invalid JSON response');
//             }
//         } else {
//             console.error('Response is empty');
//             throw new Error('Response is empty');
//         }
//     } else {
//         console.error('Request failed:', response.status, response.statusText);
//         throw new Error(`Request failed with status ${response.status}`);
//     }
// }


// window.createReshumot = createReshumot;

// // Read
// export async function readReshumot(Rsh_id) {
//     const response = await fetch(`${apiUrl}/read/${Rsh_id}`);
//     return response.json();
// }

// // Update
// export async function updateReshumot(Rsh_id, data) {
//     const response = await fetch(`${apiUrl}/update/${Rsh_id}`, {
//         method: 'PUT',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify(data)
//     });
//     return response.json();
// }

// // Delete
// export async function deleteReshumot(Rsh_id) {
//     const response = await fetch(`${apiUrl}/delete/${Rsh_id}`, {
//         method: 'DELETE'
//     });
//     return response.ok;
// }

// List allexport
  async function listAllReshumot() {
    const apiUrl = 'http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumots';
    console.log('Calling API to list all Reshumot...');
    try {
        const response = await fetch(`${apiUrl}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Received data:', data);
        return data;
    } catch (error) {
        console.error('Failed to fetch data:', error);
    }
}


window.listAllReshumot = listAllReshumot;