@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('style')
    <style>
        /* Print CSS */
        @media print {
            #printButton {
                display: none;
            }

            .card {
                border: none;
                box-shadow: none;
            }
        }

        .school-header {
            text-align: center;
            padding: 15px;
        }

        .school-header img {
            height: 80px;
            width: 80px;
            margin-bottom: 10px;
        }

        .school-header h2 {
            font-weight: 100;
            margin-bottom: 5px;
        }

        .school-header p {
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }

        .info-box {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')

    <div class="row" id="main_div">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">
                    <div class="row" id="search_box">

                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label>POP Branch<span class="text-danger">*</span></label>
                                <select name="pop_id" id="pop_id" class="form-control" style="width:100%;" required>
                                    <option value="">Select POP Branch</option>
                                    @php
                                        $get_pop_branch = App\Models\Pop_branch::latest()->get();
                                    @endphp
                                    @foreach ($get_pop_branch as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label>Area<span class="text-danger">*</span></label>
                                <select name="area_id" id="area_id" class="form-control" style="width:100%;" required>
                                    <option value="">Select Area</option>
                                    @php
                                        $datas = App\Models\Pop_area::latest()->get();
                                    @endphp
                                    @foreach ($datas as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label>Router</label>
                                <select name="router_id" class="form-control" style="width:100%;" required>
                                    <option value="">Select Router</option>
                                    @php
                                        $datas = App\Models\Router::latest()->get();
                                    @endphp
                                    @foreach ($datas as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label>Package</label>
                                <select name="package_id" id="package_id" class="form-control" style="width:100%;" required>
                                    <option value="">Select Package</option>
                                    @php
                                        $datas = App\Models\Branch_package::latest()->get();
                                    @endphp
                                    @foreach ($datas as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label>Amount</label>
                                <input type="number" name="amount" class="form-control" required>
                            </div>
                        </div>


                        <div class="col">
                            <div class="form-group mt-3 d-flex">
                                <button type="button" name="submit_btn" class="btn btn-success mr-2"
                                    style="margin-top: 16px">
                                    <i class="fas fa-search"></i> Find Now</button>
                                <button type="button" name="upload_csv_file_btn" data-toggle="modal"
                                    data-target="#fileImportModal" class="btn btn-danger mr-2" style="margin-top: 16px">
                                    <i class="fas fa-upload"></i> Upload CSV</button>

                                    <a href="{{ asset('customers.csv') }}" download class="btn btn-primary" style="margin-top: 16px">
                                        <i class="fas fa-download"></i> Download CSV Format
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <div class="row " id="table_area">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">
                    <button id="printButton" class="btn btn-primary"><i class="fas fa-print"></i> </button>
                </div>
                <div class="card-body" id="printArea">
                    <!-- School Header -->
                    <div id="printHeader" class="school-header">
                        <img src="{{ asset('Backend/uploads/photos/' . ($website_info->logo ?? 'default-logo.jpg')) }}"
                            alt="School Logo">
                        <h2>{{ $website_info->name ?? 'Future ICT School' }}</h2>
                        <p>{{ $website_info->address ?? 'Daudkandi , Chittagong , Bangladesh' }}</p>

                        <span><strong>POP/Branch:</strong> <span id="popName"></span> | </span>
                        <span><strong>Area:</strong> <span id="areaName"></span> | </span>
                        <span><strong>Router IP:</strong> <span id="RouterIP"></span> | </span>
                        <span><strong>Package:</strong> <span id="PackageName"></span> | </span>
                        <span><strong>Amount:</strong> <span id="PackageAmount"></span> | </span>
                    </div>

                    <div class="table-responsive responsive-table">
                        <table id="" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="">SL</th>
                                    <th>Name</th>
                                    <th>User Name</th>
                                    <th>Mobile no.</th>

                                </tr>

                            </thead>
                            <tbody id="_data">
                                @for ($i = 0; $i < 15; $i++)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><input type="text" name="name[]" class="form-control"></td>
                                        <td><input type="text" name="user_name[]" class="form-control"></td>
                                        <td><input type="text" name="mobile_no[]" class="form-control"></td>
                                    </tr>
                                @endfor
                            </tbody>

                        </table>
                    </div>

                </div>


                <div class="card-footer text-center">
                    <!-- Submit Button -->
                    <button type="submit" name="submit_result_btn" class="btn btn-success px-4">
                        <i class="fas fa-save"></i> Submit Now
                    </button>

                    <!-- Note -->
                    <p class="text-danger mt-2" style="font-size: 14px; font-weight: 500;">
                        <i class="fas fa-exclamation-triangle"></i> Please check all the information before submitting the
                        form.
                    </p>
                </div>

            </div>

        </div>
    </div>


    <!--------------------CSV File Import Modal---------------------------->
    <div class="modal fade " id="fileImportModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="mdi mdi-upload"></i> File Import
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.customer.customer_csv_file_import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">


                        <div class="form-group mb-2">
                            <label>Upload Your File:</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" name="file_upload_submit_btn" class="btn btn-success"><i
                                class="mdi mdi-upload"></i> Upload Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("button[name='submit_btn']").on('click', function(e) {
                e.preventDefault();
                var pop_id = $("select[name='pop_id']").val();
                var area_id = $("select[name='area_id']").val();
                var router_id = $("select[name='router_id']").val();
                if (pop_id == '') {
                    toastr.error('Please Select POP/Branch Name');
                    return false;
                }
                if (area_id == '') {
                    toastr.error('Please Select Area Name');
                    return false;
                }
                if (router_id == '') {
                    toastr.error('Please Select Mikrotik Router');
                    return false;
                }

                $("#popName").text($('select[name="pop_id"] option:selected').text());
                $("#areaName").text($('select[name="area_id"] option:selected').text());
                $("#RouterIP").text($('select[name="router_id"] option:selected').text());
                $("#PackageName").text($('select[name="package_id"] option:selected').text());
                $("#PackageAmount").text($('input[name="amount"]').val());

                var submitBtn = $('#search_box').find('button[name="submit_btn"]');
                submitBtn.html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`
                );
                submitBtn.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: "",
                    cache: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        class_id: class_id,
                        section_id: section_id,
                    },
                    success: function(response) {
                        $("#table_area").removeClass('d-none');

                        var _number = 1;
                        var html = '';

                        /*Check if the response data is an array*/
                        if (Array.isArray(response.data) && response.data.length > 0) {
                            response.data.forEach(function(data) {

                                html += '<tr data-id="' + data.id + '">';
                                html += '<td>' + (_number++) + '</td>';
                                html += '<td>' + (data.name ? data.name : 'N/A') +
                                    '</td>';
                                html += '<td>' + (data.roll_no ? data.roll_no : 'N/A') +
                                    '</td>';
                                html += '<td><input type="checkbox" name="is_absent[' +
                                    data.id + ']"></td>';

                                html +=
                                    '<td><input class="form-control written_marks"  type="text" name="written_marks[' +
                                    data.id + ']" data-id="' + data.id + '"></td>';

                                html +=
                                    '<td><input class="form-control prectial_marks"  type="text" name="prectial_marks[' +
                                    data.id + ']" data-id="' + data.id + '"></td>';

                                html +=
                                    '<td><input class="form-control objective_marks"  type="text" name="objective_marks[' +
                                    data.id + ']" data-id="' + data.id + '"></td>';

                                html +=
                                    '<td><input class="form-control total_marks" type="text" name="total_marks[' +
                                    data.id + ']" data-id="' + data.id +
                                    '" value="100"></td>';

                                html +=
                                    '<td><input class="form-control grade" Placeholder="Grade" type="text" name="grade[' +
                                    data.id + ']" data-id="' + data.id +
                                    '" readonly></td>';



                                html +=
                                    '<td><input class="form-control" Placeholder="Enter Remarks" type="text" name="remarks[' +
                                    data.id + ']"></td>';

                                html += '</tr>';
                            });
                        } else {
                            html += '<tr>';
                            html +=
                                '<td colspan="10" style="text-align: center;">No Data Available</td>';
                            html += '</tr>';
                        }

                        $("#_data").html(html);
                    },
                    error: function() {
                        toastr.error('An error occurred. Please try again.');
                    },
                    complete: function() {
                        submitBtn.html('<i class="fas fa-search"></i> Find Now');
                        submitBtn.prop('disabled', false);
                    }

                });
            });
        });


        function load_dropdown(url, target_url) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $(target_url).empty().append('<option value="">---Select---</option>');
                    $.each(data.data, function(key, value) {
                        $(target_url).append('<option value="' + value.id + '">' + value
                            .name + '</option>');
                    });
                }
            });
        }
        /** Handle pop branch button click **/
        $(document).on('change', ' select[name="pop_id"]', function() {
            var pop_id = $(this).val();
            if (pop_id) {
                var $area_url = "{{ route('admin.pop.area.get_pop_wise_area', ':id') }}".replace(':id',
                    pop_id);
                var $package_url = "{{ route('admin.pop.branch.get_pop_wise_package', ':id') }}"
                    .replace(':id', pop_id);
                load_dropdown($area_url, ' select[name="area_id"]');
                load_dropdown($package_url, 'select[name="package_id"]');
                $("button[name='upload_csv_file_btn']").addClass('d-none');
            } else {
                $('select[name="area_id"]').html(
                    '<option value="">Select Area</option>');
                $(' select[name="package_id"]').html(
                    '<option value="">Select Package</option>');
                $("button[name='upload_csv_file_btn']").removeClass('d-none');
            }

        });
        /** Handle Amount when package button click **/
        $(document).on('change', ' select[name="package_id"]', function() {
            var package_id = $(this).val();
            var $amount_url = "{{ route('admin.pop.branch.get_pop_wise_package_price', ':id') }}"
                .replace(':id', package_id);
            if (package_id) {
                $.ajax({
                    url: $amount_url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $(' input[name="amount"]').val(response.data
                            .purchase_price);
                        $("button[name='upload_csv_file_btn']").addClass('d-none');
                    }
                });
            } else {
                $(' input[name="amount"]').val('0');
            }

        });


        /*********************** Print Bulk Customer  Data *******************************/
        document.getElementById("printButton").addEventListener("click", function() {
            var printContents = document.getElementById("printArea").outerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = "<html><head><title>Print</title></head><body>" + printContents +
                "</body></html>";
            window.print();
            document.body.innerHTML = originalContents;
        });
    </script>
@endsection
