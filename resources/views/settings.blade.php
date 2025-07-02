<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Settings</h1>
                    <p class="text-muted">Configure your account and application preferences</p>
                </div>
            </div>

            <!-- Alert for success messages -->
            <div id="settingsAlert" class="alert alert-success alert-dismissible fade d-none" role="alert">
                <span id="settingsAlertMessage"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="row g-4">
                <!-- User Preferences -->
                <div class="col-md-6">
                    <div class="card border-0 shadow h-100">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-person-circle me-2"></i>User Preferences
                                </h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#profileModal">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Name</label>
                                <p class="mb-0">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p class="mb-0">{{ Auth::user()->email }}</p>
                            </div>
                            <div>
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                    <i class="bi bi-key me-1"></i>Change Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="col-md-6">
                    <div class="card border-0 shadow h-100">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-bell me-2"></i>Notifications
                                </h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 fw-medium">SMS Notifications</p>
                                        <p class="text-muted small mb-0">Receive alerts via SMS</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" disabled 
                                            {{ Auth::user()->sms_notifications ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 fw-medium">Email Notifications</p>
                                        <p class="text-muted small mb-0">Receive alerts via email</p>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" disabled
                                            {{ Auth::user()->email_notifications ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Settings -->
                <div class="col-md-6">
                    <div class="card border-0 shadow h-100">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-map me-2"></i>Map Settings
                                </h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#mapSettingsModal">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Default Map Type</label>
                                <p class="mb-0 text-capitalize">{{ Auth::user()->default_map_type ?? 'street' }}</p>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body p-2 text-center">
                                            <i class="bi bi-map fs-4 d-block mb-1"></i>
                                            <span class="small">Street</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body p-2 text-center">
                                            <i class="bi bi-globe fs-4 d-block mb-1"></i>
                                            <span class="small">Satellite</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body p-2 text-center">
                                            <i class="bi bi-layers fs-4 d-block mb-1"></i>
                                            <span class="small">Hybrid</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body p-2 text-center">
                                            <i class="bi bi-mountains fs-4 d-block mb-1"></i>
                                            <span class="small">Terrain</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Localization -->
                <div class="col-md-6">
                    <div class="card border-0 shadow h-100">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-globe2 me-2"></i>Localization
                                </h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#localizationModal">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Language</label>
                                <p class="mb-0">
                                    @php
                                        $languages = [
                                            'en' => 'English',
                                            'es' => 'Spanish',
                                            'fr' => 'French',
                                            'de' => 'German'
                                        ];
                                        $userLang = Auth::user()->language ?? 'en';
                                    @endphp
                                    {{ $languages[$userLang] }}
                                </p>
                            </div>
                            <div>
                                <label class="form-label text-muted">Measurement Units</label>
                                <p class="mb-0 text-capitalize">{{ Auth::user()->measurement_unit ?? 'km' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="profileForm">
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="profileFormErrors"></div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="passwordForm">
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="passwordFormErrors"></div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Notifications Modal -->
    <div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationsModalLabel">Notification Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="notificationsForm">
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="notificationsFormErrors"></div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="sms_notifications" name="sms_notifications" 
                                    {{ Auth::user()->sms_notifications ? 'checked' : '' }}>
                                <label class="form-check-label" for="sms_notifications">SMS Notifications</label>
                            </div>
                            <div class="form-text">Receive alerts via SMS when events occur</div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications"
                                    {{ Auth::user()->email_notifications ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_notifications">Email Notifications</label>
                            </div>
                            <div class="form-text">Receive alerts via email when events occur</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Map Settings Modal -->
    <div class="modal fade" id="mapSettingsModal" tabindex="-1" aria-labelledby="mapSettingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapSettingsModalLabel">Map Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="mapSettingsForm">
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="mapSettingsFormErrors"></div>
                        <div class="mb-3">
                            <label for="default_map_type" class="form-label">Default Map Type</label>
                            <select class="form-select" id="default_map_type" name="default_map_type">
                                <option value="street" {{ (Auth::user()->default_map_type ?? '') == 'street' ? 'selected' : '' }}>Street</option>
                                <option value="satellite" {{ (Auth::user()->default_map_type ?? '') == 'satellite' ? 'selected' : '' }}>Satellite</option>
                                <option value="hybrid" {{ (Auth::user()->default_map_type ?? '') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="terrain" {{ (Auth::user()->default_map_type ?? '') == 'terrain' ? 'selected' : '' }}>Terrain</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Localization Modal -->
    <div class="modal fade" id="localizationModal" tabindex="-1" aria-labelledby="localizationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="localizationModalLabel">Localization Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="localizationForm">
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="localizationFormErrors"></div>
                        <div class="mb-3">
                            <label for="language" class="form-label">Language</label>
                            <select class="form-select" id="language" name="language">
                                <option value="en" {{ (Auth::user()->language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                                <option value="es" {{ (Auth::user()->language ?? '') == 'es' ? 'selected' : '' }}>Spanish</option>
                                <option value="fr" {{ (Auth::user()->language ?? '') == 'fr' ? 'selected' : '' }}>French</option>
                                <option value="de" {{ (Auth::user()->language ?? '') == 'de' ? 'selected' : '' }}>German</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="measurement_unit" class="form-label">Measurement Units</label>
                            <select class="form-select" id="measurement_unit" name="measurement_unit">
                                <option value="km" {{ (Auth::user()->measurement_unit ?? '') == 'km' ? 'selected' : '' }}>Kilometers</option>
                                <option value="miles" {{ (Auth::user()->measurement_unit ?? '') == 'miles' ? 'selected' : '' }}>Miles</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('modals')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Helper function to show alert
            function showAlert(message, type = 'success') {
                const alertEl = document.getElementById('settingsAlert');
                const alertMessage = document.getElementById('settingsAlertMessage');
                
                alertEl.classList.remove('d-none', 'alert-success', 'alert-danger');
                alertEl.classList.add('show', `alert-${type}`);
                alertMessage.textContent = message;
                
                // Auto hide after 5 seconds
                setTimeout(() => {
                    alertEl.classList.remove('show');
                    setTimeout(() => alertEl.classList.add('d-none'), 300);
                }, 5000);
            }
            
            // Helper function to display form errors
            function displayErrors(errors, formId) {
                const errorContainer = document.getElementById(`${formId}Errors`);
                errorContainer.innerHTML = '';
                errorContainer.classList.remove('d-none');
                
                let errorHtml = '<ul class="mb-0">';
                for (const field in errors) {
                    errors[field].forEach(error => {
                        errorHtml += `<li>${error}</li>`;
                    });
                }
                errorHtml += '</ul>';
                
                errorContainer.innerHTML = errorHtml;
            }
            
            // Helper function to clear form errors
            function clearErrors(formId) {
                const errorContainer = document.getElementById(`${formId}Errors`);
                errorContainer.innerHTML = '';
                errorContainer.classList.add('d-none');
            }
            
            // Helper function for AJAX form submission
            function submitForm(formId, url, successCallback) {
                const form = document.getElementById(formId);
                
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    clearErrors(formId);
                    
                    const formData = new FormData(form);
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.errors) {
                            displayErrors(data.errors, formId);
                        } else if (data.success) {
                            // Close modal
                            const modalId = form.closest('.modal').id;
                            const modalInstance = bootstrap.Modal.getInstance(document.getElementById(modalId));
                            modalInstance.hide();
                            
                            // Show success message
                            showAlert(data.message);
                            
                            // Execute success callback if provided
                            if (successCallback) successCallback(data);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('An error occurred. Please try again.', 'danger');
                    });
                });
            }
            
            // Profile form submission
            submitForm('profileForm', '{{ url("settings/update-profile") }}', function(data) {
                // Update displayed name and email
                document.querySelector('.card-body p:nth-child(2)').textContent = document.getElementById('name').value;
                document.querySelector('.card-body p:nth-child(4)').textContent = document.getElementById('email').value;
            });
            
            // Password form submission
            submitForm('passwordForm', '{{ url("settings/update-password") }}', function(data) {
                // Reset form
                document.getElementById('passwordForm').reset();
            });
            
            // Notifications form submission
            submitForm('notificationsForm', '{{ url("settings/update-notifications") }}', function(data) {
                // Update displayed switches
                const smsChecked = document.getElementById('sms_notifications').checked;
                const emailChecked = document.getElementById('email_notifications').checked;
                
                document.querySelectorAll('.card-body .form-check-input')[0].checked = smsChecked;
                document.querySelectorAll('.card-body .form-check-input')[1].checked = emailChecked;
            });
            
            // Map settings form submission
            submitForm('mapSettingsForm', '{{ url("settings/update-map-settings") }}', function(data) {
                // Update displayed map type
                const mapType = document.getElementById('default_map_type').value;
                document.querySelector('.card-body p.text-capitalize').textContent = mapType;
            });
            
            // Localization form submission
            submitForm('localizationForm', '{{ url("settings/update-localization") }}', function(data) {
                // Update displayed language and measurement unit
                const languageSelect = document.getElementById('language');
                const languageText = languageSelect.options[languageSelect.selectedIndex].text;
                const measurementUnit = document.getElementById('measurement_unit').value;
                
                document.querySelectorAll('.card-body p.mb-0')[3].textContent = languageText;
                document.querySelectorAll('.card-body p.text-capitalize')[1].textContent = measurementUnit;
            });
        });
    </script>
    @endpush
</x-app-layout>

