

const listReshumot = async () => {
    try {
        const scriptText = await (await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/reshumot.server.js')).text();
        eval(scriptText);
        return typeof listAllReshumot === 'function' ? listAllReshumot() : (console.error('listAllReshumot לא זמינה'), null);
    } catch (error) {
        console.error('שגיאה בטעינת הסקריפט:', error);
        return null;
    }
};

window.listReshumot = listReshumot;

const saveReshumot = async (data, id) => {
    try {
        const scriptText = await (await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/reshumot.server.js')).text();
        eval(scriptText);
        return typeof updateReshumot === 'function' ? updateReshumot(data, id) : (console.error('updateReshumot לא זמינה'), null);
    } catch (error) {
        console.error('שגיאה בטעינת הסקריפט:', error);
        return null;
    }
};

window.saveReshumot = saveReshumot;

const deletereshumot = async (data) => {
    try {
        const response = await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/reshumot.server.js');
        
        if (!response.ok) {
            console.error('שגיאה בטעינת הסקריפט: ', response.statusText);
            return null;
        }

        const scriptText = await response.text();

        eval(scriptText);

        if (typeof deleteReshumot === 'function') {
			debugger
            return deleteReshumot(data);
        } else {
            console.error('deleteReshumot לא זמינה');
            return null;
        }
    } catch (error) {
        console.error('שגיאה בטעינת הסקריפט:', error);
        return null;
    }
};


window.deletereshumot = deletereshumot;

const createReshumot = async (data) => {
    try {
        const scriptText = await (await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/reshumot.server.js')).text();
        eval(scriptText);
        return typeof createReshumot === 'function' ? createReshumot(data) : (console.error('createReshumot לא זמינה'), null);
    } catch (error) {
        console.error('שגיאה בטעינת הסקריפט:', error);
        return null;
    }
};
window.createReshumot = createReshumot;

const listSuppliers = async () => {
    try {
        const scriptText = await (await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/supplier.server.js')).text();
        eval(scriptText);
        return typeof getAllSuppliers === 'function' ? getAllSuppliers() : (console.error('getAllSuppliers לא זמינה'), null);
    } catch (error) {
        console.error('שגיאה בטעינת הסקריפט:', error);
        return null;
    }
};

window.listSuppliers = listSuppliers;

const SupplierById = async (id) => {
    try {
        const scriptText = await (await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/supplier.server.js')).text();
        eval(scriptText);
        return typeof getSupplierById === 'function' ? getSupplierById(id) : (console.error('getSupplierById לא זמינה'), null);
    } catch (error) {
        console.error('שגיאה בטעינת הסקריפט:', error);
        return null;
    }
};


window.SupplierById = SupplierById;

const createSupplier = async (supplier) => {
    try {
        const scriptText = await (await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/supplier.server.js')).text();
        eval(scriptText);
        return typeof createSupplier === 'function' ? createSupplier(supplier) : (console.error('createSupplier לא זמינה'), null);
    } catch (error) {
        console.error('שגיאה בטעינת הסקריפט:', error);
        return null;
    }
};


window.createSupplier = createSupplier;


const loadMnilvim = async (doc) => {
	    console.log("doc" + doc)

	debugger;
    try {
        const scriptText = await (await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/mnilvim.server.js')).text();
        eval(scriptText);
        return typeof addMnilvim === 'function' ? addMnilvim(doc) : (console.error('addMnilvim לא זמינה'), null);
    } catch (error) {
        console.error('שגיאה בטעינת הסקריפט:', error);
        return null;
    }
};

window.loadMnilvim = loadMnilvim;

const getListMnilvim = async (id) => {
    try {
        const scriptText = await (await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/mnilvim.server.js')).text();
        eval(scriptText);
        return typeof listMnilvim  === 'function' ? listMnilvim (id) : (console.error('listMnilvim  לא זמינה'), null);
    } catch (error) {
        console.error('שגיאה בטעינת הסקריפט:', error);
        return null;
    }
};

window.getListMnilvim = getListMnilvim;

const updateUserLog = async (id, userData) => {
    try {
        const scriptText = await (await fetch('https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/userLog.server.js')).text();
        eval(scriptText);
        return typeof updateUser   === 'function' ? updateUser(id, userData): (console.error('updateUser  לא זמינה'), null);
    } catch (error) {
        console.error('שגיאה בטעינת הסקריפט:', error);
        return null;
    }
};

window.updateUserLog = updateUserLog;
