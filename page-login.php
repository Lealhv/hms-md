<?php
/**
 * Template Name: HMS Login Page
 */
get_header();
?>

<div class="hms-login-container">
    <div class="login-container">
        <div class="logo-container">
            <img src="https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/images/logo.jpg" alt="רגעים">
        </div>
        <h2>ברוכים הבאים</h2>
        <div id="error-message" class="error-message"></div>

        <div class="input-group">
            <input type="text" id="username" placeholder="שם משתמש" required>
            <i class="fas fa-user"></i>
        </div>

        <div class="input-group">
            <input type="password" id="password" placeholder="סיסמה" required>
            <i class="fas fa-lock"></i>
        </div>

        <div class="input-group">
            <input type="text" id="code" placeholder="קוד אימות" required>
            <i class="fas fa-key"></i>
        </div>

        <button class="btn-primary" onclick="login()">
            כניסה
        </button>

        <div class="button-group">
            <button class="btn-secondary" onclick="clearFields()">
                <i class="fas fa-redo"></i> ניקוי
            </button>
            <button class="btn-danger" onclick="exit()">
                <i class="fas fa-times"></i> יציאה
            </button>
        </div>
    </div>
</div>

<script>

let attempts = 0;
let verificationCode = "";

async function login() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const code = document.getElementById("code").value;
    const errorElement = document.getElementById("error-message");

    try {
        const validUser = await fetchData(password);

        if (username === validUser.EU_Name && parseInt(password) === validUser.EU_PW) {
            if (attempts < 6) {
                if (verificationCode === "") {
                    verificationCode = Math.floor(100000 + Math.random() * 900000).toString();
                    alert(`קוד האימות נשלח: ${verificationCode}`);
                    attempts++;
                } else {
                    if (code === verificationCode) {
                 if (validUser.EU_PR == 1) {
    localStorage.setItem('userId', validUser.EU_ID);
    localStorage.setItem('EU_Name', validUser.EU_Name); // שמירה של שם המשתמש
    localStorage.setItem('PR', 1);
    window.location.href = "<?php echo site_url('/worker'); ?>";
} else {
    localStorage.setItem('userId', validUser.EU_ID);
    localStorage.setItem('EU_Name', validUser.EU_Name); // שמירה של שם המשתמש
    localStorage.setItem('PR', 2);
    window.location.href = "<?php echo site_url('/admin'); ?>";
}

                    } else {
                        errorElement.innerText = "קוד אימות לא תקין. קוד חדש נשלח.";
                        errorElement.classList.add("active");
                        verificationCode = Math.floor(100000 + Math.random() * 900000).toString();
                        alert(`קוד אימות חדש נשלח: ${verificationCode}`);
                    }
                }
            } else {
                errorElement.innerText = "יותר מדי ניסיונות. אנא המתן 10 דקות.";
                errorElement.classList.add("active");
            }
        } else {
            errorElement.innerText = "שם משתמש או סיסמה לא תקינים.";
            errorElement.classList.add("active");
        }
    } catch (error) {
        console.error('שגיאה במהלך הכניסה:', error);
        errorElement.innerText = "אירעה שגיאה במהלך הכניסה. אנא נסה שוב.";
        errorElement.classList.add("active");
    }
}

function clearFields() {
    document.getElementById("username").value = "";
    document.getElementById("password").value = "";
    document.getElementById("code").value = "";
    document.getElementById("error-message").innerText = "";
    document.getElementById("error-message").classList.remove("active");
    verificationCode = ""; // Reset verification code
    attempts = 0; // Reset attempts
}

function exit() {
    window.location.href = "<?php echo site_url(); ?>";
}
</script>

<?php
// Include Font Awesome
wp_enqueue_script('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js', array(), null, true);
wp_enqueue_script('function-script', 'https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/js/EndUser.server.js', array(), null, true);
// Include Roboto font
wp_enqueue_style('roboto-font', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
// Include login styles
wp_enqueue_style('login-styles', 'https://hms-md.co.il/wp-content/themes/twentytwentyfour-child/hms-md/css/login.style.css');
get_footer();
?> 