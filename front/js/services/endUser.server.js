
async function fetchData(passId) {
    const url = `http://localhost/project/hms-md/Back/controller/EndUserController.php/user/${passId}`;

    try {
        const response = await fetch(`${url}`);
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.status} ${response.statusText}`);
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        throw error;
    }
}


async function fetchWithTimeout(url, options, timeout = 5000) {
    return Promise.race([
        fetch(url, options),
        new Promise((_, reject) => setTimeout(() => reject(new Error('Request timed out')), timeout))
    ]);
}


window.fetchData = fetchData;

