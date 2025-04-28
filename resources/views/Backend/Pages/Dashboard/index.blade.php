
@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')


  <div class="row" id="dashboardCards">

    <div class="col-lg-3 col-6 card-item wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>02</h3>
                <p>Pending Tickets</p>
            </div>
            <div class="icon">
                <i class="fas fas fa-solid fa-exclamation-triangle fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
  <script type="text/javascript">



</script>
@endsection
