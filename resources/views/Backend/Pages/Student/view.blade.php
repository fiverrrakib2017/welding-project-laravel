@extends('Backend.Layout.App')
@section('title', 'Dashboard | Admin Panel')
@section('style')
<style>
.file-container {
    position: relative;
    overflow: hidden;
}

.file-container img {
    display: block;
    width: 100%;
    height: auto;
}

.download-btn {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    display: none;
    z-index: 10;
    padding: 8px 16px;
    font-size: 14px;
}

.file-container:hover .download-btn {
    display: inline-block;
}

.file-container:hover img {
    filter: brightness(0.8);
}
</style>
@endsection

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                    @if($student->photo && file_exists(public_path('uploads/photos/' . $student->photo)))
                    <img src="{{ asset('uploads/photos/'.$student->photo) }}" alt='Profile Picture' class="profile-user-img img-fluid img-circle"/>
                 @else
                    <img src="{{ asset('uploads/avatar.png') }}" alt='Default Profile Picture' class="profile-user-img img-fluid img-circle" />
                 @endif
              </div>

              <h3 class="profile-username text-center">{{ $student->name ?? '' }}</h3>

              <p class="text-muted text-center">Roll No.{{ $student->roll_no ?? 0 }}</p>
              <a href="{{ route('admin.student.edit', $student->id) }}" class="btn-sm btn btn-primary"><i class="fas fa-edit"></i></a>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Name</b> <a class="float-right">{{ $student->name ?? '' }}</a>
                </li>
                <li class="list-group-item">
                  <b>Class</b> <a class="float-right"> {{ $student->currentClass->name ?? ''  }}</a>
                </li>
                <li class="list-group-item">
                  <b>Birth Date</b> <a class="float-right">{{ $student->birth_date ?? '' }}</a>
                </li>
                <li class="list-group-item">
                  <b>Gender</b> <a class="float-right"> {{ $student->gender ?? '' }}</a>
                </li>
                <li class="list-group-item">
                  <b>Father's Name</b> <a class="float-right">{{ $student->father_name ?? '' }}</a>
                </li>
                <li class="list-group-item">
                  <b>Mother's Name</b> <a class="float-right">{{ $student->mother_name ?? '' }}</a>
                </li>
                <li class="list-group-item">
                  <b>C. Address</b> <a class="float-right">{{ $student->current_address ?? '' }}</a>
                </li>
                <li class="list-group-item">
                  <b>P. Address:</b> <a class="float-right">{{ $student->permanent_address  ?? '' }}</a>
                </li>
                <li class="list-group-item">
                  <b>Phone</b> <a class="float-right">{{ $student->phone }}</a>
                </li>

                <li class="list-group-item">
                  <b>Academic Results:</b> <a class="float-right"> {{ $student->academic_results  ?: 'N/A' }}</a>
                </li>
                <li class="list-group-item">
                  <b>Blood Group:</b> <a class="float-right">{{ $student->blood_group  ? : 'N/A' }}</a>
                </li>
                <li class="list-group-item">
                  <b>Health Conditions</b> <a class="float-right"> {{ $student->health_conditions ?: 'N/A' }}</a>
                </li>
                <li class="list-group-item">
                  <b>Emergency Phone:</b> <a class="float-right"> {{ $student->emergency_contact_phone }}</a>
                </li>
              </ul>


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                <li class="nav-item"><a class="nav-link" href="#invoice" data-toggle="tab">Invoice</a></li>
                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                <li class="nav-item"><a class="nav-link" href="#documents" data-toggle="tab">Documents</a></li>
                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <!-- Activity -->
                <div class="active tab-pane" id="activity">
                    <div class="table-responsive">
                        <table id="activities_datatable"
                            class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>In Time</th>
                                    <th>Out Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="">
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Invoice -->
                <div class="tab-pane" id="invoice">
                    <div class="table-responsive">
                        <table id="invoice_datatable"
                            class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Invoice id</th>
                                    <th>Sub Total</th>
                                    <th>Discount</th>
                                    <th>Grand Total</th>
                                    <th>Create Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id=""> </tbody>
                        </table>
                    </div>
                </div>
                  <!-- Timeline -->
                <div class="tab-pane" id="timeline">
                  <!-- The timeline -->
                  <div class="timeline timeline-inverse">
                    <!-- timeline time label -->
                    <div class="time-label">
                      <span class="bg-danger">
                        10 Feb. 2014
                      </span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-envelope bg-primary"></i>

                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 12:05</span>

                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                        <div class="timeline-body">
                          Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                          weebly ning heekya handango imeem plugg dopplr jibjab, movity
                          jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                          quora plaxo ideeli hulu weebly balihoo...
                        </div>
                        <div class="timeline-footer">
                          <a href="#" class="btn btn-primary btn-sm">Read more</a>
                          <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                      </div>
                    </div>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-user bg-info"></i>

                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                        <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                        </h3>
                      </div>
                    </div>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-comments bg-warning"></i>

                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                        <div class="timeline-body">
                          Take me to your leader!
                          Switzerland is small and neutral!
                          We are more like Germany, ambitious and misunderstood!
                        </div>
                        <div class="timeline-footer">
                          <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                        </div>
                      </div>
                    </div>
                    <!-- END timeline item -->
                    <!-- timeline time label -->
                    <div class="time-label">
                      <span class="bg-success">
                        3 Jan. 2014
                      </span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <div>
                      <i class="fas fa-camera bg-purple"></i>

                      <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                        <div class="timeline-body">
                          <img src="http://placehold.it/150x100" alt="...">
                          <img src="http://placehold.it/150x100" alt="...">
                          <img src="http://placehold.it/150x100" alt="...">
                          <img src="http://placehold.it/150x100" alt="...">
                        </div>
                      </div>
                    </div>
                    <!-- END timeline item -->
                    <div>
                      <i class="far fa-clock bg-gray"></i>
                    </div>
                  </div>
                </div>
                <!-- Documents -->
                <div class="tab-pane" id="documents">
                    <div class="row">
                        @if(!empty($student_docs))
                            @foreach ($student_docs as $item)
                            <!-- File 1 -->
                            <div class="col-sm-3">
                                <div class="position-relative file-container">
                                    <img src="https://winaero.com/blog/wp-content/uploads/2018/12/file-explorer-folder-libraries-icon-18298.png" alt="{{ $item->file_name }}" class="img-fluid">

                                    <a href="{{ asset('/uploads/documents/' . $item->docs_name) }}" download class="download-btn btn btn-primary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <h4 class="text-center text-danger">Documents Not Found</h4>
                        @endif
                    </div>
                </div>
                <!--Settings -->
                <div class="tab-pane" id="settings">
                  <form class="form-horizontal">
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName2" placeholder="Name">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->




<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <form action="{{route('admin.student.delete')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="fas fa-trash"></i>
                </div>
                <h4 class="modal-title w-100">Are you sure?</h4>
                <input type="hidden" name="id" value="">
                <a class="close" data-bs-dismiss="modal" aria-hidden="true"><i class="mdi mdi-close"></i></a>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $("#transaction_datatable").DataTable();
        $("#activities_datatable").DataTable();
        $("#invoice_datatable").DataTable();


        /** Handle Delete button click**/
        $(document).on('click', '.delete-btn', function () {
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
            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');

            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();
            /** Use Ajax to send the delete request **/
            $.ajax({
            type:'POST',
            'url':url,
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#deleteModal').modal('hide');
                    toastr.success(response.message);
                    window.location.href = "{{ route('admin.student.index') }}";
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

    });


</script>

@endsection
