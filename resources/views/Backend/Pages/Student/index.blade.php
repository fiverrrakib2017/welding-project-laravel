@extends('Backend.Layout.App')
@section('title','Student List | Admin Panel')

@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
        <div class="card-header">
          <a href="{{ route('admin.student.create') }}" class="btn btn-success "><i class="mdi mdi-account-plus"></i>
          Add New Student</a>

          </div>
            <div class="card-body">
                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1"  class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="">No.</th>
                                <th class="">Student Name </th>
                                <th class="">NID Or Passport </th>
                                <th class="">Mobile Number</th>
                                <th class="">Father's Name</th>
                                <th class="">Present Address</th>
                                <th class="">Permanent Address</th>
                                <th class="">Course</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($students) > 0)
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->nid_or_passport }}</td>
                                        <td>{{ $student->mobile_number }}</td>
                                        <td>{{ $student->father_name }}</td>
                                        <td>{{ $student->present_address }}</td>
                                        <td>{{ $student->permanent_address }}</td>
                                        <td>{{ $student->course->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.student.edit', $student->id) }}" class="btn btn-success btn-sm mr-3 edit-btn"><i class="fa fa-edit"></i></a>
                                            <button data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm mr-3"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">No Data Found</td>
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

<script type="text/javascript">
  $(document).ready(function(){
    $('#datatable1').DataTable();
  });
  </script>
@endsection
