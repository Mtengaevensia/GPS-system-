/**
 * AJAX Utilities for GPS Navigator
 * Provides reusable functions for AJAX operations across the application
 */

// CSRF token setup for all AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

/**
 * Show a toast notification
 * @param {string} message - The message to display
 * @param {string} type - The type of toast (success, error, warning, info)
 * @param {number} duration - Duration in milliseconds
 */
function showToast(message, type = 'success', duration = 3000) {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '1050';
        document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    // Toast content
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    // Add to container
    toastContainer.appendChild(toast);
    
    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: duration
    });
    bsToast.show();
    
    // Remove from DOM after hiding
    toast.addEventListener('hidden.bs.toast', function() {
        toast.remove();
    });
}

/**
 * Display validation errors in a form
 * @param {Object} errors - The errors object from Laravel validation
 * @param {string} formId - The ID of the form
 */
function displayValidationErrors(errors, formId) {
    const form = document.getElementById(formId);
    
    // Clear previous errors
    clearValidationErrors(form);
    
    // Add new error messages
    for (const field in errors) {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            
            // Create error feedback element
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = errors[field][0]; // First error message
            
            // Insert after input
            input.parentNode.insertBefore(feedback, input.nextSibling);
        }
    }
}

/**
 * Clear validation errors from a form
 * @param {HTMLElement} form - The form element
 */
function clearValidationErrors(form) {
    // Remove is-invalid class from all inputs
    form.querySelectorAll('.is-invalid').forEach(input => {
        input.classList.remove('is-invalid');
    });
    
    // Remove all error messages
    form.querySelectorAll('.invalid-feedback').forEach(feedback => {
        feedback.remove();
    });
}

/**
 * Submit a form via AJAX
 * @param {string} formId - The ID of the form
 * @param {string} url - The URL to submit to (optional, defaults to form action)
 * @param {Function} successCallback - Function to call on success
 * @param {string} method - HTTP method (POST, PUT, etc.)
 */
function submitFormAjax(formId, url = null, successCallback = null, method = null) {
    const form = document.getElementById(formId);
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearValidationErrors(form);
        
        // Get form data
        const formData = new FormData(form);
        
        // Use form action if URL not provided
        const submitUrl = url || form.getAttribute('action');
        
        // Use form method if not provided
        const submitMethod = method || form.getAttribute('method') || 'POST';
        
        // Send AJAX request
        fetch(submitUrl, {
            method: submitMethod,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                // Display validation errors
                displayValidationErrors(data.errors, formId);
            } else if (data.success) {
                // Show success message
                showToast(data.message || 'Operation completed successfully');
                
                // Close modal if form is in a modal
                const modal = form.closest('.modal');
                if (modal) {
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
                
                // Execute success callback if provided
                if (successCallback && typeof successCallback === 'function') {
                    successCallback(data);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred. Please try again.', 'danger');
        });
    });
}

/**
 * Load content via AJAX into a container
 * @param {string} url - The URL to fetch content from
 * @param {string} containerId - The ID of the container to load content into
 * @param {Function} callback - Function to call after content is loaded
 */
function loadContent(url, containerId, callback = null) {
    const container = document.getElementById(containerId);
    
    // Show loading indicator
    container.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    
    fetch(url, {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => response.text())
    .then(html => {
        container.innerHTML = html;
        
        // Execute callback if provided
        if (callback && typeof callback === 'function') {
            callback();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        container.innerHTML = '<div class="alert alert-danger">Failed to load content. Please try again.</div>';
    });
}

/**
 * Perform a simple AJAX action (e.g., mark as read, delete)
 * @param {string} url - The URL to send the request to
 * @param {string} method - HTTP method (POST, PUT, DELETE)
 * @param {Object} data - Data to send with the request
 * @param {Function} successCallback - Function to call on success
 */
function performAction(url, method, data = {}, successCallback = null) {
    // Create form data
    const formData = new FormData();
    for (const key in data) {
        formData.append(key, data[key]);
    }
    
    // Add CSRF token
    formData.append('_token', csrfToken);
    
    // For PUT/DELETE methods in Laravel
    if (method.toUpperCase() === 'PUT') {
        formData.append('_method', 'PUT');
    } else if (method.toUpperCase() === 'DELETE') {
        formData.append('_method', 'DELETE');
    }
    
    // Send request
    fetch(url, {
        method: 'POST', // Always POST, with _method for PUT/DELETE
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showToast(data.message || 'Operation completed successfully');
            
            // Execute success callback if provided
            if (successCallback && typeof successCallback === 'function') {
                successCallback(data);
            }
        } else {
            // Show error message
            showToast(data.message || 'Operation failed', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.', 'danger');
    });
}

// Export functions
window.gpsAjax = {
    showToast,
    displayValidationErrors,
    clearValidationErrors,
    submitFormAjax,
    loadContent,
    performAction
};