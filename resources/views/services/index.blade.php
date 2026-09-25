<x-layout>
    @section('title', 'Manage Services')

    @section('content')
        <div class="row">
            <!-- Left Column: Add New Service Form -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Add New Service</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Service Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">JPG, PNG (Max 2MB)</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Service Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g., Wash & Fold" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Price ($)</label>
                                    <input type="number" step="0.01" name="price" class="form-control" placeholder="5.00" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Unit</label>
                                    <select name="unit" class="form-select" required>
                                        <option value="kg">Kilogram (kg)</option>
                                        <option value="piece">Piece</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle me-2"></i> Add Service
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: List of Services -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 font-weight-bold text-primary">All Services</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 80px">Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Unit</th>
                                        <th style="width: 100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($services as $service)
                                    <tr>
                                        <td>
                                            @if($service->image)
                                                <img src="{{ asset('images/services/' . $service->image) }}" 
                                                     class="rounded" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td><strong>{{ $service->name }}</strong></td>
                                        <td>${{ number_format($service->price, 2) }}</td>
                                        <td>{{ $service->unit }}</td>
                                        <td>
                                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No services found. Add your first service!</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-layout>