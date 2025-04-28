@extends('Backend.Layout.App')
@section('title', 'Student Course List | Admin Panel')

@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">


                    <div class="table-responsive" id="tableStyle">
                        <table id="student_datatable1" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $course->name }}</td>
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
@endsection
