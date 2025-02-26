<div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <h5 class="modal-title" id="speechModalLabel"><span class="mdi mdi-account-check mdi-18px"></span>
                    &nbsp;Add New Speech</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.settings.website.speech.store') }}" id="speechForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Title</label>
                        <input name="title" class="form-control" placeholder="Enter Your Title" type="text"
                            style="width: 100%;" required>

                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" placeholder="Enter Description" type="text" style="width: 100%;" required></textarea>

                    </div>
                    <div class="form-group">
                        <label>Upload Images</label>
                        <input name="images" class="form-control" type="file" style="width: 100%;"><br>
                        <img id="preview" class="img-fluid" src="#" alt="Image Preview" style="display: none; max-width: 100px; max-height: 100px;" />
                       <!-- jQuery -->
                        <script src="{{ asset('Backend/plugins/jquery/jquery.min.js') }}"></script>
                        <script>
                            $('input[name="images"]').change(function() {
                                    let reader = new FileReader();
                                    reader.onload = function(e) {
                                        $('#preview').attr('src', e.target.result).show();
                                    }
                                    reader.readAsDataURL(this.files[0]);
                                });
                        </script>
                    </div>

                    <div class="modal-footer ">
                        <button data-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


