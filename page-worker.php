<?php

/**
 * Template Name: HMS worker Page
 */
get_header();
?>

<div class="container" onload="getData()">
    <div class="section" id="header">
        <div class="header-container">
            <div class="logo-area">
            </div>
            <div class="title-area">
                <h1>מערכת ניהול הזמנות</h1>
                <p class="subtitle">מערכת לניהול ומעקב אחר הזמנות</p>
            </div>
        </div>
    </div>

    <div class="header-buttons">
        <button type="button" class="btn-danger" onclick="exit()">
            <i class="fas fa-sign-out-alt"></i> יציאה
        </button>
        <button id="conditionalButton" class="admin-btn" onclick="goToAdmin()">לעמוד מנהל</button>
    </div>

    <div class="section" id="input-form">

        <h2>טופס הזמנה</h2>
        <form id="documentForm">
            <!-- Row 1 -->
            <div class="form-group">
                <label for="department">מחלקה:</label>
                <input type="text" id="department" name="department" placeholder="הזן שם מחלקה">
                <div id="error-department" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="supplierId">מספר הספק:</label>
                <select id="supplierId" name="supplierId">
                    <option value="" disabled selected>בחר ספק</option>
                </select>
                <div id="error-supplierId" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="supplierName">שם ספק:</label>
                <input type="text" id="supplierName" name="supplierName" placeholder="בחר ספק" readonly>
                <div id="error-supplierName" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="amount">סכום:</label>
                <input type="number" id="amount" name="amount" placeholder="הזן סכום">
                <div id="error-amount" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="deliveryPlace">מקום אספקה:</label>
                <input type="text" id="deliveryPlace" name="deliveryPlace" placeholder="הזן מקום אספקה">
                <div id="error-deliveryPlace" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="agentNumber">מס סוכן:</label>
                <input type="text" id="agentNumber" name="" placeholder="הזן מספר סוכן">
                <div id="error-agentNumber" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="contactName">שם סוכן:</label>
                <input type="text" id="contactName" name="contactName" placeholder="הזן שם סוכן">
                <div id="error-contactName" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="contactPhone">טלפון סוכן:</label>
                <input type="text" id="contactPhone" name="contactPhone" placeholder="הזן טלפון סוכן">
                <div id="error-contactPhone" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="contactEmail">מייל סוכן:</label>
                <input type="email" id="contactEmail" name="contactEmail" placeholder="הזן מייל סוכן">
                <div id="error-contactEmail" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="projectName">שם פרויקט:</label>
                <input type="text" id="projectName" name="projectName" placeholder="הזן שם פרויקט">
                <div id="error-projectName" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="budgetItem">מספר סעיף תקציבי:</label>
                <input type="number" id="budgetItem" name="budgetItem" placeholder="הזן מספר סעיף">
                <div id="error-budgetItem" class="error-message" style="color: red;"></div>
            </div>

            <!-- Hidden fields -->
            <input type="hidden" id="autoNumber" name="autoNumber">
            <input type="hidden" id="timestamp" name="timestamp">

            <div id="error-message" class="error-message" style="color: red;"></div>

            <!-- Buttons -->
            <div class="btn-container">
                <div class="btn-container">
                    <button type="button" class="btn-primary form-action-btn" onclick="saveData()">
                        <i class="fas fa-save"></i> שמירת נתונים
                    </button>

                    <button type="button" class="btn-secondary form-action-btn"
                        onclick="document.getElementById('document').click();">
                        <i class="fas fa-file-upload"></i> הוספת מסמכים נילווים
                    </button>
                    <button type="button" class="btn-secondary form-action-btn" onclick="printData()">
                        <i class="fas fa-print"></i> הדפסה
                    </button>
                    <button type="button" class="btn-secondary form-action-btn" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> ייצוא PDF
                    </button>
                    <button type="button" class="btn-secondary form-action-btn" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> ייצוא EXCEL
                    </button>
                    <button type="button" class="btn-secondary" onclick="clearFields()">
                        <i class="fas fa-eraser"></i> ניקוי
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- ---------------------------------------------------- -->

    <div class="card" id="documents-area">
        <h2><i class="fas fa-folder-open"></i> מסמכים נלווים</h2>
        <div id="message" style="display:none; color:red;"></div> <!-- הודעה נפרדת -->
        <table id="documentsTable" style="display:none;">
            <thead>
                <tr>
                    <th>שם מסמך</th>
                    <th>תאריך הוספה</th>
                    <th>פעולה</th>
                </tr>
            </thead>
            <tbody id="documents-body">
            </tbody>
        </table>
    </div>

    <div id="listAllReshumot">
    </div>

    <div id="formContainer"></div>

    <input type="file" id="document" style="display: none;" onchange="MnilvimUpload(event)">

</div>

<script>
    let isFunctionCalled = false; // משתנה גלובלי לבדוק אם הפונקציה זומנה

    var RSH_ID = 0;

    function getData() {
        getReshumot();
        checkFunctionCall();
        loadListSuppliers();
    }
document.addEventListener('DOMContentLoaded', function() {
    const formFields = document.querySelectorAll('#documentForm input, #documentForm select');
    formFields.forEach(field => {
        field.addEventListener('input', checkFormCompletion);
    });

    // הוסף מאזין לאירוע blur לשדה מספר סעיף תקציבי
    document.getElementById('budgetItem').addEventListener('blur', function() {
        const budgetItemValue = this.value;
        const errorMessageElement = document.getElementById("error-budgetItem");
        errorMessageElement.innerText = ""; // נקה הודעת שגיאה קודמת

        // בדוק אם הערך הוא בדיוק 7 ספרות
        if (!/^\d{7}$/.test(budgetItemValue)) {
            errorMessageElement.innerText = "מספר סעיף תקציבי חייב להיות 7 ספרות.";
        }
    });

    // Initial check
    checkFormCompletion();
});

	
async function loadListSuppliers() {
    const suppliers = await listSuppliers(); // הנחה שהפונקציה מחזירה מערך של ספקים

    if (!Array.isArray(suppliers)) {
        console.error("החזרה אינה מערך");
        return;
    }

    const supplierSelect = document.getElementById('supplierId');
    supplierSelect.innerHTML = '<option value="" disabled selected>בחר ספק</option>'; // ניקוי אפשרויות קודמות

    suppliers.forEach(supplier => {
        const option = document.createElement('option');
        option.value = supplier.SP_id; // הנח כאן את ה-SP_id
        option.textContent = `${supplier.SP_id} - ${supplier.SP_name}`; // הצגת SP_id ו-SP_name
        supplierSelect.appendChild(option);
    });
}

    // Function to check if all required fields are filled
    function checkFormCompletion() {
        const requiredFields = [
            'department',
            'supplierId',
            'amount',
            'deliveryPlace',
            'agentNumber',
            'contactName',
            'contactPhone',
            'contactEmail',
            'projectName',
            'budgetItem'
        ];

        let allFilled = true;

        for (const fieldId of requiredFields) {
            const field = document.getElementById(fieldId);
            if (!field || !field.value.trim()) {
                allFilled = false;
                break;
            }
        }

        // Special validation for phone and email
        const phone = document.getElementById('contactPhone').value;
        const email = document.getElementById('contactEmail').value;

        if (!validatePhone(phone) || !validateEmail(email)) {
            allFilled = false;
        }

        // Update buttons state
        const actionButtons = document.querySelectorAll('.form-action-btn');
        actionButtons.forEach(button => {
            if (allFilled) {
                button.classList.remove('disabled-btn');
                button.disabled = false;
            } else {
                button.classList.add('disabled-btn');
                button.disabled = true;
            }
        });
    }

    // Add event listeners to all form fields to check completion on input
    document.addEventListener('DOMContentLoaded', function() {
        const formFields = document.querySelectorAll('#documentForm input, #documentForm select');
        formFields.forEach(field => {
            field.addEventListener('input', checkFormCompletion);
        });

        // Initial check
        checkFormCompletion();
    });

function validateForm() {
    const department = document.getElementById("department").value;
    const supplierId = document.getElementById("supplierId").value;
    const amount = document.getElementById("amount").value;
    const deliveryPlace = document.getElementById("deliveryPlace").value;
    const agentNumber = document.getElementById("agentNumber").value;
    const contactName = document.getElementById("contactName").value;
    const contactPhone = document.getElementById("contactPhone").value;
    const contactEmail = document.getElementById("contactEmail").value;
    const projectName = document.getElementById("projectName").value;
    const budgetItem = document.getElementById("budgetItem").value;

    // נקה הודעות שגיאה קודמות
    clearErrorMessages();

    let isValid = true;

    if (!department) {
        document.getElementById("error-department").innerText = "מחלקה היא שדה חובה.";
        isValid = false;
    }

    if (!supplierId) {
        document.getElementById("error-supplierId").innerText = "יש לבחור ספק.";
        isValid = false;
    }

    if (!amount || amount <= 0) {
        document.getElementById("error-amount").innerText = "סכום חייב להיות חיובי.";
        isValid = false;
    }

    if (!deliveryPlace) {
        document.getElementById("error-deliveryPlace").innerText = "מקום אספקה הוא שדה חובה.";
        isValid = false;
    }

    if (!agentNumber) {
        document.getElementById("error-agentNumber").innerText = "מס סוכן הוא שדה חובה.";
        isValid = false;
    }

    if (!contactName) {
        document.getElementById("error-contactName").innerText = "שם סוכן הוא שדה חובה.";
        isValid = false;
    }

    if (!validatePhone(contactPhone)) {
        document.getElementById("error-contactPhone").innerText = "טלפון סוכן לא תקין.";
        isValid = false;
    }

    if (!validateEmail(contactEmail)) {
        document.getElementById("error-contactEmail").innerText = "מייל סוכן לא תקין.";
        isValid = false;
    }

    if (!projectName) {
        document.getElementById("error-projectName").innerText = "שם פרויקט הוא שדה חובה.";
        isValid = false;
    }

    // בדיקה עבור מספר סעיף תקציבי
    if (!/^\d{7}$/.test(budgetItem)) {
        document.getElementById("error-budgetItem").innerText = "מספר סעיף תקציבי חייב להיות 7 ספרות.";
        isValid = false;
    }

    return isValid; // מחזיר true אם כל הבדיקות עברו
}


    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function validatePhone(phone) {
        const regex = /^\d{10}$/; // בדיקה לפורמט טלפון של 10 ספרות
        return regex.test(phone);
    }

    function clearErrorMessages() {
        const errorIds = [
            "error-department",
            "error-supplierId",
            "error-amount",
            "error-deliveryPlace",
            "error-agentNumber",
            "error-contactName",
            "error-contactPhone",
            "error-contactEmail",
            "error-projectName",
            "error-budgetItem"
        ];

        errorIds.forEach(id => {
            document.getElementById(id).innerText = "";
        });
    }

    // הוסף מאזיני אירועים לכל שדה
    document.querySelectorAll('input, select').forEach(element => {
        setupErrorClearingListeners();
        element.addEventListener('input', clearErrorMessages);
    });

    function setupErrorClearingListeners() {
        document.querySelectorAll('input, select').forEach(element => {
            element.addEventListener('input', clearErrorMessages);
        });
    }

    function clearErrorMessages() {
        const errorIds = [
            "error-department",
            "error-supplierId",
            "error-amount",
            "error-deliveryPlace",
            "error-agentNumber",
            "error-contactName",
            "error-contactPhone",
            "error-contactEmail",
            "error-projectName",
            "error-budgetItem"
        ];

        errorIds.forEach(id => {
            document.getElementById(id).innerText = "";
        });
    }

    // פונקציה לבדוק אם המייל תקין
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // עדכון הפונקציה לשמירת נתונים

    function clearFields() {
        // Check if elements exist before trying to set their value
        if (document.getElementById('autoNumber')) document.getElementById('autoNumber').value = '';
        if (document.getElementById('timestamp')) document.getElementById('timestamp').value = '';
        if (document.getElementById('department')) document.getElementById('department').value = '';
        if (document.getElementById('supplierId')) document.getElementById('supplierId').value = '';
        if (document.getElementById('supplierName')) document.getElementById('supplierName').value = '';
        if (document.getElementById('amount')) document.getElementById('amount').value = '';
        if (document.getElementById('deliveryPlace')) document.getElementById('deliveryPlace').value = '';
        if (document.getElementById('contactName')) document.getElementById('contactName').value = '';
        if (document.getElementById('contactPhone')) document.getElementById('contactPhone').value = '';
        if (document.getElementById('contactEmail')) document.getElementById('contactEmail').value = '';
        if (document.getElementById('projectName')) document.getElementById('projectName').value = '';
        if (document.getElementById('agentNumber')) document.getElementById('agentNumber').value = '';
        if (document.getElementById('budgetItem')) document.getElementById('budgetItem').value = '';

        checkFormCompletion();
        loadDocuments();
    }

    function clearField(fieldId) {
        document.getElementById(fieldId).value = '';
    }

    function printData() {
        window.print();
    }

    function exit() {
        window.location.href = '/login'; // דף הלוגאין
    }

function MnilvimUpload(event) {
    event.preventDefault(); // למנוע את שליחת הטופס הרגילה

    const fileInput = document.getElementById('document');
    const formData = new FormData();

    // הוסף את המידע הנוסף
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const lastDotIndex = file.name.lastIndexOf('.');
        const fileNameWithoutExtension = lastDotIndex !== -1 ? file.name.substring(0, lastDotIndex) : file.name;
        
        formData.append('MN_pratim', fileNameWithoutExtension);
        formData.append('MN_shyooch', RSH_ID); // לדוגמה, RSH_ID
        formData.append('MN_status', 1); // סטטוס
        formData.append('MN_dateAdd', new Date().toISOString().split('T')[0]); // תאריך של היום
        formData.append('MN_type', file.type); // סוג הקובץ
        formData.append('document', file); // הוספת הקובץ עצמו
    }
	console.log("formData" , formData)
	for (var pair of formData.entries()) {
    console.log(pair[0] + ', ' + pair[1]);
}

    loadMnilvim(formData)
        .then(response => {
            if (response.message === "Mnilvim created successfully")
                showNotification("הקובץ נוסף בהצלחה!");
            loadDocuments(RSH_ID);
	

        })
        .catch(error => {
            showNotification("אירעה שגיאה בהוספת הקובץ: " + error.message);
        });
}


    function showNotification(message, type = 'info') {
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => {
            notification.remove();
        });

        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        let icon = 'info-circle';
        if (type === 'success') {
            icon = 'check-circle';
        } else if (type === 'error') {
            icon = 'exclamation-circle';
        }
        notification.innerHTML = `
                <div class="notification-icon">
                    <i class="fas fa-${icon}"></i>
                </div>
                <div class="notification-message">${message}</div>
                <button class="notification-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        setTimeout(() => {
            if (notification.parentElement) {
                notification.classList.remove('show');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 5000);
    }

    function exportToPDF() {
        const element = document.querySelector('.container');
        html2pdf()
            .from(element)
            .save('purchase_request.pdf')
            .then(() => {
                showNotification('הקובץ PDF יוצא בהצלחה!');
            });
    }

    function exportToExcel() {
        const data = [
            ['Record Number', 'Timestamp', 'Department', 'Supplier Name', 'Amount', 'Delivery Location', 'sochen', 'Contact Name', 'Contact Phone', 'Contact Email', 'Project Name', 'Budget Item'],
            [
                document.getElementById('autoNumber').value,
                document.getElementById('timestamp').value,
                document.getElementById('department').value,
                document.getElementById('supplierId').value,
                document.getElementById('amount').value,
                document.getElementById('deliveryPlace').value,
                document.getElementById('agentNumber').value,
                document.getElementById('contactName').value,
                document.getElementById('contactPhone').value,
                document.getElementById('contactEmail').value,
                document.getElementById('projectName').value,
                document.getElementById('budgetItem').value
            ]
        ];
        const workbook = XLSX.utils.book_new();

        // המרת המערך לאובייקט מתאים ל-XLSX
        const worksheetData = [data[0]].concat(data.slice(1));
        const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);

        // הוסף את הגיליון לחוברת העבודה
        XLSX.utils.book_append_sheet(workbook, worksheet, "Data");

        // שמור את הקובץ
        XLSX.writeFile(workbook, "data.xlsx");
    }

    async function saveData() {
        if (validateForm()) {
            const recordId = document.getElementById('autoNumber').value;

            try {
                // Fetch all records to check if the record already exists
                const records = await listReshumot();
                const existingRecord = records.find(record => record.Rsh_id === recordId);
				const orderer = localStorage.getItem('EU_Name');
                const data = {
                    Rsh_date: new Date().toLocaleString('sv-SE'),
                    Rsh_mchlaka: document.getElementById('department').value,
                    Rsh_sapak: document.getElementById('supplierId').value,
                    Rsh_schoom: document.getElementById('amount').value,
                    Rsh_aspaka: document.getElementById('deliveryPlace').value,
                    Rsh_proyktnam: document.getElementById('projectName').value,
                    Rsh_sochen: document.getElementById('agentNumber').value,
                    Rsh_takziv: document.getElementById('budgetItem').value,
                    Rsh_cname: document.getElementById('contactName').value,
                    Rsh_cnametl: document.getElementById('contactPhone').value,
                    Rsh_cemail: document.getElementById('contactEmail').value,
					Rsh_orderer : orderer
                };
			
                let response;
                if (existingRecord) {
                    // If record exists, update it
                    response = await saveReshumot(data, recordId);
                    if (response && response.message === "Reshumot updated successfully") {
                        showNotification('הזמנה עודכנה בהצלחה!');
                        getReshumot();
                    } else {
                        showNotification('שגיאה בעדכון ההזמנה', 'error');
                    }
                } else {
                    // If record does not exist, create it
                    response = await createReshumot(data);
                    if (response && response.message === "Reshumot created successfully") {
                        showNotification('הזמנה נשמרה בהצלחה!');
                        getReshumot();
                    } else {
                        showNotification('שגיאה בשמירת ההזמנה', 'error');
                    }
                }

                clearFields(); // Clear fields after saving
            } catch (error) {
                console.error('Error saving Reshuma:', error);
                console.error('Error details:', error.message);

                // Show a more user-friendly error message
                showNotification('שגיאה בשמירת ההזמנה: ' +
                    (error.message.includes("invalid response") ?
                        "בעיה בתקשורת עם השרת" : error.message), 'error');
            }
        }
    }

    // פונקציה לניהול הרשאות
    setTimeout(() => {
        showNotification("מתנתק מהמערכת...");
        exit();
    }, 600000); // 10 דקות

    // פונקציה לטעינת הזמנות
    async function getReshumot() {
        try {
            let reshumot;
            try {
                reshumot = await listReshumot();
				console.log("reshumot" , reshumot)
                fillForm(reshumot);
            } catch (e) {
                console.error('Error calling listAllReshumot:', e);
                reshumotListDiv.innerHTML = '<p>Error fetching data: ' + e.message + '</p>';
                return;
            }

            if (!reshumot) {
                console.warn('Reshumot data is null or undefined');
                reshumotListDiv.innerHTML = '<p>No data available</p>';
                return;
            }

        } catch (error) {
            console.error('Error in getReshumot function:', error);
            const reshumotListDiv = document.getElementById('reshumotList');
            if (reshumotListDiv) {
                reshumotListDiv.innerHTML = '<p>Error loading data: ' + error.message + '</p>';
            }
        }
    }

    window.onload = function() {
        initializeForm();
        try {
            getData();
        } catch (error) {
            console.error('Error in getData:', error);
            const reshumotListDiv = document.getElementById('reshumotList');
            if (reshumotListDiv) {
                reshumotListDiv.innerHTML = '<p>Failed to load data</p>';
            }
        }
    };

    function initializeForm() {
        const now = new Date();
        if (document.getElementById('timestamp')) {
            document.getElementById('timestamp').value = now.toLocaleString();
        }

        if (document.getElementById('autoNumber')) {
            document.getElementById('autoNumber').value = 'AUTO-' + Math.floor(Math.random() * 10000);
        }

        const formFields = document.querySelectorAll('#documentForm input, #documentForm select');
        formFields.forEach(field => {
            if (field.type === 'number' && !field.value) {
                field.value = '0';
            }
        });
    }

async function fillForm(reshumot) {
    const reshumotListDiv = document.getElementById('listAllReshumot');

    if (!reshumot || reshumot.length === 0) {
        console.warn('No records to display in fillForm');
        reshumotListDiv.innerHTML = '<p>אין נתונים להצגה</p>';
        return;
    }

    const titleMapping = {
        'Rsh_date': 'תאריך',
        'Rsh_mchlaka': 'מחלקה',
        'Rsh_sapak': 'מספר ספק',
        'SP_name': 'פרטי ספק',
        'Rsh_schoom': 'סכום',
        'Rsh_aspaka': 'מקום אספקה',
        'Rsh_proyktnam': 'שם פרויקט',
        'Rsh_sochen': 'סוכן',
        'Rsh_cname': 'שם סוכן',
        'Rsh_cnametl': 'טלפון סוכן',
        'Rsh_cemail': 'מייל סוכן',
        'Rsh_takziv': 'מספר סעיף תקציבי',
        'Rsh_orderer': 'שם המזמין' // הוספת השדה החדש
    };

    const hiddenColumns = ['Rsh_id', 'Rsh_status'];

    try {
        let tableHTML = '<div class="table-responsive"><table class="records-table">';
        tableHTML += '<thead><tr>';
        for (const key in titleMapping) {
            if (!hiddenColumns.includes(key)) {
                tableHTML += `<th>${titleMapping[key]}</th>`;
            }
        }
        tableHTML += '</tr></thead>';

        tableHTML += '<tbody>';
        for (const record of reshumot) {
            const recordId = record.Rsh_id;
            tableHTML += `<tr class="record-row" data-id="${recordId}" onclick="toggleButtons(this)">`;
            for (const key in titleMapping) {
                if (!hiddenColumns.includes(key)) {
                    if (key === 'Rsh_sapak') {
                        const supplierDetails = await loadSuppliers(record.Rsh_sapak);
                        tableHTML += `<td class="data-cell"><span class="cell-content">${supplierDetails.SP_id || ''}</span></td>`;
                    } else if (key === 'SP_name') {
                        const supplierDetails = await loadSuppliers(record.Rsh_sapak);
                        tableHTML += `<td class="data-cell"><span class="cell-content">${supplierDetails.SP_name || ''}</span></td>`;
                    } else {
                        tableHTML += `<td class="data-cell"><span class="cell-content">${record[key] || ''}</span></td>`;
                    }
                }
            }
            tableHTML += '</tr>';
        }

        tableHTML += '</tbody></table></div>';
        reshumotListDiv.innerHTML = tableHTML;

        // Add click event to document to close any open button overlays when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.record-row') && !e.target.closest('.button-overlay')) {
                document.querySelectorAll('.record-row').forEach(row => {
                    row.classList.remove('blurred', 'active-row');
                    const existingOverlay = row.querySelector('.button-overlay');
                    if (existingOverlay) {
                        existingOverlay.remove();
                    }
                });
            }
        });

    } catch (error) {
        console.error("Error in fillForm:", error);
        reshumotListDiv.innerHTML = '<p>שגיאה בעיבוד הנתונים: ' + error.message + '</p>';
    }
}


    function toggleButtons(row) {
        // Check if this row already has buttons displayed
        const isActive = row.classList.contains('active-row');

        // Reset all rows first
        document.querySelectorAll('.record-row').forEach(r => {
            r.classList.remove('active-row', 'blurred');
            const existingOverlay = r.querySelector('.action-buttons-overlay');
            if (existingOverlay) {
                existingOverlay.remove();
            }
        });

        // If the row wasn't active, make it active and show buttons
        if (!isActive) {
            // Add active class to the row
            row.classList.add('active-row', 'blurred');

            // Create button overlay
            const recordId = row.getAttribute('data-id');
            const buttonOverlay = document.createElement('div');
            buttonOverlay.className = 'action-buttons-overlay';
            buttonOverlay.style.position = 'absolute';
            buttonOverlay.style.top = '0';
            buttonOverlay.style.left = '0';
            buttonOverlay.style.width = '100%';
            buttonOverlay.style.height = '50%';
            buttonOverlay.style.backgroundColor = 'rgba(135, 206, 250, 0.7)'; // Lighter cyan/blue tint
            buttonOverlay.style.display = 'flex';
            buttonOverlay.style.justifyContent = 'center';
            buttonOverlay.style.alignItems = 'center';
            buttonOverlay.style.gap = '15px'; // Space between buttons
            buttonOverlay.style.zIndex = '10';

            // Create edit button with enhanced styling
            const editButton = document.createElement('button');
            editButton.innerHTML = '<i class="fas fa-edit"></i> עריכה';
            editButton.className = 'edit-btn';
            editButton.style.padding = '8px 16px';
            editButton.style.backgroundColor = 'white';
            editButton.style.color = '#3498db';
            editButton.style.border = '2px solid #3498db';
            editButton.style.borderRadius = '5px';
            editButton.style.fontSize = '14px';
            editButton.style.fontWeight = 'bold';
            editButton.style.cursor = 'pointer';
            editButton.style.transition = 'all 0.3s ease';
            editButton.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';

            // Hover effect for edit button
            editButton.onmouseover = function() {
                this.style.backgroundColor = '#3498db';
                this.style.color = 'white';
            };
            editButton.onmouseout = function() {
                this.style.backgroundColor = 'white';
                this.style.color = '#3498db';
            };

            // Add click event for edit button
            editButton.onclick = function(e) {
                e.stopPropagation();
                editRecord(recordId);
            };

            // Create delete button with enhanced styling
            const deleteButton = document.createElement('button');
            deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i> מחיקה';
            deleteButton.className = 'delete-btn';
            deleteButton.style.padding = '8px 16px';
            deleteButton.style.backgroundColor = 'white';
            deleteButton.style.color = '#e74c3c';
            deleteButton.style.border = '2px solid #e74c3c';
            deleteButton.style.borderRadius = '5px';
            deleteButton.style.fontSize = '14px';
            deleteButton.style.fontWeight = 'bold';
            deleteButton.style.cursor = 'pointer';
            deleteButton.style.transition = 'all 0.3s ease';
            deleteButton.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';

            // Hover effect for delete button
            deleteButton.onmouseover = function() {
                this.style.backgroundColor = '#e74c3c';
                this.style.color = 'white';
            };
            deleteButton.onmouseout = function() {
                this.style.backgroundColor = 'white';
                this.style.color = '#e74c3c';
            };

            // Add click event for delete button
            deleteButton.onclick = function(e) {
                e.stopPropagation();
                deleteRecord(recordId);
            };

            // Add buttons to overlay
            buttonOverlay.appendChild(editButton);
            buttonOverlay.appendChild(deleteButton);

            // Add the overlay to the row
            row.style.position = 'relative'; // Ensure the row has position relative for absolute positioning
            row.appendChild(buttonOverlay);
        }
    }

    function editRecord(recordId) {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // הוספת אפקט גלילה חלקה
        });
        const recordRow = document.querySelector(`tr[data-id="${recordId}"]`);

        // שלוף את כל התאים בשורה
        const cells = recordRow.querySelectorAll('.data-cell .cell-content');

        // צור אובייקט record עם המידע מהתאים
        const record = {
            Rsh_id: recordId, // הוסף את ה-ID של ההזמנה
            Rsh_date: cells[0].innerText,
            Rsh_mchlaka: cells[1].innerText,
            Rsh_sapak: cells[2].innerText,
            SP_name: cells[3].innerText,
            Rsh_schoom: cells[4].innerText,
            Rsh_aspaka: cells[5].innerText,
            Rsh_proyktnam: cells[6].innerText,
            Rsh_sochen: cells[7].innerText,
            Rsh_cname: cells[8].innerText,
            Rsh_cnametl: cells[9].innerText,
            Rsh_cemail: cells[10].innerText,
            Rsh_takziv: cells[11].innerText,
        };

        // כאן תוכל להוסיף לוגיקה כדי למלא את הטופס עם המידע שנשלף
        loadRecordToForm(record);
    }

    async function deleteRecord(recordId) {
        const result = await Swal.fire({
            title: 'אישור מחיקה',
            text: 'האם אתה בטוח שברצונך למחוק הזמנה זו?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'כן, מחק את זה!',
            cancelButtonText: 'לא, ביטול'
        });

        if (result.isConfirmed) {
            const res = await deletereshumot(recordId);
            if (res.message === "Record deleted successfully") {
                showNotification('ההזמנה נמחקה בהצלחה');
                getReshumot()
            } else {
                showNotification('שגיאה במחיקת ההזמנה');
            }
        }
    }

    async function loadSuppliers(id) {
        const supplier = await SupplierById(id); // הנחה שהפונקציה מחזירה את הספק
        const supplierSelect = document.getElementById('supplierName');
        supplierSelect.innerHTML = '<option value="" disabled selected>בחר ספק</option>'; // ניקוי אפשרויות קודמות

        // אם יש צורך להוסיף את הספק לרשימה
        if (supplier) {
            const option = document.createElement('option');
            option.value = supplier.SP_name; // הנח כאן את השם של הספק
            option.textContent = supplier.SP_name; // הנח כאן את השם של הספק
            supplierSelect.appendChild(option);
        }

        return supplier; // החזר את האובייקט של הספק
    }
    async function loadRecordToForm(item) {
        document.getElementById('department').value = item.Rsh_mchlaka || '';
        // Fetch suppliers from server
        const supplierIdField = document.getElementById('supplierId');
        await loadAllSuppliers(supplierIdField, item.Rsh_sapak); // קריאה לשרת להביא את הספקים

        if (document.getElementById('supplierName')) {
            document.getElementById('supplierName').value = item.SP_name || '';
        }
        document.getElementById('amount').value = item.Rsh_schoom || '';
        document.getElementById('deliveryPlace').value = item.Rsh_aspaka || '';
        document.getElementById('agentNumber').value = item.Rsh_sochen || '';
        document.getElementById('contactName').value = item.Rsh_cname || '';
        document.getElementById('contactPhone').value = item.Rsh_cnametl || '';
        document.getElementById('contactEmail').value = item.Rsh_cemail || '';
        document.getElementById('projectName').value = item.Rsh_proyktnam || '';
        document.getElementById('budgetItem').value = item.Rsh_takziv || '';

        // Set hidden fields if necessary
        document.getElementById('autoNumber').value = item.Rsh_id || ''; // Assuming Rsh_id is the identifier
        document.getElementById('timestamp').value = item.Rsh_date || ''; // Assuming Rsh_date is the timestamp
        checkFormCompletion();
        RSH_ID = item.Rsh_id;
        loadDocuments(RSH_ID);
    }

    document.getElementById('supplierId').addEventListener('change', async function() {
        const selectedSupplierId = this.value; // קבלת ה-ID של הספק הנבחר
        const supplierData = await SupplierById(selectedSupplierId); // קריאה לפונקציה לקבלת פרטי הספק
        if (supplierData && supplierData.SP_name) {
            document.getElementById('supplierName').value = supplierData.SP_name; // עדכון השם בשדה
        } else {
            showNotification('לא נמצאו פרטי ספק עבור ID:' + selectedSupplierId, error);
        }
    });

    window.addEventListener('beforeunload', function() {
        updateUserLog(localStorage.getItem('userId'), {
            Lg_timestmpiout: new Date().toLocaleString('sv-SE'),
            Lg_status: 0
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        checkPR();
        if (document.referrer.includes("login")) {
            updateUserLog(localStorage.getItem('userId'), {
                Lg_timestmpin: new Date().toLocaleString('sv-SE'),
                Lg_status: 1
            });
        }
    });
async function loadAllSuppliers(supplierIdField, selectedSupplierId) {
    try {
        const suppliers = await getAllSuppliers(); // הנח את ה-URL לפי הצורך

        // ניקוי הסלקטור לפני הוספת ספקים חדשים
        supplierIdField.innerHTML = '<option value="" disabled selected>בחר ספק</option>';

        suppliers.forEach(supplier => {
            const option = document.createElement('option');
            option.value = supplier.SP_id; // שימוש ב-SP_id כערך
            option.text = `${supplier.SP_id} - ${supplier.SP_name}`; // הצגת SP_id ו-SP_name
            supplierIdField.add(option);
        });

        // הגדרת הספק הנבחר
        if (selectedSupplierId) {
            supplierIdField.value = selectedSupplierId;
        }
    } catch (error) {
        console.error('Error loading suppliers:', error);
        showNotification('שגיאה בטעינת ספקים: ' + error.message, 'error');
    }
}


    function checkPR() {
        if (localStorage.getItem('PR') === '2') {
            document.getElementById('conditionalButton').style.display = 'block';
        } else {
            document.getElementById('conditionalButton').style.display = 'none';
        }
    }

    function goToAdmin() {
        window.location.href = '/admin';
    }

    async function loadDocuments(id) {
        isFunctionCalled = true;
        const documentsArea = document.getElementById('documents-area');
        const tbody = document.getElementById('documents-body');
        const table = document.getElementById('documentsTable');
        const messageDiv = document.getElementById('message');

        // Clear previous content
        tbody.innerHTML = '';

        // Handle undefined ID case
        if (id === undefined) {
            documentsArea.classList.add('empty');
            messageDiv.innerHTML = '<i class="fas fa-info-circle"></i> יש לבחור הזמנה על מנת להציג מסמכים';
            messageDiv.style.display = 'block';
            table.style.display = 'none';
            isFunctionCalled = false;
            checkFunctionCall();
            return;
        }
        try {
            // Fetch documents
            const response = await getListMnilvim(id);

            // Check if response has data property and it's an array
            const documents = Array.isArray(response) ? response :
                (response.data && Array.isArray(response.data)) ? response.data : [];

            RSH_ID = id; // Set the global RSH_ID to the current id

            if (documents.length === 0) {
                documentsArea.classList.add('empty');
                messageDiv.innerHTML = '<i class="fas fa-info-circle"></i> אין מסמכים נלווים';
                messageDiv.style.display = 'block';
                table.style.display = 'none';
            } else {
                documentsArea.classList.remove('empty');
                messageDiv.style.display = 'none';
                table.style.display = 'table';
                documents.forEach(doc => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>${doc.MN_pratim}</td>
                    <td>${doc.MN_dateAdd}</td>
                    <td><button onclick="deleteDocument('${doc.MN_id}', event)"><i class="fas fa-trash"></i> מחק</button></td>
                `;
                    row.onclick = () => fetchDocument(doc.MN_location, doc.MN_pratim);
                    tbody.appendChild(row);
                });
            }
        } catch (error) {
            console.error('Error loading documents:', error);
            documentsArea.classList.add('empty');
            messageDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> שגיאה בטעינת המסמכים';
            messageDiv.style.display = 'block';
            table.style.display = 'none';
        }
    }

    async function fetchDocument(url) {
        const httpUrl = url.replace(/^file:\/\//, 'http://localhost/');
        const a = document.createElement('a');
        a.href = httpUrl;
        a.download = ''; // זה יגרום לדפדפן להוריד את הקובץ
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    function checkFunctionCall() {
        if (!isFunctionCalled) {
            const documentsArea = document.getElementById('documents-area');
            const messageDiv = document.getElementById('message');
            const table = document.getElementById('documentsTable');

            documentsArea.classList.add('empty');
            messageDiv.innerHTML = 'יש לבחור הזמנה על מנת להציג מסמכים';
            messageDiv.style.display = 'block';
            table.style.display = 'none';
        }
    }

    async function deleteDocument(id) {
        event.stopPropagation(); // מונע מהאירוע להתפשט ולגרום להורדת המסמך

        const result = await Swal.fire({
            title: 'אישור מחיקה',
            text: 'האם אתה בטוח שברצונך למחוק מסמך זה?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'כן, מחק את זה!',
            cancelButtonText: 'לא, ביטול'
        });

        if (result.isConfirmed) {
            await deleteMnilvim(id);
            Swal.fire('נמחק!', 'המסמך נמחק.', 'success');
            loadDocuments(RSH_ID); // טען מחדש את המסמכים
        }
    }
</script>

<?php
// Include Font Awesome
wp_enqueue_script('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js', array(), null, true);

// הוסף את SweetAlert
wp_enqueue_script('sweetalert-script', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);

// הוסף את ה-script שלך
wp_enqueue_script('function-script', 'https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/function.server.js', array('sweetalert-script'), null, true);



// Include Roboto font
wp_enqueue_style('roboto-font', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
// Include login styles
wp_enqueue_style('login-styles', 'https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/css/worker.style.css');
get_footer();
?>