@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
 <!-- vendor css -->
 <link href="{{asset('Backend/lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
		<link href="{{asset('Backend/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
		<link href="{{asset('Backend/lib/highlightjs/styles/github.css')}}" rel="stylesheet">
    <link href="{{asset('Backend/lib/select2/css/select2.min.css')}}" rel="stylesheet">
    
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{asset('Backend/css/bracket.css')}}">

@endsection
@section('content')
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.html">Dashboard</a>
          <a class="breadcrumb-item" href="{{route('admin.childcategory.index')}}">Child Category</a>
          <span class="breadcrumb-item active">Update</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-section-wrapper">
            <h6 class="br-section-label text-center mb-4">Update Child Category</h6>

            <!----- Start Add Category Form input ------->
            <div class="col-xl-7 mx-auto">
                <div class="form-layout form-layout-4 py-5">

            <form action="{{ route('admin.childcategory.update', $child_category->id) }}" method="post">
                @csrf
                <div class="row mb-4 mt-4">
                    <label class="col-sm-3 form-control-label">Category: <span class="tx-danger">*</span></label>
                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                        <select class="form-control select2" name="cat_id">
                            @foreach ($category as $cat)
                                @if ( $cat->id == $child_category->category_id )
                                    <option selected value="{{$cat->id}}">{{$cat->category_name}}</option>
                                    @else
                                    <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div><!-- row -->

                <div class="row mb-4 mt-4">
                    <label class="col-sm-3 form-control-label">Sub Category: <span class="tx-danger">*</span></label>
                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                        <select class="form-control select2" name="sub_cat_id">
                            @foreach ($sub_category as $item)
                                @if ( $item->id == $child_category->sub_cat_id )
                                    <option selected value="{{$item->id}}">{{$item->name}}</option>
                                    @else
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div><!-- row -->

                <div class="row mb-4">
                    <label class="col-sm-3 form-control-label"> child Category Name: <span class="tx-danger">*</span></label>
                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input type="text" name="child_cat_name" class="form-control" placeholder="Enter child Category Name" value="{{$child_category->name}}" required>
                    </div>
                </div><!-- row -->

                <div class="row mt-4">
                    <label class="col-sm-3 form-control-label">Status: <span class="tx-danger">*</span></label>
                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <select class="form-control select2" name="child_cat_status">
                        <option @if ($child_category->status == 1) @selected(true) @endif value="1">Active</option>
                        <option @if ($child_category->status == 0) @selected(true) @endif value="0">Inactive</option>
                    </select>
                    </div>
                </div><!-- row -->

                <div class="row mt-4 ">

                    <div class="col-sm-12 mg-t-10 mg-sm-t-0 text-right">
                    <a href="{{route('admin.childcategory.index')}}" type="button" class="btn btn-danger text-white mr-2" >Close</a>
                    <button type="submit" class="btn btn-info">Update changes</button>
                    </div>
                </div>
            </form>

        </div><!-- form-layout -->
        </div><!-- col-6 -->
    </div><!-- br-section-wrapper -->

@endsection

@section('script')
  <script type="text/javascript">
      $(document).ready(function(){
        imageInput.onchange = evt => {
          const [file] = imageInput.files
          if (file) {
            showImage.src = URL.createObjectURL(file)
          }
        }
      });
  </script>
@endsection

