@extends('admin.layout.dashboard')

@section('title', 'Contributions')
@section('page-title', 'Member Contributions')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Transaction History</h4>
            </div>

            <div class="card-body">
                <table id="contributions-table" class="table table-nowrap align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Ref ID</th>
                            <th>Member</th>
                            <th>Purpose / Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contributions as $item)
                        <tr>
                            <td><span class="text-muted">#{{ $item->reference ?? $item->id }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar-xs">
                                            <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                {{ substr($item->user->name ?? 'U', 0, 1) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        {{ $item->user->name ?? 'Unknown Member' }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($item->campaign)
                                    <span class="badge bg-soft-info text-info">Campaign: {{ $item->campaign->title }}</span>
                                @elseif($item->levy)
                                    <span class="badge bg-soft-primary text-primary">Levy: {{ $item->levy->name }}</span>
                                @else
                                    <span class="text-muted">General Contribution</span>
                                @endif
                            </td>
                            <td class="text-success fw-bold">₦{{ number_format($item->amount, 2) }}</td>
                            <td>{{ $item->created_at->format('d M, Y') }}</td>
                            <td>
                                @if($item->status == 'success')
                                    <span class="badge bg-success">Successful</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="avatar-lg mx-auto">
                                    <div class="avatar-title bg-light text-primary rounded-circle display-4">
                                        <i class="ri-money-dollar-circle-line"></i>
                                    </div>
                                </div>
                                <h5 class="mt-4">No Contributions Found</h5>
                                <p class="text-muted">Transactions will appear here once members start making payments.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if ($('#contributions-table tbody tr').length > 1) {
            $('#contributions-table').DataTable({
                responsive: true,
                order: [[4, 'desc']]
            });
        }
    });
</script>
@endsection