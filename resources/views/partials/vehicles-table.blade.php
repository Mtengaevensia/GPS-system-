<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Plate Number</th>
                <th scope="col">Type</th>
                <th scope="col">Driver</th>
                <th scope="col">Status</th>
                <th scope="col">Last Location</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
            <tr>
                <td>{{ $vehicle['id'] }}</td>
                <td>{{ $vehicle['plate_number'] }}</td>
                <td>{{ $vehicle['type'] }}</td>
                <td>{{ $vehicle['driver'] }}</td>
                <td>
                    @if($vehicle['status'] == 'Active')
                        <span class="badge rounded-pill text-bg-success">Active</span>
                    @elseif($vehicle['status'] == 'Offline')
                        <span class="badge rounded-pill text-bg-danger">Offline</span>
                    @else
                        <span class="badge rounded-pill text-bg-warning">{{ $vehicle['status'] }}</span>
                    @endif
                </td>
                <td>{{ $vehicle['location'] }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-info me-1" 
                        data-bs-toggle="modal" 
                        data-bs-target="#viewVehicleModal"
                        data-bs-id="{{ $vehicle['id'] }}"
                        data-bs-plate="{{ $vehicle['plate_number'] }}"
                        data-bs-type="{{ $vehicle['type'] }}"
                        data-bs-driver="{{ $vehicle['driver'] }}"
                        data-bs-status="{{ $vehicle['status'] }}"
                        data-bs-location="{{ $vehicle['location'] }}"
                        data-bs-toggle="tooltip" title="View Details">
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
                        data-bs-location="{{ $vehicle['location'] }}"
                        data-bs-toggle="tooltip" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" title="Track Live">
                        <i class="bi bi-geo-alt"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteConfirmModal"
                        data-bs-id="{{ $vehicle['id'] }}"
                        data-bs-plate="{{ $vehicle['plate_number'] }}"
                        data-bs-toggle="tooltip" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>