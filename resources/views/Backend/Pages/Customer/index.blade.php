@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">
                    <button data-toggle="modal" data-target="#addCustomerModal" type="button" class=" btn btn-success mb-2"><i
                            class="mdi mdi-account-plus"></i>
                        Add New Customer</button>

                    <div class="table-responsive" id="tableStyle">
                        @include('Backend.Component.Customer.Customer')
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('Backend.Modal.Customer.customer_modal')
    @include('Backend.Modal.delete_modal')


@endsection

@section('script')

    
@endsection
