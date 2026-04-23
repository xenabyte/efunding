@extends('admin.layout.dashboard')

@section('title', 'Financial Statement')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" id="printableArea">
            <div class="card-header d-flex align-items-center border-bottom-dashed">
                <div class="flex-grow-1">
                    <h5 class="card-title mb-0">Oko-Irese Development Association</h5>
                    <p class="text-muted mb-0">Comprehensive Financial Statement as of {{ date('d M, Y') }}</p>
                </div>
                <div class="flex-shrink-0">
                    <button onclick="printDiv()" class="btn btn-success">
                        <i class="ri-printer-line align-bottom me-1"></i> Print Statement
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 border border-dashed rounded text-center">
                            <h5 class="text-success mb-1">₦{{ number_format($income, 2) }}</h5>
                            <p class="text-muted mb-0">Total Revenue (Member Contributions)</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border border-dashed rounded text-center">
                            <h5 class="text-danger mb-1">₦{{ number_format($expense, 2) }}</h5>
                            <p class="text-muted mb-0">Total Expenditures (Project Spending)</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border border-dashed rounded text-center bg-light">
                            <h5 class="text-primary mb-1">₦{{ number_format($surplus, 2) }}</h5>
                            <p class="text-muted mb-0">Current Net Surplus/Balance</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <h6 class="fs-15 mb-3 text-uppercase fw-semibold">Revenue by Campaign</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Campaign Name</th>
                                        <th class="text-end">Total Raised</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($campaignBreakdown as $camp)
                                    <tr>
                                        <td>{{ $camp->title }}</td>
                                        <td class="text-end text-success">₦{{ number_format($camp->contributions_sum_amount ?? 0, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h6 class="fs-15 mb-3 text-uppercase fw-semibold">Expenditure by Project</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Project Title</th>
                                        <th class="text-end">Total Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projectBreakdown as $proj)
                                    <tr>
                                        <td>{{ $proj->title }}</td>
                                        <td class="text-end text-danger">₦{{ number_format($proj->expenditures_sum_amount ?? 0, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-2 border-top border-top-dashed">
                    <p class="text-muted italic small text-center">Generated automatically by the Community Development Portal Audit System.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function printDiv() {
        var printContents = document.getElementById('printableArea').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload(); // Reload to restore JS functionality
    }
</script>
@endsection