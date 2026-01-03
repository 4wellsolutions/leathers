/**
 * AJAX Form Handler for Admin Panel
 * Handles form submissions via AJAX with validation, loading states, and notifications
 */

class AjaxFormHandler {
    constructor(form) {
        this.form = form;
        this.submitButton = form.querySelector('button[type="submit"]');
        this.init();
    }

    init() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    async handleSubmit(e) {
        e.preventDefault();

        // Clear previous errors
        this.clearErrors();

        // Show loading state
        this.setLoading(true);

        try {
            const formData = new FormData(this.form);
            const method = this.form.method.toUpperCase();
            const url = this.form.action;

            // Add AJAX header to request JSON response
            const headers = {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            };

            // If not using FormData (no files), send as JSON
            const hasFiles = Array.from(formData.values()).some(value => value instanceof File);

            let response;
            if (!hasFiles && method === 'POST') {
                // Convert FormData to JSON for non-file uploads
                const jsonData = {};
                formData.forEach((value, key) => {
                    if (key.endsWith('[]')) {
                        // Handle array inputs
                        const arrayKey = key.slice(0, -2);
                        if (!jsonData[arrayKey]) jsonData[arrayKey] = [];
                        jsonData[arrayKey].push(value);
                    } else {
                        jsonData[key] = value;
                    }
                });

                headers['Content-Type'] = 'application/json';
                response = await fetch(url, {
                    method: method,
                    headers: headers,
                    body: JSON.stringify(jsonData)
                });
            } else {
                // Use FormData for file uploads
                response = await fetch(url, {
                    method: method,
                    headers: headers,
                    body: formData
                });
            }

            const data = await response.json();

            if (response.ok) {
                // Success
                this.handleSuccess(data);
            } else if (response.status === 422) {
                // Validation errors
                this.handleValidationErrors(data.errors);
            } else {
                // Other errors
                this.handleError(data.message || 'An error occurred');
            }
        } catch (error) {
            console.error('Form submission error:', error);
            this.handleError('Network error. Please try again.');
        } finally {
            this.setLoading(false);
        }
    }

    handleSuccess(data) {
        // Show success toast
        showToast(data.message || 'Saved successfully!', 'success');

        // Redirect if specified
        if (data.redirect) {
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1000);
        }

        // Trigger custom event for additional handling
        this.form.dispatchEvent(new CustomEvent('ajax:success', { detail: data }));
    }

    handleValidationErrors(errors) {
        let firstErrorMessage = '';

        Object.keys(errors).forEach((field, index) => {
            const message = errors[field][0];
            if (index === 0) firstErrorMessage = message;

            // Handle array field names like images.0 -> images[]
            let selector = `[name="${field}"], [name="${field}[]"]`;
            if (field.includes('.')) {
                const parts = field.split('.');
                selector = `[name="${parts[0]}[]"]`;
            }

            const input = this.form.querySelector(selector);
            if (input) {
                // Add error class to input
                input.classList.add('border-red-500');
                input.classList.remove('border-neutral-300');

                // Find or create error message element
                let errorElement = input.parentElement.querySelector('.error-message');

                // If input is hidden (like file input with custom UI), try to find the visible wrapper
                if (input.type === 'file' && input.classList.contains('hidden')) {
                    const wrapper = input.closest('label') || input.parentElement;
                    errorElement = wrapper.parentElement.querySelector('.error-message');
                    if (!errorElement) {
                        errorElement = document.createElement('p');
                        errorElement.className = 'error-message text-red-600 text-sm mt-1';
                        wrapper.parentElement.appendChild(errorElement);
                    }
                } else if (!errorElement) {
                    errorElement = document.createElement('p');
                    errorElement.className = 'error-message text-red-600 text-sm mt-1';

                    // Insert after input or its wrapper
                    const wrapper = input.closest('.relative') || input.parentElement;
                    wrapper.appendChild(errorElement);
                }

                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.style.display = 'block'; // Ensure it's visible
                }
            }
        });

        // Show specific error toast
        showToast(firstErrorMessage || 'Please fix the validation errors', 'error');

        // Scroll to first error
        const firstError = this.form.querySelector('.border-red-500');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }

    handleError(message) {
        showToast(message, 'error');
    }

    clearErrors() {
        // Remove error classes
        this.form.querySelectorAll('.border-red-500').forEach(input => {
            input.classList.remove('border-red-500');
            input.classList.add('border-neutral-300');
        });

        // Remove error messages
        this.form.querySelectorAll('.error-message').forEach(error => {
            error.remove();
        });
    }

    setLoading(isLoading) {
        if (!this.submitButton) return;

        if (isLoading) {
            this.submitButton.disabled = true;
            const btnText = this.submitButton.querySelector('.btn-text, .text');
            const btnLoading = this.submitButton.querySelector('.btn-loading, .loading');

            if (btnText) btnText.classList.add('hidden');
            if (btnLoading) {
                btnLoading.classList.remove('hidden');
            } else {
                // Fallback: add loading text
                this.originalButtonText = this.submitButton.innerHTML;
                this.submitButton.innerHTML = `
                    <svg class="animate-spin h-5 w-5 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                `;
            }
        } else {
            this.submitButton.disabled = false;
            const btnText = this.submitButton.querySelector('.btn-text, .text');
            const btnLoading = this.submitButton.querySelector('.btn-loading, .loading');

            if (btnText) btnText.classList.remove('hidden');
            if (btnLoading) {
                btnLoading.classList.add('hidden');
            } else if (this.originalButtonText) {
                this.submitButton.innerHTML = this.originalButtonText;
            }
        }
    }
}

// Auto-initialize all forms with ajax-form class
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ajax-form').forEach(form => {
        new AjaxFormHandler(form);
    });
});
