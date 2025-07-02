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
                    <h1 class="h3 mb-0">Vehicle Management</h1>
                    <p class="text-muted">Manage your fleet vehicles</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Vehicle
                </button>
            </div>
            
            <!-- Filters -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="typeFilter" class="form-label">Vehicle Type</label>
                            <select class="form-select" id="typeFilter">
                                <option value="">All Types</option>
                                <option value="Truck">Truck</option>
                                <option value="Van">Van</option>
                                <option value="Car">Car</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All Statuses</option>
                                <option value="Active">Active</option>
                                <option value="Offline">Offline</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="searchFilter" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchFilter" placeholder="Search by ID, plate, or driver...">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-primary w-100" id="applyFilters">Apply Filters</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Vehicles Table -->
            <div class="card border-0 shadow">
                <div class="card-body" id="vehiclesTableContainer">
                    @include('partials.vehicles-table')
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewVehicleModalLabel">Vehicle Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Vehicle ID</p>
                            <p class="fw-bold mb-0" id="viewVehicleId"></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Plate Number</p>
                            <p class="fw-bold mb-0" id="viewPlateNumber"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Vehicle Type</p>
                            <p class="fw-bold mb-0" id="viewVehicleType"></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Driver</p>
                            <p class="fw-bold mb-0" id="viewDriverName"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Status</p>
                            <div id="viewStatusContainer"></div>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Last Location</p>
                            <p class="fw-bold mb-0" id="viewLastLocation"></p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="mb-3">Recent Activity</h6>
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Location Update</h6>
                                    <small>3 hours ago</small>
                                </div>
                                <p class="mb-1">Vehicle reported location at New York, NY</p>
                            </div>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Maintenance Check</h6>
                                    <small>1 day ago</small>
                                </div>
                                <p class="mb-1">Completed maintenance check</p>
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
            
            // AJAX form submission for adding a new vehicle
            window.gpsAjax.submitFormAjax('addVehicleForm', '{{ url('vehicle/store') }}', function(data) {
                // Refresh the vehicles table
                window.gpsAjax.loadContent('{{ url('vehicles/table') }}', 'vehiclesTableContainer', function() {
                    // Re-initialize tooltips after table refresh
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    });
                });
                
                // Reset the form
                document.getElementById('addVehicleForm').reset();
            });
            
            // AJAX form submission for editing a vehicle
            window.gpsAjax.submitFormAjax('editVehicleForm', '{{ url('vehicle/update') }}', function(data) {
                // Refresh the vehicles table
                window.gpsAjax.loadContent('{{ url('vehicles/table') }}', 'vehiclesTableContainer', function() {
                    // Re-initialize tooltips after table refresh
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    });
                });
            });
            
            // AJAX form submission for deleting a vehicle
            document.getElementById('deleteVehicleForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const form = this;
                const url = form.getAttribute('action');
                
                window.gpsAjax.performAction(url, 'DELETE', {}, function(data) {
                    // Close the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                    modal.hide();
                    
                    // Refresh the vehicles table
                    window.gpsAjax.loadContent('{{ url('vehicles/table') }}', 'vehiclesTableContainer', function() {
                        // Re-initialize tooltips after table refresh
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                        tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl)
                        });
                    });
                });
            });
        });
    </script>
</x-app-layout>




