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
                // This is the updated block that handles the server's response.
                if (data.success) {
                    // Checks if a password change is required. ---
                    // The 'requires_change' key is sent from our updated login.php.
                    if (data.requires_change) {
                        // If true, we immediately redirect the user to the password change page.
                        // This happens for any role (e.g., a new stakeholder or an admin with a temporary password).
                        window.location.href = 'change_password.php';
                    } else {
                        // --- Step 2: If no change is needed, proceed with normal role-based redirection. ---
                        switch (data.role) {
                            case 'student':
                                window.location.href = 'student_dashboard.php';
                                break;
                            case 'lecturer':
                                window.location.href = 'lecturer_dashboard.php'; 
                                break;
                            case 'stakeholder':
                                // A returning stakeholder (who has already changed their password) goes here.
                                window.location.href = 'select_student.php';
                                break;
                            case 'admin':
                                // We can create this page later.
                                window.location.href = 'admin_dashboard.php';
                                break;
                            default:
                                // A fallback for any unknown roles.
                                window.location.href = 'student_dashboard.php';
                        }
                    }
                } else {
                    // This part runs if login failed (e.g., wrong username or password).
                    // We still show the error message from the server.
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