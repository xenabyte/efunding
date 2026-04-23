@extends('admin.layout.dashboard')

@section('title', 'Fundraising Campaigns')
@section('page-title', 'Fundraising Campaigns')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Active & Past Campaigns</h5>
                <div class="flex-shrink-0">
                    <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#addCampaignModal">
                        <i class="ri-add-line align-bottom me-1"></i> Launch Campaign
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="campaigns-table" class="table nowrap align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Campaign Title</th>
                            <th>Linked Project</th>
                            <th>Goal Amount</th>
                            <th>Contributions</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-2">
                                        <div class="avatar-title rounded bg-soft-warning text-warning">
                                            <i class="ri-rocket-line"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="fs-14 mb-0">{{ $campaign->title }}</h5>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $campaign->project->title ?? 'N/A' }}</td>
                            <td class="fw-medium">₦{{ number_format($campaign->goal_amount, 2) }}</td>
                            <td>
                                <span class="badge rounded-pill bg-info-subtle text-info">
                                    {{ $campaign->contributions_count }} Payments
                                </span>
                            </td>
                            <td>
                                @if($campaign->is_active)
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Closed</span>
                                @endif
                            </td>
                            <td>
                                <div class="hstack gap-2">
                                    <button class="btn btn-sm btn-soft-info edit-campaign-btn" 
                                        data-id="{{ $campaign->id }}"
                                        data-title="{{ $campaign->title }}"
                                        data-goal="{{ $campaign->goal_amount }}"
                                        data-project="{{ $campaign->project_id }}"
                                        data-active="{{ $campaign->is_active }}">
                                        <i class="ri-pencil-fill"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger" onclick="return confirm('Are you sure you want to delete this campaign?')">
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

<div class="modal fade" id="addCampaignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-primary p-3">
                <h5 class="modal-title">Launch New Fundraising</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.campaigns.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Campaign Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. 2024 Education Fund" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link to Project</label>
                        <select class="form-select" name="project_id" required>
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Goal Amount (₦)</label>
                        <input type="number" name="goal_amount" class="form-control" placeholder="0.00" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Start Campaign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCampaignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-info p-3">
                <h5 class="modal-title">Edit Campaign Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCampaignForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Campaign Title</label>
                        <input type="text" name="title" id="edit_camp_title" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Goal Amount (₦)</label>
                        <input type="number" name="goal_amount" id="edit_camp_goal" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="is_active" id="edit_camp_active">
                            <option value="1">Active</option>
                            <option value="0">Closed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update Campaign</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#campaigns-table').DataTable({
            responsive: true
        });

        $('.edit-campaign-btn').on('click', function() {
            const id = $(this).data('id');
            $('#edit_camp_title').val($(this).data('title'));
            $('#edit_camp_goal').val($(this).data('goal'));
            $('#edit_camp_active').val($(this).data('active'));

            // Set Route for Route::resource (PUT /admin/campaigns/{id})
            $('#editCampaignForm').attr('action', '/admin/campaigns/' + id);

            $('#editCampaignModal').modal('show');
        });
    });
</script>
@endsection