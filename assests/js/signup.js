// This script handles all client-side validation for the signup form.
document.addEventListener('DOMContentLoaded', () => {

    // Grab all the form elements we'll need to work with.
    const form = document.getElementById('signupForm');
    const nameInput = document.getElementById('name');
    const usernameInput = document.getElementById('username'); 
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
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

    // --- Validation logic for each input field ---

    const validateName = () => {
        if (nameInput.value.trim() === '') {
            showError(nameInput, 'Full Name is required.');
            return false;
        }
        hideError(nameInput);
        return true;
    };
    
    // New validation function for the username field.
    const validateUsername = () => {
        if (usernameInput.value.trim() === '') {
            showError(usernameInput, 'Username (ID) is required.');
            return false;
        }
        // We could add more checks here later, like for length or format.
        hideError(usernameInput);
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

    // --- Event Listeners to provide real-time feedback ---

    nameInput.addEventListener('input', validateName);
    usernameInput.addEventListener('input', validateUsername); // Added listener for the username field
    emailInput.addEventListener('input', validateEmail);
    passwordInput.addEventListener('input', () => {
        validatePassword();
        validateConfirmPassword(); 
    });
    confirmPasswordInput.addEventListener('input', validateConfirmPassword);

    // This handles the show/hide toggle for our password fields.
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

        // Run all validation checks one last time before we send anything to the server.
        const isFormValid = validateName() && validateUsername() && validateEmail() && validatePassword() && validateConfirmPassword();

        if (isFormValid) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Creating Account...';

            // Send the form data to our PHP script.
            fetch('api/signup.php', {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response from the server.
                if (data.success) {
                    alert(data.message);
                    window.location.href = 'index.html'; 
                } else {
                    alert('Signup Failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Submission error:', error);
                alert('An unexpected network error occurred. Please try again.');
            })
            .finally(() => {
                // Re-enable the button, regardless of the outcome.
                submitBtn.disabled = false;
                submitBtn.textContent = 'Create Account';
            });
        } else {
            console.log('Form has client-side validation errors. Submission blocked.');
        }
    });
});