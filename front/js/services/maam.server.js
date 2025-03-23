// const apiUrl = 'http://localhost/project/hms-md/Back/controller/maam.php'; // הכנס את ה-URL של ה-API שלך

// // Create
// export async function createMaam(maam_v, maam_value, maam_Strtdate, maam_Enddate) {
//     const response = await fetch(`${apiUrl}/create`, {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({ maam_v, maam_value, maam_Strtdate, maam_Enddate })
//     });
//     return response.json();
// }

// // Read
// export async function readMaam(maam_v) {
//     const response = await fetch(`${apiUrl}/read/${maam_v}`);
//     return response.json();
// }

// // Update
// export async function updateMaam(maam_v, maam_value, maam_Strtdate, maam_Enddate) {
//     const response = await fetch(`${apiUrl}/update/${maam_v}`, {
//         method: 'PUT',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({ maam_value, maam_Strtdate, maam_Enddate })
//     });
//     return response.json();
// }

// // Delete
// export async function deleteMaam(maam_v) {
//     const response = await fetch(`${apiUrl}/delete/${maam_v}`, {
//         method: 'DELETE'
//     });
//     return response.ok;
// }

// List all
async function listAllMaam() {
    const apiUrl = 'http://localhost/project/hms-md/Back/controller/MaamController.php/maams'; // הכנס את ה-URL של ה-API שלך
    const response = await fetch(`${apiUrl}`);
    return response.json();
}

window.listAllMaam = listAllMaam;