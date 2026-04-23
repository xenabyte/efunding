@extends('admin.layout.dashboard')

@section('title', 'Levy Configuration')
@section('page-title', 'Levy Settings')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Community Levies & Dues</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLevyModal">
                    <i class="ri-add-line align-bottom me-1"></i> Add New Levy
                </button>
            </div>
            <div class="card-body">
                <table id="levies-table" class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Levy Name</th>
                            <th>Amount</th>
                            <th>Applied To</th>
                            <th>Frequency</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($levies as $levy)
                        <tr>
                            <td class="fw-bold">{{ $levy->name }}</td>
                            <td>₦{{ number_format($levy->amount, 2) }}</td>
                            <td>
                                @if($levy->member_type == 'all')
                                    <span class="badge bg-primary">Everyone</span>
                                @elseif($levy->member_type == 'resident')
                                    <span class="badge bg-info">Residents Only</span>
                                @else
                                    <span class="badge bg-warning text-dark">Diaspora Only</span>
                                @endif
                            </td>
                            <td class="text-capitalize">{{ $levy->frequency }}</td>
                            <td>{{ Str::limit($levy->description, 50) }}</td>
                            <td>
                                <div class="hstack gap-2">
                                    <button class="btn btn-sm btn-soft-info edit-levy-btn" 
                                        data-id="{{ $levy->id }}"
                                        data-name="{{ $levy->name }}"
                                        data-amount="{{ $levy->amount }}"
                                        data-type="{{ $levy->member_type }}"
                                        data-freq="{{ $levy->frequency }}"
                                        data-desc="{{ $levy->description }}">
                                        <i class="ri-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('admin.financial.levy.delete', $levy->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger" onclick="return confirm('Delete this levy definition?')">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addLevyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.financial.levy.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5>Create New Levy</h5></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Levy Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Annual Security Dues" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label>Amount (₦)</label>
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label>Frequency</label>
                            <select name="frequency" class="form-select">
                                <option value="once">One-time</option>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Member Category</label>
                        <select name="member_type" class="form-select">
                            <option value="all">All Members</option>
                            <option value="resident">Residents Only</option>
                            <option value="diaspora">Diaspora Only</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Levy</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.edit-levy-btn').on('click', function() {
        // Implementation for edit modal population similar to projects
    });
</script>
@endsection