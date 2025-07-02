// This script handles the stakeholder invite form on the student dashboard.
document.addEventListener('DOMContentLoaded', () => {
    const inviteForm = document.getElementById('inviteForm');
    
    if (inviteForm) {
        const responseMessage = document.getElementById('inviteResponseMessage');

        inviteForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const submitBtn = inviteForm.querySelector('.send-invite-btn');
            const originalBtnText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';

            fetch('api/invite_stakeholder.php', {
                method: 'POST',
                body: new FormData(inviteForm)
            })
            .then(response => response.json())
            .then(data => {
                responseMessage.textContent = data.message;
                responseMessage.style.color = data.success ? 'green' : 'red';
                if(data.success) {
                    inviteForm.reset(); // Clear the form on success.
                }
            })
            .catch(error => {
                console.error('Error:', error);
                responseMessage.textContent = 'An unexpected network error occurred.';
                responseMessage.style.color = 'red';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
            });
        });
    }
});