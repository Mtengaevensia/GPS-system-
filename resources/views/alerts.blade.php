<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Alerts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Alerts</h1>
                    <p class="text-muted">Manage and monitor all system alerts.</p>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addAlertModal">
                    <i class="bi bi-plus-lg me-2"></i> Add Alert
                </button>
            </div>

            <!-- Filters and Search -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body p-4">
                    <form action="{{ url('alerts/index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-12 col-md-3">
                                <label for="severityFilter" class="form-label small text-muted">Severity</label>
                                <select class="form-select" id="severityFilter" name="severity">
                                    <option value="">All Severities</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="typeFilter" class="form-label small text-muted">Alert Type</label>
                                <select class="form-select" id="typeFilter" name="type">
                                    <option value="">All Types</option>
                                    <option value="Overspeed">Overspeed</option>
                                    <option value="GeoFence">GeoFence</option>
                                    <option value="Offline">Offline</option>
                                    <option value="Idle">Idle</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Fuel">Fuel</option>
                                    <option value="Battery">Battery</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="searchAlert" class="form-label small text-muted">Search</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="searchAlert" name="search" placeholder="Search by vehicle, message, or ID...">
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

            <!-- Alerts Table -->
            <div class="card border-0 shadow">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">Alert ID</th>
                                    <th scope="col">Vehicle</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Timestamp</th>
                                    <th scope="col">Severity</th>
                                    <th scope="col" class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alerts as $alert)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $alert['id'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($alert['vehicle_type'] == 'Truck')
                                                <i class="bi bi-truck me-2 text-muted"></i>
                                            @elseif($alert['vehicle_type'] == 'Van')
                                                <i class="bi bi-truck me-2 text-muted"></i>
                                            @else
                                                <i class="bi bi-car-front me-2 text-muted"></i>
                                            @endif
                                            {{ $alert['vehicle_id'] }}
                                        </div>
                                    </td>
                                    <td>{{ $alert['type'] }}</td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 250px;">
                                            {{ $alert['message'] }}
                                        </div>
                                    </td>
                                    <td>{{ date('M d, Y H:i', strtotime($alert['timestamp'])) }}</td>
                                    <td>
                                        @if($alert['severity'] == 'High')
                                            <span class="badge rounded-pill text-bg-danger">High</span>
                                        @elseif($alert['severity'] == 'Medium')
                                            <span class="badge rounded-pill text-bg-warning">Medium</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-success">Low</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button type="button" class="btn btn-sm btn-info me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewAlertModal" 
                                            data-bs-id="{{ $alert['id'] }}"
                                            data-bs-vehicle="{{ $alert['vehicle_id'] }}"
                                            data-bs-vehicle-type="{{ $alert['vehicle_type'] }}"
                                            data-bs-type="{{ $alert['type'] }}"
                                            data-bs-message="{{ $alert['message'] }}"
                                            data-bs-timestamp="{{ $alert['timestamp'] }}"
                                            data-bs-severity="{{ $alert['severity'] }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editAlertModal"
                                            data-bs-id="{{ $alert['id'] }}"
                                            data-bs-vehicle="{{ $alert['vehicle_id'] }}"
                                            data-bs-type="{{ $alert['type'] }}"
                                            data-bs-message="{{ $alert['message'] }}"
                                            data-bs-timestamp="{{ $alert['timestamp'] }}"
                                            data-bs-severity="{{ $alert['severity'] }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteConfirmModal"
                                            data-bs-id="{{ $alert['id'] }}"
                                            data-bs-vehicle="{{ $alert['vehicle_id'] }}">
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

    <!-- View Alert Modal -->
    <div class="modal fade" id="viewAlertModal" tabindex="-1" aria-labelledby="viewAlertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAlertModalLabel">Alert Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Alert ID</h6>
                            <p class="fs-5 fw-medium" id="viewAlertId"></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="text-muted mb-1">Severity</h6>
                            <div id="viewSeverityContainer"></div>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-1">Vehicle</h6>
                                <div class="d-flex align-items-center">
                                    <div id="viewVehicleIcon" class="me-2"></div>
                                    <p class="mb-0" id="viewVehicleId"></p>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="text-muted mb-1">Alert Type</h6>
                                <p class="mb-0" id="viewAlertType"></p>
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="text-muted mb-1">Timestamp</h6>
                                <p class="mb-0" id="viewTimestamp"></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-1">Message</h6>
                                <p class="mb-0" id="viewMessage"></p>
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="text-muted mb-1">Recommended Action</h6>
                                <p class="mb-0 text-muted">Based on the alert type and severity, the system recommends the following action:</p>
                                <p class="mb-0 mt-2" id="viewRecommendedAction"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editAlertModal">Edit Alert</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Alert Modal -->
    <div class="modal fade" id="addAlertModal" tabindex="-1" aria-labelledby="addAlertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAlertModalLabel">Add New Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAlertForm" action="{{ url('alerts/store') }}" method="POST">
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
                                <label for="alertType" class="form-label">Alert Type</label>
                                <select class="form-select" id="alertType" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="Overspeed">Overspeed</option>
                                    <option value="GeoFence">GeoFence</option>
                                    <option value="Offline">Offline</option>
                                    <option value="Idle">Idle</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Fuel">Fuel</option>
                                    <option value="Battery">Battery</option>
                                </select>
                            </div>
                            
                            <div class="col-12">
                                <label for="alertMessage" class="form-label">Message</label>
                                <textarea class="form-control" id="alertMessage" name="message" rows="3" required></textarea>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="alertSeverity" class="form-label">Severity</label>
                                <select class="form-select" id="alertSeverity" name="severity" required>
                                    <option value="">Select Severity</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="alertTimestamp" class="form-label">Timestamp</label>
                                <input type="datetime-local" class="form-control" id="alertTimestamp" name="timestamp" value="{{ date('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveNewAlert">Save Alert</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Alert Modal -->
    <div class="modal fade" id="editAlertModal" tabindex="-1" aria-labelledby="editAlertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAlertModalLabel">Edit Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAlertForm" action="{{ url('alerts/update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editAlertId" name="id">
                        
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
                                <label for="editAlertType" class="form-label">Alert Type</label>
                                <select class="form-select" id="editAlertType" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="Overspeed">Overspeed</option>
                                    <option value="GeoFence">GeoFence</option>
                                    <option value="Offline">Offline</option>
                                    <option value="Idle">Idle</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Fuel">Fuel</option>
                                    <option value="Battery">Battery</option>
                                </select>
                            </div>
                            
                            <div class="col-12">
                                <label for="editAlertMessage" class="form-label">Message</label>
                                <textarea class="form-control" id="editAlertMessage" name="message" rows="3" required></textarea>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="editAlertSeverity" class="form-label">Severity</label>
                                <select class="form-select" id="editAlertSeverity" name="severity" required>
                                    <option value="">Select Severity</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="editAlertTimestamp" class="form-label">Timestamp</label>
                                <input type="datetime-local" class="form-control" id="editAlertTimestamp" name="timestamp" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateAlert">Update Alert</button>
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
                    <p>Are you sure you want to delete the alert for vehicle <span id="deleteAlertVehicle" class="fw-bold"></span>?</p>
                    <p class="text-danger mb-0"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteAlertForm" action="{{ url('alerts/destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Alert</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
            
            // Get recommended action based on alert type and severity
            function getRecommendedAction(type, severity) {
                if (type === 'Overspeed' && severity === 'High') {
                    return 'Contact driver immediately and instruct to reduce speed. Check for pattern of behavior.';
                } else if (type === 'GeoFence') {
                    return 'Verify vehicle location and contact driver to confirm reason for deviation from route.';
                } else if (type === 'Offline') {
                    return 'Check device connectivity. If persists, dispatch technician to inspect GPS unit.';
                } else if (type === 'Idle' && severity === 'Low') {
                    return 'Monitor situation. Contact driver if idle time exceeds 1 hour.';
                } else if (type === 'Maintenance') {
                    return 'Schedule vehicle for maintenance service at earliest convenience.';
                } else if (type === 'Fuel' && severity === 'High') {
                    return 'Investigate potential fuel theft. Compare with driver logs and receipts.';
                } else if (type === 'Battery') {
                    return 'Schedule battery check. Consider replacement if vehicle is over 3 years old.';
                } else {
                    return 'Review alert details and take appropriate action based on company policy.';
                }
            }
            
            // View Alert Modal
            const viewAlertModal = document.getElementById('viewAlertModal')
            if (viewAlertModal) {
                viewAlertModal.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const vehicle = button.getAttribute('data-bs-vehicle')
                    const vehicleType = button.getAttribute('data-bs-vehicle-type')
                    const type = button.getAttribute('data-bs-type')
                    const message = button.getAttribute('data-bs-message')
                    const timestamp = button.getAttribute('data-bs-timestamp')
                    const severity = button.getAttribute('data-bs-severity')
                    
                    // Update the modal's content
                    document.getElementById('viewAlertId').textContent = id
                    document.getElementById('viewVehicleId').textContent = vehicle
                    document.getElementById('viewAlertType').textContent = type
                    document.getElementById('viewMessage').textContent = message
                    document.getElementById('viewTimestamp').textContent = new Date(timestamp).toLocaleString()
                    document.getElementById('viewRecommendedAction').textContent = getRecommendedAction(type, severity)
                    
                    // Vehicle icon
                    const vehicleIcon = document.getElementById('viewVehicleIcon')
                    if (vehicleType === 'Truck' || vehicleType === 'Van') {
                        vehicleIcon.innerHTML = '<i class="bi bi-truck text-muted"></i>'
                    } else {
                        vehicleIcon.innerHTML = '<i class="bi bi-car-front text-muted"></i>'
                    }
                    
                    // Severity badge
                    const severityContainer = document.getElementById('viewSeverityContainer')
                    if (severity === 'High') {
                        severityContainer.innerHTML = '<span class="badge rounded-pill text-bg-danger">High</span>'
                    } else if (severity === 'Medium') {
                        severityContainer.innerHTML = '<span class="badge rounded-pill text-bg-warning">Medium</span>'
                    } else {
                        severityContainer.innerHTML = '<span class="badge rounded-pill text-bg-success">Low</span>'
                    }
                })
            }
            
            // Edit Alert Modal
            const editAlertModal = document.getElementById('editAlertModal')
            if (editAlertModal) {
                editAlertModal.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const vehicle = button.getAttribute('data-bs-vehicle')
                    const type = button.getAttribute('data-bs-type')
                    const message = button.getAttribute('data-bs-message')
                    const timestamp = button.getAttribute('data-bs-timestamp')
                    const severity = button.getAttribute('data-bs-severity')
                    
                    // Update the modal's content
                    document.getElementById('editAlertId').value = id
                    document.getElementById('editVehicleSelect').value = vehicle
                    document.getElementById('editAlertType').value = type
                    document.getElementById('editAlertMessage