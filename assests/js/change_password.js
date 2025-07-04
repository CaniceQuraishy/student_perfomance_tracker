// This script handles the logic for the forced password change page.
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('changePasswordForm');
    const responseMessage = document.getElementById('responseMessage');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const submitBtn = form.querySelector('.login-btn');

    // We can reuse our strong password validation logic here.
    const validatePasswords = () => {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        let errorMessage = '';
        const specialCharRegex = /[!@#$%^&*()_+\-=\[\]{}|]/;

        if (password.length < 8) {
            errorMessage = 'Password must be at least 8 characters long.';
        } else if (!/[A-Z]/.test(password)) {
            errorMessage = 'Password must contain at least one uppercase letter.';
        } else if (!/[a-z]/.test(password)) {
            errorMessage = 'Password must contain at least one lowercase letter.';
        } else if (!/[0-9]/.test(password)) {
            errorMessage = 'Password must contain at least one number.';
        } else if (!specialCharRegex.test(password)) {
            errorMessage = 'Password must contain at least one special character.';
        } else if (password !== confirmPassword && confirmPassword !== '') {
            errorMessage = 'Passwords do not match.';
        }
        
        // Display or hide the error message.
        if (errorMessage) {
            responseMessage.textContent = errorMessage;
            responseMessage.style.color = 'red';
            return false;
        } else {
            responseMessage.textContent = '';
            return true;
        }
    };

    // Add real-time validation listeners.
    passwordInput.addEventListener('input', validatePasswords);
    confirmPasswordInput.addEventListener('input', validatePasswords);


    // Handle the final form submission.
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        // Run the validation one last time.
        if (!validatePasswords() || confirmPasswordInput.value === '') {
            if (confirmPasswordInput.value === '') {
                responseMessage.textContent = 'Please confirm your password.';
                responseMessage.style.color = 'red';
            }
            return; // Stop if validation fails.
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';

        fetch('api/update_user_password.php', {
            method: 'POST',
            body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
            responseMessage.textContent = data.message;
            responseMessage.style.color = data.success ? 'green' : 'red';

            if (data.success) {
                // It worked! Disable the form and redirect after a short delay.
                submitBtn.style.display = 'none'; // Hide the button on success.
                
                // Redirect the user to their correct page after 2 seconds.
                setTimeout(() => {
                    switch (data.role) {
                        case 'student':
                            window.location.href = 'student_dashboard.php';
                            break;
                        case 'stakeholder':
                            window.location.href = 'select_student.php';
                            break;
                        // Add other roles as needed.
                        default:
                            window.location.href = 'index.html'; // Fallback to login.
                    }
                }, 2000);
            } else {
                // Re-enable the button if there was an error.
                submitBtn.disabled = false;
                submitBtn.textContent = 'Set New Password';
            }
        });
    });
});