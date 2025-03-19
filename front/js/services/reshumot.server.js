const apiUrl = 'http://localhost/project/hms-md/Back/controller/reshumot.php'; 

// Create
export async function createReshumot(Rsh_id, Rsh_date, Rsh_mchlaka, Rsh_sapak, Rsh_schoom, Rsh_maam, Rsh_schmaam, Rsh_schtotal, Rsh_pratim, Rsh_proyktnam, Rsh_status, Rsh_sochen, Rsh_takziv, Rsh_cname, Rsh_cnametl, Rsh_cemail) {
    const response = await fetch(`${apiUrl}/create`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ Rsh_id, Rsh_date, Rsh_mchlaka, Rsh_sapak, Rsh_schoom, Rsh_maam, Rsh_schmaam, Rsh_schtotal, Rsh_pratim, Rsh_proyktnam, Rsh_status, Rsh_sochen, Rsh_takziv, Rsh_cname, Rsh_cnametl, Rsh_cemail })
    });
    return response.json();
}

// Read
export async function readReshumot(Rsh_id) {
    const response = await fetch(`${apiUrl}/read/${Rsh_id}`);
    return response.json();
}

// Update
export async function updateReshumot(Rsh_id, Rsh_date, Rsh_mchlaka, Rsh_sapak, Rsh_schoom, Rsh_maam, Rsh_schmaam, Rsh_schtotal, Rsh_pratim, Rsh_proyktnam, Rsh_status, Rsh_sochen, Rsh_takziv, Rsh_cname, Rsh_cnametl, Rsh_cemail) {
    const response = await fetch(`${apiUrl}/update/${Rsh_id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ Rsh_date, Rsh_mchlaka, Rsh_sapak, Rsh_schoom, Rsh_maam, Rsh_schmaam, Rsh_schtotal, Rsh_pratim, Rsh_proyktnam, Rsh_status, Rsh_sochen, Rsh_takziv, Rsh_cname, Rsh_cnametl, Rsh_cemail })
    });
    return response.json();
}

// Delete
export async function deleteReshumot(Rsh_id) {
    const response = await fetch(`${apiUrl}/delete/${Rsh_id}`, {
        method: 'DELETE'
    });
    return response.ok;
}

// List all
export async function listAllReshumot() {
    const response = await fetch(`${apiUrl}/listAll`);
    return response.json();
}
