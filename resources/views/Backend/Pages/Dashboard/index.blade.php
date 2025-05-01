
@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')


  <div class="row" id="dashboardCards">

    <div class="col-lg-3 col-6 card-item wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>
                    @php
                     $total_student = App\Models\Student::count();

                    @endphp
                    {{ $total_student }}
                </h3>
                <p>Total Students</p>
            </div>
            <div class="icon">
                <i class="fas fas fa-solid fa-user-graduate fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6 card-item wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>
                    @php
                     $total_course = App\Models\Course::count();

                    @endphp
                    {{ $total_course }}
                </h3>
                <p>Total Course</p>
            </div>
            <div class="icon">
                <i class="fas fas fa-solid fa-user-graduate fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
  <script type="text/javascript">



</script>
@endsection
