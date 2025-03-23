// Define API URL
const mnilvimApiUrl = 'http://localhost/project/hms-md/Back/controller/MnilvimController.php/mnilvims';

// Function to list all mnilvim
async function listAllMnilvim() {
  try {
    const response = await fetch(mnilvimApiUrl);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    console.log('Fetched mnilvim data:', data); // הוסף קונסול לוג כאן
    return data;
  } catch (error) {
    console.error('Error listing mnilvim:', error);
    throw error;
  }
}





window.listAllMnilvim = listAllMnilvim;
