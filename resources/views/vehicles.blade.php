
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vehicles') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Vehicles</h1>
                    <p class="text-muted">Manage and monitor all vehicles in the system.</p>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#addVehicleModal">
                    <i class="bi bi-plus-lg me-2"></i> Add Vehicle
                </button>
            </div>


             <!-- Filters and Search -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body p-4">
                    <form action="{{ url('vehicle/index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-12 col-md-3">
                                <label for="statusFilter" class="form-label small text-muted">Status</label>
                                <select class="form-select" id="statusFilter" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-7">
                                <label for="searchName" class="form-label small text-muted">Search</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="searchName"
                                        name="search" value="{{ request('search') }}" 
                                        placeholder="Search by license, or model">
                                </div>
                            </div>
                            <div class="col-12 col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-funnel me-2"></i> Filter
                                </button>
                            </div>
                        </div>
                        @if(request()->hasAny(['status', 'search']))
                            <div class="row mt-3">
                                <div class="col-12">
                                    <a href="{{ url('vehicle/index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-x-circle me-1"></i> Clear Filters
                                    </a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

             <!-- Results Info -->
            @if(request()->hasAny(['status', 'search']))
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle me-2"></i>
                    Showing {{ $vehicles->count() }} of {{ $vehicles->total() }} results
                    @if(request('status'))
                        for status: <strong>{{ request('status') }}</strong>
                    @endif
                    @if(request('search'))
                        matching: <strong>"{{ request('search') }}"</strong>
                    @endif
                </div>
            @endif


              <!-- Vehicles Table -->
            <div class="card border-0 shadow">
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover table-striped mb-0" id="myTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">#</th>
                                    <th scope="col">Plate Number</th>
                                    <th scope="col">Make</th>
                                    <th scope="col">Model</th>
                                    <th scope='col'>Year</th>
                                    <th scope="col">Status</th>
                                    <th scope='col'>GPS Device</th>
                                    <th scope="col" class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vehicles as $vehicle)
                                    <tr>
                                        <td class="ps-4">{{ $loop->iteration }}</td>
                                        <td class="fw-medium">{{ $vehicle->plate_number }}</td>
                                        <td>{{ $vehicle->make }}</td>
                                        <td>{{ $vehicle->model }}</td>
                                        <td>{{ $vehicle->year }}</td>

                                        <td>
                                            @if ($vehicle->status == 'active')
                                                <span class="badge rounded-pill text-bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $vehicle->gps_device_id }}</td>

                                        <td class="text-end pe-4">
                                            <button type="button" class="btn btn-sm btn-info me-1 btn-view-vehicle"
                                                data-bs-target="#viewVehicleModal" data-bs-toggle="modal"
                                                data-vehicle-id="{{ $vehicle->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning me-1 btn-edit-vehicle"
                                                data-bs-target="#editVehicleModal" data-bs-toggle="modal"
                                                data-vehicle-id="{{ $vehicle->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-vehicle"
                                                data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                                                data-vehicle-id="{{ $vehicle->id }}"
                                                {{-- data-vehicle-name="{{ $vehicle->name }}" --}}>
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No vehicle found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3 mb-4">
                    {!! $vehicles->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>




    <!-- Add Vehicle Modal -->
    <div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="addVehicleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVehicleModalLabel">Add Vehicle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addVehicleForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Plate Number</label>
                                <input type="text" class="form-control" name="plate_number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Make</label>
                                <input type="text" class="form-control" name="make" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Model</label>
                                <input type="text" class="form-control" name="model" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Year</label>
                                <input type="number" class="form-control" name="year" min="1900" max="2099" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">GPS Device ID</label>
                                <input type="text" class="form-control" name="gps_device_id">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-sm btn-primary" id="saveNewVehicle">
                                Save Vehicle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- View Vehicle Modal -->
    <div class="modal fade" id="viewVehicleModal" tabindex="-1" aria-labelledby="viewVehicleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewVehicleModalLabel">Vehicle Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted small">VEHICLE ID</h6>
                                <p class="mb-0 fw-medium" id="viewVehicleId"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">PLATE NUMBER</h6>
                                <p class="mb-0 fw-medium" id="viewPlateNumber"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">MAKE</h6>
                                <p class="mb-0" id="viewMake"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">MODEL</h6>
                                <p class="mb-0" id="viewModel"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted small">YEAR</h6>
                                <p class="mb-0" id="viewYear"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">GPS DEVICE ID</h6>
                                <p class="mb-0" id="viewGpsDeviceId"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">STATUS</h6>
                                <p class="mb-0" id="viewStatusContainer"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bg-light rounded p-3">
                                <h6 class="mb-3">Additional Info</h6>
                                <div id="viewAdditionalInfo">
                                    <p class="text-muted">No additional info available.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-sm btn-primary btn-edit-vehicle">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>


<!-- Edit Vehicle Modal -->
<div class="modal fade" id="editVehicleModal" tabindex="-1" aria-labelledby="editVehicleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVehicleModalLabel">Edit Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editVehicleForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editVehicleId">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Plate Number</label>
                            <input type="text" class="form-control" name="plate_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Make</label>
                            <input type="text" class="form-control" name="make" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Model</label>
                            <input type="text" class="form-control" name="model" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Year</label>
                            <input type="number" class="form-control" name="year" min="1900" max="2099" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">GPS Device ID</label>
                            <input type="text" class="form-control" name="gps_device_id">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Additional Info</label>
                            <textarea class="form-control" name="additional_info" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-sm btn-primary btn-edit-vehicle" type="submit">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Delete Vehicle Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this vehicle?</p>
                    <p class="text-danger mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- Hidden input for vehicle ID -->
                    <input type="hidden" id="deleteVehicleId" value="">
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="bi bi-trash"></i> Delete Vehicle
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
        $(document).on('submit', '#addVehicleForm', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            const $submitBtn = $('#saveNewVehicle');

            // Show loading state
            $submitBtn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span> Saving...');

            $.ajax({
                type: "POST",
                url: "{{ url('vehicle/store') }}",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    if (response.status === 200) {
                        console.log('Vehicle store response:', response);
                        $('#addVehicleModal').modal('hide');
                        $('#addVehicleForm')[0].reset();

                        // Fix modal backdrop
                        $('.modal-backdrop').fadeOut(300, function() {
                            $(this).remove();
                        });
                        $('body').removeClass('modal-open').css('padding-right', '');

                        showAlert(response.message, 'success');

                // Append new vehicle to table with proper data attributes
                let vehicle = response.vehicle;
                let statusBadge = vehicle.status === 'active'
                    ? '<span class="badge rounded-pill text-bg-success">Active</span>'
                    : '<span class="badge rounded-pill text-bg-danger">Inactive</span>';

                let newRow = `
                    <tr>
                        <td class="ps-4">${$('#myTable tbody tr').length + 1}</td>
                        <td class="fw-medium">${vehicle.plate_number}</td>
                        <td>${vehicle.make}</td>
                        <td>${vehicle.model}</td>
                        <td>${vehicle.year}</td>
                        <td>${statusBadge}</td>
                        <td>${vehicle.gps_device_id}</td>
                        <td class="text-end pe-4">
                            <button type="button" class="btn btn-sm btn-info me-1 btn-view-vehicle"
                                data-bs-target="#viewVehicleModal" data-bs-toggle="modal"
                                data-vehicle-id="${vehicle.id}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning me-1 btn-edit-vehicle"
                                data-bs-target="#editVehicleModal" data-bs-toggle="modal"
                                data-vehicle-id="${vehicle.id}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete-vehicle"
                                data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"
                                data-vehicle-id="${vehicle.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#myTable tbody').append(newRow);

                        // Scroll to new row
                        $('#myTable').parent().scrollTop($('#myTable').parent()[0].scrollHeight);

                    } else {
                        showAlert(response.message || 'Failed to create vehicle', 'danger');
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
                    $submitBtn.prop('disabled', false).html('Save Vehicle');
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
        $(document).on('click', '.btn-edit-vehicle', function() {
            const vehicleId = $(this).data('vehicle-id'); // Fetch ID from the button
            
            if (!vehicleId) {
                showAlert('Vehicle ID not found!', 'danger');
                return;
            }


            $.ajax({
                url: "{{ url('vehicle/show') }}/" + vehicleId,
                method: 'GET',
                success: function(vehicle) {

                    if (!vehicle || !vehicle.id) {
                        showAlert('No vehicle data found!', 'danger');
                        return;
                    }

                    // Set hidden ID input
                    $('#editVehicleId').val(vehicle.id);

                    // Fill all matching fields dynamically
                    $('#editVehicleForm').find('input, select, textarea').each(function() {
                        const fieldName = $(this).attr('name');
                        if (vehicle[fieldName] !== undefined) {
                            $(this).val(vehicle[fieldName]);
                        }
                    });

                    // Show modal
                    $('#editVehicleModal').modal('show');
                },
                error: function(xhr) {
                    // showAlert('Failed to load vehicle data.', 'danger');
                    console.error('Error response:', xhr.responseText);
                }
            });
        });


        // SUBMIT EDIT FORM
         $(document).on('submit', '#editVehicleForm', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent event bubbling

            console.log('Edit form submitted via AJAX');

            const vehicleId = $('#editVehicleId').val();

            if (!vehicleId) {
                showAlert('Vehicle ID not found!', 'danger');
                return false;
            }

            const formData = $(this).serialize();
            const $submitBtn = $(this).find('button[type="submit"]');
            const originalBtnText = $submitBtn.html();

            // Show loading state
            $submitBtn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span> Updating...');

            $.ajax({
                url: "{{ url('vehicle/update') }}/" + vehicleId,
                method: 'POST',
                data: formData + '&_method=PUT&_token={{ csrf_token() }}',
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    console.log('Update success:', response);

                    if (response.status === 200) {
                        showAlert(response.message, 'success');
                        $('#editVehicleModal').modal('hide');

                        // Fix modal backdrop issue
                        setTimeout(function() {
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open').css('padding-right', '');
                        }, 100);

                        // Update the table row instead of reloading
                        updateTableRow(vehicleId, response.vehicle);

                    } else {
                        showAlert(response.message || 'Failed to update vehicle', 'danger');
                    }
                },
                error: function(xhr) {
                    console.error('Update error:', xhr);

                    let message = 'Failed to update vehicle';

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
        function updateTableRow(vehicleId, vehicle) {
            const $row = $(`button[data-vehicle-id="${vehicleId}"]`).closest('tr');

            if ($row.length > 0) {
            const statusBadge = vehicle.status === 'active'
                ? '<span class="badge rounded-pill text-bg-success">Active</span>'
                : '<span class="badge rounded-pill text-bg-danger">Inactive</span>';

            // Update table cells based on your table structure:
            $row.find('td').eq(1).text(vehicle.plate_number); // Plate Number
            $row.find('td').eq(2).text(vehicle.make);        // Make
            $row.find('td').eq(3).text(vehicle.model);       // Model
            $row.find('td').eq(4).text(vehicle.year);        // Year
            $row.find('td').eq(5).html(statusBadge);         // Status
            $row.find('td').eq(6).text(vehicle.gps_device_id); // GPS Device

            // Add a brief highlight effect
            $row.addClass('table-success');
            setTimeout(function() {
                $row.removeClass('table-success');
            }, 2000);
            }
        }



        // Handle delete button click in table (opens modal)
        $(document).on('click', '.btn-delete-vehicle', function(e) {
            e.preventDefault();

            const vehicleId = $(this).data('vehicle-id');
            const vehicleName = $(this).data('vehicle-name'); // Adjust based on your table

            // Set the vehicle info in modal
            $('#deleteVehicleId').val(vehicleId);
            $('#deleteVehicleName').text(vehicleName);

            // Show modal
            $('#deleteConfirmModal').modal('show');
        });


        // Handle the actual delete when confirm button is clicked
        $(document).on('click', '#confirmDeleteBtn', function(e) {
            e.preventDefault();

            const vehicleId = $('#deleteVehicleId').val();

            if (!vehicleId || vehicleId.trim() === '') {
                showAlert('Vehicle ID not found in modal!', 'danger');
                return;
            }

            const deleteUrl = "{{ url('vehicle/destroy') }}/" + vehicleId;
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

                    showAlert(response.message || 'Vehicle deleted successfully', 'success');

                    // Find and remove the deleted row from the table
                    $('button[data-vehicle-id="' + vehicleId + '"]').closest('tr').fadeOut(500,
                        function() {
                            $(this).remove();
                            updateRowNumbers();
                        });
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr);
                    let message = 'Failed to delete vehicle';
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
                    $btn.prop('disabled', false).html('<i class="bi bi-trash"></i> Delete Vehicle');
                }
            });
        });

        // Optional: Function to update row numbers after deletion
        function updateRowNumbers() {
            $('table tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }

        // Handle view vehicle modal
        $('#viewVehicleModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const vehicleId = button.data('vehicle-id');

            if (!vehicleId) {
                showAlert('Vehicle ID not found!', 'danger');
                return;
            }

            // Show loading state
            $(this).find('.modal-body').html(`
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading vehicle details...</p>
        </div>
    `);

            $.ajax({
                url: "{{ url('vehicle/show') }}/" + vehicleId,
                method: 'GET',
                success: function(vehicle) {
                    if (!vehicle || !vehicle.id) {
                        showAlert('No vehicle data found!', 'danger');
                        return;
                    }

                    // Format status badge
                    let statusBadge = vehicle.status === 'active' ?
                        '<span class="badge rounded-pill text-bg-success">Active</span>' :
                        '<span class="badge rounded-pill text-bg-danger">Inactive</span>';

                    // Format joined date
                    let joinedDate = vehicle.joined_date ?
                        new Date(vehicle.joined_date).toLocaleDateString() : 'Not specified';

                    // Update modal content
                    const modalContent = `
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted small">VEHICLE ID</h6>
                            <p class="mb-0 fw-medium">${vehicle.id}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">PLATE NUMBER</h6>
                            <p class="mb-0 fw-medium">${vehicle.plate_number}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">MAKE</h6>
                            <p class="mb-0">${vehicle.make}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">MODEL</h6>
                            <p class="mb-0">${vehicle.model}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted small">YEAR</h6>
                            <p class="mb-0">${vehicle.year}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">GPS DEVICE ID</h6>
                            <p class="mb-0">${vehicle.gps_device_id || 'Not assigned'}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">STATUS</h6>
                            <p class="mb-0">${statusBadge}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="bg-light rounded p-3">
                            <h6 class="mb-3">Additional Info</h6>
                            <p class="text-muted">${vehicle.additional_info || 'No additional info available.'}</p>
                        </div>
                    </div>
                </div>
            `;

                    $('#viewVehicleModal .modal-body').html(modalContent);

                    // Set the vehicle ID on the edit button in the modal footer
                    $('#viewVehicleModal .btn-edit-vehicle').attr('data-vehicle-id', vehicle.id);

                },
                error: function(xhr) {
                    console.error('View vehicle error:', xhr);
                    $('#viewVehicleModal .modal-body').html(`
                <div class="text-center">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                    <h4 class="mt-3 text-danger">Error</h4>
                    <p>Failed to load vehicle details.</p>
                </div>
            `);
                }
            });
        });

        // Handle edit button click from view modal
        $(document).on('click', '#viewVehicleModal .btn-edit-vehicle', function(e) {
            const vehicleId = $(this).attr('data-vehicle-id');

            // Close view modal
            $('#viewVehicleModal').modal('hide');

            // Wait for view modal to close, then open edit modal
            $('#viewVehicleModal').on('hidden.bs.modal', function() {
                // Trigger the edit modal with the vehicle ID
                const editButton = $('<button>').attr('data-vehicle-id', vehicleId);
                $('#editVehicleModal').trigger('show.bs.modal', [{
                    relatedTarget: editButton[0]
                }]);

                // Remove the event handler
                $(this).off('hidden.bs.modal');
            });
        });
    </script>
</x-app-layout>

