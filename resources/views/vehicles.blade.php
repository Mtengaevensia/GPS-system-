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
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
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
                                    <option value="Active">Active</option>
                                    <option value="Offline">Offline</option>
                                    <option value="Maintenance">Maintenance</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="typeFilter" class="form-label small text-muted">Vehicle Type</label>
                                <select class="form-select" id="typeFilter" name="type">
                                    <option value="">All Types</option>
                                    <option value="Truck">Truck</option>
                                    <option value="Van">Van</option>
                                    <option value="Car">Car</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="searchPlate" class="form-label small text-muted">Plate Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="searchPlate" name="search" placeholder="Search plate number...">
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

            <!-- Vehicles Table -->
            <div class="card border-0 shadow">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">#</th>
                                    <th scope="col">Plate Number</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Assigned Driver</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Last Location</th>
                                    <th scope="col" class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehicles as $vehicle)
                                <tr>
                                    <td class="ps-4">{{ $vehicle['id'] }}</td>
                                    <td class="fw-medium">{{ $vehicle['plate_number'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($vehicle['type'] == 'Truck')
                                                <i class="bi bi-truck me-2 text-muted"></i>
                                            @elseif($vehicle['type'] == 'Van')
                                                <i class="bi bi-truck me-2 text-muted"></i>
                                            @else
                                                <i class="bi bi-car-front me-2 text-muted"></i>
                                            @endif
                                            {{ $vehicle['type'] }}
                                        </div>
                                    </td>
                                    <td>{{ $vehicle['driver'] }}</td>
                                    <td>
                                        @if($vehicle['status'] == 'Active')
                                            <span class="badge rounded-pill text-bg-success">Active</span>
                                        @elseif($vehicle['status'] == 'Offline')
                                            <span class="badge rounded-pill text-bg-danger">Offline</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-warning">Maintenance</span>
                                        @endif
                                    </td>
                                    <td>{{ $vehicle['location'] }}</td>
                                    <td class="text-end pe-4">
                                        <button type="button" class="btn btn-sm btn-info me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewVehicleModal" 
                                            data-bs-id="{{ $vehicle['id'] }}"
                                            data-bs-plate="{{ $vehicle['plate_number'] }}"
                                            data-bs-type="{{ $vehicle['type'] }}"
                                            data-bs-driver="{{ $vehicle['driver'] }}"
                                            data-bs-status="{{ $vehicle['status'] }}"
                                            data-bs-location="{{ $vehicle['location'] }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editVehicleModal"
                                            data-bs-id="{{ $vehicle['id'] }}"
                                            data-bs-plate="{{ $vehicle['plate_number'] }}"
                                            data-bs-type="{{ $vehicle['type'] }}"
                                            data-bs-driver="{{ $vehicle['driver'] }}"
                                            data-bs-status="{{ $vehicle['status'] }}"
                                            data-bs-location="{{ $vehicle['location'] }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" title="Track Live">
                                            <i class="bi bi-geo-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteConfirmModal"
                                            data-bs-id="{{ $vehicle['id'] }}"
                                            data-bs-plate="{{ $vehicle['plate_number'] }}">
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

    <!-- Add Vehicle Modal -->
    <div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVehicleModalLabel">Add New Vehicle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addVehicleForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="plateNumber" class="form-label">Plate Number</label>
                                <input type="text" class="form-control" id="plateNumber" required>
                            </div>
                            <div class="col-md-6">
                                <label for="vehicleType" class="form-label">Vehicle Type</label>
                                <select class="form-select" id="vehicleType" required>
                                    <option value="">Select Type</option>
                                    <option value="Truck">Truck</option>
                                    <option value="Van">Van</option>
                                    <option value="Car">Car</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="driverName" class="form-label">Assigned Driver</label>
                                <input type="text" class="form-control" id="driverName">
                            </div>
                            <div class="col-md-6">
                                <label for="vehicleStatus" class="form-label">Status</label>
                                <select class="form-select" id="vehicleStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Offline">Offline</option>
                                    <option value="Maintenance">Maintenance</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="lastLocation" class="form-label">Last Known Location</label>
                                <input type="text" class="form-control" id="lastLocation">
                            </div>
                            <div class="col-md-6">
                                <label for="vehicleModel" class="form-label">Model</label>
                                <input type="text" class="form-control" id="vehicleModel">
                            </div>
                            <div class="col-md-6">
                                <label for="yearManufactured" class="form-label">Year</label>
                                <input type="number" class="form-control" id="yearManufactured" min="1990" max="2030">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveNewVehicle">Save Vehicle</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Vehicle Modal -->
    <div class="modal fade" id="editVehicleModal" tabindex="-1" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVehicleModalLabel">Edit Vehicle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editVehicleForm">
                        <input type="hidden" id="editVehicleId">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="editPlateNumber" class="form-label">Plate Number</label>
                                <input type="text" class="form-control" id="editPlateNumber" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editVehicleType" class="form-label">Vehicle Type</label>
                                <select class="form-select" id="editVehicleType" required>
                                    <option value="">Select Type</option>
                                    <option value="Truck">Truck</option>
                                    <option value="Van">Van</option>
                                    <option value="Car">Car</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editDriverName" class="form-label">Assigned Driver</label>
                                <input type="text" class="form-control" id="editDriverName">
                            </div>
                            <div class="col-md-6">
                                <label for="editVehicleStatus" class="form-label">Status</label>
                                <select class="form-select" id="editVehicleStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Offline">Offline</option>
                                    <option value="Maintenance">Maintenance</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="editLastLocation" class="form-label">Last Known Location</label>
                                <input type="text" class="form-control" id="editLastLocation">
                            </div>
                            <div class="col-md-6">
                                <label for="editVehicleModel" class="form-label">Model</label>
                                <input type="text" class="form-control" id="editVehicleModel">
                            </div>
                            <div class="col-md-6">
                                <label for="editYearManufactured" class="form-label">Year</label>
                                <input type="number" class="form-control" id="editYearManufactured" min="1990" max="2030">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateVehicle">Update Vehicle</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Vehicle Modal -->
    <div class="modal fade" id="viewVehicleModal" tabindex="-1" aria-labelledby="viewVehicleModalLabel" aria-hidden="true">
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
                                <h6 class="text-muted small">VEHICLE TYPE</h6>
                                <p class="mb-0" id="viewVehicleType"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">ASSIGNED DRIVER</h6>
                                <p class="mb-0" id="viewDriverName"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted small">STATUS</h6>
                                <p class="mb-0" id="viewStatusContainer"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">LAST KNOWN LOCATION</h6>
                                <p class="mb-0" id="viewLastLocation"></p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted small">LAST UPDATED</h6>
                                <p class="mb-0 text-muted">Today at 10:23 AM</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bg-light rounded p-3">
                                <h6 class="mb-3">Recent Activity</h6>
                                <div class="d-flex mb-2">
                                    <div class="flex-shrink-0">
                                        <div class="p-2 rounded-circle bg-success-subtle">
                                            <i class="bi bi-check text-success small"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <p class="mb-0 small">Started trip from Nairobi CBD to Westlands</p>
                                        <p class="mb-0 small text-muted">Today at 08:15 AM</p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="p-2 rounded-circle bg-primary-subtle">
                                            <i class="bi bi-geo-alt text-primary small"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <p class="mb-0 small">Completed maintenance check</p>
                                        <p class="mb-0 small text-muted">Yesterday at 02:30 PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editVehicleModal">Edit Vehicle</button>
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
                    <p>Are you sure you want to delete vehicle <span id="deleteVehiclePlate" class="fw-bold"></span>?</p>
                    <p class="text-danger mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteVehicleForm" action="" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Vehicle</button>
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
            
            // View Vehicle Modal
            const viewVehicleModal = document.getElementById('viewVehicleModal')
            if (viewVehicleModal) {
                viewVehicleModal.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const plate = button.getAttribute('data-bs-plate')
                    const type = button.getAttribute('data-bs-type')
                    const driver = button.getAttribute('data-bs-driver')
                    const status = button.getAttribute('data-bs-status')
                    const location = button.getAttribute('data-bs-location')
                    
                    // Update the modal's content
                    document.getElementById('viewVehicleId').textContent = id
                    document.getElementById('viewPlateNumber').textContent = plate
                    document.getElementById('viewVehicleType').textContent = type
                    document.getElementById('viewDriverName').textContent = driver
                    document.getElementById('viewLastLocation').textContent = location
                    
                    // Status badge
                    const statusContainer = document.getElementById('viewStatusContainer')
                    let badgeClass = 'badge rounded-pill '
                    
                    if (status === 'Active') {
                        badgeClass += 'text-bg-success'
                    } else if (status === 'Offline') {
                        badgeClass += 'text-bg-danger'
                    } else {
                        badgeClass += 'text-bg-warning'
                    }
                    
                    statusContainer.innerHTML = `<span class="${badgeClass}">${status}</span>`
                })
            }
            
            // Edit Vehicle Modal
            const editVehicleModal = document.getElementById('editVehicleModal')
            if (editVehicleModal) {
                editVehicleModal.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const plate = button.getAttribute('data-bs-plate')
                    const type = button.getAttribute('data-bs-type')
                    const driver = button.getAttribute('data-bs-driver')
                    const status = button.getAttribute('data-bs-status')
                    const location = button.getAttribute('data-bs-location')
                    
                    // Update the modal's content
                    document.getElementById('editVehicleId').value = id
                    document.getElementById('editPlateNumber').value = plate
                    document.getElementById('editVehicleType').value = type
                    document.getElementById('editDriverName').value = driver
                    document.getElementById('editVehicleStatus').value = status
                    document.getElementById('editLastLocation').value = location
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
                    const plate = button.getAttribute('data-bs-plate')
                    
                    // Update the modal's content
                    document.getElementById('deleteVehiclePlate').textContent = plate
                    document.getElementById('deleteVehicleForm').action = `{{ url('vehicle/destroy') }}/${id}`
                })
            }
            
            // Save new vehicle
            document.getElementById('saveNewVehicle').addEventListener('click', function() {
                // Here you would normally submit the form via AJAX
                // For demo purposes, we'll just close the modal and show a success message
                const addModal = bootstrap.Modal.getInstance(document.getElementById('addVehicleModal'))
                addModal.hide()
                
                // Show success message (you could use a toast or alert)
                alert('Vehicle added successfully!')
            })
            
            // Update vehicle
            document.getElementById('updateVehicle').addEventListener('click', function() {
                // Here you would normally submit the form via AJAX
                // For demo purposes, we'll just close the modal and show a success message
                const editModal = bootstrap.Modal.getInstance(document.getElementById('editVehicleModal'))
                editModal.hide()
                
                // Show success message (you could use a toast or alert)
                alert('Vehicle updated successfully!')
            })
        });
    </script>
</x-app-layout>


