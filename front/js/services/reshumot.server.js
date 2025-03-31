
// Create
// In reshumot.server.js, around line 22
async function createReshumot(data) {
    try {
        debugger
      const response = await fetch('http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumot/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      });
      
      // Get the raw text response for debugging
      const rawText = await response.text();      
      // Try to parse it as JSON
      try {
        const result = JSON.parse(rawText);
        return result;
      } catch (parseError) {
        console.error('Failed to parse response as JSON:', parseError);
        throw new Error(`Server returned invalid JSON. First 100 chars: ${rawText.substring(0, 100)}...`);
      }
    } catch (error) {
      console.error('Error in createReshumot:', error);
      throw error;
    }
  }
  




// // Read
// export async function readReshumot(Rsh_id) {
//     const response = await fetch(`${apiUrl}/read/${Rsh_id}`);
//     return response.json();
// }

// Update
async function updateReshumot(data) {
    const apiUrl = `http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumot/${data.Rsh_id}`;


    try {
        const response = await fetch(apiUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data) // ודא ש-data מכיל את כל השדות הנדרשים
        });


        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.statusText}`);
        }

        const result = await response.json();
        return result;

    } catch (error) {
        console.error('Error updating reshumot:', error);
        throw error; // לזרוק את השגיאה כדי שניתן יהיה לטפל בה מחוץ לפונקציה
    }
}

// Delete
async function deleteReshumot(id) {
    const apiUrl = `http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumot/${id}`;

    try {
        const response = await fetch(`${apiUrl}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        return data; // מחזירה את התגובה מהשרת
    } catch (error) {
        console.error('Error deleting reshumot:', error);
        return { error: error.message }; // מחזירה שגיאה במקרה של בעיה
    }
}

// List allexport
async function listAllReshumot() {
    const apiUrl = 'http://localhost/project/hms-md/Back/controller/ReshumotController.php/reshumots';
    try {
        const response = await fetch(`${apiUrl}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Failed to fetch data:', error);
    }
}


window.listAllReshumot = listAllReshumot;
window.deleteReshumot = deleteReshumot;
window.createReshumot = createReshumot;
window.updateReshumot = updateReshumot;