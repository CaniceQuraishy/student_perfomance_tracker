// This script handles the submission of the final password reset form.
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('resetPasswordForm');
    const responseMessage = document.getElementById('responseMessage');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        
        // Basic client-side validation
        if (passwordInput.value.length < 8) {
            responseMessage.textContent = 'Password must be at least 8 characters long.';
            responseMessage.style.color = 'red';
            return;
        }
        if (passwordInput.value !== confirmPasswordInput.value) {
            responseMessage.textContent = 'Passwords do not match.';
            responseMessage.style.color = 'red';
            return;
        }

        const submitBtn = form.querySelector('.login-btn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';

        fetch('api/update_password.php', {
            method: 'POST',
            body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
            responseMessage.textContent = data.message;
            responseMessage.style.color = data.success ? 'green' : 'red';

            if (data.success) {
                // If successful, disable the button permanently to prevent re-submission.
                submitBtn.style.display = 'none'; 
                // We could also redirect to login after a few seconds.
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 3000); // Redirect after 3 seconds
            } else {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Update Password';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            responseMessage.textContent = 'An unexpected network error occurred.';
            responseMessage.style.color = 'red';
            submitBtn.disabled = false;
            submitBtn.textContent = 'Update Password';
});
    });
});