// Script for signup form validation, now connected to the PHP backend.
document.addEventListener('DOMContentLoaded', () => {

    // All your existing element selections are correct.
    const form = document.getElementById('signupForm');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const submitBtn = document.getElementById('submitBtn'); // Added this to disable the button
    
    // --- Helper functions for UI feedback (These are correct and unchanged) ---
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

    // --- Validation logic for each input field (These are correct and unchanged) ---
    const validateName = () => {
        if (nameInput.value.trim() === '') {
            showError(nameInput, 'Full Name is required.');
            return false;
        }
        hideError(nameInput);
        return true;
    };
    const validateEmail = () => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            showError(emailInput, 'Please enter a valid email address.');
            return false;
        }
        hideError(emailInput);
        return true;
    };
    const validatePassword = () => {
        if (passwordInput.value.length < 8) {
            showError(passwordInput, 'Password must be at least 8 characters long.');
            return false;
        }
        hideError(passwordInput);
        return true;
    };
    const validateConfirmPassword = () => {
        if (confirmPasswordInput.value !== passwordInput.value) {
            showError(confirmPasswordInput, 'Passwords do not match.');
            return false;
        }
        if (confirmPasswordInput.value === '') {
            showError(confirmPasswordInput, 'Please confirm your password.');
            return false;
        }
        hideError(confirmPasswordInput);
        return true;
    };

    // --- Event Listeners (These are correct and unchanged) ---
    nameInput.addEventListener('input', validateName);
    emailInput.addEventListener('input', validateEmail);
    passwordInput.addEventListener('input', () => {
        validatePassword();
        validateConfirmPassword(); 
    });
    confirmPasswordInput.addEventListener('input', validateConfirmPassword);

    // Logic for our custom image icon toggle (This is correct and unchanged)
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

    // --- REPLACED: This is the new, functional form submission handler ---
    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevents the page from reloading.

        // Run all checks one last time before submitting.
        const isFormValid = validateName() && validateEmail() && validatePassword() && validateConfirmPassword();

        if (isFormValid) {
            // Disable the button to prevent multiple submissions.
            submitBtn.disabled = true;
            submitBtn.textContent = 'Creating Account...';

            // Use the Fetch API to send the form data to our PHP script.
            fetch('api/signup.php', {
                method: 'POST',
                body: new FormData(form) // FormData packages the form data for us.
            })
            .then(response => response.json()) // We expect a JSON response from PHP.
            .then(data => {
                // The server has responded with data.
                if (data.success) {
                    // It worked!
                    alert(data.message);
                    // Redirect to the login page after success.
                    window.location.href = 'index.html'; 
                } else {
                    // The server reported an error.
                    alert('Signup Failed: ' + data.message);
                }
            })
            .catch(error => {
                // This catches network issues (e.g., server is down).
                console.error('Submission error:', error);
                alert('An unexpected network error occurred. Please try again.');
            })
            .finally(() => {
                // This code runs whether the fetch succeeded or failed.
                // Re-enable the button so the user can try again if there was an error.
                submitBtn.disabled = false;
                submitBtn.textContent = 'Create Account';
            });
        } else {
            console.log('Form has client-side validation errors. Submission blocked.');
        }
    });
});