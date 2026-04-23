@extends('admin.layout.dashboard')

@section('title', 'Community Projects')
@section('page-title', 'Community Projects')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Project Oversight</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="ri-add-line align-bottom me-1"></i> New Project
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Project Title</th>
                                <th>Target Amount</th>
                                <th>Expended</th>
                                <th>Status</th>
                                <th>Active Campaigns</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr>
                                <td>
                                    <h5 class="fs-14 mb-1">{{ $project->title }}</h5>
                                    <p class="text-muted mb-0">{{ Str::limit($project->description, 40) }}</p>
                                </td>
                                <td class="fw-medium">₦{{ number_format($project->target_amount, 2) }}</td>
                                <td>
                                    <span class="text-danger">₦{{ number_format($project->expenditures_sum_amount ?? 0, 2) }}</span>
                                    @php
                                        $percent = ($project->target_amount > 0) ? ($project->expenditures_sum_amount / $project->target_amount) * 100 : 0;
                                    @endphp
                                    <div class="progress progress-sm mt-2">
                                        <div class="progress-bar bg-danger" style="width: {{ $percent }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    @if($project->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($project->status == 'ongoing')
                                        <span class="badge bg-warning text-dark">Ongoing</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                                <td><span class="badge rounded-pill bg-info">{{ $project->campaigns_count }}</span></td>
                                <td>
                                    <div class="hstack gap-2">
                                        <button class="btn btn-sm btn-soft-info edit-project-btn" 
                                            data-id="{{ $project->id }}"
                                            data-title="{{ $project->title }}"
                                            data-amount="{{ $project->target_amount }}"
                                            data-status="{{ $project->status }}"
                                            data-desc="{{ $project->description }}">
                                            <i class="ri-pencil-fill"></i>
                                        </button>
                                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" onclick="return confirm('Archive project?')">
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
</div>

<div class="modal fade" id="addProjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.projects.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5>Initiate New Project</h5></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Target Budget (₦)</label>
                        <input type="number" name="target_amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Initial Status</label>
                        <select name="status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="ongoing">Ongoing</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editProjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editProjectForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-header"><h5>Edit Project Details</h5></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Target Budget (₦)</label>
                        <input type="number" name="target_amount" id="edit_amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="edit_desc" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Project</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.edit-project-btn').on('click', function() {
        $('#edit_title').val($(this).data('title'));
        $('#edit_amount').val($(this).data('amount'));
        $('#edit_status').val($(this).data('status'));
        $('#edit_desc').val($(this).data('desc'));
        $('#editProjectForm').attr('action', '/admin/projects/' + $(this).data('id'));
        $('#editProjectModal').modal('show');
    });
</script>
@endsection