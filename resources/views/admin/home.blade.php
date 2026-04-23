@extends('admin.layout.dashboard')

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate bg-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-white-50 text-truncate mb-0">Total Community Balance</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white">₦{{ number_format($balance, 2) }}</h4>
                        <span class="badge bg-white text-primary">Available Funds</span>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-light rounded fs-3">
                            <i class="ri-bank-line text-white"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Contributions</p>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">₦{{ number_format($totalIncome, 2) }}</h4>
                        <a href="{{ route('admin.financial.contributions') }}" class="text-decoration-underline text-success">View all</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-success rounded fs-3">
                            <i class="ri-arrow-right-up-line text-success"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Expenses</p>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">₦{{ number_format($totalExpense, 2) }}</h4>
                        <a href="{{ route('admin.financial.expenditure.index') }}" class="text-decoration-underline text-danger">View logs</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-danger rounded fs-3">
                            <i class="ri-arrow-right-down-line text-danger"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Members</p>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ number_format($memberCount) }}</h4>
                        <span class="text-muted small">{{ $residentCount }} Residents | {{ $diasporaCount }} Diaspora</span>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-info rounded fs-3">
                            <i class="ri-team-line text-info"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Recent Contributions</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Member</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentContributions as $rc)
                            <tr>
                                <td>{{ $rc->user->name }}</td>
                                <td>{{ $rc->created_at->format('M d, Y') }}</td>
                                <td class="text-success">₦{{ number_format($rc->amount, 2) }}</td>
                                <td><span class="badge bg-success">Success</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Project Summary</h4>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                        <h5 class="fs-14 mb-0">Ongoing Projects</h5>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="badge bg-warning">{{ $activeProjects }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="fs-14 mb-0">Completed Projects</h5>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="badge bg-success">{{ $completedProjects }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection