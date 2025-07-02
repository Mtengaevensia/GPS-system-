<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="row g-4 mb-4">
                <!-- Total Vehicles -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="p-3 rounded-circle bg-indigo-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#4F46E5" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m-8 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 small">Total Vehicles</p>
                                    <h4 class="mb-0 fw-bold">48</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Vehicles Online -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="p-3 rounded-circle bg-success-subtle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#10B981" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 small">Vehicles Online</p>
                                    <h4 class="mb-0 fw-bold">36</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Trips Today -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="p-3 rounded-circle bg-primary-subtle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#0d6efd" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 small">Trips Today</p>
                                    <h4 class="mb-0 fw-bold">24</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Active Alerts -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="p-3 rounded-circle bg-warning-subtle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#ffc107" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 small">Active Alerts</p>
                                    <h4 class="mb-0 fw-bold">7</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Live Map Section -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">Live Vehicle Tracking</h5>
                    <div class="bg-light rounded p-3" style="height: 400px;">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="#adb5bd" class="mb-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                <p class="text-muted">Map loading... <br>Showing 36 active vehicles</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Two Column Layout for Charts and Recent Trips -->
            <div class="row g-4">
                <!-- Charts Section -->
                <div class="col-12 col-lg-4">
                    <!-- Vehicle Usage Chart -->
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">Vehicle Usage</h5>
                            <div class="bg-light rounded p-3" style="height: 250px;">
                                <div class="h-100 d-flex align-items-center">
                                    <div class="w-100 space-y-3">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1 small">
                                                <span>Truck A</span>
                                                <span>75%</span>
                                            </div>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-indigo" role="progressbar" style="width: 75%; background-color: #4F46E5;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1 small">
                                                <span>Van B</span>
                                                <span>65%</span>
                                            </div>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-indigo" role="progressbar" style="width: 65%; background-color: #4F46E5;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1 small">
                                                <span>Car C</span>
                                                <span>90%</span>
                                            </div>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-indigo" role="progressbar" style="width: 90%; background-color: #4F46E5;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1 small">
                                                <span>Truck D</span>
                                                <span>45%</span>
                                            </div>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-indigo" role="progressbar" style="width: 45%; background-color: #4F46E5;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Trip Frequency Chart -->
                    <div class="card border-0 shadow">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">Trip Frequency</h5>
                            <div class="bg-light rounded p-3" style="height: 250px;">
                                <div class="h-100 d-flex align-items-center justify-content-center">
                                    <div class="position-relative" style="height: 160px; width: 160px;">
                                        <div class="position-absolute top-0 start-0 end-0 bottom-0 rounded-circle" style="background-color: rgba(79, 70, 229, 0.1);"></div>
                                        <div class="position-absolute top-0 start-0 end-0 bottom-0 rounded-circle border border-4" style="border-color: #4F46E5 !important; clip-path: polygon(50% 50%, 100% 0, 100% 100%, 50% 100%);"></div>
                                        <div class="position-absolute top-0 start-0 end-0 bottom-0 rounded-circle border border-4" style="border-color: #10B981 !important; clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 50%);"></div>
                                        <div class="position-absolute top-0 start-0 end-0 bottom-0 rounded-circle border border-4" style="border-color: #ffc107 !important; clip-path: polygon(50% 50%, 0 0, 0 100%, 50% 100%);"></div>
                                        <div class="position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-center justify-content-center">
                                            <span class="fw-bold fs-4">24</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Trips Table -->
                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Recent Trips</h5>
                                <a href="#" class="btn btn-sm btn-link text-decoration-none" style="color: #4F46E5;">View All</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Vehicle ID</th>
                                            <th scope="col">Driver</th>
                                            <th scope="col">Start Location</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Distance</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium">TRK-1234</td>
                                            <td>John Doe</td>
                                            <td>Nairobi CBD</td>
                                            <td>Mombasa Road</td>
                                            <td>45 km</td>
                                            <td><span class="badge rounded-pill text-bg-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">VAN-5678</td>
                                            <td>Jane Smith</td>
                                            <td>Westlands</td>
                                            <td>Thika Road</td>
                                            <td>18 km</td>
                                            <td><span class="badge rounded-pill text-bg-primary">In Progress</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">CAR-9012</td>
                                            <td>Robert Johnson</td>
                                            <td>Karen</td>
                                            <td>Ngong Road</td>
                                            <td>12 km</td>
                                            <td><span class="badge rounded-pill text-bg-warning">Delayed</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">TRK-3456</td>
                                            <td>Michael Brown</td>
                                            <td>Jomo Kenyatta Airport</td>
                                            <td>Nakuru</td>
                                            <td>156 km</td>
                                            <td><span class="badge rounded-pill text-bg-danger">Cancelled</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


