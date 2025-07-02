// This script handles the submission of the forgot password form.
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('requestResetForm');
    const responseMessage = document.getElementById('responseMessage');

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const submitBtn = form.querySelector('.login-btn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';

        fetch('api/request_reset.php', {
            method: 'POST',
            body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
            // Display the message we get back from the server.
            responseMessage.textContent = data.message;
            // Use green for success messages and red for errors.
            responseMessage.style.color = data.success ? 'green' : 'red';
        })
        .catch(error => {
            console.error('Error:', error);
            responseMessage.textContent = 'An unexpected network error occurred.';
            responseMessage.style.color = 'red';
        })
        .finally(() => {
            // Always re-enable the button when the process is done.
            submitBtn.disabled = false;
            submitBtn.textContent = 'Send Reset Link';
        });
    });
});