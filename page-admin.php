<?php

/**
 * Template Name: HMS Login Page
 */
get_header();
?>

<div class="container">

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
        <button class="btn btn-danger" onclick="logout()"><i class="fas fa-sign-out-alt"></i> יציאה</button>

        <button class="btn" onclick="goToEmployeePage(2)"><i class="fas fa-user"></i> לעמוד עובד</button>
    </div>



    <div class="upload-section">
        <h2><i class="fas fa-filter"></i> סינון הזמנות</h2>
        <div class="filter-area">
            <input type="text" id="supplierFilter" placeholder=" ספק">
            <input type="text" id="agentFilter" placeholder="מספר סוכן">
            <button class="btn btn-secondary" onclick="clearFilters()"><i class="fas fa-eraser"></i> נקה</button>
            <button class="btn" onclick="filterRecords()"><i class="fas fa-search"></i> סנן</button>
        </div>
    </div>


    <div class="upload-section">
        <div class="upload-buttons-container">
            <div class="upload-button-wrapper">
                <button type="button" class="upload-btn" onclick="document.getElementById('recordsFile').click();">
                    <i class="fas fa-file-upload"></i>
                    <span>טעינת הזמנות</span>
                </button>
                <input type="file" id="recordsFile" style="display: none;" accept=".csv, .xls, .xlsx"
                    onchange="loadRecords(event)">
            </div>

            <div class="upload-button-wrapper">
                <button type="button" class="upload-btn" onclick="document.getElementById('Suppliers').click();">
                    <i class="fas fa-users"></i>
                    <span>טעינת ספקים</span>
                </button>
                <input type="file" id="Suppliers" style="display: none;" accept=".csv, .xls, .xlsx"
                    onchange="loadFile(event)">
            </div>
        </div>
    </div>


    <!-- <button onclick="loadFile()">טעון קובץ</button> -->
    <div id="supplierList"></div>

    <div class="card">
        <h2><i class="fas fa-file-alt"></i> הזמנות</h2>
        <div id="listAllReshumot"></div>
    </div>
</div>

<div id="editDialog" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title"> עריכת הזמנה </h2>
            <button type="button" class="close" onclick="closeEditDialog()" aria-label="סגור">&times;</button>
        </div>
        <form id="documentForm">
            <!-- Row 1 -->
            <div class="form-group">
                <label for="editDepartment">מחלקה:</label>
                <input type="text" id="editDepartment" name="department" placeholder="הזן שם מחלקה">
                <div id="error-department" class="error-message" style="color: red;"></div>
            </div>


            <div id="supplierList"></div>

            <div class="form-group">
                <label for="supplierId">מספר הספק:</label>
                <select id="supplierId" name="supplierId">
                    <option value="" disabled selected>בחר ספק</option>
                </select>
                <div id="error-supplierName" class="error-message" style="color: red;"></div>
            </div>


            <div class="form-group">
                <label for="supplierName">שם ספק:</label>
                <input type="text" id="supplierName" name="supplierName" placeholder="בחר ספק" readonly>
                <div id="error-supplierName" class="error-message" style="color: red;"></div>
            </div>


            <div class="form-group">
                <label for="amount">סכום:</label>
                <input type="number" id="amount" name="amount" onchange="calculateVAT()" placeholder="הזן סכום">
                <div id="error-amount" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="deliveryPlace">מקום אספקה:</label>
                <input type="text" id="deliveryPlace" name="deliveryPlace" placeholder="הזן מקום אספקה">
                <div id="error-deliveryPlace" class="error-message" style="color: red;"></div>
            </div>

            <div class="form-group">
                <label for="agentNumber">מס סוכן:</label>
                <input type="text" id="agentNumber" name="agentNumber" placeholder="הזן מספר סוכן">
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
                <button type="button" class="btn-secondary form-action-btn" onclick="closeEditDialog()">
                    <i class="fas fa-times-circle"></i>
                    ביטול
                </button>
                <button type="button" class="btn-primary form-action-btn" onclick="saveData()">
                    <i class="fas fa-save"></i> שמירת נתונים
                </button>
            </div>
        </form>
    </div>
    <input type="file" id="document" style="display: none;" onchange="MnilvimUpload(event)">
    <input type="file" id="Suppliers" style="display: none;" onchange="loadFile(event)">

</div>


<script>
    // Define fetchData function directly in the login page

 
        if (document.referrer.includes("login")) {
            document.addEventListener('DOMContentLoaded', function() {
                updateUserLog(localStorage.getItem('userId'), {
                    Lg_timestmpin: new Date().toLocaleString('sv-SE'),
                    Lg_status: 1
                });
            });
        }

    let inactivityTime = function() {
        let timer;
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onkeypress = resetTimer;

        function resetTimer() {
            clearTimeout(timer);
            timer = setTimeout(logout, 600000); // 10 דקות
        }
    };

    inactivityTime();

    async function getReshumot() {
        try {
            const reshumotListDiv = document.getElementById('listAllReshumot');

            // Check if the div exists
            if (!reshumotListDiv) {
                console.error('listAllReshumot div not found in the DOM');
                return;
            }

            // Show loading indicator
            reshumotListDiv.innerHTML = '<p>טוען נתונים...</p>';

            let reshumot;
            try {
                reshumot = await listReshumot();
				console.log("reshumot", reshumot)
                if (reshumot && Array.isArray(reshumot) && reshumot.length > 0) {
                    // Store the data in a global variable for filtering
                    window.allReshumotData = reshumot;
                    // Display all data initially
                    fillForm(reshumot);
                } else {
                    console.warn('No records returned from API');
                    reshumotListDiv.innerHTML = '<p>אין נתונים להצגה</p>';
                }
            } catch (e) {
                console.error('Error calling listAllReshumot:', e);
                reshumotListDiv.innerHTML = '<p>שגיאה בטעינת נתונים: ' + e.message + '</p>';
            }
        } catch (error) {
            console.error('Error in getReshumot function:', error);
            const reshumotListDiv = document.getElementById('listAllReshumot');
            if (reshumotListDiv) {
                reshumotListDiv.innerHTML = '<p>שגיאה בטעינת נתונים: ' + error.message + '</p>';
            }
        }
    }

    // Separate function for filtering data
    function filterRecords() {
        // Check if we have data to filter
        if (!window.allReshumotData || !Array.isArray(window.allReshumotData)) {
            console.error('No data available for filtering');
            return;
        }

        // Get filter values with null checks
        const supplierFilterEl = document.getElementById('supplierFilter');
        const agentFilterEl = document.getElementById('agentFilter');

        const supplierName = supplierFilterEl ? supplierFilterEl.value.trim() : '';
        const agentName = agentFilterEl ? agentFilterEl.value.trim() : '';

        // Check if any filter is applied
        const hasFilters = supplierName !== '' || agentName !== '';

        if (!hasFilters) {
            // If no filters, show all data
            fillForm(window.allReshumotData);
            return;
        }

        // Apply filters
        const filteredData = window.allReshumotData.filter(record => {
            // Check supplier filter
            if (supplierName && !(record.Rsh_sapak && record.Rsh_sapak.toLowerCase().includes(supplierName.toLowerCase()))) {
                return false;
            }

            // Check agent name filter
            if (agentName && !(record.Rsh_sochen && record.Rsh_sochen.toLowerCase().includes(agentName.toLowerCase()))) {
                return false;
            }

            // If we get here, the record passed all filters
            return true;
        });

        // Display filtered data
        fillForm(filteredData);

        // Show message if no results
        if (filteredData.length === 0) {
            const reshumotListDiv = document.getElementById('listAllReshumot');
            reshumotListDiv.innerHTML = '<p class="no-results">אין תוצאות מתאימות לחיפוש שלך</p>';
        }
    }

    function clearFilters() {
        // Reset filter input values
        const supplierFilterEl = document.getElementById('supplierFilter');
        const agentFilterEl = document.getElementById('agentFilter');

        if (supplierFilterEl) supplierFilterEl.value = '';
        if (agentFilterEl) agentFilterEl.value = '';

        // Check if we have data to display
        if (window.allReshumotData && Array.isArray(window.allReshumotData)) {
            // Display all records by calling fillForm with the complete dataset
            fillForm(window.allReshumotData);
        } else {
            // If no data is available, refresh from the server
            getReshumot();
        }

    }

    function goToEmployeePage(variable) {
        localStorage.setItem('PR', variable);
        window.location.href = "<?php echo site_url('/worker'); ?>";
    }

    function logout() {
        updateUserLog(localStorage.getItem('userId'), {
            Lg_timestmpiout: new Date().toLocaleString('sv-SE'),
            Lg_status: 0
        });
        showNotification("מתנתק מהמערכת...");
        window.location.href = "<?php echo site_url('/login'); ?>"; // הפניה לדף התחברות
    }

    let selectedRow = null; // משתנה לשמור על השורה הנבחרת

    function handleRowClick(row) {
        const recordId = row.getAttribute('data-id');

        // If the same row is clicked again, just toggle the accordion
        if (selectedRow === row) {
            toggleAccordion(row);
            return;
        }

        // If there's a previously selected row, remove its action buttons and close its accordion
        if (selectedRow) {
            const previousButtons = selectedRow.querySelector('.action-buttons-overlay');
            if (previousButtons) previousButtons.remove();
            toggleAccordion(selectedRow, 'close'); // Force close the previous accordion
        }

        // Update the selected row reference
        selectedRow = row;

        // Add action buttons without highlighting the row
        addActionButtons(row, recordId);

        // Open the accordion for this row
        toggleAccordion(row, 'open');
    }

    function addActionButtons(row, recordId) {
        // Remove any existing action buttons
        const existingButtons = row.querySelector('.action-buttons-overlay');
        if (existingButtons) existingButtons.remove();

        // Create action buttons overlay
        const actionButtonsOverlay = document.createElement('div');
        actionButtonsOverlay.className = 'action-buttons-overlay';
        actionButtonsOverlay.innerHTML = `
                <button class="btn btn-primary btn-sm" onclick="editRecord('${recordId}'); event.stopPropagation();"><i class="fas fa-edit"></i> עריכה</button>
                <button class="btn btn-danger btn-sm" onclick="deleteRecord('${recordId}'); event.stopPropagation();"><i class="fas fa-trash-alt"></i> מחיקה</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('document').click(); event.stopPropagation();">
                    <i class="fas fa-file-upload"></i> הוספת מסמכים נילווים
                </button>
            `;
        row.appendChild(actionButtonsOverlay);
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
        'Rsh_sapak': 'ספק ',
        'SP_name': 'פרטי ספק',
        'Rsh_schoom': 'סכום',
        'Rsh_aspaka': 'מקום אספקה',
        'Rsh_proyktnam': 'שם פרויקט',
        'Rsh_sochen': 'סוכן',
        'Rsh_cname': 'שם סוכן',
        'Rsh_cnametl': 'טלפון סוכן',
        'Rsh_cemail': 'מייל סוכן',
        'Rsh_takziv': 'מספר סעיף תקציבי',
        'Rsh_orderer': 'שם המזמין' 
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

            tableHTML += `<tr class="record-row" data-id="${recordId}" onclick="handleRowClick(this)">`;
            for (const key in titleMapping) {
                if (!hiddenColumns.includes(key)) {
                    if (key === 'Rsh_sapak') {
                        const supplierDetails = await loadSuppliers(record.Rsh_sapak); // טען את פרטי הספק
                        tableHTML += `<td class="data-cell"><span class="cell-content">${supplierDetails.SP_id || ''}</span></td>`;
                    } else if (key === 'SP_name') {
                        const supplierDetails = await loadSuppliers(record.Rsh_sapak); // טען את פרטי הספק
                        tableHTML += `<td class="data-cell"><span class="cell-content">${supplierDetails.SP_name || ''}</span></td>`;
                    } else {
                        tableHTML += `<td class="data-cell"><span class="cell-content">${record[key] || ''}</span></td>`;
                    }
                }
            }
            tableHTML += '</tr>';

            // Add accordion row for each record
            tableHTML += `<tr id="accordion-${recordId}" class="accordion-row" style="display: none;">
            <td colspan="${Object.keys(titleMapping).length - hiddenColumns.length}">
                <div id="details-${recordId}" class="accordion-content">
                    <p>טוען מסמכים נילווים...</p>
                </div>
            </td>
        </tr>`;
        }

        tableHTML += '</tbody></table></div>';
        reshumotListDiv.innerHTML = tableHTML;

    } catch (error) {
        console.error("Error in fillForm:", error);
        reshumotListDiv.innerHTML = '<p>שגיאה בעיבוד הנתונים: ' + error.message + '</p>';
    }
}


    // Modified toggleAccordion function to support forced open/close and load accompanying documents
    function toggleAccordion(row, forceState) {
        const recordId = row.getAttribute('data-id');
        document.getElementById('autoNumber').value = recordId;

        const accordionRow = document.getElementById(`accordion-${recordId}`);

        if (!accordionRow) {
            console.error(`Accordion row not found for record ID: ${recordId}`);
            return;
        }

        if (forceState === 'open') {
            accordionRow.style.display = "table-row";
            // Load the accompanying documents
            viewMnilvim(recordId).then(details => {
                const detailsElement = document.getElementById(`details-${recordId}`);
                if (detailsElement) {
                    detailsElement.innerHTML = details;
                }
            }).catch(error => {
                console.error(`Error loading documents for record ${recordId}:`, error);
                const detailsElement = document.getElementById(`details-${recordId}`);
                if (detailsElement) {
                    detailsElement.innerHTML = '<p>שגיאה בטעינת מסמכים נילווים</p>';
                }
            });
        } else if (forceState === 'close') {
            accordionRow.style.display = "none";
        } else {
            // Toggle as before
            const newDisplay = accordionRow.style.display === "none" ? "table-row" : "none";
            accordionRow.style.display = newDisplay;

            // If opening, load the documents
            if (newDisplay === "table-row") {
                viewMnilvim(recordId).then(details => {
                    const detailsElement = document.getElementById(`details-${recordId}`);
                    if (detailsElement) {
                        detailsElement.innerHTML = details;
                    }
                }).catch(error => {
                    console.error(`Error loading documents for record ${recordId}:`, error);
                    const detailsElement = document.getElementById(`details-${recordId}`);
                    if (detailsElement) {
                        detailsElement.innerHTML = '<p>שגיאה בטעינת מסמכים נילווים</p>';
                    }
                });
            }
        }
    }


    // Replace toggleActions with selectRow
    function selectRow(row) {
        const recordId = row.getAttribute('data-id');
        // Update the ID of the selected record
        document.getElementById('autoNumber').value = recordId;

        // Add action buttons without highlighting
        addActionButtons(row, recordId);


    }

    async function editRecord(recordId) {
        try {
            // Retrieve the selected record data
            const selectedRow = document.querySelector(`tr[data-id="${recordId}"]`);

            if (!selectedRow) {
                console.error('Selected row not found for ID:', recordId);
                showNotification('שגיאה: לא ניתן למצוא את השורה הנבחרת', 'error');
                return;
            }

            // Get all data cells in the row
            const cells = selectedRow.querySelectorAll('td.data-cell');

            // Check if we have enough cells
            if (cells.length < 12) {
                console.error('Not enough cells in the selected row:', cells.length);
                showNotification(' מבנה הטבלה אינו תקין', 'error');
                return;
            }

            // Create record object safely by checking each cell before accessing
            const record = {
                Rsh_mchlaka: (cells[1] ? cells[1].innerText.trim() : ''),
                Rsh_sapak: (cells[2] ? cells[2].innerText.trim() : ''),
                SP_name: (cells[3] ? cells[3].innerText.trim() : ''),
                Rsh_schoom: (cells[4] ? cells[4].innerText.trim() : ''),
                Rsh_aspaka: (cells[5] ? cells[5].innerText.trim() : ''),
                Rsh_proyktnam: (cells[6] ? cells[6].innerText.trim() : ''),
                Rsh_sochen: (cells[7] ? cells[7].innerText.trim() : ''),
                Rsh_cname: (cells[8] ? cells[8].innerText.trim() : ''),
                Rsh_cnametl: (cells[9] ? cells[9].innerText.trim() : ''),
                Rsh_cemail: (cells[10] ? cells[10].innerText.trim() : ''),
                Rsh_takziv: (cells[11] ? cells[11].innerText.trim() : ''),
            };

            // Set form values safely with null checks
            if (document.getElementById('editDepartment')) {
                document.getElementById('editDepartment').value = record.Rsh_mchlaka || '';
            }

            // Fetch suppliers from server
            const supplierIdField = document.getElementById('supplierId');
            await loadAllSuppliers(supplierIdField, record.Rsh_sapak); // קריאה לשרת להביא את הספקים

            if (document.getElementById('supplierName')) {
                document.getElementById('supplierName').value = record.SP_name || '';
            }
            if (document.getElementById('amount')) {
                document.getElementById('amount').value = record.Rsh_schoom || '';
            }
            if (document.getElementById('deliveryPlace')) {
                document.getElementById('deliveryPlace').value = record.Rsh_aspaka || '';
            }
            if (document.getElementById('projectName')) {
                document.getElementById('projectName').value = record.Rsh_proyktnam || '';
            }
            if (document.getElementById('agentNumber')) {
                document.getElementById('agentNumber').value = record.Rsh_sochen || '';
            }
            if (document.getElementById('contactEmail')) {
                document.getElementById('contactEmail').value = record.Rsh_cemail || '';
            }
            if (document.getElementById('contactName')) {
                document.getElementById('contactName').value = record.Rsh_cname || '';
            }
            if (document.getElementById('contactPhone')) {
                document.getElementById('contactPhone').value = record.Rsh_cnametl || '';
            }
            if (document.getElementById('budgetItem')) {
                document.getElementById('budgetItem').value = record.Rsh_takziv || '';
            }

            // Show the edit dialog
            const modal = document.getElementById("editDialog");
            modal.style.display = "block";
        } catch (error) {
            console.error('Error in editRecord:', error);
            showNotification('שגיאה בעריכת הרשומה: ' + error.message, 'error');
        }
    }

    // פונקציה לטעינת ספקים מהשרת
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




    // Function to close the edit dialog
    function closeEditDialog() {
        document.getElementById("editDialog").style.display = "none";
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
            const res = await deleteReshumot(recordId);
            if (res.message === "Record deleted successfully") {
                showNotification('ההזמנה נמחקה בהצלחה');
                getReshumot()
            } else {
                showNotification('שגיאה במחיקת ההזמנה', 'error');
            }
        }
    }
async function saveData() {
    const recordId = document.getElementById('autoNumber').value;

    if (!recordId) {
        console.error("recordId is not found or is empty");
        return; // טיפול בשגיאה אם ה-ID לא נמצא
    }

    // Fetch all records to check if the record already exists
    const records = await listReshumot();

    const existingRecord = records.find(record => record.Rsh_id === recordId);
    const selectedRow = document.querySelector(`tr[data-id="${recordId}"]`);
    const cells = selectedRow.querySelectorAll('td.data-cell');

    const data = {
        Rsh_date: document.getElementById('timestamp').value,
        Rsh_mchlaka: document.getElementById('editDepartment').value,
        Rsh_sapak: document.getElementById('supplierId').value,
        Rsh_schoom: document.getElementById('amount').value,
        Rsh_aspaka: document.getElementById('deliveryPlace').value,
        Rsh_proyktnam: document.getElementById('projectName').value,
        Rsh_email: document.getElementById('contactEmail').value,
        Rsh_sochen: document.getElementById('agentNumber').value,
        Rsh_takziv: document.getElementById('budgetItem').value,
        Rsh_cname: document.getElementById('contactName').value,
        Rsh_cnametl: document.getElementById('contactPhone').value || '',
        Rsh_cemail: document.getElementById('contactEmail').value,
        Rsh_orderer: cells[11].innerText.trim() // הנחה שהשדה הזה נמצא בעמודה המתאימה
    };

    try {
        data.Rsh_date = new Date().toLocaleString('sv-SE');
        const response = await updateReshumot(data, recordId);
        if (response.message === "Reshumot updated successfully") {
            showNotification('הזמנה עודכנה בהצלחה!', 'success');
            getReshumot();
        } else {
            showNotification('שגיאה בעדכון ההזמנה', 'error');
        }
        closeEditDialog();
    } catch (error) {
        console.error('Error updating record:', error);
        showNotification('שגיאה בעדכון ההזמנה: ' + error.message, 'error');
    }
}




    function showNotification(message, type = 'success', duration = 3000) {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => {
            notification.remove();
        });

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;

        // Set icon based on notification type
        let icon = '';
        switch (type) {
            case 'success':
                icon = 'fa-check-circle';
                break;
            case 'error':
                icon = 'fa-exclamation-circle';
                break;
            case 'info':
                icon = 'fa-info-circle';
                break;
            case 'warning':
                icon = 'fa-exclamation-triangle';
                break;
        }

        // Create notification content
        notification.innerHTML = `
                <i class="fas ${icon}"></i>
                <span class="message">${message}</span>
                <button class="close-notification" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

        // Add to DOM
        document.body.appendChild(notification);

        // Auto-remove after duration
        if (duration > 0) {
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.classList.add('fade-out');
                    setTimeout(() => notification.remove(), 500);
                }
            }, duration);
        }
    }

async function viewMnilvim(id) {
    try {
        const data = await getListMnilvim(id); // קבל את המידע

        // אם יש מינלווים, הצג את המידע
        if (Array.isArray(data) && data.length > 0) {
            return data.map(mnilvim => `
                <div 
				 
                    onclick="fetchDocument('${mnilvim.MN_location}')" 
                    style="cursor: pointer; position: relative;"
                    onmouseover="showDownloadHint(this)" 
                    onmouseout="hideDownloadHint(this)"
                >
                    <h4>פרטי מסמך ${mnilvim.MN_id}</h4>
                    <p>תאריך הוספה: ${mnilvim.MN_dateAdd}</p>
                    <p>מיקום: ${mnilvim.MN_location}</p>
                    <p>פרטים: ${mnilvim.MN_pratim}</p>
                    <p>שימוש: ${mnilvim.MN_shyooch}</p>
                    <p>סטטוס: ${mnilvim.MN_status}</p>
                    <p>סוג: ${mnilvim.MN_type}</p>
                  
                </div>
            `).join(''); // חבר את כל המידע למחרוזת אחת
        } else {
            // במידה ואין מינלווים, הצג הודעת שגיאה באקורדיון
            return `
                <div class="accordion">
                    <h4>אין מסמכים נלווים</h4>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error fetching mnilvim details:', error);
        // במידה ויש שגיאה, הצג הודעה באקורדיון
        return `
            <div class="accordion">
                <h4>אין מסמכים נלווים</h4>
            </div>
        `;
    }
}


function MnilvimUpload(event) {
    event.preventDefault(); // למנוע את שליחת הטופס הרגילה
        const recordId = document.getElementById('autoNumber').value;
    const fileInput = document.getElementById('document');
    const formData = new FormData();
debugger; // להפסיק את הביצוע כאן ולפתוח את כלי המפתחים

    // הוסף את המידע הנוסף
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const lastDotIndex = file.name.lastIndexOf('.');
        const fileNameWithoutExtension = lastDotIndex !== -1 ? file.name.substring(0, lastDotIndex) : file.name;
        
        formData.append('MN_pratim', fileNameWithoutExtension);
        formData.append('MN_shyooch', recordId); // לדוגמה, RSH_ID
        formData.append('MN_status', 1); // סטטוס
        formData.append('MN_dateAdd', new Date().toISOString().split('T')[0]); // תאריך של היום
        formData.append('MN_type', file.type); // סוג הקובץ
        formData.append('document', file); // הוספת הקובץ עצמו
    }
	console.log("formData" , formData)
	debugger;
	for (var pair of formData.entries()) {
    console.log(pair[0] + ', ' + pair[1]);
}

    loadMnilvim(formData)
        .then(response => {
                           if (response.message === "Mnilvim created successfully") {
                    // הנח את ההודעה כאן אם ההוספה הצליחה
                    showNotification("הקובץ נוסף בהצלחה!");

                    // עדכון מיידי של רשימת המסמכים הנלווים להזמנה הספציפית
                    viewMnilvim(recordId).then(details => {
                        const detailsElement = document.getElementById(`details-${recordId}`);
                        if (detailsElement) {
                            detailsElement.innerHTML = details;

                            // פתח את האקורדיון אם הוא סגור
                            const accordionRow = document.getElementById(`accordion-${recordId}`);
                            if (accordionRow && accordionRow.style.display === "none") {
                                accordionRow.style.display = "table-row";
                            }
                        }
                    });

                    // נקה את שדה הקובץ
                    fileInput.value = '';
                }
	

        })
        .catch(error => {
            showNotification("אירעה שגיאה בהוספת הקובץ: " + error.message);
        });
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

    function loadFile(event) {
        const fileInput = event.target; // קבלת שדה הקלט מתוך האירוע
        const file = fileInput.files[0];

        if (!file) {
            showNotification('אנא בחר קובץ.');
            return;
        }

        const fileExtension = file.name.split('.').pop().toLowerCase();


        if (fileExtension === 'xls' || fileExtension === 'xlsx') {
            loadExcel(file);
        } else {
            showNotification('פורמט קובץ לא נתמך. אנא בחר קובץ   Excel.', 'error');
        }
    }



    function loadExcel(file) {
        const reader = new FileReader();
        reader.onload = async function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {
                type: 'array'
            });
            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const jsonData = XLSX.utils.sheet_to_json(firstSheet, {
                header: 1
            });

            // הנחה שהשמות נמצאים בעמודה הראשונה וקוד הספק בעמודה השנייה, מתחילים מהשורה השנייה
            const suppliers = jsonData.slice(1).map(row => ({
                SP_id: row[0], // קוד ספק
                SP_name: row[1] // שם ספק
            })).filter(supplier => supplier.SP_id && supplier.SP_name); // מסנן ספקים ללא קוד או שם

            try {
                const response = await createSupplier(suppliers);

				debugger;
                // שלח את כל הספקים ל-createSuppliers
                if (response.message != 'error') {
                    loadSuppliers(); // עדכן את רשימת הספקים כאן
                    showNotification('הספקים נוספו בהצלחה!');
                } else {
                    showNotification('נכשלה יצירת הספקים: ' + "קוד קיים במערכת", 'error');
                }
            } catch (error) {
                showNotification('שגיאה ביצירת ספקים: ', 'error');
            }
        };
        reader.readAsArrayBuffer(file);
    }

    document.getElementById('supplierId').addEventListener('change', async function() {
        const selectedSupplierId = this.value; // קבלת ה-ID של הספק הנבחר
        const supplierData = await SupplierById(selectedSupplierId); // קריאה לפונקציה לקבלת פרטי הספק

        if (supplierData && supplierData.SP_name) {
            document.getElementById('supplierName').value = supplierData.SP_name; // עדכון השם בשדה
        } else {
            console.error('לא נמצאו פרטי ספק עבור ID:', selectedSupplierId);
        }
    });


    // טעינת הזמנות:
    async function loadRecords(event) {
        const file = event.target.files[0];
        if (!file) {
            console.error('No file selected');
            return;
        }


        const reader = new FileReader();
        reader.onload = async function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {
                type: 'array'
            });
            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const jsonData = XLSX.utils.sheet_to_json(firstSheet, {
                header: 1
            });
			const orderer = localStorage.getItem('EU_Name');
            const records = jsonData.slice(1).map(row => {
                const record = {
                    Rsh_id: "AUTO-2943", // שינוי ל-ID ייחודי
                    Rsh_date: new Date().toLocaleString('sv-SE'),
                    Rsh_mchlaka: row[2],
                    Rsh_sapak: row[3],
                    Rsh_schoom: parseFloat(row[4]),
                    Rsh_aspaka: row[5],
                    Rsh_proyktnam: row[10],
                    Rsh_sochen: row[6],
                    Rsh_takziv: row[11],
                    Rsh_cname: row[7],
                    Rsh_cnametl: row[8],
                    Rsh_cemail: row[9],
					Rsh_orderer : orderer
                };    
				console.log("record" , record)
                return record;
            });
            // בדוק אם כל הערכים מלאים
            for (const record of records) {
                const hasEmptyValues = Object.values(record).some(value => value === null || value === undefined || value === '');
                if (hasEmptyValues) {
                    showNotification('חסר ערכים', 'error');
                    continue; // עבור לרשומה הבאה אם יש ערך חסר
                }
                // שלח את כל ההזמנות לשרת אחת אחת
                try {
                    const response = await createReshumot(record); // שלח את האובייקט לשרת
                    if (response.message === "Reshumot created successfully") {
                        showNotification('ההזמנות נוספו בהצלחה!');
                        getReshumot();
                    } else {
                        console.error('Failed to create record:', response);
                        showNotification('שגיאה בהוספת ההזמנות', 'error');
                    }
                } catch (error) {
                    console.error('Error creating record:', error);
                    showNotification('שגיאה בהוספת ההזמנות: ' + error.message);
                }
            }
        };
        reader.readAsArrayBuffer(file);
    }


    document.addEventListener('DOMContentLoaded', function() {
        getReshumot();
    });
</script>

<?php
// Include Font Awesome
wp_enqueue_script('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js', array(), null, true);

// הוסף את SweetAlert
wp_enqueue_script('sweetalert-script', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);

// Include different scripts with unique names
wp_enqueue_script('function-script', 'https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/function.server.js', array(), null, true);



// Include Roboto font
wp_enqueue_style('roboto-font', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
// Include login styles
wp_enqueue_style('login-styles', 'https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/css/admin.style.css');
get_footer();
?>