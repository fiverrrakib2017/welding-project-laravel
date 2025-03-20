@extends('Backend.Layout.App')
@section('title','Dashboard | SMS Management | Admin Panel')
@section('style')

@endsection
@section('content')
<div class="row">
    <div class="col-md-7 m-auto">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title"> <i class="fas fa-sms"></i>&nbsp;SMS Settings</h3>
            </div>
            <div class="card-body">
                <!-- SMS Form -->
                <form action="{{ route('admin.sms.config.store') }}" method="POST" enctype="multipart/form-data" id="addSmsForm">@csrf


                    <div class="form-group row">
                        <label for="api_url" class="col-md-3 col-form-label">Api Url</label>
                        <div class="col-md-9">
                            <input type="text"  name="api_url"  class="form-control"  placeholder="Enter Api Url" value="{{ $data->api_url ?? '' }}">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="api_key" class="col-md-3 col-form-label">Api Key</label>
                        <div class="col-md-9">
                            <input type="text"  name="api_key"  class="form-control"  placeholder="Enter Api Key" value="{{ $data->api_key ?? '' }}">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sender_id" class="col-md-3 col-form-label">Sender Id</label>
                        <div class="col-md-9">
                            <input type="text"  name="sender_id"  class="form-control"  placeholder="Enter Sender Id"  value="{{ $data->sender_id ?? '' }}">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="default_country_code" class="col-md-3 col-form-label">Country Code</label>
                        <div class="col-md-9">
                            <select name="default_country_code" class="form-control">
                                <option value="">---Select---</option>

                                @php
                                    $selectedCountry = $data->default_country_code ?? '';
                                    $countries = [
                                        "+88" => "Bangladesh (+88)",
                                        "+91" => "India (+91)",
                                        "+61" => "Australia (+61)"
                                    ];
                                @endphp

                                @foreach ($countries as $code => $name)
                                    <option value="{{ $code }}" {{ $selectedCountry == $code ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        handle_submit_form('#addSmsForm');


    });


  </script>
@endsection
