document.addEventListener('DOMContentLoaded', function() {
    // ----- Existing Tab Functionality -----
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

    // ----- File Upload Functionality -----
    function initializeFileUploads() {
        // Find all file input containers in the current tab
        const fileContainers = document.querySelectorAll('.tab-pane.active .file-upload-container');
        
        fileContainers.forEach(container => {
            const fileInput = container.querySelector('input[type="file"]');
            const fileNameDisplay = container.querySelector('.file-name-display');

            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files.length > 0) {
                    fileNameDisplay.textContent = this.files[0].name;
                    fileNameDisplay.classList.remove('text-gray-500');
                    fileNameDisplay.classList.add('text-blue-600', 'font-medium');
                } else {
                    const defaultText = container.getAttribute('data-default-text');
                    fileNameDisplay.textContent = defaultText;
                    fileNameDisplay.classList.remove('text-blue-600', 'font-medium');
                    fileNameDisplay.classList.add('text-gray-500');
                }
            });
        });
    }

    // Initialize when tab changes
    document.querySelectorAll('[data-tab-target]').forEach(button => {
        button.addEventListener('click', initializeFileUploads);
    });

    // Initialize on first load
    initializeFileUploads();

    // ----- Form Validation -----
    function updateButtonState(tabId) {
        const tab = document.getElementById(tabId);
        const requiredInputs = tab.querySelectorAll('input[required], select[required]');
        const nextButton = tab.querySelector('.next-tab-btn');

        let allFilled = true;
        requiredInputs.forEach(input => {
            if (input.type === 'file') {
                if (!input.files || input.files.length === 0) {
                    allFilled = false;
                }
            } else if (input.value === '') {
                allFilled = false;
            }
        });

        if (nextButton) {
            nextButton.disabled = !allFilled;
        }
    }

    // ----- Form Submission -----
    const form = document.getElementById('upload-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = document.getElementById('submit-all-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Envoi en cours...
                `;
            }

            // Submit form via AJAX or let it submit normally
            this.submit();
        });
    }

    // Initialize all functionality
    document.querySelectorAll('.tab-content').forEach(tab => {
        if (tab.classList.contains('active')) {
            updateButtonState(tab.id);
        }
    });
});