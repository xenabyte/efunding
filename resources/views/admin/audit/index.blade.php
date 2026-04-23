@extends('admin.layout.dashboard')

@section('title', 'Audit Logs')
@section('page-title', 'Security & Audit Trail')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">System Activity Log</h4>
                <div class="flex-shrink-0">
                    <p class="text-muted mb-0">Tracking all Administrative Actions</p>
                </div>
            </div>
            <div class="card-body">
                <table id="audit-table" class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Timestamp</th>
                            <th>Administrator</th>
                            <th>Action Performed</th>
                            <th>Data Changes (JSON)</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td class="text-nowrap">
                                {{ $log->created_at->format('d M, Y') }} <br>
                                <small class="text-muted">{{ $log->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs flex-shrink-0 me-2">
                                        <span class="avatar-title rounded-circle bg-soft-info text-info">
                                            {{ substr($log->user->name ?? 'S', 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        {{ $log->user->name ?? 'System' }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ str_contains($log->action, 'Delete') ? 'bg-danger' : 'bg-primary' }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-soft-secondary" 
                                        onclick="viewJson(this)" 
                                        data-json='{{ $log->changes }}'>
                                    <i class="ri-code-s-slash-line me-1"></i> View Changes
                                </button>
                            </td>
                            <td><code class="text-primary">{{ $log->ip_address ?? request()->ip() }}</code></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="jsonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="jsonViewer" class="bg-light p-3 rounded text-primary" style="white-space: pre-wrap;"></pre>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#audit-table').DataTable({
            order: [[0, 'desc']],
            responsive: true
        });
    });

    function viewJson(btn) {
        let rawData = $(btn).attr('data-json');
        try {
            let obj = JSON.parse(rawData);
            let pretty = JSON.stringify(obj, undefined, 4);
            $('#jsonViewer').text(pretty);
        } catch (e) {
            $('#jsonViewer').text(rawData);
        }
        $('#jsonModal').modal('show');
    }
</script>
@endsection