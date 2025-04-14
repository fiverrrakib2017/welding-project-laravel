@extends('Backend.Layout.App')
@section('title', 'Dashboard-Mikrotik Online Users | Admin Panel')
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">Mikrotik Users</div>
                <div class="card-body">
                    <div class="table-responsive" id="tableStyle">
                        <table id="customers_log_datatable1" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Service</th>
                                    <th>Uptime</th>
                                    <th>IP Address</th>
                                    <th>MAC</th>
                                </tr>
                            </thead>
                            <tbody>
                             @if(!empty($data))

                             @foreach ($data as $item)
                             <tr>
                                 <td>{{ $item['name'] }}</td>
                                 <td>{{ $item['service'] }}</td>
                                 <td>
                                     @php
                                         $uptime = $item['uptime'] ?? 'N/A';

                                         preg_match('/(?:(\d+)w)?(?:(\d+)d)?(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?/', $uptime, $matches);

                                         $weeks = $matches[1] ?? 0;
                                         $days = $matches[2] ?? 0;
                                         $hours = $matches[3] ?? 0;
                                         $minutes = $matches[4] ?? 0;
                                         $seconds = $matches[5] ?? 0;
                                     @endphp

                                     @if($uptime !== 'N/A' && ($weeks || $days || $hours || $minutes || $seconds))
                                         <div class="d-flex flex-wrap gap-1">
                                             @if($weeks)
                                                 <span class="badge rounded-pill bg-dark" title="Weeks">{{ $weeks }}w</span>
                                             @endif
                                             @if($days)
                                                 <span class="badge rounded-pill bg-success" title="Days">{{ $days }}d</span>
                                             @endif
                                             @if($hours)
                                                 <span class="badge rounded-pill bg-warning text-dark" title="Hours">{{ $hours }}h</span>
                                             @endif
                                             @if($minutes)
                                                 <span class="badge rounded-pill bg-info text-dark" title="Minutes">{{ $minutes }}m</span>
                                             @endif
                                             @if($seconds)
                                                 <span class="badge rounded-pill bg-secondary" title="Seconds">{{ $seconds }}s</span>
                                             @endif
                                         </div>
                                     @else
                                         <span class="badge bg-danger">N/A</span>
                                     @endif
                                 </td>


                                 <td>{{ $item['address'] }}</td>
                                 <td>{{ $item['caller-id'] }}</td>
                             </tr>
                            @endforeach
                             @else
                                <tr>
                                    <td colspan="5" class="text-center">No Data Found</td>
                                </tr>
                             @endif

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
