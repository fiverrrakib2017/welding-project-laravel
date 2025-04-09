@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('style')

{{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css"> --}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">Mikrotik Logs</div>
                <div class="card-body">
                    <div class="table-responsive" id="tableStyle">
                        <table id="customers_log_datatable1" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Mikrotik Router</th>
                                <th>Time</th>
                                <th>Topics</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allLogs as $log)
                            <tr>
                                <td>{{ $log['router_name'] }}</td>
                                <td>{{ $log['time'] }}</td>

                                <td>{{ $log['topics'] }}</td>
                                <td>{{ $log['message'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

        </div>
    </div>



@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#customers_log_datatable1').DataTable();
        });
    </script>
@endsection
