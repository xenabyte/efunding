@extends('admin.layout.dashboard')

@section('title', 'Expenditure Logs')
@section('page-title', 'Financial Outflow')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Expenditure Records</h5>
                <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                    <i class="ri-subtract-line align-bottom me-1"></i> Record New Expense
                </button>
            </div>
            <div class="card-body">
                <table id="expenditure-table" class="table table-bordered nowrap align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Purpose/Title</th>
                            <th>Project</th>
                            <th>Amount</th>
                            <th>Receipt</th>
                            <th>Logged By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenditures as $exp)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($exp->date_spent)->format('d M, Y') }}</td>
                            <td>
                                <h5 class="fs-14 mb-0">{{ $exp->title }}</h5>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info">{{ $exp->project->title }}</span>
                            </td>
                            <td class="text-danger fw-bold">
                                -₦{{ number_format($exp->amount, 2) }}
                            </td>
                            <td>
                                @if($exp->receipt_image)
                                    <a href="{{ asset($exp->receipt_image) }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                        <i class="ri-image-line me-1"></i> View
                                    </a>
                                @else
                                    <span class="text-muted small">No Receipt</span>
                                @endif
                            </td>
                            <td>{{ $exp->admin->name ?? 'Admin' }}</td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Details</a></li>
                                        <li><a href="#!" class="dropdown-item text-danger"><i class="ri-delete-bin-fill align-bottom me-2"></i> Delete</a></li>
                                    </ul>
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

<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-danger p-3">
                <h5 class="modal-title">Record Expenditure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.financial.expenditure.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Expense Title/Purpose</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Purchase of Pumping Machine" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Project Category</label>
                        <select class="form-select" name="project_id" required>
                            <option value="">Select Linked Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Amount (₦)</label>
                            <input type="number" name="amount" class="form-control" placeholder="0.00" required />
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Date of Expense</label>
                            <input type="date" name="date_spent" class="form-control" value="{{ date('Y-m-d') }}" required />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Receipt (Image)</label>
                        <input type="file" name="receipt_image" class="form-control" accept="image/*" />
                        <small class="text-muted">Max size: 2MB (JPG, PNG)</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Additional Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Briefly explain the expense..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Post Expenditure</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#expenditure-table').DataTable({
            responsive: true,
            order: [[0, 'desc']] // Show latest first
        });
    });
</script>
@endsection