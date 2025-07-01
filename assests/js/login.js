// This script handles all client-side logic for the login form.
document.addEventListener('DOMContentLoaded', () => {

    // Grab all the form elements we need to work with.
    const form = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const submitBtn = document.getElementById('submitBtn');

    // --- Helper functions for showing and hiding validation errors ---

    const showError = (input, message) => {
        const formGroup = input.closest('.form-group');
        const errorElement = formGroup.querySelector('.error-message');
        
        errorElement.innerText = message;
        errorElement.classList.add('visible');
        input.classList.add('invalid');
    };

    const hideError = (input) => {
        const formGroup = input.closest('.form-group');
        const errorElement = formGroup.querySelector('.error-message');

        errorElement.innerText = '';
        errorElement.classList.remove('visible');
        input.classList.remove('invalid');
    };

    // --- Validation logic for each field ---

    const validateUsername = () => {
        if (usernameInput.value.trim() === '') {
            showError(usernameInput, 'Username is required.');
            return false;
        }
        hideError(usernameInput);
        return true;
    };

    const validatePassword = () => {
        if (passwordInput.value === '') {
            showError(passwordInput, 'Password is required.');
            return false;
        }
        hideError(passwordInput);
        return true;
    };

    // --- Event Listeners ---

    // Set up real-time validation.
    usernameInput.addEventListener('input', validateUsername);
    passwordInput.addEventListener('input', validatePassword);

    // This handles the show/hide toggle for the password field.
    form.addEventListener('click', (event) => {
        if (event.target.classList.contains('password-toggle-icon')) {
            const icon = event.target;
            const passwordField = icon.closest('.password-container').querySelector('input');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.src = 'assests/media/eye_closed.png';
            } else {
                passwordField.type = 'password';
                icon.src = 'assests/media/eye.png';
            }
        }
    });

    // --- Final form submission handler ---
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Run checks one last time before submitting.
        const isFormValid = validateUsername() && validatePassword();

        if (isFormValid) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Logging In...';

            // Send the form data to our login.php script.
            fetch('api/login.php', {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response from the server.
                if (data.success) {
                    // --- SUCCESS! Now, we redirect based on the role. ---
                    alert(data.message); // e.g., "Login successful!"

                    // This is the role-based redirection logic.
                    switch (data.role) {
                        case 'student':
                            window.location.href = 'student_dashboard.php';
                            break;
                        case 'lecturer':
                            // We can create this page later.
                            window.location.href = 'lecturer_dashboard.php'; 
                            break;
                        case 'admin':
                             // We can create this page later.
                            window.location.href = 'admin_dashboard.php';
                            break;
                        case 'stakeholder':
                            // We can create this page later.
                            window.location.href = 'stakeholder_dashboard.php';
                            break;
                        default:
                            // If the role is unknown, just go to a default page.
                            window.location.href = 'student_dashboard.php';
                    }

                } else {
                    // The server reported a login error (e.g., wrong password).
                    alert('Login Failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Submission error:', error);
                alert('An unexpected network error occurred. Please try again.');
            })
            .finally(() => {
                // Re-enable the button so the user can try again.
                submitBtn.disabled = false;
                submitBtn.textContent = 'Login';
            });
        } else {
            console.log('Form has client-side validation errors.');
        }
    });
});