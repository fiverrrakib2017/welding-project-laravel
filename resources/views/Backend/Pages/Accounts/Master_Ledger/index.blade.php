@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">


                <div class="table-responsive" id="tableStyle">
                    <table id="datatable1" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                              <th class="">No.</th>
                              <th class="">Master Ledger Name</th>
                              <th class="">Status</th>
                              <th class="">Create Date</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>



@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function(){

     var table=$("#datatable1").DataTable({
       "processing":true,
       "responsive": true,
       "serverSide":true,
       beforeSend: function () {
         //$('#preloader').addClass('active');
       },
       complete: function(){
         //$('.product_loading').css({"display":"none"});
       },
       ajax: "{{ route('admin.master_ledger.all_data') }}",
       language: {
         searchPlaceholder: 'Search...',
         sSearch: '',
         lengthMenu: '_MENU_ items/page',
       },
       "columns":[
         {
           "data":"id"
         },
         {
           "data":"name"
         },
         {
           "data":"status",
           render:function(data,type,row){
               if (row.status==1) {
                   return '<span class="badge bg-success">Active</span>';
               }else{
                   return '<span class="badge bg-danger">Inactive</span>';
               }
           }
         },
         {
           "data":"created_at",
           render: function (data, type, row) {
               var formattedDate = moment(row.created_at).format('DD MMM YYYY');
               return formattedDate;
           }
         },
       ],
       order:[
         [0, "desc"]
       ],

     });
     $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
   });



   /** Handle edit button click**/
   $('#datatable1 tbody').on('click', '.edit-btn', function () {
     var id = $(this).data('id');
     $.ajax({
         type: 'GET',
         url: '/admin/accounts/master_ledger/edit/' + id,
         success: function (response) {
             if (response.success) {
               $('#editModal').modal('show');
               $('#editModal input[name="id"]').val(response.data.id);
               $('#editModal input[name="master_ledger_name"]').val(response.data.name);
               $('#editModal select[name="status"]').val(response.data.status);
             } else {
               toastr.error("Error fetching data for edit!");
             }
         },
         error: function (xhr, status, error) {
           console.error(xhr.responseText);
           toastr.error("Error fetching data for edit!");
         }
     });
   });




 /** Handle Delete button click**/
 $('#datatable1 tbody').on('click', '.delete-btn', function () {
   var id = $(this).data('id');
   $('#deleteModal').modal('show');
   console.log("Delete ID: " + id);
   var value_input = $("input[name*='id']").val(id);
 });



 /** Handle form submission for delete **/
 $('#deleteModal form').submit(function(e){
   e.preventDefault();
   /*Get the submit button*/
   var submitBtn =  $('#deleteModal form').find('button[type="submit"]');

   /* Save the original button text*/
   var originalBtnText = submitBtn.html();

   /*Change button text to loading state*/
   submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);

   var form = $(this);
   var url = form.attr('action');
   var formData = form.serialize();
   /** Use Ajax to send the delete request **/
   $.ajax({
     type:'POST',
     'url':url,
     data: formData,
     success: function (response) {
       $('#deleteModal').modal('hide');
       if (response.success) {
         toastr.success(response.message);
         $('#datatable1').DataTable().ajax.reload( null , false);
       }
     },

     error: function (xhr, status, error) {
        /** Handle  errors **/
        toastr.error(xhr.responseText);
     },
     complete: function () {
       submitBtn.html(originalBtnText);
       }
   });
 });




 /** Store The data from the database table **/
 $('#addModal form').submit(function(e){
   e.preventDefault();

   var form = $(this);
   var url = form.attr('action');
   var formData = form.serialize();
   /** Use Ajax to send the delete request **/
   $.ajax({
     type:'POST',
     'url':url,
     data: formData,
     success: function (response) {
       $('#addModal').modal('hide');
       $('#addModal form')[0].reset();
       if (response.success) {
         toastr.success(response.message);
         $('#datatable1').DataTable().ajax.reload( null , false);
       } else {
          /** Handle validation errors **/
         if (response.errors) {
           var errorMessages = response.errors.join('<br>');
           toastr.error(errorMessages);
         }
       }
     },

     error: function (xhr, status, error) {
        /** Handle  errors **/
       console.error(xhr.responseText);
     }
   });
 });




 /** Update The data from the database table **/
 $('#editModal form').submit(function(e){
   e.preventDefault();

   var form = $(this);
   var url = form.attr('action');
   var formData = form.serialize();

   // Get the submit button
   var submitBtn = form.find('button[type="submit"]');

   // Save the original button text
   var originalBtnText = submitBtn.html();

   // Change button text to loading state
   submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`);

   var form = $(this);
   var url = form.attr('action');
   var formData = form.serialize();
   /** Use Ajax to send the delete request **/
   $.ajax({
     type:'POST',
     'url':url,
     data: formData,
     beforeSend: function () {
       form.find(':input').prop('disabled', true);
     },
     success: function (response) {

       $('#editModal').modal('hide');
       $('#editModal form')[0].reset();
       if (response.success) {
           submitBtn.html(originalBtnText);
           toastr.success(response.success);
           $('#datatable1').DataTable().ajax.reload( null , false);
       } else {
          /** Handle validation errors **/
         if (response.errors) {
             var errorMessages = response.errors.join('<br>');
             toastr.error(errorMessages);
         }else {
           toastr.error("Error!!!");
         }
       }
     },

     error: function (xhr, status, error) {
       console.error(xhr.responseText);
     },
     complete: function () {
       submitBtn.html(originalBtnText);
         form.find(':input').prop('disabled', false);
       }
   });
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
