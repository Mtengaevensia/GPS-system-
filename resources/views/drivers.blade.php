<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Drivers') }}
        </h2>
    </x-slot>


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-4 auto-dismiss" style="z-index: 1055; min-width: 300px;" role="alert">
            {{ session('success') }}
            <div class="progress mt-2" style="height: 3px;">
                <div class="progress-bar bg-success" id="successProgressBar" style="width: 100%; transition: width 0.1s linear;"></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-4 auto-dismiss" style="z-index: 1055; min-width: 300px;" role="alert">
            {{ session('error') }}
            <div class="progress mt-2" style="height: 3px;">
                <div class="progress-bar bg-danger" id="errorProgressBar" style="width: 100%; transition: width 0.1s linear;"></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-4 mx-4 auto-dismiss" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const duration = 4000; // ms
            document.querySelectorAll('.auto-dismiss').forEach(function (el) {
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
                            setTimeout(function () {
                                el.remove();
                            }, 500);
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

                if (progressBar) {
                    startTimer();
                } else {
                    timer = setTimeout(function () {
                        el.classList.remove('show');
                        setTimeout(function () {
                            el.remove();
                        }, 500);
                    }, duration);
                    el.addEventListener('mouseenter', function () {
                        clearTimeout(timer);
                    });
                    el.addEventListener('mouseleave', function () {
                        timer = setTimeout(function () {
                            el.classList.remove('show');
                            setTimeout(function () {
                                el.remove();
                            }, 500);
                        }, duration - elapsed);
                    });
                }
            });
        });
    </script>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Drivers</h1>
                    <p class="text-muted">Manage and monitor all drivers in the system.</p>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addDriverModal">
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
                                    <input type="text" class="form-control border-start-0" id="searchName" name="search" placeholder="Search by name, license, or phone...">
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
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
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
                                @foreach($drivers as $driver)
                                <tr>
                                    <td class="ps-4">{{ $driver['id'] }}</td>
                                    <td class="fw-medium">{{ $driver['name'] }}</td>
                                    <td>{{ $driver['license_number'] }}</td>
                                    <td>{{ $driver['phone'] }}</td>
                                    <td>
                                        @if($driver['status'] == 'Active')
                                            <span class="badge rounded-pill text-bg-success">Active</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button type="button" class="btn btn-sm btn-info me-1" >
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
    data-bs-toggle="modal"
    data-bs-target="#deleteConfirmModal"
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

    <!-- Add Driver Modal -->
    <div class="modal fade" id="addDriverModal" tabindex="-1" aria-labelledby="addDriverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDriverModalLabel">Add New Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDriverForm" action="{{ url('driver/store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="licenseNumber" class="form-label">License Number</label>
                                <input type="text" class="form-control" id="licenseNumber" name="license_number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phoneNumber" name="phone" required>
                            </div>
                            <div class="col-md-6">
                                <label for="emailAddress" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="emailAddress" name="email" required>
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
                        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveNewDriver">Save Driver</button>
                </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Edit Driver Modal -->
    <div class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="editDriverModalLabel" aria-hidden="true">
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
                        <input type="hidden" id="editDriverId" name="id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="editFullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="editFullName" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editLicenseNumber" class="form-label">License Number</label>
                                <input type="text" class="form-control" id="editLicenseNumber" name="license_number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editPhoneNumber" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="editPhoneNumber" name="phone" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editEmailAddress" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="editEmailAddress" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editDriverStatus" class="form-label">Status</label>
                                <select class="form-select" id="editDriverStatus" name="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editJoinedDate" class="form-label">Joined Date</label>
                                <input type="date" class="form-control" id="editJoinedDate" name="joined_date">
                            </div>
                            <div class="col-12">
                                <label for="editAddress" class="form-label">Address</label>
                                <textarea class="form-control" id="editAddress" name="address" rows="2"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateDriver">Update Driver</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Driver Modal -->
    <div class="modal fade" id="viewDriverModal" tabindex="-1" aria-labelledby="viewDriverModalLabel" aria-hidden="true">
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
                                <p class="mb-0 fw-medium" id="viewDriverId"></p>
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
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editDriverModal">Edit Driver</button>
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
                    <p>Are you sure you want to delete driver <span id="deleteDriverName" class="fw-bold"></span>?</p>
                    <p class="text-danger mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ url('driver/destroy') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
                        <input type="hidden" name="id" id="deleteDriverId" value="{{ $driver->id }}">
                        <button type="submit" class="btn btn-danger">Delete Driver</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteConfirmModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const driverId = button.getAttribute('data-driver-id');
        const driverName = button.getAttribute('data-driver-name');

        // Update hidden input & driver name
        document.getElementById('deleteDriverId').value = driverId;
        document.getElementById('deleteDriverName').textContent = driverName;
    });
});
</script>

</x-app-layout>
