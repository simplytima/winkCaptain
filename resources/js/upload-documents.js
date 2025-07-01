
document.addEventListener('DOMContentLoaded', function () {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-tab-target');
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('block');
            });
            // Show selected tab content
            document.querySelector(targetId).classList.remove('hidden');
            document.querySelector(targetId).classList.add('block');
            
            // Update tab button styles
            tabButtons.forEach(btn => {
                btn.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
                btn.classList.add('text-gray-500');
            });
            button.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
            button.classList.remove('text-gray-500');
        });
    });

    // Form validation and button state management
    function updateButtonState(tabId) {
        const tab = document.getElementById(tabId);
        const requiredInputs = tab.querySelectorAll('input[required], select[required]');
        const nextButton = tab.querySelector('.next-tab-btn');

        let allFilled = true;
        requiredInputs.forEach(input => {
            if (input.value === '' || (input.type === 'file' && !input.files.length)) {
                allFilled = false;
            }
        });

        if (nextButton) {
            nextButton.disabled = !allFilled;
        }
    }

    // Add event listeners for all required inputs
    document.querySelectorAll('.tab-content').forEach(tab => {
        const requiredInputs = tab.querySelectorAll('input[required], select[required]');
        const tabId = tab.id;

        requiredInputs.forEach(input => {
            input.addEventListener('change', () => updateButtonState(tabId));
            if (input.type !== 'file') {
                input.addEventListener('input', () => updateButtonState(tabId));
            }
        });
    });

    // Next button functionality
    document.querySelectorAll('.next-tab-btn').forEach(button => {
        button.addEventListener('click', function () {
            const nextTabId = this.getAttribute('data-next-tab');
            if (nextTabId) {
                document.querySelector(`[data-tab-target="#${nextTabId}"]`).click();
            }
        });
    });

    // Form submission
    const form = document.getElementById('upload-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const submitBtn = document.getElementById('submit-all-btn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Envoi en cours...
            `;

            const alertDiv = document.getElementById('form-response-alert');
            alertDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded';
            alertDiv.textContent = 'Documents soumis avec succès!';
            alertDiv.classList.remove('hidden');

            // Simulate form submission
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 2000);
        });
    }

    // Initialize button states
    document.querySelectorAll('.tab-content').forEach(tab => updateButtonState(tab.id));
});
