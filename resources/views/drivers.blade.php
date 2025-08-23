<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Drivers') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Drivers</h1>
                    <p class="text-muted">Manage and monitor all drivers in the system.</p>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#addDriverModal">
                    <i class="bi bi-plus-lg me-2"></i> Add Driver
                </button>
            </div>

            <!-- Filters and Search -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body p-4">
                    <form action="{{ url('driver/index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-12 col-md-3">
                                <label for="statusFilter" class="form-label small text-muted">Status</label>
                                <select class="form-select" id="statusFilter" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-7">
                                <label for="searchName" class="form-label small text-muted">Search</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="searchName"
                                        name="search" placeholder="Search by name, license, or phone...">
                                </div>
                            </div>
                            <div class="col-12 col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-funnel me-2"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Drivers Table -->
            <div class="card border-0 shadow">
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover table-striped mb-0" id="myTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">License Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drivers as $driver)
                                    <tr>
                                        <td class="ps-4">{{ $loop->iteration }}</td>
                                        <td class="fw-medium">{{ $driver['name'] }}</td>
                                        <td>{{ $driver['license_number'] }}</td>
                                        <td>{{ $driver['phone'] }}</td>
                                        <td>
                                            @if ($driver['status'] == 'Active')
                                                <span class="badge rounded-pill text-bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <button type="button" class="btn btn-sm btn-info me-1 btn-view-driver"
                                                data-bs-target="#viewDriverModal" data-bs-toggle="modal"
                                                data-driver-id="{{ $driver->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning me-1 btn-edit-driver"
                                                data-bs-target="#editDriverModal" data-bs-toggle="modal"
                                                data-driver-id="{{ $driver->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-driver"
                                                data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                                                data-driver-id="{{ $driver->id }}"
                                                data-driver-name="{{ $driver->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3 mb-4">
                    {!! $drivers->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Driver Modal -->
    <div class="modal fade" id="addDriverModal" tabindex="-1" aria-labelledby="addDriverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDriverModalLabel">Add New Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addDriverForm">
                    <div class="modal-body">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="licenseNumber" class="form-label">License Number</label>
                                <input type="text" class="form-control" id="licenseNumber" name="license_number"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phoneNumber" name="phone" required>
                            </div>
                            <div class="col-md-6">
                                <label for="emailAddress" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="emailAddress" name="email">
                            </div>
                            <div class="col-md-6">
                                <label for="driverStatus" class="form-label">Status</label>
                                <select class="form-select" id="driverStatus" name="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="joinedDate" class="form-label">Joined Date</label>
                                <input type="date" class="form-control" id="joinedDate" name="joined_date">
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveNewDriver">Save Driver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Driver Modal -->
    <div class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="editDriverModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDriverModalLabel">Edit Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDriverForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="editDriverId">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">License Number</label>
                                <input type="text" class="form-control" name="license_number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Joined Date</label>
                                <input type="date" class="form-control" name="joined_date">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-sm btn-primary btn-edit-driver">
                                Save Changes
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- View Driver Modal -->
    <div class="modal fade" id="viewDriverModal" tabindex="-1" aria-labelledby="viewDriverModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDriverModalLabel">Driver Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted small">DRIVER ID</h6>
                                <p class="mb-0 fw-medium" id="viewDriverId">{{ $driver->id }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">FULL NAME</h6>
                                <p class="mb-0 fw-medium" id="viewFullName"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">LICENSE NUMBER</h6>
                                <p class="mb-0" id="viewLicenseNumber"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">PHONE NUMBER</h6>
                                <p class="mb-0" id="viewPhoneNumber"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted small">STATUS</h6>
                                <p class="mb-0" id="viewStatusContainer"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">EMAIL ADDRESS</h6>
                                <p class="mb-0" id="viewEmailAddress"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">ADDRESS</h6>
                                <p class="mb-0" id="viewAddress"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">JOINED DATE</h6>
                                <p class="mb-0" id="viewJoinedDate"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bg-light rounded p-3">
                                <h6 class="mb-3">Assigned Vehicles</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless mb-0">
                                        <thead>
                                            <tr>
                                                <th>Vehicle</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>KBZ 123A</td>
                                                <td>Truck</td>
                                                <td><span class="badge rounded-pill text-bg-success">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td>KCY 456B</td>
                                                <td>Van</td>
                                                <td><span class="badge rounded-pill text-bg-danger">Offline</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-sm btn-primary btn-edit-driver">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete driver?</p>
                    <p class="text-danger mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- Add this hidden input -->
                    <input type="hidden" id="deleteDriverId" value="">
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="bi bi-trash"></i> Delete Driver
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        // Function to show dynamic alerts like your session() alerts
        function showAlert(message, type = 'success') {
            const alertId = 'alert-' + Date.now();
            const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
            const container = document.body;

            const el = document.createElement('div');
            el.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-4 auto-dismiss`;
            el.style.zIndex = 1055;
            el.style.minWidth = '300px';
            el.id = alertId;
            el.role = 'alert';
            el.innerHTML = `
        ${message}
        <div class="progress mt-2" style="height: 3px;">
            <div class="progress-bar ${bgClass}" style="width: 100%; transition: width 0.1s linear;"></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
            container.appendChild(el);

            // Auto-dismiss progress
            const duration = 4000;
            let progressBar = el.querySelector('.progress-bar');
            let paused = false;
            let start = Date.now();
            let elapsed = 0;
            let timer;

            function updateBar() {
                if (!paused) {
                    elapsed = Date.now() - start;
                    let percent = Math.max(0, 100 - (elapsed / duration) * 100);
                    if (progressBar) progressBar.style.width = percent + '%';
                    if (percent <= 0) {
                        clearInterval(timer);
                        el.classList.remove('show');
                        setTimeout(() => el.remove(), 500);
                    }
                }
            }

            function startTimer() {
                timer = setInterval(updateBar, 50);
            }

            function pauseTimer() {
                paused = true;
            }

            function resumeTimer() {
                paused = false;
                start = Date.now() - elapsed;
            }

            el.addEventListener('mouseenter', pauseTimer);
            el.addEventListener('mouseleave', resumeTimer);
            startTimer();
        }

        // AJAX form submission
        // AJAX form submission for adding driver
        $(document).on('submit', '#addDriverForm', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            const $submitBtn = $('#saveNewDriver');

            // Show loading state
            $submitBtn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span> Saving...');

            $.ajax({
                type: "POST",
                url: "{{ url('driver/store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 200) {
                        $('#addDriverModal').modal('hide');
                        $('#addDriverForm')[0].reset();

                        // Fix modal backdrop
                        $('.modal-backdrop').fadeOut(300, function() {
                            $(this).remove();
                        });
                        $('body').removeClass('modal-open').css('padding-right', '');

                        showAlert(response.message, 'success');

                        // Append new driver to table with proper data attributes
                        let driver = response.driver;
                        let statusBadge = driver.status === 'Active' ?
                            '<span class="badge rounded-pill text-bg-success">Active</span>' :
                            '<span class="badge rounded-pill text-bg-danger">Inactive</span>';

                        let newRow = `
                    <tr>
                        <td class="ps-4">${$('#myTable tbody tr').length + 1}</td>
                        <td>${driver.name}</td>
                        <td>${driver.license_number}</td>
                        <td>${driver.phone}</td>
                        <td>${statusBadge}</td>
                        <td class="text-end pe-4">
                            <button type="button" class="btn btn-sm btn-info me-1 btn-view-driver"
                                    data-bs-target="#viewDriverModal" data-bs-toggle="modal"
                                    data-driver-id="${driver.id}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning me-1 btn-edit-driver"
                                    data-bs-target="#editDriverModal" data-bs-toggle="modal"
                                    data-driver-id="${driver.id}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete-driver" 
                                    data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                                    data-driver-id="${driver.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                        $('#myTable tbody').append(newRow);

                        // Scroll to new row
                        $('#myTable').parent().scrollTop($('#myTable').parent()[0].scrollHeight);

                    } else {
                        showAlert(response.message || 'Failed to create driver', 'danger');
                    }
                },
                error: function(xhr) {
                    console.error('Add driver error:', xhr);
                    let message = 'An unexpected error occurred';

                    if (xhr.responseJSON?.errors) {
                        let errors = xhr.responseJSON.errors;
                        message = Object.values(errors).flat().join('<br>');
                    } else if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    }

                    showAlert(message, 'danger');
                },
                complete: function() {
                    // Reset button state
                    $submitBtn.prop('disabled', false).html('Save Driver');
                }
            });
        });

        function updateRowNumbers() {
            $('#myTable tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }



        // OPEN EDIT MODAL AND LOAD DRIVER DATA
        // Handle click on Edit button
        $(document).on('click', '.btn-edit-driver', function() {
            const driverId = $(this).data('driver-id'); // Fetch ID from the button

            if (!driverId) {
                showAlert('Driver ID not found!', 'danger');
                return;
            }

            $.ajax({
                url: "{{ url('driver/show') }}/" + driverId,
                method: 'GET',
                success: function(driver) {

                    if (!driver || !driver.id) {
                        showAlert('No driver data found!', 'danger');
                        return;
                    }

                    // Set hidden ID input
                    $('#editDriverId').val(driver.id);

                    // Fill all matching fields dynamically
                    $('#editDriverForm').find('input, select, textarea').each(function() {
                        const fieldName = $(this).attr('name');
                        if (driver[fieldName] !== undefined) {
                            $(this).val(driver[fieldName]);
                        }
                    });

                    // Show modal
                    $('#editDriverModal').modal('show');
                },
                error: function(xhr) {
                    showAlert('Failed to load driver data.', 'danger');
                    console.error('Error response:', xhr.responseText);
                }
            });
        });


        // SUBMIT EDIT FORM
        $(document).on('submit', '#editDriverForm', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent event bubbling

            console.log('Edit form submitted via AJAX');

            const driverId = $('#editDriverId').val();

            if (!driverId) {
                showAlert('Driver ID not found!', 'danger');
                return false;
            }

            const formData = $(this).serialize();
            const $submitBtn = $(this).find('button[type="submit"]');
            const originalBtnText = $submitBtn.html();

            // Show loading state
            $submitBtn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span> Updating...');

            $.ajax({
                url: "{{ url('driver/update') }}/" + driverId,
                method: 'POST',
                data: formData + '&_method=PUT&_token={{ csrf_token() }}',
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    console.log('Update success:', response);

                    if (response.status === 200) {
                        showAlert(response.message, 'success');
                        $('#editDriverModal').modal('hide');

                        // Fix modal backdrop issue
                        setTimeout(function() {
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open').css('padding-right', '');
                        }, 100);

                        // Update the table row instead of reloading
                        updateTableRow(driverId, response.driver);

                    } else {
                        showAlert(response.message || 'Failed to update driver', 'danger');
                    }
                },
                error: function(xhr) {
                    console.error('Update error:', xhr);

                    let message = 'Failed to update driver';

                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        } else if (xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            message = Object.values(errors).flat().join('<br>');
                        }
                    }

                    showAlert(message, 'danger');
                },
                complete: function() {
                    // Reset button state
                    $submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });

            return false; // Prevent any default form submission
        });

        // Function to update table row without page reload
        function updateTableRow(driverId, driver) {
            const $row = $(`button[data-driver-id="${driverId}"]`).closest('tr');

            if ($row.length > 0) {
                const statusBadge = driver.status === 'Active' ?
                    '<span class="badge rounded-pill text-bg-success">Active</span>' :
                    '<span class="badge rounded-pill text-bg-danger">Inactive</span>';

                // Update table cells (adjust column indices based on your table structure)
                $row.find('td').eq(1).text(driver.name); // Name column
                $row.find('td').eq(2).text(driver.license_number); // License column
                $row.find('td').eq(3).text(driver.phone); // Phone column
                $row.find('td').eq(4).html(statusBadge); // Status column

                // Add a brief highlight effect
                $row.addClass('table-success');
                setTimeout(function() {
                    $row.removeClass('table-success');
                }, 2000);
            }
        }



        // Handle delete button click in table (opens modal)
        $(document).on('click', '.btn-delete-driver', function(e) {
            e.preventDefault();

            const driverId = $(this).data('driver-id');
            const driverName = $(this).data('driver-name'); // Adjust based on your table

            // Set the driver info in modal
            $('#deleteDriverId').val(driverId);
            $('#deleteDriverName').text(driverName);

            // Show modal
            $('#deleteConfirmModal').modal('show');
        });


        // Handle the actual delete when confirm button is clicked
        $(document).on('click', '#confirmDeleteBtn', function(e) {
            e.preventDefault();

            const driverId = $('#deleteDriverId').val();

            if (!driverId || driverId.trim() === '') {
                showAlert('Driver ID not found in modal!', 'danger');
                return;
            }

            const deleteUrl = "{{ url('driver/destroy') }}/" + driverId;
            const $btn = $(this);
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Deleting...');

            $.ajax({
                url: deleteUrl,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: 'DELETE'
                },
                success: function(response) {
                    console.log('Success response:', response);

                    // Properly hide modal and remove backdrop
                    const modal = bootstrap.Modal.getInstance(document.getElementById(
                        'deleteConfirmModal'));
                    if (modal) {
                        modal.hide();
                    }

                    // Alternative method - force remove backdrop
                    setTimeout(function() {
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '');
                    }, 100);

                    showAlert(response.message || 'Driver deleted successfully', 'success');

                    // Find and remove the deleted row from the table
                    $('button[data-driver-id="' + driverId + '"]').closest('tr').fadeOut(500,
                        function() {
                            $(this).remove();
                            updateRowNumbers();
                        });
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr);
                    let message = 'Failed to delete driver';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showAlert(message, 'danger');

                    // Also fix backdrop on error
                    setTimeout(function() {
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '');
                    }, 100);
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="bi bi-trash"></i> Delete Driver');
                }
            });
        });

        // Optional: Function to update row numbers after deletion
        function updateRowNumbers() {
            $('table tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }

        // Handle view driver modal
        $('#viewDriverModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const driverId = button.data('driver-id');

            if (!driverId) {
                showAlert('Driver ID not found!', 'danger');
                return;
            }

            // Show loading state
            $(this).find('.modal-body').html(`
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading driver details...</p>
        </div>
    `);

            $.ajax({
                url: "{{ url('driver/show') }}/" + driverId,
                method: 'GET',
                success: function(driver) {
                    if (!driver || !driver.id) {
                        showAlert('No driver data found!', 'danger');
                        return;
                    }

                    // Format status badge
                    let statusBadge = driver.status === 'Active' ?
                        '<span class="badge rounded-pill text-bg-success">Active</span>' :
                        '<span class="badge rounded-pill text-bg-danger">Inactive</span>';

                    // Format joined date
                    let joinedDate = driver.joined_date ?
                        new Date(driver.joined_date).toLocaleDateString() : 'Not specified';

                    // Update modal content
                    const modalContent = `
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted small">DRIVER ID</h6>
                            <p class="mb-0 fw-medium">${driver.id}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">FULL NAME</h6>
                            <p class="mb-0 fw-medium">${driver.name}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">LICENSE NUMBER</h6>
                            <p class="mb-0">${driver.license_number}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">PHONE NUMBER</h6>
                            <p class="mb-0">${driver.phone}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted small">STATUS</h6>
                            <p class="mb-0">${statusBadge}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">EMAIL ADDRESS</h6>
                            <p class="mb-0">${driver.email || 'Not provided'}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">ADDRESS</h6>
                            <p class="mb-0">${driver.address || 'Not provided'}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">JOINED DATE</h6>
                            <p class="mb-0">${joinedDate}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="bg-light rounded p-3">
                            <h6 class="mb-3">Assigned Vehicles</h6>
                            <p class="text-muted">No vehicles assigned yet.</p>
                        </div>
                    </div>
                </div>
            `;

                    $('#viewDriverModal .modal-body').html(modalContent);

                    // Set the driver ID on the edit button in the modal footer
                    $('#viewDriverModal .btn-edit-driver').attr('data-driver-id', driver.id);

                },
                error: function(xhr) {
                    console.error('View driver error:', xhr);
                    $('#viewDriverModal .modal-body').html(`
                <div class="text-center">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                    <h4 class="mt-3 text-danger">Error</h4>
                    <p>Failed to load driver details.</p>
                </div>
            `);
                }
            });
        });

        // Handle edit button click from view modal
        $(document).on('click', '#viewDriverModal .btn-edit-driver', function(e) {
            const driverId = $(this).attr('data-driver-id');

            // Close view modal
            $('#viewDriverModal').modal('hide');

            // Wait for view modal to close, then open edit modal
            $('#viewDriverModal').on('hidden.bs.modal', function() {
                // Trigger the edit modal with the driver ID
                const editButton = $('<button>').attr('data-driver-id', driverId);
                $('#editDriverModal').trigger('show.bs.modal', [{
                    relatedTarget: editButton[0]
                }]);

                // Remove the event handler
                $(this).off('hidden.bs.modal');
            });
        });
    </script>
</x-app-layout>
