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
          <a class="breadcrumb-item" href="{{route('admin.category.index')}}">Category</a>
          <span class="breadcrumb-item active">Sub-Category</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-section-wrapper">
            <h6 class="br-section-label text-center">All  SubCategory</h6>

            <div class="mb-3 d-flex justify-content-end">
                <button class="btn btn-info tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-toggle="modal" data-target="#addModal"> <i class="fa fa-plus ml-0 mr-1"></i>Add New </button>
            </div>

            <div class="table-wrapper">
              <table id="datatable1" class="table display responsive nowrap">
                <thead>
                  <tr>
                    <th class="wd-15p">Id</th>
                    <th class="wd-25p">Category Name</th>
                    <th class="wd-25p">Sub Category Name</th>
                    <th class="wd-155p">status</th>
                    <th class="wd-20p">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $i = 1;
                  @endphp

                  @if (count($data) > 0)
                    @foreach ($data as $item)
                      <tr>
                          <td>{{$i++}}</td>
                          <td>{{$item->category->category_name}}</td>
                          <td>{{$item->name}}</td>
                          <td>
                          @if ($item->status==1)
                            <span class="badge badge-success">Active</span>
                            @else
                            <span class="badge badge-danger">Inactive</span>
                            @endif
                          </td>
                          <td>
                            <!-- Add your action buttons here -->
                            <a class="btn btn-primary btn-sm mr-3" href="{{route('admin.subcategory.edit', $item->id)}}"><i class="fa fa-edit"></i></a>
                            <button data-toggle="modal" data-target="#deleteModal{{$item->id}}" class="btn btn-danger btn-sm mr-3"><i class="fa fa-trash"></i></button>
                          </td>
                       </tr>





                        <!--Start Delete MODAL ---->
                        <div id="deleteModal{{$item->id}}" class="modal fade">
                                <div class="modal-dialog modal-dialog-top" role="document">
                                    <div class="modal-content tx-size-sm">
                                    <div class="modal-body tx-center pd-y-20 pd-x-20">
                                        <form action="{{route('admin.subcategory.delete')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <i class="icon icon ion-ios-close-outline tx-60 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                                            <h4 class="tx-danger  tx-semibold mg-b-20 mt-2">Are you sure! you want to delete this?</h4>
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <button type="submit" class="btn btn-danger mr-2 text-white tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20">
                                                yes
                                            </button>
                                            <button type="button" class="btn btn-success tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20" data-dismiss="modal" aria-label="Close">
                                                No
                                            </button>
                                        </form>
                                    </div><!-- modal-body -->
                                    </div><!-- modal-content -->
                                </div>
                            </div>
                        <!--End Delete MODAL ---->
                    @endforeach
                  @endif

                </tbody>
              </table>
            </div><!-- table-wrapper -->


          </div><!-- br-section-wrapper -->

    <div id="addModal" class="modal fade effect-scale">
        <div class="modal-dialog modal-lg modal-dialog-top mt-4" role="document">
            <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add SubCategory</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <!----- Start Add Category Form ------->
        <form action="{{route('admin.subcategory.store')}}" method="post">
        @csrf

        <div class="modal-body pd-20">
            <!----- Start Add Category Form input ------->
            <div class="col-xl-12">
                <div class="form-layout form-layout-4">
                    <div class="row mb-4 mt-4">
                        <label class="col-sm-3 form-control-label">Category: <span class="tx-danger">*</span></label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">

                            <select class="form-control custom-select" name="cat_id" required>
                                <option value="">---Select Category---</option>
                                @foreach ($category as $cat)
                                   <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div><!-- row -->

                    <div class="row mb-4">
                        <label class="col-sm-3 form-control-label">Sub Category Name: <span class="tx-danger">*</span></label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                        <input type="text" name="sub_cat_name" class="form-control" placeholder="Enter Sub Category Name" required>
                        </div>
                    </div><!-- row -->
                    <div class="row mb-4 mt-4">
                        <label class="col-sm-3 form-control-label">Status: <span class="tx-danger">*</span></label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">

                            <select class="form-control custom-select" name="status" required>
                                <option value="">---Select---</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>

                            </select>
                        </div>
                    </div><!-- row -->

                </div><!-- form-layout -->
            </div><!-- col-6 -->
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success tx-size-xs">Save changes</button>
            <button type="button" class="btn btn-danger tx-size-xs" data-dismiss="modal">Close</button>
        </div>

        </form>
        <!----- End Add Category Form ------->
        </div>
    </div><!-- modal-dialog -->
    </div><!-- modal -->


   
@endsection

@section('script')
    <script src="{{asset('Backend/lib/highlightjs/highlight.pack.min.js')}}"></script>
    <script src="{{asset('Backend/lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('Backend/lib/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{asset('Backend/lib/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('Backend/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js')}}"></script>
    


    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });
        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>


  @if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
    @elseif(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
    @endif
@endsection
