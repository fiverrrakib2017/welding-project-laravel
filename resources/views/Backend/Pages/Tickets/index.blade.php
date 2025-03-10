@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('style')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">
                <button data-toggle="modal" data-target="#ticketModal" type="button" class=" btn btn-success mb-2"><i class="mdi mdi-account-plus"></i>
                    Add New Ticket</button>

                <div class="table-responsive" id="tableStyle">
                    @include('Backend.Component.Tickets.Tickets')
                </div>
            </div>
        </div>

    </div>
</div>
@include('Backend.Modal.Tickets.ticket_modal')
@include('Backend.Modal.delete_modal')


@endsection

@section('script')
<script  src="{{ asset('Backend/assets/js/__handle_submit.js') }}"></script>
<script  src="{{ asset('Backend/assets/js/delete_data.js') }}"></script>
<script  src="{{ asset('Backend/assets/js/custom_select.js') }}"></script>
  
@endsection
