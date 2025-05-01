@extends('Backend.Layout.App')
@section('title','Student Profile | Admin Panel')

@section('content')
<div class="row">
    <div class="col-md-7 offset-md-2">
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title">{{ $student->name }}'s Profile</h3>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Name:</strong> {{ $student->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Registration No:</strong> {{ $student->reg_no ?? 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>NID/Passport:</strong> {{ $student->nid_or_passport }}
                    </div>
                    <div class="col-md-6">
                        <strong>Mobile Number:</strong> {{ $student->mobile_number }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Father's Name:</strong> {{ $student->father_name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Course(s):</strong>
                        @php
                            $courses = explode(',', $student->course);
                        @endphp
                        @foreach ($courses as $index => $course)
                            {{ strtoupper($course) }}@if($index < count($courses) - 1), @endif
                        @endforeach
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Course Duration:</strong> {{ $student->course_duration }} Month
                    </div>
                    <div class="col-md-6">
                        <strong>Course End:</strong> {{ $student->course_end }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Permanent Address:</strong><br>
                        {{ $student->permanent_address }}
                    </div>
                    <div class="col-md-6">
                        <strong>Present Address:</strong><br>
                        {{ $student->present_address }}
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Course Completed:</strong>
                        @if ($student->is_completed==1)
                            <span class="badge badge-success">Completed</span>
                        @else
                            <span class="badge badge-danger">Not Completed</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



@endsection

@section('script')

<script type="text/javascript">


</script>
@endsection
