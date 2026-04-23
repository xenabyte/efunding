@extends('admin.layout.dashboard')

@section('title', $title)
@section('page-title', $title)

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">{{ $title }} List</h5>
                <div class="flex-shrink-0">
                    <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                        <i class="ri-add-line align-bottom me-1"></i> Add Member
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="members-table" class="table nowrap align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Member ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td><span class="fw-semibold">{{ $member->member_id_code }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar-xs">
                                            <div class="avatar-title rounded-circle bg-soft-primary text-primary text-uppercase">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-14 mb-1">{{ $member->name }}</h5>
                                        <p class="text-muted mb-0">Joined {{ $member->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>
                                @if($member->member_type == 'resident')
                                    <span class="badge bg-info-subtle text-info text-uppercase">Resident</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning text-uppercase">Diaspora</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View Profile</a></li>
                                        
                                        <li>
                                            <a href="javascript:void(0);" 
                                               class="dropdown-item edit-item-btn" 
                                               data-id="{{ $member->id }}"
                                               data-name="{{ $member->name }}"
                                               data-email="{{ $member->email }}"
                                               data-phone="{{ $member->phone }}"
                                               data-type="{{ $member->member_type }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit Details
                                            </a>
                                        </li>

                                        <li>
                                            <form action="{{ url('admin/members/reset-password/'.$member->id) }}" method="POST" onsubmit="return confirm('Reset this member\'s password to default?')">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-warning">
                                                    <i class="ri-lock-password-line align-bottom me-2"></i> Reset Password
                                                </button>
                                            </form>
                                        </li>

                                        <li class="dropdown-divider"></li>

                                        <li>
                                            <form action="{{ url('admin/members/delete/'.$member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?')">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="ri-delete-bin-fill align-bottom me-2"></i> Delete Member
                                                </button>
                                            </form>
                                        </li>
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

<div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-info p-3">
                <h5 class="modal-title">Register New Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/members/store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="example@mail.com" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="e.g. +234..." required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location Type</label>
                        <select class="form-select" name="member_type" required>
                            <option value="">Select Type</option>
                            <option value="resident">Resident (Home)</option>
                            <option value="diaspora">Diaspora (Overseas)</option>
                        </select>
                    </div>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0 text-muted"><i class="ri-information-line me-1"></i> A default password <strong>12345678</strong> will be assigned. The member should change this after login.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-warning p-3">
                <h5 class="modal-title">Modify Member Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editMemberForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" id="edit_phone" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location Type</label>
                        <select class="form-select" name="member_type" id="edit_member_type" required>
                            <option value="resident">Resident</option>
                            <option value="diaspora">Diaspora</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update Records</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable with Export Buttons
        $('#members-table').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        // Edit Button Interaction
        $('.edit-item-btn').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const phone = $(this).data('phone');
            const type = $(this).data('type');

            $('#edit_name').val(name);
            $('#edit_email').val(email);
            $('#edit_phone').val(phone);
            $('#edit_member_type').val(type);

            // Set Form Route
            $('#editMemberForm').attr('action', '{{ url("admin/members/update") }}/' + id);

            $('#editMemberModal').modal('show');
        });
    });
</script>
@endsection