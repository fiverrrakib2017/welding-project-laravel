@extends('Backend.Layout.App')
@section('title', 'School Settings | Admin Panel')

@section('style')
    <!-- Custom styles for the page can be added here -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-7 m-auto">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="card-title">App Information Settings</h3>
            </div>
            <div class="card-body">
                <!-- School Information Form -->
                <form action="{{ route('admin.settings.information.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="logo" class="col-md-3 col-form-label">App Logo</label>
                        <div class="col-md-9">
                            <input type="file" id="logo" name="logo" class="form-control">
                            @if (!empty($data->logo))
                            <img height="100" width="100" src="{{ asset('Backend/uploads/photos/' . $data->logo) }}" class="img-fluid" alt="Logo">
                        @endif


                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="school_name" class="col-md-3 col-form-label">App  Name</label>
                        <div class="col-md-9">
                            <input type="text" id="school_name" name="school_name"  class="form-control"  value="{{ $data->name ?? '' }}">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-3 col-form-label">App Address</label>
                        <div class="col-md-9">
                            <textarea id="address" name="address" class="form-control" rows="3">{{ $data->address ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone_number" class="col-md-3 col-form-label">Phone Number</label>
                        <div class="col-md-9">
                            <input type="text" id="phone_number" name="phone_number"  class="form-control" value="{{ $data->phone_number ?? '' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-3 col-form-label">Email Address</label>
                        <div class="col-md-9">
                            <input type="email" id="email" name="email" class="form-control" value="{{ $data->email ?? '' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>
<script src="{{ asset('Backend/assets/js/custom_select.js') }}"></script>

@endsection
