<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trips') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Trips</h1>
                    <p class="text-muted">Manage and monitor all trips in the system.</p>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addTripModal">
                    <i class="bi bi-plus-lg me-2"></i> Add Trip
                </button>
            </div>

            <!-- Filters and Search -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body p-4">
                    <form action="{{ url('trips/index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-12 col-md-3">
                                <label for="statusFilter" class="form-label small text-muted">Status</label>
                                <select class="form-select" id="statusFilter" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="Completed">Completed</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Delayed">Delayed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="dateFilter" class="form-label small text-muted">Date Range</label>
                                <select class="form-select" id="dateFilter" name="date_range">
                                    <option value="today">Today</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="last_7_days">Last 7 Days</option>
                                    <option value="last_30_days">Last 30 Days</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="searchTrip" class="form-label small text-muted">Search</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="searchTrip" name="search" placeholder="Search by vehicle, driver, or location...">
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

            <!-- Trips Table -->
            <div class="card border-0 shadow">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">Trip ID</th>
                                    <th scope="col">Vehicle</th>
                                    <th scope="col">Driver</th>
                                    <th scope="col">Start Location</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Distance</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col" class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trips as $trip)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $trip['id'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($trip['vehicle_type'] == 'Truck')
                                                <i class="bi bi-truck me-2 text-muted"></i>
                                            @elseif($trip['vehicle_type'] == 'Van')
                                                <i class="bi bi-truck me-2 text-muted"></i>
                                            @else
                                                <i class="bi bi-car-front me-2 text-muted"></i>
                                            @endif
                                            {{ $trip['vehicle_id'] }}
                                        </div>
                                    </td>
                                    <td>{{ $trip['driver'] }}</td>
                                    <td>{{ $trip['start_location'] }}</td>
                                    <td>{{ $trip['destination'] }}</td>
                                    <td>{{ $trip['distance'] }}</td>
                                    <td>
                                        @if($trip['status'] == 'Completed')
                                            <span class="badge rounded-pill text-bg-success">Completed</span>
                                        @elseif($trip['status'] == 'In Progress')
                                            <span class="badge rounded-pill text-bg-primary">In Progress</span>
                                        @elseif($trip['status'] == 'Delayed')
                                            <span class="badge rounded-pill text-bg-warning">Delayed</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>{{ date('M d, Y H:i', strtotime($trip['date'])) }}</td>
                                    <td class="text-end pe-4">
                                        <button type="button" class="btn btn-sm btn-info me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewTripModal" 
                                            data-bs-id="{{ $trip['id'] }}"
                                            data-bs-vehicle="{{ $trip['vehicle_id'] }}"
                                            data-bs-vehicle-type="{{ $trip['vehicle_type'] }}"
                                            data-bs-driver="{{ $trip['driver'] }}"
                                            data-bs-start="{{ $trip['start_location'] }}"
                                            data-bs-destination="{{ $trip['destination'] }}"
                                            data-bs-distance="{{ $trip['distance'] }}"
                                            data-bs-status="{{ $trip['status'] }}"
                                            data-bs-date="{{ $trip['date'] }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editTripModal"
                                            data-bs-id="{{ $trip['id'] }}"
                                            data-bs-vehicle="{{ $trip['vehicle_id'] }}"
                                            data-bs-driver="{{ $trip['driver'] }}"
                                            data-bs-start="{{ $trip['start_location'] }}"
                                            data-bs-destination="{{ $trip['destination'] }}"
                                            data-bs-distance="{{ $trip['distance'] }}"
                                            data-bs-status="{{ $trip['status'] }}"
                                            data-bs-date="{{ $trip['date'] }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteConfirmModal"
                                            data-bs-id="{{ $trip['id'] }}"
                                            data-bs-vehicle="{{ $trip['vehicle_id'] }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Trip Modal -->
    <div class="modal fade" id="addTripModal" tabindex="-1" aria-labelledby="addTripModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTripModalLabel">Add New Trip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTripForm" action="{{ url('trips/store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="vehicleSelect" class="form-label">Vehicle</label>
                                <select class="form-select" id="vehicleSelect" name="vehicle_id" required>
                                    <option value="">Select Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle['id'] }}">{{ $vehicle['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="driverSelect" class="form-label">Driver</label>
                                <select class="form-select" id="driverSelect" name="driver_id" required>
                                    <option value="">Select Driver</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{ $driver['id'] }}">{{ $driver['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="startLocation" class="form-label">Start Location</label>
                                <input type="text" class="form-control" id="startLocation" name="start_location" required>
                            </div>
                            <div class="col-md-6">
                                <label for="destination" class="form-label">Destination</label>
                                <input type="text" class="form-control" id="destination" name="destination" required>
                            </div>
                            <div class="col-md-4">
                                <label for="distance" class="form-label">Distance</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="distance" name="distance" min="1" required>
                                    <span class="input-group-text">km</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="tripStatus" class="form-label">Status</label>
                                <select class="form-select" id="tripStatus" name="status" required>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Delayed">Delayed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="tripDate" class="form-label">Date & Time</label>
                                <input type="datetime-local" class="form-control" id="tripDate" name="date" required>
                            </div>
                            <div class="col-12">
                                <label for="tripNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="tripNotes" name="notes" rows="2"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveNewTrip">Save Trip</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Trip Modal -->
    <div class="modal fade" id="editTripModal" tabindex="-1" aria-labelledby="editTripModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTripModalLabel">Edit Trip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTripForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editTripId" name="id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="editVehicleSelect" class="form-label">Vehicle</label>
                                <select class="form-select" id="editVehicleSelect" name="vehicle_id" required>
                                    <option value="">Select Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle['id'] }}">{{ $vehicle['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editDriverSelect" class="form-label">Driver</label>
                                <select class="form-select" id="editDriverSelect" name="driver_id" required>
                                    <option value="">Select Driver</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{ $driver['id'] }}">{{ $driver['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editStartLocation" class="form-label">Start Location</label>
                                <input type="text" class="form-control" id="editStartLocation" name="start_location" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editDestination" class="form-label">Destination</label>
                                <input type="text" class="form-control" id="editDestination" name="destination" required>
                            </div>
                            <div class="col-md-4">
                                <label for="editDistance" class="form-label">Distance</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="editDistance" name="distance" min="1" required>
                                    <span class="input-group-text">km</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="editTripStatus" class="form-label">Status</label>
                                <select class="form-select" id="editTripStatus" name="status" required>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Delayed">Delayed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="editTripDate" class="form-label">Date & Time</label>
                                <input type="datetime-local" class="form-control" id="editTripDate" name="date" required>
                            </div>
                            <div class="col-12">
                                <label for="editTripNotes" class="form-label">Notes</label>
                                <textarea class="form-control" id="editTripNotes" name="notes" rows="2"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateTrip">Update Trip</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Trip Modal -->
    <div class="modal fade" id="viewTripModal" tabindex="-1" aria-labelledby="viewTripModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTripModalLabel">Trip Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted small">TRIP ID</h6>
                                <p class="mb-0 fw-medium" id="viewTripId"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">VEHICLE</h6>
                                <p class="mb-0 d-flex align-items-center" id="viewVehicle">
                                    <span id="viewVehicleIcon" class="me-2"></span>
                                    <span id="viewVehicleId"></span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">DRIVER</h6>
                                <p class="mb-0" id="viewDriver"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">DATE & TIME</h6>
                                <p class="mb-0" id="viewDate"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted small">STATUS</h6>
                                <p class="mb-0" id="viewStatusContainer"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">START LOCATION</h6>
                                <p class="mb-0" id="viewStartLocation"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">DESTINATION</h6>
                                <p class="mb-0" id="viewDestination"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">DISTANCE</h6>
                                <p class="mb-0" id="viewDistance"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bg-light rounded p-3">
                                <h6 class="mb-3">Trip Route</h6>
                                <div class="bg-white rounded p-2" style="height: 200px;">
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <div class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#adb5bd" class="mb-3">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                            </svg>
                                            <p class="text-muted">Map loading... <br>Showing trip route</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editTripModal">Edit Trip</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete trip for vehicle <span id="deleteTripVehicle" class="fw-bold"></span>?</p>
                    <p class="text-danger mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteTripForm" action="" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Trip</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize tooltips and modals -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Format date for datetime-local input
            function formatDateForInput(dateString) {
                const date = new Date(dateString);
                return date.toISOString().slice(0, 16);
            }
            
            // View Trip Modal
            const viewTripModal = document.getElementById('viewTripModal')
            if (viewTripModal) {
                viewTripModal.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const vehicle = button.getAttribute('data-bs-vehicle')
                    const vehicleType = button.getAttribute('data-bs-vehicle-type')
                    const driver = button.getAttribute('data-bs-driver')
                    const start = button.getAttribute('data-bs-start')
                    const destination = button.getAttribute('data-bs-destination')
                    const distance = button.getAttribute('data-bs-distance')
                    const status = button.getAttribute('data-bs-status')
                    const date = button.getAttribute('data-bs-date')
                    
                    // Update the modal's content
                    document.getElementById('viewTripId').textContent = id
                    document.getElementById('viewVehicleId').textContent = vehicle
                    document.getElementById('viewDriver').textContent = driver
                    document.getElementById('viewStartLocation').textContent = start
                    document.getElementById('viewDestination').textContent = destination
                    document.getElementById('viewDistance').textContent = distance
                    document.getElementById('viewDate').textContent = new Date(date).toLocaleString()
                    
                    // Vehicle icon
                    const vehicleIcon = document.getElementById('viewVehicleIcon')
                    if (vehicleType === 'Truck' || vehicleType === 'Van') {
                        vehicleIcon.innerHTML = '<i class="bi bi-truck text-muted"></i>'
                    } else {
                        vehicleIcon.innerHTML = '<i class="bi bi-car-front text-muted"></i>'
                    }
                    
                    // Status badge
                    const statusContainer = document.getElementById('viewStatusContainer')
                    if (status === 'Completed') {
                        statusContainer.innerHTML = '<span class="badge rounded-pill text-bg-success">Completed</span>'
                    } else if (status === 'In Progress') {
                        statusContainer.innerHTML = '<span class="badge rounded-pill text-bg-primary">In Progress</span>'
                    } else if (status === 'Delayed') {
                        statusContainer.innerHTML = '<span class="badge rounded-pill text-bg-warning">Delayed</span>'
                    } else {
                        statusContainer.innerHTML = '<span class="badge rounded-pill text-bg-danger">Cancelled</span>'
                    }
                })
            }
            
            // Edit Trip Modal
            const editTripModal = document.getElementById('editTripModal')
            if (editTripModal) {
                editTripModal.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const vehicle = button.getAttribute('data-bs-vehicle')
                    const driver = button.getAttribute('data-bs-driver')
                    const start = button.getAttribute('data-bs-start')
                    const destination = button.getAttribute('data-bs-destination')
                    const distance = button.getAttribute('data-bs-distance')
                    const status = button.getAttribute('data-bs-status')
                    const date = button.getAttribute('data-bs-date')
                    
                    // Update the modal's content
                    document.getElementById('editTripId').value = id
                    document.getElementById('editVehicleSelect').value = vehicle
                    
                    // Find the driver option by name
                    const driverSelect = document.getElementById('editDriverSelect')
                    for (let i = 0; i < driverSelect.options.length; i++) {
                        if (driverSelect.options[i].text === driver) {
                            driverSelect.selectedIndex = i
                            break
                        }
                    }
                    
                    document.getElementById('editStartLocation').value = start
                    document.getElementById('editDestination').value = destination
                    document.getElementById('editDistance').value = distance.replace(' km', '')
                    document.getElementById('editTripStatus').value = status
                    document.getElementById('editTripDate').value = formatDateForInput(date)
                    
                    // Update form action
                    document.getElementById('editTripForm').action = `{{ url('trips/update') }}/${id}`
                })
            }
            
            // Delete Confirmation Modal
            const deleteConfirmModal = document.getElementById('deleteConfirmModal')
            if (deleteConfirmModal) {
                deleteConfirmModal.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const vehicle = button.getAttribute('data-bs-vehicle')
                    
                    // Update the modal's content
                    document.getElementById('deleteTripVehicle').textContent = vehicle
                    document.getElementById('deleteTripForm').action = `{{ url('trips/destroy') }}/${id}`
                })
            }
            
            // Save new trip
            document.getElementById('saveNewTrip').addEventListener('click', function() {
                document.getElementById('addTripForm').submit()
            })
            
            // Update trip
            document.getElementById('updateTrip').addEventListener('click', function() {
                // Here you would normally submit the form via AJAX
                // For demo purposes, we'll just close the modal and show a success message
                const editModal = bootstrap.Modal.getInstance(document.getElementById('editTripModal'))
                editModal.hide()
                
                // Show success message (you could use a toast or alert)
                alert('Trip updated successfully!')
            })
        });
    </script>
</x-app-layout>

