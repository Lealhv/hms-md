// Define API URL
const mnilvimApiUrl = 'http://localhost/project/hms-md/Back/controller/MnilvimController.php/mnilvim';

// Function to list all mnilvim
async function listMnilvim(id) {
  try {
    const response = await fetch(`${mnilvimApiUrl}/${id}`);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    return data;
  } catch (error) {
    throw error;
  }
}
async function deleteMnilvim(id) {
  try {
    const response = await fetch(`${mnilvimApiUrl}/${id}`, {
      method: 'DELETE',
    });
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return { success: true, message: ' המסמך נמחק בהצלחה' };
  } catch (error) {
    throw error;
  }
}
async function updateMnilvim(id, updatedDocument) {
  try {
    const response = await fetch(`${mnilvimApiUrl}/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(updatedDocument),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    return data;
  } catch (error) {
    throw error;
  }
}
async function addMnilvim(document) {
  try {
    const response = await fetch(mnilvimApiUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(document),
    });
   
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    return data;
  } catch (error) {
    throw error;
  }
}


window.updateMnilvim = updateMnilvim ;

window.addMnilvim = addMnilvim ;

window.deleteMnilvim = deleteMnilvim ;

window.listMnilvim = listMnilvim;
