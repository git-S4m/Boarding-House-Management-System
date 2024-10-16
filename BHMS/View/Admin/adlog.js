document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission
    login(); // Call your login function
});

function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

function login() {
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const errorMessage = document.getElementById('error-message');

    // Clear previous error message
    errorMessage.style.display = 'none';

    // Validate inputs
    if (usernameInput.value.trim() === "" || passwordInput.value.trim() === "") {
        errorMessage.textContent = "Please fill in both the username and password.";
        errorMessage.style.display = 'block'; // Show error message
        return;
    }

    // Create an AJAX request to check the password
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../../control/admin_login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === "error") {
                // Show the error message if the password is incorrect
                errorMessage.textContent = response.message; // Display specific error message
                errorMessage.style.display = 'block'; // Show error message
            } else {
                // Password is correct, handle success
                window.location.href = "admin_dashboard.php"; // Redirect to tenant dashboard
            }
        }
    };

    // Send the username and password to the server
    xhr.send("username=" + encodeURIComponent(usernameInput.value) + "&password=" + encodeURIComponent(passwordInput.value));
}
