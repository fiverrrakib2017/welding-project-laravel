@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
<!-- vendor css -->
<link href="{{asset('Backend/lib/highlightjs/styles/github.css')}}" rel="stylesheet">

<link href="{{asset('Backend/lib/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('Backend/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet">

<!-- Bracket CSS -->
<link rel="stylesheet" href="{{asset('Backend/css/bracket.css')}}">
@endsection


@section('content')
<div class="br-pageheader">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="{{route('admin.dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item" href="{{route('admin.supplier.index')}}">Supplier</a>
        <span class="breadcrumb-item active">Return List</span>
    </nav>
</div><!-- br-pageheader -->
<div class="br-section-wrapper" style="padding: 0px !important;">
  <div class="table-wrapper">
    <div class="card">
      <div class="card-header">
        <a href="{{route('admin.supplier.return.create_return')}}" class="btn btn btn-success">Add New Supplier Return</a>
      </div>
      <div class="card-body">
      <table id="datatable1" class="table display responsive nowrap">
      <thead>
        <tr>
            <th class="">No.</th>
            <th class="">Return Invoice No.</th>
            <th class="">Supplier Name</th>
            <th class="">Total Return Amount</th>
            <th class="">Status</th>
            <th class="">Create Date</th>
            
            <th class="">Action</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
      </div>
    </div>

  </div><!-- table-wrapper -->
</div><!-- br-section-wrapper -->

@endsection


@section('script')



@endsection